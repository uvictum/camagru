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
        if (!empty($_POST)) {
            $token = bin2hex(openssl_random_pseudo_bytes(16));
            $user = new User(null, $_POST['username'], $_POST['pass'], $_POST['email'], $token);
            try {
                $user->saveUser();
                require_once(ROOT.'/components/SendMail.php');
                $newmessage = new SendMail(Array('Login' => $user->Login, 'Email' =>$user->Email,
                    'Pass' => $user->Pass), $token);
                $newmessage->sendEmail();
            } catch (Exception $err) {
                header('HTTP/1.0 400 Bad error');
                echo $err->getMessage();
            }
        } else {
            require_once (ROOT.'/views/signup.php');
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