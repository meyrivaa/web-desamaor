<?php
namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerAction;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;
class AdminController extends Controller
{
    private array $tables = ['berita', 'infografis', 'agenda', 'poi', 'umkm', 'struktur_organisasi'];
    private function data(string $t, string $order = 'id', string $dir = 'desc'): array
    {
        return DB::table($t)->orderBy($order, $dir)->get()->map(fn($r) => (array) $r)->all();
    }
    public function dashboard(Request $r): View
    {
        return view('admin', ['desa' => config('desa'), 'daftar_berita' => $this->data('berita'), 'daftar_infografis' => $this->data('infografis'), 'daftar_agenda' => $this->data('agenda', 'tanggal', 'asc'), 'daftar_poi' => $this->data('poi', 'id', 'asc'), 'daftar_umkm' => $this->data('umkm'), 'daftar_struktur' => $this->data('struktur_organisasi', 'urutan', 'asc')]);
    }
    public function store(Request $r)
    {
        $type = $r->input('jenis_form');
        match ($type) { 'berita' => $this->storeBerita($r), 'infografis' => $this->storeInfografis($r), 'agenda' => $this->storeAgenda($r), 'poi' => $this->storePoi($r), 'struktur' => $this->storeStruktur($r), 'umkm' => $this->storeUmkm($r), default => abort(422, 'Jenis formulir tidak valid.')};
        return redirect()->route('admin_dashboard')->with('success', 'Data berhasil disimpan.');
    }
    private function upload(
        Request $request,
        string $field,
        string $prefix
    ): string {
        $file = $request->file($field);

        /*
         * Tidak ada gambar yang dipilih.
         * Gunakan gambar bawaan.
         */
        if ($file === null) {
            return 'default.jpg';
        }

        /*
         * File ada, tetapi gagal diterima PHP.
         * Contohnya karena ukuran melewati upload_max_filesize.
         */
        if (!$file->isValid()) {
            $errorCode = $file->getError();
            $errorMessage = $file->getErrorMessage();

            throw \Illuminate\Validation\ValidationException::withMessages([
                $field => "Gambar gagal diunggah. Kode PHP: {$errorCode}. Pesan: {$errorMessage}",
            ]);
        }

        $request->validate([
            $field => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);

        $uploadPath = public_path('uploads');

        /*
         * Buat folder uploads apabila belum tersedia.
         */
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0775, true);
        }

        /*
         * Periksa apakah folder bisa dipakai untuk menyimpan file.
         */
        if (!is_writable($uploadPath)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                $field => 'Folder public/uploads tidak dapat digunakan untuk menyimpan gambar.',
            ]);
        }

        $originalName = pathinfo(
            $file->getClientOriginalName(),
            PATHINFO_FILENAME
        );

        $safeName = Str::slug($originalName) ?: 'gambar';
        $extension = strtolower($file->getClientOriginalExtension());

        $fileName =
            $prefix . '_' .
            now()->format('YmdHisv') . '_' .
            $safeName . '.' .
            $extension;

        $file->move($uploadPath, $fileName);

        return $fileName;
    }
    private function deleteFile(?string $name): void
    {
        if (!$name || $name === 'default.jpg')
            return;
        $p = public_path('uploads/' . $name);
        if (is_file($p))
            @unlink($p);
    }
    private function nowLabel(): string
    {
        return Carbon::now('Asia/Jakarta')->translatedFormat('d F Y');
    }

    private function sanitizeNewsHtml(string $html): string
    {
        $config = (new HtmlSanitizerConfig())
            /*
             * Tag yang tidak diizinkan akan dihapus,
             * tetapi tulisannya tetap dipertahankan.
             */
            ->defaultAction(HtmlSanitizerAction::Block)

            /*
             * Format yang diperbolehkan dalam berita.
             */
            ->allowElement('p', [])
            ->allowElement('br', [])
            ->allowElement('h2', [])
            ->allowElement('h3', [])
            ->allowElement('strong', [])
            ->allowElement('em', [])
            ->allowElement('u', [])
            ->allowElement('s', [])
            ->allowElement('blockquote', [])
            ->allowElement('ol', [])
            ->allowElement('ul', [])
            ->allowElement('li', ['class', 'data-list'])
            ->allowElement('span', ['class'])
            ->allowElement('a', ['href'])

            /*
             * Batasi jenis tautan yang diperbolehkan.
             */
            ->allowLinkSchemes([
                'http',
                'https',
                'mailto',
            ])
            ->allowRelativeLinks()

            /*
             * Perlindungan tambahan pada tautan.
             */
            ->forceAttribute(
                'a',
                'rel',
                'noopener noreferrer'
            )

            /*
             * Tag berbahaya dibuang beserta isinya.
             */
            ->dropElement('script')
            ->dropElement('style')
            ->dropElement('iframe')
            ->dropElement('object')
            ->dropElement('embed')

            /*
             * Batas maksimal panjang isi berita.
             */
            ->withMaxInputLength(100000);

        $sanitizer = new HtmlSanitizer($config);

        return trim($sanitizer->sanitize($html));
    }

    private function validateNewsContent(string $html): string
    {
        $cleanHtml = $this->sanitizeNewsHtml($html);

        $plainText = html_entity_decode(
            strip_tags($cleanHtml),
            ENT_QUOTES | ENT_HTML5,
            'UTF-8'
        );

        $plainText = str_replace(
            "\u{00A0}",
            ' ',
            $plainText
        );

        if (trim($plainText) === '') {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'isi' => 'Isi berita wajib diisi.',
            ]);
        }

        return $cleanHtml;
    }

    private function storeBerita(Request $r): void
    {
        $d = $r->validate([
            'judul' => 'required|string|max:255',
            'ringkasan' => 'required|string',
            'isi' => 'required|string',
        ]);

        /*
         * Bersihkan HTML dari editor sebelum disimpan.
         */
        $d['isi'] = $this->validateNewsContent(
            $d['isi']
        );

        $d += [
            'tanggal' => $this->nowLabel(),
            'gambar' => $this->upload(
                $r,
                'gambar',
                'berita'
            ),
        ];

        DB::table('berita')->insert($d);
    }

    private function storeInfografis(Request $r): void
    {
        $d = $r->validate(['judul' => 'required|string|max:255']);
        $d += ['tanggal' => $this->nowLabel(), 'gambar' => $this->upload($r, 'gambar', 'infografis')];
        DB::table('infografis')->insert($d);
    }
    private function storeAgenda(Request $r): void
    {
        DB::table('agenda')->insert($r->validate(['judul' => 'required|string|max:255', 'tanggal' => 'required|date', 'waktu' => 'required|string|max:100', 'lokasi' => 'required|string|max:255']));
    }
    private function storePoi(Request $r): void
    {
        DB::table('poi')->insert($r->validate(['nama' => 'required|string|max:255', 'kategori' => 'required|string|max:100', 'deskripsi' => 'required|string', 'lat' => 'required|numeric|between:-90,90', 'lng' => 'required|numeric|between:-180,180']));
    }
    private function phone(string $v): string
    {
        $v = preg_replace('/[\s\-]/', '', $v);
        if (str_starts_with($v, '08'))
            return '62' . substr($v, 1);
        if (str_starts_with($v, '+62'))
            return substr($v, 1);
        return $v;
    }
    private function storeStruktur(Request $r): void
    {
        $d = $r->validate(['nama' => 'required|string|max:255', 'jabatan' => 'required|string|max:255', 'urutan' => 'required|integer|min:0']);
        $d['foto'] = $this->upload($r, 'foto', 'struktur');
        DB::table('struktur_organisasi')->insert($d);
    }
    private function storeUmkm(Request $r): void
    {
        $d = $r->validate(['nama_produk' => 'required|string|max:255', 'nama_usaha' => 'required|string|max:255', 'kategori' => 'required|string|max:100', 'deskripsi' => 'nullable|string', 'nomor_wa' => 'required|string|max:30', 'alamat' => 'required|string', 'maps_url' => 'required|url', 'status' => 'required|in:aktif,nonaktif']);
        $d += ['harga' => 0, 'satuan' => '-', 'tanggal' => $this->nowLabel(), 'gambar' => $this->upload($r, 'gambar', 'umkm')];
        $d['nomor_wa'] = $this->phone($d['nomor_wa']);
        DB::table('umkm')->insert($d);
    }
    private function editView(string $table, int $id, string $view): View
    {
        $x = DB::table($table)->find($id);
        abort_unless($x, 404);
        return view($view, ['desa' => config('desa'), 'item' => (array) $x, 'error' => null]);
    }
    public function editBerita(int $id): View
    {
        return $this->editView('berita', $id, 'admin_edit_berita');
    }
    public function updateBerita(Request $request, int $id)
    {
        $old = DB::table('berita')->find($id);

        abort_unless($old, 404);

        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|string|max:100',
            'ringkasan' => 'required|string',
            'isi' => 'required|string',
        ]);

        /*
         * Bersihkan HTML dari editor sebelum perubahan disimpan.
         */
        $data['isi'] = $this->validateNewsContent(
            $data['isi']
        );

        $imageName = $old->gambar ?: 'default.jpg';

        /*
         * Ada usaha mengunggah gambar baru.
         * Simpan gambar baru terlebih dahulu.
         */
        if ($request->file('gambar') !== null) {
            $newImageName = $this->upload(
                $request,
                'gambar',
                'berita'
            );

            /*
             * Gambar lama baru dihapus setelah gambar baru
             * berhasil disimpan.
             */
            $this->deleteFile($imageName);

            $imageName = $newImageName;
        } elseif ($request->boolean('hapus_gambar')) {
            /*
             * Tidak ada gambar baru, tetapi pengguna
             * memang memilih hapus gambar.
             */
            $this->deleteFile($imageName);

            $imageName = 'default.jpg';
        }

        $data['gambar'] = $imageName;

        DB::table('berita')
            ->where('id', $id)
            ->update($data);

        return $this->back();
    }
    public function destroyBerita(int $id)
    {
        return $this->destroy('berita', $id, 'gambar');
    }
    public function editInfografis(int $id): View
    {
        return $this->editView('infografis', $id, 'admin_edit_infografis');
    }
    public function updateInfografis(Request $r, int $id)
    {
        $old = DB::table('infografis')->find($id);
        abort_unless($old, 404);
        $d = $r->validate(['judul' => 'required|string|max:255', 'tanggal' => 'required|string|max:100']);
        $img = $old->gambar;
        if ($r->boolean('hapus_gambar')) {
            $this->deleteFile($img);
            $img = 'default.jpg';
        }
        if ($r->hasFile('gambar')) {
            $this->deleteFile($img);
            $img = $this->upload($r, 'gambar', 'infografis');
        }
        $d['gambar'] = $img;
        DB::table('infografis')->where('id', $id)->update($d);
        return $this->back();
    }
    public function destroyInfografis(int $id)
    {
        return $this->destroy('infografis', $id, 'gambar');
    }
    public function editAgenda(int $id): View
    {
        return $this->editView('agenda', $id, 'admin_edit_agenda');
    }
    public function updateAgenda(Request $r, int $id)
    {
        DB::table('agenda')->where('id', $id)->update($r->validate(['judul' => 'required|string|max:255', 'tanggal' => 'required|date', 'waktu' => 'required|string|max:100', 'lokasi' => 'required|string|max:255']));
        return $this->back();
    }
    public function destroyAgenda(int $id)
    {
        return $this->destroy('agenda', $id);
    }
    public function editPoi(int $id): View
    {
        return $this->editView('poi', $id, 'admin_edit_poi');
    }
    public function updatePoi(Request $r, int $id)
    {
        DB::table('poi')->where('id', $id)->update($r->validate(['nama' => 'required|string|max:255', 'kategori' => 'required|string|max:100', 'deskripsi' => 'required|string', 'lat' => 'required|numeric|between:-90,90', 'lng' => 'required|numeric|between:-180,180']));
        return $this->back();
    }
    public function destroyPoi(int $id)
    {
        return $this->destroy('poi', $id);
    }
    public function editStruktur(int $id): View
    {
        return $this->editView('struktur_organisasi', $id, 'admin_edit_struktur');
    }
    public function updateStruktur(Request $r, int $id)
    {
        $old = DB::table('struktur_organisasi')->find($id);
        abort_unless($old, 404);
        $d = $r->validate(['nama' => 'required|string|max:255', 'jabatan' => 'required|string|max:255', 'urutan' => 'required|integer|min:0']);
        $img = $old->foto;
        if ($r->boolean('hapus_foto')) {
            $this->deleteFile($img);
            $img = 'default.jpg';
        }
        if ($r->hasFile('foto')) {
            $this->deleteFile($img);
            $img = $this->upload($r, 'foto', 'struktur');
        }
        $d['foto'] = $img;
        DB::table('struktur_organisasi')->where('id', $id)->update($d);
        return $this->back();
    }
    public function destroyStruktur(int $id)
    {
        return $this->destroy('struktur_organisasi', $id, 'foto');
    }
    public function editUmkm(int $id): View
    {
        return $this->editView('umkm', $id, 'admin_edit_umkm');
    }
    public function updateUmkm(Request $r, int $id)
    {
        $old = DB::table('umkm')->find($id);
        abort_unless($old, 404);
        $d = $r->validate(['nama_produk' => 'required|string|max:255', 'nama_usaha' => 'required|string|max:255', 'kategori' => 'required|string|max:100', 'deskripsi' => 'nullable|string', 'nomor_wa' => 'required|string|max:30', 'alamat' => 'required|string', 'maps_url' => 'required|url', 'status' => 'required|in:aktif,nonaktif']);
        $img = $old->gambar;
        if ($r->boolean('hapus_gambar')) {
            $this->deleteFile($img);
            $img = 'default.jpg';
        }
        if ($r->hasFile('gambar')) {
            $this->deleteFile($img);
            $img = $this->upload($r, 'gambar', 'umkm');
        }
        $d['gambar'] = $img;
        $d['nomor_wa'] = $this->phone($d['nomor_wa']);
        $d['harga'] = 0;
        $d['satuan'] = '-';
        DB::table('umkm')->where('id', $id)->update($d);
        return $this->back();
    }
    public function destroyUmkm(int $id)
    {
        return $this->destroy('umkm', $id, 'gambar');
    }
    private function destroy(string $table, int $id, ?string $file = null)
    {
        $x = DB::table($table)->find($id);
        abort_unless($x, 404);
        if ($file)
            $this->deleteFile($x->{$file} ?? null);
        DB::table($table)->where('id', $id)->delete();
        return $this->back();
    }
    private function back()
    {
        return redirect()->route('admin_dashboard')->with('success', 'Perubahan berhasil disimpan.');
    }
}
