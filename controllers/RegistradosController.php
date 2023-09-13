<?php

namespace Controllers;
use MVC\Router;

class Registradoscontroller {
    public static function index(Router $router){
        $router->render('admin/registrados/index', [
            'titulo' => 'Usuarios Regitrados'
        ]);
    }
}