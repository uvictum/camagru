<?php

class Login
{
    private $user;

    public function __construct()
    {
        include_once(ROOT.'/models/User.php');
        $this->user = new User();
    }

    public function actionSignin()
    {
        echo"actionSignin<br>";
        include_once (ROOT.'/views/signin.php');
        if ($_POST['submit'] == 'signin') {
            if ($this->authUser()) {
                echo "Login successful";
            }
            else {
                echo "Login failed";
            }
        }
    }

    public function authUser()
    {
        if ($this->user->checkUser()) {
            $userdata = $this->user->getUserData();
            setcookie('usr_id', $userdata['usr_id']);
            return 1;
        }
        else {
            return 0;
        }
    }

    public function actionSignup()
    {
        echo "actionSignup<br>";
        include_once (ROOT.'/views/signup.php');
        if ($_POST['submit'] == 'signup') {
            if ($this->checkInput()) {
                $userdata = $this->collectUserData();
                $token = bin2hex(openssl_random_pseudo_bytes(16));
                $this->user->createNew($userdata, $token);
                require_once(ROOT.'/components/SendMail.php');
                $newmessage = new SendMail($userdata, $token);
                $newmessage->sendEmail();
            }
        }
    }
    private function checkInput()
    {
        //If the name field is not empty  and If the name is not to short or contain escaped characters
        if (isset($_POST['username']) && !empty($_POST['username'])
            AND strlen($_POST['username']) >= 3
            && preg_match("^[A-z0-9\-_]+$", $_POST['username'])) {
                if (isset($_POST['email']) && !empty($_POST['email'])
                AND preg_match("^[_A-z0-9-]+(\.[_A-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $_POST['email'])) {
                    if (!isset($_POST['pass']) || empty($_POST['pass'])) {
                        echo "empty password please change it and resubmit";
                        return 0;
                    }
                    elseif (User::checkLogEmail($_POST['username'],$_POST['email'])) {
                        return 1;
                    }
                    else {
                        echo "such email or login already exists";
                        return 0;
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

    public function actionVerify()
    {
        if ($this->user->activateUser($_GET['email'],$_GET['token'])) {
            echo "user activated<br></br>";
        }
        else {
            echo "activation failed<br></br>";
        }
    }

    static public function collectUserData()
    {
        $user = array("username" => $_POST['username'], "pass" => $_POST['pass'], "email" => $_POST['email']);
        return($user);
    }
}