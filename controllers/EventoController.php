<?php

namespace Controllers;
use MVC\Router;

class Eventocontroller {
    public static function index(Router $router){
        $router->render('admin/eventos/index', [
            'titulo' => 'Conferencias y Workshops'
        ]);
    }
}