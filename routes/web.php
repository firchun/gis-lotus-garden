<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Route::get('/', [App\Http\Controllers\PageController::class, 'index']);
Route::get('/about', [App\Http\Controllers\PageController::class, 'about']);
Route::get('/maps', [App\Http\Controllers\PageController::class, 'maps']);
Route::get('/check-tiket', [App\Http\Controllers\PageController::class, 'tiket']);
Route::get('/semua-fasilitas', [App\Http\Controllers\PageController::class, 'fasilitas']);
Route::get('/form-pemesanan', [App\Http\Controllers\PageController::class, 'form']);
//simpan tiket
Route::post('/tiket/store', [App\Http\Controllers\TiketController::class, 'store'])->name('tiket.store');
Route::get('barcode/{filename}', function ($filename) {
    $path = storage_path('app/barcodes/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    return response($file, 200)->header('Content-Type', $type);
});
Route::get('/download-tiket/{barcode}', [TiketController::class, 'downloadPdf'])->name('download-tiket');
Route::post('/search-tiket', [PageController::class, 'search_tiket'])->name('search-tiket');

Route::get('/detail-tiket/{barcode}', [App\Http\Controllers\PageController::class, 'detail_tiket'])->name('detail-tiket');
Route::get('/detail-fasilitas/{slug}', [App\Http\Controllers\PageController::class, 'detail'])->name('detail-fasilitas');

Auth::routes(['register' => false, 'reset' => false]);
Route::middleware(['auth:web'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/setting', [App\Http\Controllers\SettingController::class, 'index'])->name('setting');
    Route::post('/setting/update', [App\Http\Controllers\SettingController::class, 'update'])->name('setting.update');

    //akun managemen
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //customers managemen
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::post('/customers/store',  [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/edit/{id}',  [CustomerController::class, 'edit'])->name('customers.edit');
    Route::delete('/customers/delete/{id}',  [CustomerController::class, 'destroy'])->name('customers.delete');
    Route::get('/customers-datatable', [CustomerController::class, 'getCustomersDataTable']);
});
Route::middleware(['auth:web', 'role:Admin'])->group(function () {
    //fasilitas
    Route::get('/fasilitas', [FasilitasController::class, 'index'])->name('fasilitas');
    Route::post('/fasilitas/store',  [FasilitasController::class, 'store'])->name('fasilitas.store');
    Route::get('/fasilitas/edit/{id}',  [FasilitasController::class, 'edit'])->name('fasilitas.edit');
    Route::delete('/fasilitas/delete/{id}',  [FasilitasController::class, 'destroy'])->name('fasilitas.delete');
    Route::get('/fasilitas-datatable', [FasilitasController::class, 'getFasilitasDataTable']);
    //tiket
    Route::get('/tiket', [TiketController::class, 'index'])->name('tiket');
    Route::get('/update-tiket', [TiketController::class, 'update_tiket'])->name('update-tiket');
    Route::post('/tiket/store',  [TiketController::class, 'store'])->name('tiket.store');
    Route::post('/tiket/update',  [TiketController::class, 'update'])->name('tiket.update');
    Route::get('/tiket/get-one/{barcode}',  [TiketController::class, 'getOne'])->name('tiket.get-one');
    Route::get('/tiket-datatable', [TiketController::class, 'getTiketDataTable']);
    //user managemen
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::post('/users/store',  [UserController::class, 'store'])->name('users.store');
    Route::get('/users/edit/{id}',  [UserController::class, 'edit'])->name('users.edit');
    Route::delete('/users/delete/{id}',  [UserController::class, 'destroy'])->name('users.delete');
    Route::get('/users-datatable', [UserController::class, 'getUsersDataTable']);
});
