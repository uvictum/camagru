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
		$className = NULL;
		//echo $path.'<br></br>';
		foreach ($this->routes as $rt => $pth) {
			if (preg_match($rt,$path)) {
				$result = explode('/', $pth);
				$className = ucfirst(array_shift($result));
				$actionName = 'action'.ucfirst(array_shift($result));
                $classPath = ROOT.'/controllers/'.$className.'.php';
                if (file_exists($classPath)) {
                    include_once($classPath);
                }
                $controllerObject = new $className;
                //include (ROOT.'/views/header.php');
                $controllerObject->$actionName();
                //include (ROOT.'/views/footer.php');
				break;
			}
		}
		if (!isset($className)) {
		    header("HTTP/1.0 404 Not Found");
        }
	}
}
