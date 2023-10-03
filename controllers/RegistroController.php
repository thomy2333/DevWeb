<?php

namespace Controllers;

use MVC\Router;
use Model\Paquete;
use Model\Usuario;
use Model\Registro;

class RegistroController {
    public static function crear(Router $router){

        if(!is_auth()){
            header('location: /');
        }

        //vewrificar si el usuario ya esta registrado
        $registro = Registro::where('usuario_id', $_SESSION['id']);

        if(isset($registro) && $registro->paquete_id === "3"){
            header('location: /boleto?id=' . urlencode($registro->token));
        }

        $router->render('registro/crear', [
            'titulo' => 'Finalizar Registro',
        ]);
    }

    public static function gratis(Router $router){

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_auth()){
                header('location: /login');
            }

             //vewrificar si el usuario ya esta registrado
            $registro = Registro::where('usuario_id', $_SESSION['id']);

            if(isset($registro) && $registro->paquete_id === "3"){
                header('location: /boleto?id=' . urlencode($registro->token));
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

    public static function pagar (Router $router){

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!is_auth()){
                header('location: /login');
            }

            //validar que el post no benga vacio
            if(empty($_POST)){
                json_encode([]);
                return;
            }

            //crear el registro
            $datos = $_POST;
            $datos['token'] = substr( md5( uniqid( rand(), true)), 0, 8);
            $datos['usuario_id'] = $_SESSION['id'];
            
            try {
                $registro = new Registro($datos);
                $resultado = $registro->guardar();
                echo json_encode($resultado);
            } catch (\Throwable $th) {
                echo json_encode([
                    'resultado' => 'error'
                ]);
            }

        }
    }

}