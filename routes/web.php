<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\paciente\ListarPacienteController;
use App\Http\Controllers\paciente\PacienteController;
use App\Http\Controllers\paciente\DetallarPacienteController;
use App\Http\Controllers\configuracion\CantonController;
use App\Http\Controllers\configuracion\CategoriaController;
use App\Http\Controllers\citas\CitasController;
use App\Http\Controllers\consultas\ConsultaController;
use App\Http\Controllers\especialista\EspecialistaController;
use App\Http\Controllers\reportes\CitaReporteController;
use App\Http\Controllers\liquidaciones\PagoController;
use GuzzleHttp\Psr7\Request;

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

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('home', 'home')->name('home');
});



Route::get('paciente/mostrar', [ListarPacienteController::class, 'index'])->name('mostrar.persona');
Route::post('paciente/listar', [ListarPacienteController::class, 'listar'])->name('listar.persona');
Route::get('paciente/ingresar', [PacienteController::class, 'index'])->name('ingresar.persona');
Route::post('paciente/guardar', [PacienteController::class, 'store'])->name('guardar.persona');
Route::patch('paciente/actualizar/{id}', [PacienteController::class, 'update'])->name('actualizar.paciente');
Route::post('paciente/foto', [DetallarPacienteController::class, 'guardarFoto'])->name('foto.persona');
Route::post('paciente/archivo', [DetallarPacienteController::class, 'guardarArchivo'])->name('guardar.archivo');
Route::get('paciente/detallar/{id}',[DetallarPacienteController::class, 'index'])->name('detallar.persona');
Route::get('paciente/editar/{id}',[PacienteController::class, 'edit'])->name('editar.paciente');
Route::post('paciente/verificar', [PacienteController::class, 'verificarCedula'])->name('verificar.persona');
Route::post('canton/obtener', [CantonController::class, 'obtener'])->name('canton.obtener');
Route::get('usuario/listar', [ListarUsuarioController::class, 'index'])->name('listar.usuario');
Route::get('usuario/crear', [CrearUsuarioController::class, 'index'])->name('crear.usuario');
Route::post('usuario/guardar',[CrearUsuarioController::class, 'guardar'])->name('guardar.usuario');
Route::post('usuario/verificar',[CrearUsuarioController::class, 'verificarUsuario'])->name('verificar.usuario');
Route::get('usuario/detallar/{idusuario}/persona/{idpersona}', [DetallarUsuarioController::class, 'index'])->name('detallar.usuario');

Route::post('especialista/lista', [EspecialistaController::class, 'list'])->name('list.especialista');

Route::get('cita', [CitasController::class, 'index'])->name('index.cita');
Route::get('cita/ingresar', [CitasController::class, 'create'])->name('create.cita');
Route::get('cita/{id}/editar', [CitasController::class, 'edit'])->name('edit.cita');
Route::post('cita', [CitasController::class, 'store'])->name('store.cita');
Route::post('cita/listar', [CitasController::class, 'list'])->name('list.cita');
Route::patch('cita/{id}', [CitasController::class, 'update'])->name('update.cita');
Route::post('cita/cancel', [CitasController::class, 'cancel'])->name('cancel.cita');

Route::get('pago/{id}', [PagoController::class, 'index'])->name('index.pago');

Route::get('citareporte/ficha/{id}', [CitaReporteController::class, 'index'])->name('ficha.citareporte');
Route::get('citareporte/recibo/{id}', [CitaReporteController::class, 'recibo'])->name('recibo.citareporte');

Route::get('categoria/{id?}', [CategoriaController::class, 'index'])->name('index.categoria');
Route::post('categoria', [CategoriaController::class, 'store'])->name('store.categoria');
Route::post('categoria/obtener', [CategoriaController::class, 'getValue'])->name('obtener.categoria');



Route::get('consulta/ingresar/{id}', [ConsultaController::class, 'create'])->name('create.consulta');
Route::post('consulta', [ConsultaController::class, 'store'])->name('store.consulta');
