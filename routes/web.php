<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\paciente\ListarPacienteController;
use App\Http\Controllers\paciente\PacienteController;
use App\Http\Controllers\paciente\DetallarPacienteController;
use App\Http\Controllers\configuracion\CantonController;
use App\Http\Controllers\configuracion\CategoriaController;
use App\Http\Controllers\configuracion\ServicioController;
use App\Http\Controllers\configuracion\RolesController;
use App\Http\Controllers\configuracion\PermissionController;
use App\Http\Controllers\configuracion\AssignRoles;
use App\Http\Controllers\citas\CitasController;
use App\Http\Controllers\consultas\ConsultaController;
use App\Http\Controllers\especialista\EspecialistaController;
use App\Http\Controllers\reportes\CitaReporteController;
use App\Http\Controllers\liquidaciones\PagoController;
use App\Http\Controllers\usuarios\DetallarUsuarioController;
use App\Http\Controllers\usuarios\UsuarioController;
use App\Http\Controllers\HomeController;
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
    //Route::view('home', 'home')->name('home');

    Route::get('home', [HomeController::class, 'index'])->name('home');

    Route::get('paciente/mostrar', [ListarPacienteController::class, 'index'])->name('mostrar.persona');
    Route::post('paciente/listar', [ListarPacienteController::class, 'listar'])->name('listar.persona');
    Route::get('paciente/ingresar', [PacienteController::class, 'create'])->name('ingresar.persona');
    Route::post('paciente/guardar', [PacienteController::class, 'store'])->name('guardar.persona');
    Route::patch('paciente/actualizar/{id}', [PacienteController::class, 'update'])->name('actualizar.paciente');
    Route::post('paciente/foto', [DetallarPacienteController::class, 'guardarFoto'])->name('foto.persona');
    Route::post('paciente/archivo', [DetallarPacienteController::class, 'guardarArchivo'])->name('guardar.archivo');
    Route::get('paciente/descargar/{id}', [DetallarPacienteController::class, 'descargar'])->name('descargar.archivo');
    Route::get('paciente/detallar/{id}',[DetallarPacienteController::class, 'index'])->name('detallar.persona');
    Route::get('paciente/editar/{id}',[PacienteController::class, 'edit'])->name('editar.paciente');
    Route::post('paciente/verificar', [PacienteController::class, 'verificarCedula'])->name('verificar.persona');
    Route::post('canton/obtener', [CantonController::class, 'obtener'])->name('canton.obtener');

    Route::post('especialista/lista', [EspecialistaController::class, 'list'])->name('list.especialista');
    //Route::post('especialista/listar', [EspecialistaController::class, 'list'])->name('listar.especialista');
    Route::get('especialista', [EspecialistaController::class, 'index'])->name('index.especialista');
    Route::post('especialista', [EspecialistaController::class, 'store'])->name('store.especialista');
    Route::patch('especialista', [EspecialistaController::class, 'update'])->name('update.especialista');
    Route::get('especialista/ingresar', [EspecialistaController::class, 'create'])->name('create.especialista');
    Route::get('especialista/{id}/editar', [EspecialistaController::class, 'edit'])->name('edit.especialista');
    Route::get('especialista/{id}/detallar',[EspecialistaController::class, 'show'])->name('detallar.especialista');

    Route::get('usuario', [UsuarioController::class, 'index'])->name('index.usuario');
    Route::post('usuario/listar', [UsuarioController::class, 'list'])->name('list.usuario');
    Route::get('usuario/crear', [UsuarioController::class, 'create'])->name('create.usuario');
    Route::get('usuario/{id}/editar', [UsuarioController::class, 'edit'])->name('edit.usuario');
    Route::post('usuario',[UsuarioController::class, 'store'])->name('store.usuario');
    Route::patch('usuario/{id}',[UsuarioController::class, 'update'])->name('update.usuario');
    Route::post('usuario/verificar',[CrearUsuarioController::class, 'verificarUsuario'])->name('verificar.usuario');
    Route::get('usuario/detallar/{idusuario}/persona/{idpersona}', [DetallarUsuarioController::class, 'index'])->name('detallar.usuario');
    Route::get('usuario/perfil/{id}', [DetallarUsuarioController::class, 'show'])->name('show.usuario');


    Route::post('servicios/lista', [ServicioController::class, 'list'])->name('list.servicios');

    Route::get('cita', [CitasController::class, 'index'])->name('index.cita');
    Route::get('cita/ingresar', [CitasController::class, 'create'])->name('create.cita');
    Route::get('cita/{id}/editar', [CitasController::class, 'edit'])->name('edit.cita');
    Route::post('cita', [CitasController::class, 'store'])->name('store.cita');
    Route::post('cita/listar', [CitasController::class, 'list'])->name('list.cita');
    Route::patch('cita/{id}', [CitasController::class, 'update'])->name('update.cita');
    Route::post('cita/cancel', [CitasController::class, 'cancel'])->name('cancel.cita');

    Route::get('pago/{id}', [PagoController::class, 'index'])->name('index.pago');
    Route::post('pago', [PagoController::class, 'store'])->name('store.pago');
    Route::get('recibo/{id}', [PagoController::class, 'recibo'])->name('recibo.pago');

    Route::get('citareporte/ficha/{id}', [CitaReporteController::class, 'index'])->name('ficha.citareporte');
    Route::get('citareporte/recibo/{id}', [CitaReporteController::class, 'recibo'])->name('recibo.citareporte');

    Route::get('categoria/{id?}', [CategoriaController::class, 'index'])->name('index.categoria');
    Route::post('categoria', [CategoriaController::class, 'store'])->name('store.categoria');
    Route::post('categoria/obtener', [CategoriaController::class, 'getValue'])->name('obtener.categoria');


    Route::get('consulta', [ConsultaController::class, 'index'])->name('index.consulta');
    Route::get('consulta/ingresar/{id}', [ConsultaController::class, 'create'])->name('create.consulta');
    Route::get('consulta/{id}/editar', [ConsultaController::class, 'edit'])->name('edit.consulta');
    Route::post('consulta', [ConsultaController::class, 'store'])->name('store.consulta');
    Route::patch('consulta', [ConsultaController::class, 'update'])->name('update.consulta');
    Route::post('consulta/listar', [ConsultaController::class, 'list'])->name('list.consulta');

    Route::get('asignacion/crear', [AssignRoles::class, 'create'])->name('create.assign');

    Route::get('roles', [RolesController::class, 'index'])->name('index.roles');
    Route::post('roles/listar', [RolesController::class, 'list'])->name('list.roles');
    Route::get('roles/{id}/editar', [RolesController::class, 'edit'])->name('edit.roles');
    Route::get('roles/ingresar', [RolesController::class, 'create'])->name('create.roles');
    Route::patch('roles', [RolesController::class, 'update'])->name('update.roles');
    Route::post('roles', [RolesController::class, 'store'])->name('store.roles');

    Route::post('permissions/obtener', [PermissionController::class, 'obtener'])->name('obtener.permissions');

});



