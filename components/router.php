<?php

class Router
{
	private $routes;

	public function __construct()
	{
		$this->routes = require_once(ROOT.'/config/routes.php');
	}

	public function chooseRoute() {
		$path = $_SERVER['REQUEST_URI'];
		foreach ($this->routes as $rt => $pth) {
			if (preg_match($rt,$path)) {
				$result = explode('/', $pth);
				$className = ucfirst(array_shift($result));
				$actionName = 'action'.ucfirst(array_shift($result));
                $classPath = ROOT.'/controllers/'.$className.'.php';
                if (file_exists($classPath)) {
                    require_once($classPath);
                }
                $controllerObject = new $className;
                //include (ROOT.'/views/header.php');
                $controllerObject->$actionName();
                //include (ROOT.'/views/footer.php');
				break;
			}
		}
		if (!isset($className)) {
            header('HTTP/1.0 404 Not Found', true, 404);
            die();
        }
	}
}
