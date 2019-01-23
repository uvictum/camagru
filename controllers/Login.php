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
        //echo"actionSignin<br>";
        include_once (ROOT.'/views/signin.php');
        if ($_POST) {
            if ($_POST['submit'] == 'signin') {
                if ($this->authUser()) {
                    echo "Login successful";
                    header("Refresh: 2; url=../");
                }
            }
        }
    }

    public function actionLogout()
    {
        if ($_SESSION && isset($_SESSION['logged_user'])) {
            unset($_SESSION['logged_user']);
            unset($_SESSION['login']);
        }
        header("Refresh: 1; url=../");
    }

    public function authUser()
    {
        $res = $this->user->checkUser();
        if ($res == 1) {
            $userdata = $this->user->getUserData($_POST['username']);
            $_SESSION['logged_user'] = $userdata['ID'];
            $_SESSION['login'] = $userdata['Login'];
            return 1;
        }
        elseif ($res == 2) {
            echo "<br> User was not activated <a href='../resend/?login=".$_POST['username'].">Resend confirmation link?</a></br>";
            return 0;
        }
        elseif ($res == 3) {
            echo "<br> User was already logged in </br>";
            header("Refresh: 2; url=../");
            return 0;
        }
        else {
            echo "<br> Wrong password or login </br>";
            return 0;
        }
    }

    public function actionSignup()
    {
        //echo "actionSignup<br>";
        include_once (ROOT.'/views/signup.php');
        if ($_POST) {
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

    public function actionVerify()
    {
        if ($this->user->activateUser($_GET['email'],$_GET['token'])) {
            $userdata = $this->user->getUserData($_GET['email']);
            $this->user->updateUser($userdata['ID'], bin2hex(openssl_random_pseudo_bytes(16)), 'hash');
            echo "user was activated<br></br>";
        }
        else {
            echo "user was not activated<br></br>";
        }
    }

    static public function collectUserData()
    {
        $user = array("Username" => $_POST['username'], "Pass" => $_POST['pass'], "Email" => $_POST['email']);
        return($user);
    }

    public function actionRequest()
    {
        echo"actionRequest<br>";
        $mode = 1;
        include_once (ROOT.'/views/resetpass.php');
        if (!array_key_exists('email', $_GET))
        {
            if ($_POST) {
                if ($_POST['submit'] == 'reset') {
                    if (User::checkLogEmail($_POST['username'], $_POST['username'])) {
                        $userdata = $this->user->getUserData($_POST["username"]);
                        require_once(ROOT.'/components/SendMail.php');
                        $newmessage = new SendMail($userdata, $userdata['Hash']);
                        $newmessage->messagetype = 1;
                        $newmessage->sendEmail();
                        echo "<br>Password reset link was emailed to you <br/>";
                        return 0;
                    }
                    echo "<br>No such user in the database<br/>";
                }
            }
        }
        else {
            $userdata = $this->user->getUserData($_GET['email']);
            if ($userdata['Hash'] == $_GET['token']) {
                $this->actionSet($userdata['ID']);
            }
        }
    }

    public function actionSet(...$id)
    {
        echo "actionSet";
        $mode = 1;
        print_r($id);
        print_r($_SESSION);
        if (isset($id[0])) {
            $_SESSION['reset_id'] = $id[0];
        }
        include_once (ROOT.'/views/resetpass.php');
        if ($_POST) {
            if ($_POST['submit'] == 'setpass') {
                $res = $this->user->updateUser($_SESSION['reset_id'], hash('whirlpool', $_POST['newpass']), 'pass');
                $this->user->updateUser($_SESSION['reset_id'], bin2hex(openssl_random_pseudo_bytes(16)), 'hash');
                if (isset($_SESSION['reset_id'])) {
                    unset($_SESSION['reset_id']);
                }
                if ($res) {
                    echo "Password was updated";
                } else {
                    echo "Password was not updated";
                }
            }
            else {
                echo "this operation is not allowed";
            }

        }
    }
}