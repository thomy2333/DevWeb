<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\APIEventos;
use Controllers\APIPonentes;
use MVC\Router;
use Controllers\AuthController;
use Controllers\DashboardController;
use Controllers\Eventocontroller;
use Controllers\PaginasControllers;
use Controllers\PonentesController;
use Controllers\RegalosController;
use Controllers\Registradoscontroller;

$router = new Router();


// Login
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);

// Crear Cuenta
$router->get('/registro', [AuthController::class, 'registro']);
$router->post('/registro', [AuthController::class, 'registro']);

// Formulario de olvide mi password
$router->get('/olvide', [AuthController::class, 'olvide']);
$router->post('/olvide', [AuthController::class, 'olvide']);

// Colocar el nuevo password
$router->get('/reestablecer', [AuthController::class, 'reestablecer']);
$router->post('/reestablecer', [AuthController::class, 'reestablecer']);

// Confirmación de Cuenta
$router->get('/mensaje', [AuthController::class, 'mensaje']);
$router->get('/confirmar-cuenta', [AuthController::class, 'confirmar']);

//area de administracion
$router->get('/admin/dashboard', [DashboardController::class, 'index']);

$router->get('/admin/ponentes', [PonentesController::class, 'index']);
$router->get('/admin/ponentes/crear', [PonentesController::class, 'crear']);
$router->post('/admin/ponentes/crear', [PonentesController::class, 'crear']);
$router->get('/admin/ponentes/editar', [PonentesController::class, 'editar']);
$router->post('/admin/ponentes/editar', [PonentesController::class, 'editar']);
$router->post('/admin/ponentes/eliminar', [PonentesController::class, 'eliminar']);


$router->get('/admin/eventos', [Eventocontroller::class, 'index']);
$router->get('/admin/eventos/crear', [Eventocontroller::class, 'crear']);
$router->post('/admin/eventos/crear', [Eventocontroller::class, 'crear']);
$router->get('/admin/eventos/editar', [Eventocontroller::class, 'editar']);
$router->post('/admin/eventos/editar', [Eventocontroller::class, 'editar']);
$router->post('/admin/eventos/eliminar', [Eventocontroller::class, 'eliminar']);

$router->get('/api/eventos-horario', [APIEventos::class, 'index']);
$router->get('/api/ponentes', [APIPonentes::class, 'index']);
$router->get('/api/ponente', [APIPonentes::class, 'ponente']);

$router->get('/admin/registrados', [Registradoscontroller::class, 'index']);
$router->get('/admin/regalos', [RegalosController::class, 'index']);

//area publica
$router->get('/', [PaginasControllers::class, 'index']);
$router->get('/devwebcamp', [PaginasControllers::class, 'evento']);
$router->get('/paquetes', [PaginasControllers::class, 'paquetes']);
$router->get('/workshops-conferencia', [PaginasControllers::class, 'conferencias']);


$router->comprobarRutas();