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

    public function __construct($userdata, $token)
    {
        $this->userdata = $userdata;
        $this->token = $token;
    }

    private function generateEmail($userdata, $token)
    {
        $emailtext = ' 
        Thanks for signing up!
        Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
         
        ------------------------
        Username: '.$userdata['username'].'
        Password: '.$userdata['pass'].'
        ------------------------
         
        Please click this link to activate your account:
        http://localhost:8200/verify/?email='.$userdata['email'].'&token='.$token.'';
        return($emailtext);
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

        $mail_subject = "Finish Registration to Camagru";
        $from_name = "vmorguno";
        $from_mail = "camagru project";
        // Set mail header
        $header = "Content-type: text/html; charset=".$encoding." \r\n";
        $header .= "From: ".$from_name." <".$from_mail."> \r\n";
        $header .= "MIME-Version: 1.0 \r\n";
        $header .= "Content-Transfer-Encoding: 8bit \r\n";
        $header .= "Date: ".date("r (T)")." \r\n";
        $header .= iconv_mime_encode("Subject", $mail_subject, $subject_preferences);

        // Send mail
        mail($this->userdata['email'], $mail_subject, $this->generateEmail($this->userdata, $this->token), $header);
    }
}