<?php
use App\Http\Controllers\PropuestaController;
use App\Http\Controllers\DirectionController;
use App\Http\Controllers\PdfController;
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

Route::get('/', [PropuestaController::class,'index'])->name('propuesta');

    Route::get('/propuesta/{encrypt}', [PropuestaController::class,'editPropuesta'])->name('propuesta.edit');
    Route::get('/{encrypt?}', [PropuestaController::class,'index'])->name('propuesta');
    Route::get('/condicionesCompra/{id?}', [PropuestaController::class,'condicionesCompra'])->name('propuesta.condicionesCompra');
    Route::get('/create', [PropuestaController::class,'create'])->name('propuesta.create');
    Route::get('/type/{code_type_person?}', [PropuestaController::class,'type'])->name('propuesta.type');
    Route::post('/search', [PropuestaController::class,'search'])->name('propuesta.search');
    Route::post('/details', [PropuestaController::class,'details'])->name('propuesta.details');
    Route::post('/store', [PropuestaController::class,'store'])->name('propuesta.store');
    Route::post('/update', [PropuestaController::class,'update'])->name('propuesta.update');
    Route::post('/store_attorney', [PropuestaController::class,'store_attorney'])->name('propuesta.store_attorney');
    Route::post('/opt', [PropuestaController::class,'opt'])->name('propuesta.opt');
    Route::post('propuesta/optfirma', [PropuestaController::class,'optfirma'])->name('propuesta.optfirma');
    Route::post('/valid_opt', [PropuestaController::class,'valid_opt'])->name('propuesta.valid_opt');
    Route::post('/valid_vendor', [PropuestaController::class,'valid_vendor'])->name('propuesta.valid_vendor');
    Route::post('/search_plan', [PropuestaController::class,'search_plan'])->name('propuesta.search_plan');
    Route::post('/valid', [PropuestaController::class,'valid'])->name('valid');
    Route::post('/rut', [PropuestaController::class,'rut'])->name('propuesta.rut');
    Route::post('/certificado/{id_enterprise?}/', [PropuestaController::class,'certificado'])->name('propuesta.certificado');
    Route::get('propuesta/pdf/{encrypt}', [PropuestaController::class,'exportPdf'])->name('propuesta.pdf');
    Route::post('propuesta/firmado', [PropuestaController::class,'firmarpdf'])->name('propuesta.firmar');
    Route::get('/typeFormat/{val?}', [PropuestaController::class,'typeFormat'])->name('typeFormat');

Route::group(['prefix' => 'direccion'], function () {
    Route::get('/municipality/{code_department?}', [DirectionController::class,'municipality'])->name('direction.municipality');
    Route::get('/cities/{code_municipality?}/{code_department?}', [DirectionController::class,'city'])->name('direction.city');
});



Route::group(['prefix' => 'certificado'], function () {
    Route::get('/', [PdfController::class,'index'])->name('certificado.lista');
    Route::get('/{id_enterprise?}/reporte/', [PdfController::class,'pdf'])->name('certificado.report');
});