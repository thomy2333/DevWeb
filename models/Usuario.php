<?php

namespace Model;

class Usuario extends ActiveRecord {
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'confirmado', 'token', 'admin'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $password2;
    public $confirmado;
    public $token;
    public $admin;

    public $password_actual;
    public $password_nuevo;

    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
        $this->admin = $args['admin'] ?? '';
    }

    // Validar el Login de Usuarios
    public function validarLogin() {
        if(!$this->email) {
            self::$errores['error'][] = 'El Email del Usuario es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$errores['error'][] = 'Email no válido';
        }
        if(!$this->password) {
            self::$errores['error'][] = 'El Password no puede ir vacio';
        }
        return self::$errores;

    }

    // Validación para cuentas nuevas
    public function validar_cuenta() {
        if(!$this->nombre) {
            self::$errores['error'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->apellido) {
            self::$errores['error'][] = 'El Apellido es Obligatorio';
        }
        if(!$this->email) {
            self::$errores['error'][] = 'El Email es Obligatorio';
        }
        if(!$this->password) {
            self::$errores['error'][] = 'El Password no puede ir vacio';
        }
        if(strlen($this->password) < 6) {
            self::$errores['error'][] = 'El password debe contener al menos 6 caracteres';
        }
        if($this->password !== $this->password2) {
            self::$errores['error'][] = 'Los password son diferentes';
        }
        return self::$errores;
    }

    // Valida un email
    public function validarEmail() {
        if(!$this->email) {
            self::$errores['error'][] = 'El Email es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$errores['error'][] = 'Email no válido';
        }
        return self::$errores;
    }

    // Valida el Password 
    public function validarPassword() {
        if(!$this->password) {
            self::$errores['error'][] = 'El Password no puede ir vacio';
        }
        if(strlen($this->password) < 6) {
            self::$errores['error'][] = 'El password debe contener al menos 6 caracteres';
        }
        return self::$errores;
    }

    public function nuevo_password() : array {
        if(!$this->password_actual) {
            self::$errores['error'][] = 'El Password Actual no puede ir vacio';
        }
        if(!$this->password_nuevo) {
            self::$errores['error'][] = 'El Password Nuevo no puede ir vacio';
        }
        if(strlen($this->password_nuevo) < 6) {
            self::$errores['error'][] = 'El Password debe contener al menos 6 caracteres';
        }
        return self::$errores;
    }

    // Comprobar el password
    public function comprobar_password() : bool {
        return password_verify($this->password_actual, $this->password );
    }

    // Hashea el password
    public function hashPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generar un Token
    public function crearToken() : void {
        $this->token = uniqid();
    }
}