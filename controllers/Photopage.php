<?php
/**
 * Created by PhpStorm.
 * User: Виктор
 * Date: 07.12.2018
 * Time: 2:20
 */

class Photopage
{
    public $commentsModel;

    public function __construct()
    {
        require_once (ROOT . '/models/Comments.php');
        $this->commentsModel = new Comments();
    }

    public function actionShow()
    {
        require_once (ROOT . '/models/Photos.php');

        $photoModel = new Photos(NULL);

        $photo = $photoModel->getPhoto($_GET['image']);
        $comments = $this->commentsModel->getComments($_GET['image']);
        if (isset($photo)) {
            require_once(ROOT.'/views/single_photo.php');
        }
        else {
            header('HTTP/1.0 404 Not Found', true, 404);
            die();
        }
    }

    public function actionAddComment()
    {
        if (is_numeric($_POST['image']) && isset($_SESSION['logged_user']))
        {
            $this->commentsModel->saveComment($_POST['image'], $_SESSION['logged_user'], $_POST['txt'], $_SESSION['login']);
            require_once (ROOT . '/models/User.php');
          //  $user = new User();
           // $userdata = $user->getUserData($_SESSION['login']);
           // if ($userdata['Notify'] > 0) {
          //      require_once (ROOT . '/components/SendMail.php');
           //     $mail = new SendMail($userdata, NULL);
          //      $mail->messagetype = 2;
           //     $mail->sendEmail();
          //  }
        }
    }

}