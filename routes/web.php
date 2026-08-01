<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPasswordResetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
Route::get('/', [PublicController::class, 'index'])->name('index');
Route::get(
    '/beranda',
    [PublicController::class, 'listing']
)->name('listing');

/*
 * Alamat lama tetap diarahkan ke Beranda.
 */
Route::redirect(
    '/listing',
    '/beranda',
    301
);
Route::get(
    '/visimisi',
    [PublicController::class, 'profil']
)->name('profil');

/*
 * Alamat lama diarahkan ke halaman Visi & Misi.
 */
Route::redirect(
    '/profil',
    '/visimisi',
    301
);
Route::get('/struktur', [PublicController::class, 'struktur'])->name('struktur');
Route::get('/berita', [PublicController::class, 'berita'])->name('berita');
Route::get('/berita/{id}', [PublicController::class, 'beritaDetail'])->whereNumber('id')->name('berita_detail');
Route::get('/umkm', [PublicController::class, 'umkm'])->name('umkm');
Route::get(
    '/statistik',
    [PublicController::class, 'statistik']
)->name('statistik');

/*
 * Alamat lama tetap dapat dibuka dan otomatis
 * diarahkan ke halaman Statistik Desa.
 *
 * Nama route "infografis" sementara dipertahankan
 * agar menu lama tidak menyebabkan error.
 */
Route::redirect(
    '/infografis',
    '/statistik',
    301
)->name('infografis');
Route::get('/peta', [PublicController::class, 'peta'])->name('peta');
Route::get('/api/poi', [PublicController::class, 'apiPoi'])->name('api_poi');
Route::post('/api/poi', function (Request $r) {
    abort_unless(hash_equals((string) config('desa.poi_api_key', 'admin_maor_2026'), (string) $r->header('X-API-KEY')), 401);
    $d = $r->validate(['nama' => 'required', 'kategori' => 'required', 'deskripsi' => 'required', 'lat' => 'required|numeric', 'lng' => 'required|numeric']);
    $id = DB::table('poi')->insertGetId($d);
    return response()->json(['id' => $id, 'status' => 'tersimpan'], 201);
})->name('api_poi_create');
Route::get('/api/stats', [PublicController::class, 'apiStats'])->name('api_stats');
Route::get('/admin', [AuthController::class, 'show'])
    ->name('admin_login');

Route::post('/admin', [AuthController::class, 'login'])
    ->name('admin_login_submit');

Route::get(
    '/admin/lupa-password',
    [AdminPasswordResetController::class, 'showForgotForm']
)->name('password.request');

Route::post(
    '/admin/lupa-password',
    [AdminPasswordResetController::class, 'sendResetLink']
)->name('password.email');

Route::get(
    '/admin/reset-password/{token}',
    [AdminPasswordResetController::class, 'showResetForm']
)->name('password.reset');

Route::post(
    '/admin/reset-password',
    [AdminPasswordResetController::class, 'resetPassword']
)->name('password.update');

Route::middleware('admin.auth')->group(function () {
    Route::match(['get', 'post'], '/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin_dashboard');
    Route::post('/admin/dashboard/simpan', [AdminController::class, 'store'])->name('admin_store');
    Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin_logout');
    Route::get('/admin/berita/{id}/edit', [AdminController::class, 'editBerita'])->name('admin_edit_berita');
    Route::post('/admin/berita/{id}/edit', [AdminController::class, 'updateBerita'])->name('admin_update_berita');
    Route::post('/admin/berita/{id}/hapus', [AdminController::class, 'destroyBerita'])->name('admin_hapus_berita');
    Route::get('/admin/agenda/{id}/edit', [AdminController::class, 'editAgenda'])->name('admin_edit_agenda');
    Route::post('/admin/agenda/{id}/edit', [AdminController::class, 'updateAgenda'])->name('admin_update_agenda');
    Route::post('/admin/agenda/{id}/hapus', [AdminController::class, 'destroyAgenda'])->name('admin_hapus_agenda');
    Route::get('/admin/poi/{id}/edit', [AdminController::class, 'editPoi'])->name('admin_edit_poi');
    Route::post('/admin/poi/{id}/edit', [AdminController::class, 'updatePoi'])->name('admin_update_poi');
    Route::post('/admin/poi/{id}/hapus', [AdminController::class, 'destroyPoi'])->name('admin_hapus_poi');
    Route::get('/admin/struktur/{id}/edit', [AdminController::class, 'editStruktur'])->name('admin_edit_struktur');
    Route::post('/admin/struktur/{id}/edit', [AdminController::class, 'updateStruktur'])->name('admin_update_struktur');
    Route::post('/admin/struktur/{id}/hapus', [AdminController::class, 'destroyStruktur'])->name('admin_hapus_struktur');
    Route::get('/admin/umkm/{id}/edit', [AdminController::class, 'editUmkm'])->name('admin_edit_umkm');
    Route::post('/admin/umkm/{id}/edit', [AdminController::class, 'updateUmkm'])->name('admin_update_umkm');
    Route::post('/admin/umkm/{id}/hapus', [AdminController::class, 'destroyUmkm'])->name('admin_hapus_umkm');
});
