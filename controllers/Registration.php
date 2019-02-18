<?php
/**
 * Created by PhpStorm.
 * User: vmorgan
 * Date: 03.02.19
 * Time: 19:21
 */

class Registration
{
    public function __construct()
    {
        require_once (ROOT . '/models/User.php');
    }

    public function actionSignup() //допилить верификацию и отлов эксепшенов, убрать двойной иф
    {
        include_once (ROOT.'/views/signup.php');
        if ($_POST) {
            if ($_POST['submit'] == 'signup') {
                $user = new User(null,null, null, null, null);
                $user->Login = $_POST['username'];
                $user->Email = $_POST['email'];
                $user->Pass = $_POST['pass'];
                $token = bin2hex(openssl_random_pseudo_bytes(16));
                $user->Hash = $token;
                $user->saveUser();
                require_once(ROOT.'/components/SendMail.php');
                $newmessage = new SendMail(Array('Login' => $user->Login, 'Email' =>$user->Email,
                    'Pass' =>$user->Pass), $token);
                $newmessage->sendEmail();
            }
        }
    }

    public function actionVerify()
    {
        try {
            $user = new User(null, null, null, $_GET['email'], $_GET['token']);
            $user->Activate = 1;
            $user->Hash = bin2hex(openssl_random_pseudo_bytes(16));
            $user->saveUser();
        } catch (Exception $err) {
            echo "user was not activated<br/>";
            echo $err->getMessage() . "<br/>";
            return;
        }
        echo "user was activated<br/>";
    }
}