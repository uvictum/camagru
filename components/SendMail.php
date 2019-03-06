<?php
/**
 * Created by PhpStorm.
 * User: Виктор
 * Date: 16.07.2018
 * Time: 17:41
 */

class SendMail
{
    private $userdata;
    private $token;
    public $messagetype = 0;
    private $emailtext;
    private static $mailsubjects = array("Finish Registration to Camagru", "Here is reset link for Camagru",
                                           "Finish Registration to Camagru", "Your photo was commented on Camagru");

    public function __construct($userdata, $token)
    {
        $this->userdata = $userdata;
        $this->token = $token;
    }

    private function generateEmail($userdata, $token)
    {
        if ($this->messagetype == 0) {
            $this->emailtext = ' 
            Thanks for signing up!
            Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
             
            ------------------------
            Username: ' . $userdata['Login'] . '
            Password: ' . $userdata['Pass'] . '
            ------------------------
             
            Please click this link to activate your account:'.
            $_SERVER['HTTP_HOST'] .'/verify/?email='. $userdata['Email'] . '&token=' . $token . '';
        }
        elseif ($this->messagetype == 1) {
            $this->emailtext = ' 
            Please click this link to reset your account password:
            http://localhost:8200/resetpass/?email='.$userdata['Email'].'&token='.$token.'';
        }
        elseif ($this->messagetype == 2) {
            $this->emailtext = ' 
            Hello ' . $this->userdata['Login'] .
            'Your photo '. $_SERVER['HTTP_HOST'] . $this->userdata['image_link'] .' has received new comment';
        } elseif ($this->messagetype == 3) {
            $this->emailtext = 'Please click this link to activate your account:'.
            $_SERVER['HTTP_HOST'] .'/verify/?email='. $userdata['Email'] . '&token=' . $token . '';
        }
    }

    public function sendEmail()
    {
        $encoding = "utf-8";

        // Set preferences for Subject field
        $subject_preferences = array(
            "input-charset" => $encoding,
            "output-charset" => $encoding,
            "line-length" => 76,
            "line-break-chars" => "\r\n"
        );

        $from_name = "vmorguno";
        $from_mail = "vmorguno@student.unit.ua";
        // Set mail header
        $header = "Content-type: text/html; charset=".$encoding." \r\n";
        $header .= "From: ".$from_name." <".$from_mail."> \r\n";
        $header .= "MIME-Version: 1.0 \r\n";
        $header .= "Content-Transfer-Encoding: 8bit \r\n";
        $header .= "Date: ".date("r (T)")." \r\n";
        $header .= iconv_mime_encode("Subject", SendMail::$mailsubjects[$this->messagetype], $subject_preferences);
        $this->generateEmail($this->userdata, $this->token);
        // Send mail
        mail($this->userdata['Email'], SendMail::$mailsubjects[$this->messagetype], $this->emailtext, $header);
    }
}