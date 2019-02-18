<?php

class Login
{
    public function __construct()
    {
        include_once(ROOT.'/models/User.php');
    }

    public function actionSignin()
    {
        include_once (ROOT.'/views/signin.php');
        if (!empty($_POST)) {
            if ($_POST['submit'] == 'signin') {
                try  {
                    $this->authUser();
                } catch (Exception $err){
                    echo $err->getMessage();
                    return;
                }
                echo "Successfuly logged in<br/>";
            }
        }
    }

    public function authUser()
    {
        if (!empty($_SESSION['login']) && $_POST['username'] == $_SESSION['login']) {
            throw new Exception("User was already logged in");
        }
        $user = new User(null, $_POST['username'], $_POST['pass'], null, null);
        if ($user->Activate != 1) {
            throw new Exception("<br> User was not activated <a href='../resend/?login=".$_POST['username'].">Resend confirmation link?</a></br>");
        }
        $_SESSION['logged_user'] = $user->ID;
        $_SESSION['login'] = $user->Login;
    }

    public function actionLogout()
    {
        if ($_SESSION && isset($_SESSION['logged_user'])) {
            unset($_SESSION['logged_user']);
            unset($_SESSION['login']);
            echo "Successully signed off<br>";
            return;
        }
        echo "nobody signed in <br/>";
    }

    private function checkInput()
    {
        //If the name field is not empty  and If the name is not to short or contain escaped characters
        if (isset($_POST['username']) && !empty($_POST['username'])
            AND strlen($_POST['username']) >= 3
            && preg_match("'^[A-z0-9\-_\.]+$'", $_POST['username'])) {
                if (isset($_POST['email']) && !empty($_POST['email'])
                AND preg_match("'^[_A-z0-9-]+(\.[_A-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$'", $_POST['email'])) {
                    if (!isset($_POST['pass']) || empty($_POST['pass'])) {
                        echo "empty password please change it and resubmit";
                        return 0;
                    }
                    elseif (User::checkLogEmail($_POST['username'],$_POST['email'])) {
                        echo "such email or login already exists";
                        return 0;
                    }
                    else {
                        return 1;
                    }
                }
                else {
                    echo "incorrect email please change it and resubmit";
                    return 0;
                }
            }
            else {
                echo "incorrect username please change it and resubmit";
                return 0;
            }
    }

    static public function collectUserData()
    {
        $user = array("Username" => $_POST['username'], "Pass" => $_POST['pass'], "Email" => $_POST['email']);
        return($user);
    }

    public function actionRequest()
    {
        $mode = 1;
        include_once (ROOT.'/views/resetpass.php');
        if (!array_key_exists('email', $_GET))
        {
            if (!empty($_POST['submit']) && $_POST['submit'] == 'reset') {
                $user = new User(null, $_POST['username'], null, $_POST['username'], null);
                require_once(ROOT.'/components/SendMail.php');
                $newmessage = new SendMail(Array('Login' => $user->Login, 'Email' =>$user->Email,
                    'Pass' =>$user->Pass), $user->Hash);
                $newmessage->messagetype = 1;
                $newmessage->sendEmail();
                echo "<br>Password reset link was emailed to you <br/>";
                return 0;
                }
            echo "<br>No such user in the database<br/>";
        }
        else {
            $user = new User(null, $_GET['email'], null, $_GET['email'], null);
            if ($user->Hash == $_GET['token']) {
                $this->actionSet($user->ID);
            }
        }
    }

    public function actionSet(...$id)
    {
        echo "actionSet";
        $mode = 1;
        if (isset($id[0])) {
            $_SESSION['reset_id'] = $id[0];
        }
        include_once (ROOT.'/views/resetpass.php');
        if (!empty($_POST['submit']) && $_POST['submit'] == 'setpass' && !empty($_SESSION['reset_id'])) {
            $user = new User($_SESSION['reset_id'], null, null, null, null);
            $user->Pass = hash('whirlpool', $_POST['newpass']);
            $user->Hash = bin2hex(openssl_random_pseudo_bytes(16));
            try {
                $user->saveUser();
                unset($_SESSION['reset_id']);
            } catch (Exception $err) {
                echo $err->getMessage() . "Password was not updated<br/>";
                return;
            }
            echo "Password was updated</br>";
        } else {
            echo "this operation is not allowed";
        }
    }
}