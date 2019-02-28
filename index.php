<?php
// 1) применить настройки
define('ROOT', dirname(__FILE__));
// 2) подключить файлы системы
require_once (ROOT.'/components/router.php');
require_once (ROOT.'/components/ConnectDatabase.php');
// 3) инициализировать коннект с базой данных
$connection = new ConnectDatabase();
$PDOConnection = $connection->connectDB();
if (!$PDOConnection) {
    echo "Beginning setup....";
    include_once (ROOT.'/config/setup.php');
    $setupObject = new Setup();
    $setupObject->SetupDB();
}
else {
// 4) запустить роутер
    session_start();
    $router = new Router;
    $router->chooseRoute();
}
