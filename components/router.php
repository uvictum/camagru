<?php

class Router
{

	private $routes;


	public function __construct()
	{
		$routesPath = ROOT.'/config/routes.php';
		$this->routes = include($routesPath);
	}

	public function chooseRoute() {
		$path = $_SERVER['REQUEST_URI'];
		foreach ($this->routes as $rt => $pth) {
			if ($path == $rt) {
				$result = explode('/', $pth);
				$className = ucfirst(array_shift($result));
				$actionName = 'action'.ucfirst(array_shift($result));
                $classPath = ROOT.'/controllers/'.$className.'.php';
                if (file_exists($classPath)) {
                    include_once($classPath);
                }
				$controllerObject = new $className;
				$controllerObject->$actionName();
				break;
			}
		}



	}

}
?>