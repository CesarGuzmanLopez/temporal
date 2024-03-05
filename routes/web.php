<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ConsultaUsuario;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VerifyMailController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\LtiController;

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
Route::get('/', [AuthController::class, 'index'])->name('index');

Route::get('get-ladas/{id}', [HomeController::class, 'getLadas']);
Route::get('get-municipios/{entidad}', [HomeController::class, 'getMunicipios']);
Route::get('get-localidades/{entidad}/{municipio}', [HomeController::class, 'getLocalidades']);
Route::get('get-cct/{entidad}/{municipio}/{localidad}', [HomeController::class, 'getCcts']);
Route::get('valida-cct/{cct}', [HomeController::class, 'validaCCT']);
Route::get('get-libros/{usuario_id}/{cct}', [HomeController::class, 'getGrados'])->name('get-libros');
Route::get('valida-correo/{correo}', [HomeController::class, 'validaCorreo']);
Route::get('home', [HomeController::class, 'index'])->name('home');

Route::post('insertaLibros',[HomeController::class, 'insertaAdopciones'])->name('insertaLibros');

// E-mail verification
Route::get('/register/verify/{code}',[VerifyMailController::class, 'verify'])->name('verify.email');
// E-mail reset
Route::post('/reset', [VerifyMailController::class, 'recuperaPassword'])->name('recupera.password');
Route::get('/restore/password/{code}', [VerifyMailController::class, 'introducePassword'])->name('new.password');
// New Password
Route::post('/save/password', [VerifyMailController::class, 'savePassword'])->name('save.password');


//Login ruta
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');

//MEE login
Route::get('login/mee', [AuthController::class, 'handleMeeCallback'])->name('login.mee');
Route::get('login/lti/mee', [AuthController::class, 'redirectToLtiMee'])->name('login.lti.mee');


// Google login
Route::get('login/google', [AuthController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [AuthController::class, 'handleGoogleCallback']);

// Facebook login
Route::get('login/facebook', [AuthController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [AuthController::class, 'handleFacebookCallback']);

// Microsoft login
Route::get('login/microsoft', [AuthController::class, 'redirectToMicrosoft'])->name('login.microsoft');
Route::get('login/microsoft/callback', [AuthController::class, 'handleMicrosoftCallback']);

//Registro ruta
Route::get('registration', [RegisterController::class, 'registration'])->name('register');
//Registro form
Route::post('post-registration', [RegisterController::class, 'postRegistration'])->name('register.post');
//Completa datos paso1
Route::get('edit-post-p1', [RegisterController::class, 'postEditPaso1'])->name('edit.post.paso1')->middleware('auth');

//Completa datos paso2
Route::post('edit-post-p2', [RegisterController::class, 'postEditPaso2'])->name('post.edit.paso2');

//Dashboard
Route::get('dashboard/{usuario_id}', [DashboardController::class, 'construye_dashboard'])->name('assemble')->middleware('auth');


//Login CED
Route::get('loginCED/{idusuario}',[DashboardController::class, 'loginCED'])->name('loginCED');

//Activa Licencia
Route::post('addLicencia', [DashboardController::class, 'activaLicencia'])->name('activa.licencia');
Route::post('addLicenciaCED', [DashboardController::class, 'activaLicenciaCED'])->name('activa.licenciaCED');
Route::get('getssorequest/{sso}/{idusuario}',[DashboardController::class, 'getSsoRequest'])->name('getssorequest');

//Consulta usuarios
Route::get('usuarioForm', [ConsultaUsuario::class, 'index'])->name('usuario.form');
Route::get('usuarioConsulta', [ConsultaUsuario::class, 'searchUsuario'])->name('usuario.consulta');
Route::post('usuarioExportar', [ConsultaUsuario::class, 'exportarUsuario'])->name('usuario.exportar');
Route::post('usuarioEditar', [ConsultaUsuario::class, 'editarUsuario'])->name('usuario.editar');
Route::post('usuarioEditarFoto', [ConsultaUsuario::class, 'editarFotoUsuario'])->name('usuario.editarFoto');
Route::post('usuarioEditarPassword', [ConsultaUsuario::class, 'editarPasswordUsuario'])->name('usuario.editarPassword');

//Agregar  CCT
Route::post('agregarCct', [DashboardController::class, 'agregarCct'])->name('dashboard.agregarCct');

//Borrar CCT
Route::post('borrarCct', [ConsultaUsuario::class, 'eliminarCct'])->name('usuario.borrarCct');

//Edicion de datos
Route::get('dashboard/editarDatos/{usuario_id?}/{cct_actual?}', [ConsultaUsuario::class, 'editarUsuarioDatos'])->name('usuario.editarDatos');

//url donde regresa la respuesta TOKEN de 360macmillan
Route::post('getssorequestmacmillan',[DashboardController::class, 'getSsoRequestMacmillan'])->name('getssorequestmacmillan');

//url donde regresa la respuesta TOKEN de 360castillo
Route::post('getssorequestcastillo',[DashboardController::class, 'getSsoRequestCastillo'])->name('getssorequestcastillo');

Route::get('getssoappcastillo/{idusuario}',[DashboardController::class, 'ssoAppCastillo'])->name('getssoAppCastillo');

/*
Route::get('wslibros_appcastillo/{idusuario}',[DashboardController::class, 'sendLibrosAppCastillo'])->name('sendlibrosappCastillo');
Route::get('wslibros_appmacmillan/{idusuario}',[DashboardController::class, 'sendLibrosAppMacmillan'])->name('sendlibrosappMacmillan');
*/

Route::get('validaguias/{idusuario}',[DashboardController::class, 'validaGuias_appCastillo'])->name('validaGuias');

//url donde regresa respuesta TOKEN GUIAS
Route::post('getssorequestguias',[DashboardController::class, 'getSsoRequestGuias'])->name('getssorequestguias');

//Se inhabilitan los metodos Socialite del login para ocuparlos de forma manual
Auth::routes([
    'login' => false,
    'register' => false,
    'verify' => false,
    'logout' => false,
]);

//Route::get('/password/reset', [AuthController::class, 'reset']);

//Rutas para metodos de verificacion y reestablecimeinto de contrasena ocupando Socialite
//Route::group(['middleware' => ['auth']], function() {
    //Route::get('/email/verify', [VerificationController::class,'show'])->name('verification.notice');
    //Route::get('/email/verify/{id}/{hash}',  [VerificationController::class,'verify'])->name('verification.verify')->middleware(['signed']);
    //Route::post('/email/resend',  [VerificationController::class,'resend'])->name('verification.resend');
//});

//Acceso a estas rutas si esta autenticado y verificado
Route::group(['middleware' => ['auth']], function() {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
});

Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('servicios/mesadeayuda/soporte',  [AuthController::class, 'helpdesk'])->name('helpdesk');

Route::post('servicios/mesadeayuda/soporte/validacorreo', [AuthController::class, 'busca_cuenta'])->name('validacorreo');

Route::get('servicios/mesadeayuda/soporte/validacuenta/{idusuario}',[AuthController::class,'valida_cuenta'])->name('validacuenta');

Route::get('servicios/mesadeayuda/soporte/validacuentamesaayuda/{idusuario}',[AuthController::class,'valida_cuenta_mesa_ayuda'])->name('validacuenta_mesaayuda');


// Route::get('/forgot-password', function () {
//     return view('auth.forgot-password');
// })->middleware('guest')->name('password.request');

//Ruta para el cambio de idioma
Route::get('/set_language/{lang}', [App\Http\Controllers\Controller::class, 'set_language'])->name('set_language');

// Manager colegios
Route::get('moduloEscuelas/{cct}/{castillo_id}', [DashboardController::class, 'moduloEscuelas'])->name('moduloEscuelas')->middleware('auth');


//LTI
Route::any('/lti', [App\Http\Controllers\LtiController::class, 'ltiMessage']);
Route::get('/lti/jwks', [App\Http\Controllers\LtiController::class, 'getJWKS']);
