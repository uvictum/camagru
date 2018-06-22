<?php
// 1) применить настройки
define('ROOT', dirname(__FILE__));
// 2) подключить файлы системы
require_once (ROOT.'/components/router.php');
// 3) инициализировать коннект с базой данных
// 4) запустить роутер
$router = new Router;
$router->chooseRoute();
?>
