<?php

class Router
{

    private $routes;


    public function Router()
    {
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include($routesPath);
    }

    public function chooseRoute()
    {      //1. Получить запрос (урл)
        $path = $_SERVER['REQUEST_URI'];
        print($path);
        //2. Определить нужный маршрут
        foreach ($this->routes as $rt => $pth) {
            if ($path == $rt) {
                $result = explode('/', $pth);
                print_r($result);
                //$objectClass = array_sp
                //3. Передать управление контроллеру
                break;
            }
        }



    }

}
?>