<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\skPenetapanController;
use App\Http\Controllers\IdentifikasiController;
use App\Http\Controllers\JadwalRapatController;
use App\Http\Controllers\RapatPembahasanController;
use App\Http\Controllers\NotaDinasController;
use App\Http\Controllers\NotifikasiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/', function () {
    return redirect('/dashboard');
});
Route::get('/notifikasi', [NotifikasiController::class, 'index']);
Route::get('/dashboard', [DashboardController::class, 'index']);
// Route::get('/dashboard/test', [DashboardController::class, 'test']);
Route::get('/dashboard/masa-transisi-sni-dt', [DashboardController::class, 'masaTransisiSNI']);
Route::get('/dashboard/sni-lama-pencabutan-dt', [DashboardController::class, 'SNIpencabutan']);
Route::get('/sk-penetapan', [skPenetapanController::class, 'index']);
Route::get('/sk-penetapan/rekap-petugas', [skPenetapanController::class, 'rekapPetugas']);
Route::post('/sk-penetapan/tambah-data-sk', [skPenetapanController::class, 'store']);
Route::get('/sk-penetapan/lihat-detail-sk/{id}', [skPenetapanController::class, 'lihatDetailSK']);
Route::get('/sk-penetapan/modal-sk-edit/{id}', [skPenetapanController::class, 'modalEdit']);
Route::post('/sk-penetapan/edit-data-sk', [skPenetapanController::class, 'editSK']);
Route::delete('/sk-penetapan/hapus-sni-lama/{id}', [skPenetapanController::class, 'hapusSNILama']);
Route::get('/sk-penetapan/konfirmasi-hapus-sk/{id}', [skPenetapanController::class, 'modalKonfirmasiHapusSK']);
Route::delete('/sk-penetapan/hapus-sk/{id}', [skPenetapanController::class, 'hapusSK']);
Route::get('/identifikasi-sni', [IdentifikasiController::class, 'index']);
Route::get('/identifikasi-sni/konten-super-admin', [IdentifikasiController::class, 'kontenSuperAdmin']);
Route::get('/identifikasi-sni/konten-super-admin/dt-{id}', [IdentifikasiController::class, 'dtAdmin']);
Route::get('/identifikasi-sni/konten-admin', [IdentifikasiController::class, 'kontenAdmin']);
Route::get('/identifikasi-sni/konten-admin/modal-identifikasi-edit/{id}', [IdentifikasiController::class, 'modalIdentifikasiEdit']);
Route::get('/identifikasi-sni/konten-admin/konfirmasi-ubah-sifat-sni/{id}', [IdentifikasiController::class, 'modalKonfirmasiUbahSifatSNI']);
Route::delete('/identifikasi-sni/konten-admin/ubah-sifat-sni/{id}', [IdentifikasiController::class, 'ubahSifatSNI']);
Route::post('/identifikasi-sni/identifikasi-edit', [IdentifikasiController::class, 'identifikasiEdit']);
Route::delete('/identifikasi-sni/hapus-penerap/{id}', [IdentifikasiController::class, 'hapusPenerap']);
Route::get('/identifikasi-sni/{id}', [IdentifikasiController::class, 'dtIdentifikasi']);
Route::get('/jadwal-rapat', [JadwalRapatController::class, 'index']);
Route::get('/jadwal-rapat/data-sni-lama', [JadwalRapatController::class, 'modalSNILama']);
Route::get('/jadwal-rapat/data-penerap/{id}', [JadwalRapatController::class, 'penerapModalSNILama']);
Route::get('/jadwal-rapat/tambah-sni-lama/{id}', [JadwalRapatController::class, 'tambahSNILama']);
Route::post('/jadwal-rapat/simpan-jadwal-rapat', [JadwalRapatController::class, 'simpanJadwalRapat']);
Route::get('/jadwal-rapat/lihat-detail-jadwal-rapat/{id}', [JadwalRapatController::class, 'lihatDetailJadwalRapat']);
Route::get('/jadwal-rapat/export-bahan-rapat/{id}', [JadwalRapatController::class, 'export']);    
Route::get('/jadwal-rapat/konfirmasi-hapus-jadwal-rapat/{id}', [JadwalRapatController::class, 'modalKonfirmasiHapusJadwalRapat']);
Route::delete('/jadwal-rapat/hapus-jadwal-rapat/{id}', [JadwalRapatController::class, 'hapusJadwalRapat']);
Route::get('/rapat-pembahasan', [RapatPembahasanController::class, 'index']);
Route::get('/rapat-pembahasan/konten-super-admin', [RapatPembahasanController::class, 'kontenSuperAdmin']);
Route::get('/rapat-pembahasan/konten-super-admin/lihat-detail-pembahasan/{id}', [RapatPembahasanController::class, 'detailPembahasan']);
Route::get('/rapat-pembahasan/konten-super-admin/export-rapat-pembahasan/{id}', [RapatPembahasanController::class, 'export']);
Route::get('/rapat-pembahasan/konten-admin/', [RapatPembahasanController::class, 'kontenAdmin']);
Route::get('/rapat-pembahasan/konten-admin/pembahasan-dt/{id}', [RapatPembahasanController::class, 'dt_pembahasan']);
Route::get('rapat-pembahasan/data-pembahasan/{id}', [RapatPembahasanController::class, 'dataPembahasan']);
Route::post('/rapat-pembahasan/simpan-data-pembahasan', [RapatPembahasanController::class, 'simpanDataPembahasan']);
Route::get('/rapat-pembahasan/konfirmasi-hapus-sni/{id}', [RapatPembahasanController::class, 'modalKonfirmasiHapusSNI']);
Route::get('/rapat-pembahasan/data-penerap/{id}', [RapatPembahasanController::class, 'penerapModalSNILama']);
Route::delete('/rapat-pembahasan/hapus-sni/{id}', [RapatPembahasanController::class, 'hapusSNILama']);
Route::get('/nota-dinas', [NotaDinasController::class, 'index']);
Route::get('/nota-dinas/data-pilihan-tanggal-rapat', [NotaDinasController::class, 'pilihanTanggalRapat']);
Route::get('/nota-dinas/data-pencabutan/{id}', [NotaDinasController::class, 'datapencabutan']);
Route::get('/nota-dinas/data-transisi/{id}', [NotaDinasController::class, 'dataTransisi']);
Route::post('/nota-dinas/tambah-data-nodin', [NotaDinasController::class, 'store']);
Route::get('/nota-dinas/konfirmasi-hapus-nota-dinas/{id}', [NotaDinasController::class, 'modalKonfirmasiHapusNotaDinas']);
Route::delete('/nota-dinas/hapus-nota-dinas/{id}', [NotaDinasController::class, 'hapusNotaDinas']);
Route::get('/nota-dinas/modal-update-tahap-nota-dinas/{id}', [NotaDinasController::class, 'modalUpdateNotaDinas']);
Route::post('/nota-dinas/update-tahap-nota-dinas/{id}', [NotaDinasController::class, 'updateNotaDinas']);
