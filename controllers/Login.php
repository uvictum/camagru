<?php

class Login
{
    public function __construct()
    {
        include_once(ROOT.'/models/User.php');
    }

    public function actionSignin()
    {
        if (!empty($_POST)) {
            try  {
                $this->authUser();
            } catch (Exception $err) {
                header('HTTP/1.0 400 Bad error');
                echo $err->getMessage();
                die ;
            }
            echo 'Successfuly logged in';
        } elseif (empty($_SESSION['logged_user'])) {
            require_once (ROOT.'/views/signin.php');
        } else {
            header("Location: /");
        }
    }

    private function authUser()
    {
        if (!empty($_SESSION['login']) && $_POST['username'] == $_SESSION['login']) {
            throw new Exception("User was already logged in");
        }
        $user = new User(null, $_POST['username'], $_POST['pass'], null, null);
        if ($user->Activate != 1) {
            throw new Exception("User was not activated <a href='../resend/?login=".$_POST['username'].">Resend confirmation link?</a>");
        }
        $_SESSION['logged_user'] = $user->ID;
        $_SESSION['login'] = $user->Login;
    }

    public function actionLogout()
    {
        if ($_SESSION && isset($_SESSION['logged_user'])) {
            unset($_SESSION['logged_user']);
            unset($_SESSION['login']);
            echo "Successully signed off";
            return;
        }
        echo "nobody signed in";
    }

    public function actionRequest()
    {
        if (!array_key_exists('email', $_GET))
        {
            if (!empty($_POST['username'])) {
                try {
                    $user = new User(null, $_POST['username'], null, $_POST['username'], null);
                    require_once(ROOT.'/components/SendMail.php');
                    $newmessage = new SendMail(Array('Login' => $user->Login, 'Email' => $user->Email,
                        'Pass' => $user->Pass), $user->Hash);
                    $newmessage->messagetype = 1;
                    $newmessage->sendEmail();
                    echo "Password reset link was emailed to you";
                } catch (Exception $err) {
                    header('HTTP/1.0 400 Bad error');
                    echo $err->getMessage();
                }
            } elseif (empty($_SESSION['logged_user'])) {
                require_once (ROOT.'/views/resetpass.php');
            } else {
                header('Location: /');
            }
        } else {
            try {
                require_once (ROOT.'/views/resetpass.php');
                $user = new User(null, $_GET['email'], null, $_GET['token'], null);
                $_SESSION['reset_id'] = $user->ID;
            } catch (Exception $err) {
                header('HTTP/1.0 400 Bad error');
                echo $err->getMessage();
            }
        }
    }

    public function actionSet()
    {
        if (!empty($_POST['newpass']) && !empty($_SESSION['reset_id'])) {
            $user = new User($_SESSION['reset_id'], null, null, null, null);
            $user->Pass = $_POST['newpass'];
            $user->Hash = bin2hex(openssl_random_pseudo_bytes(16));
            try {
                $user->saveUser();
                unset($_SESSION['reset_id']);
            } catch (Exception $err) {
                header('HTTP/1.0 400 Bad error');
                echo $err->getMessage() . "Password was not updated";
            }
            echo "Password was updated";
        } else {
            echo "this operation is not allowed";
            header('Location: /');
        }
    }
}