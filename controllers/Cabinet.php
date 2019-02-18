<?php
/**
 * Created by PhpStorm.
 * User: Виктор
 * Date: 18.07.2018
 * Time: 14:25
 */

class Cabinet
{
    private $user;
    private static $userdata = Array('Login', 'Email', 'Pass', 'Notify');
    private $view;

    public function __construct()
    {
        if (!empty($_SESSION['login'])) {
            require_once (ROOT. '/models/User.php');
            $this->user = new User($_SESSION['ID'], null, null, null, null);
            $this->view = ROOT . '/views/cabinet.php';
        } else {
            $this->view = ROOT. '/views/must_login.php';
        }
    }

    public function actionDashboard()
    {
        require_once ($this->view);
    }

    public function actionUpdate()
    {
        if (!empty($_POST['submit'])) {
           foreach ($_POST as $key => $value) {
               if (array_key_exists($key, Cabinet::$userdata)) {
                   $this->user->$key = $value;
               }
           }
           try {
               $this->user->saveUser();
           } catch (Exception $err) {
               echo $err->getMessage();
               return;
           }
           echo "Properties successfully changed <br/>";
        }
    }
}