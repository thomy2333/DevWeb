<?php

namespace Controllers;

use MVC\Router;
use Model\Paquete;
use Model\Usuario;
use Model\Registro;

class RegistroController {
    public static function crear(Router $router){

        $router->render('registro/crear', [
            'titulo' => 'Finalizar Registro',
        ]);
    }

    public static function gratis(Router $router){

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_auth()){
                header('location: /login');
            }

            $token = substr( md5( uniqid( rand(), true)), 0, 8);

            //crear registro
            $datos = array(
                'paquete_id' => 3,
                'pago_id' => '',
                'token' => $token,
                'usuario_id' => $_SESSION['id']
            );

            $registro = new Registro($datos);
            $resultado = $registro->guardar();

            if($resultado){
                header('location: /boleto?id=' . urlencode($registro->token));
            }          

        }
    }

    public static function boleto(Router $router){

        //validar la url
        $id = $_GET['id'];

        if(!$id || !strlen($id) === 8){
            header('location: /');
        }

        //buscar en la base de datos
        $registro = Registro::where('token' ,$id);
        if(!$registro){
            header('location: /');
        }

        //lenar las tablas de refeencia
        $registro->usuario = Usuario::find($registro->usuario_id);
        $registro->paquete = Paquete::find($registro->paquete_id);

        $router->render('registro/boleto', [
            'titulo' => 'Asistencia a DevWebCamp',
            'registro' => $registro
        ]);
    }

}