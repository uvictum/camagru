<?php
/**
 * Created by PhpStorm.
 * User: vmorgan
 * Date: 29.01.19
 * Time: 14:00
 */

class Validator
{
    private $params;
    private $object;
    private static $paramNames = Array('Login', 'Email', 'Pass');

    public function __construct($params_name, $object)
    {
        $this->params = $params_name;
        $this->object = $object;
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
    }

    public function validateParams()
    {
        foreach ($this->params as $param) {
            if (in_array($param, Validator::$paramNames)) {
                $method = "validate$param";
                $this->$method();
            }
        }
    }

    private function validateLogin()
    {
        $login = $this->object->Login;
        if (!preg_match("/^([a-zA-Z](?:(?:(?:\w[\.\_]?)*)\w)+)([a-zA-Z0-9])$/", $login)) {
            throw new Exception("Login contains prohibited symbols");
        }
        if (strlen($login) > 16) {
            throw new Exception("Login is too long!");
        }
        if (!$this->object->checkUnique('Login', $login)) {
            throw new Exception("This login is in use");
        }
    }

    private function validatePass()
    {
        $pass = $this->object->Pass;
        if (strlen($pass) < 8) {
            throw new Exception("This password is too short");
        }
        if (strlen($pass) > 15) {
            throw new Exception("This password is too long");
        }
        if (!preg_match("/^([a-zA-Z0-9@*#]{8,15})$/", $pass)) {
            throw new Exception("This password is not strong enough");
        }
    }

    private function validateEmail()
    {
        $email = $this->object->Email;
        if (!preg_match("/^[\w-_\.]+@([\w-_]+\.)+[\w-]{2,4}$/", $email)) {
            throw new Exception("Wrong email format!");
        }
        if (strlen($email) > 64) {
            throw new Exception("Email is too long!");
        }
        if (!$this->object->checkUnique('Email', $email)) {
            throw new Exception("This email is already registred");
        }
    }

}