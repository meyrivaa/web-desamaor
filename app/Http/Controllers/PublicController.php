<?php
namespace App\Http\Controllers;
use Carbon\Carbon; use Illuminate\Http\JsonResponse; use Illuminate\Support\Facades\DB; use Illuminate\View\View;
class PublicController extends Controller {
 private function desa(): array { return config('desa'); }
 private function rows(string $table, ?callable $query=null): array { $q=DB::table($table); if($query) $query($q); return $q->get()->map(fn($r)=>(array)$r)->all(); }
 public function index(){ return redirect()->route('listing'); }
 public function listing(): View {
  $today=Carbon::now('Asia/Jakarta')->toDateString(); DB::table('kunjungan')->insertOrIgnore(['tanggal'=>$today,'jumlah'=>0]); DB::table('kunjungan')->where('tanggal',$today)->increment('jumlah');
  $agenda=$this->rows('agenda',fn($q)=>$q->orderBy('tanggal'));
  $bulan=['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
  $agenda=array_map(function($a)use($bulan){try{$d=Carbon::parse($a['tanggal']);$a['tgl_angka']=$d->format('d');$a['bln_teks']=$bulan[$d->month-1];}catch(\Throwable){$a['tgl_angka']='--';$a['bln_teks']='--';}return $a;},$agenda);
  $kepala=DB::table('struktur_organisasi')->whereRaw("LOWER(TRIM(jabatan)) = ?",['kepala desa'])->orderBy('urutan')->orderBy('id')->first();
  return view('listing',['desa'=>$this->desa(),'stats'=>$this->stats(),'agenda'=>$agenda,'kepala_desa'=>$kepala?(array)$kepala:null]);
 }
 public function profil(): View { return view('profil',['desa'=>$this->desa()]); }
 public function struktur(): View { return view('struktur',['desa'=>$this->desa(),'daftar_struktur'=>$this->rows('struktur_organisasi',fn($q)=>$q->orderBy('urutan')->orderBy('id'))]); }
 public function berita(): View { return view('berita',['desa'=>$this->desa(),'berita'=>$this->rows('berita',fn($q)=>$q->orderByDesc('id'))]); }
 public function beritaDetail(int $id): View { $r=DB::table('berita')->find($id); abort_unless($r,404); return view('berita_detail',['desa'=>$this->desa(),'item'=>(array)$r]); }
 public function umkm(): View { return view('umkm',['desa'=>$this->desa(),'daftar_umkm'=>$this->rows('umkm',fn($q)=>$q->where('status','aktif')->orderByDesc('id'))]); }
 public function infografis(): View { return view('infografis',['desa'=>$this->desa(),'infografis'=>$this->rows('infografis',fn($q)=>$q->orderByDesc('id'))]); }
 public function peta(): View { return view('peta',['desa'=>$this->desa(),'poi_data'=>$this->rows('poi')]); }
 public function apiPoi(): JsonResponse { $warna=['Pemerintahan'=>'#2f7567','Pertanian'=>'#4f8a5b','Pengairan'=>'#3b82f6','Peribadatan'=>'#7c5aa6','Pendidikan'=>'#3f6fa8','Kesehatan'=>'#c34f4f','Usaha Warga'=>'#d17a32']; $data=array_map(function($r)use($warna){$r['warna']=$warna[$r['kategori']]??'#607d8b';return $r;},$this->rows('poi',fn($q)=>$q->orderBy('id'))); return response()->json(['pusat'=>$this->desa()['peta_pusat'],'titik'=>$data]); }
 public function apiStats(): JsonResponse { return response()->json($this->stats()); }
 private function stats(): array { $t=Carbon::now('Asia/Jakarta')->startOfDay(); $sum=fn($a,$b)=>DB::table('kunjungan')->whereBetween('tanggal',[$a->toDateString(),$b->toDateString()])->sum('jumlah'); $on=fn($d)=>(int)(DB::table('kunjungan')->where('tanggal',$d->toDateString())->value('jumlah')??0); $week=$t->copy()->startOfWeek(); $lastWeek=$week->copy()->subWeek(); $month=$t->copy()->startOfMonth(); $lastMonth=$month->copy()->subMonth(); return ['hari_ini'=>$on($t),'kemarin'=>$on($t->copy()->subDay()),'minggu_ini'=>$sum($week,$t),'minggu_lalu'=>$sum($lastWeek,$week->copy()->subDay()),'bulan_ini'=>$sum($month,$t),'bulan_lalu'=>$sum($lastMonth,$month->copy()->subDay()),'total'=>(int)DB::table('kunjungan')->sum('jumlah')]; }
}
