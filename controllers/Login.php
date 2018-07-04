<?php

class Login{

    private $user;

   public function __construct()
    {
        include_once(ROOT.'/models/User.php');
        $this->user = new User();
    }

    function actionSignin()
    {
        echo"high there! actionSignin<br>";
        include_once (ROOT.'/views/signin.php');
        if ($_POST['submit'] == 'signin' && $his->user->checkUser())
        {
            $userdata = $this->user->getUserData();
            $_COOKIE['usr_id'] = $userdata['usr_id'];
        }
    }

    function actionSignup()
    {
        echo "actionSignup<br>";
        include_once (ROOT.'/views/signup.php');
        if ($_POST['submit'] == 'signup') {
            $res = $this->checkInput();
            if ($res) {
                $userdata = $this->collectUserData();
                $token = generateToken();
                mail($userdata['email'],'Finish Your Registration on Camagru',
                    $this->generateEmail($userdata, $token));
            }
        }
    }
    private function checkInput()
    {
        $username = $_POST['username'];
        $pass = $_POST['pass'];
        $email = $_POST['email'];
        return 1;
    }

    private function generateEmail($userdata, $token)
    {
        $emailtext = '...';
        return($emailtext);
    }

    static public function collectUserData()
    {
        $user = array();
        $username = $_POST['username'];
        $pass = $_POST['pass'];
        $email = $_POST['email'];
        return($user);
    }
}