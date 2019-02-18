<?php
/**
 * Created by PhpStorm.
 * User: vmorgan
 * Date: 29.01.19
 * Time: 14:00
 */

class Validator
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