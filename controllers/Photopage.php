<?php
/**
 * Created by PhpStorm.
 * User: Виктор
 * Date: 07.12.2018
 * Time: 2:20
 */

class Photopage
{
    private $commentsModel;

    public function __construct()
    {
        require_once (ROOT . '/models/Comments.php');
        $this->commentsModel = new Comments();
    }

    public function actionShow()
    {
        require_once (ROOT . '/models/Photos.php');
        $photoModel = new Photos(NULL, $_GET['image']);
        $this->commentsModel->image = $_GET['image'];
        $photo = $photoModel->getPhoto();
        if (!empty($photo)) {
            $comments = $this->commentsModel->getComments();
            if (!empty($_SESSION['logged_user'])) {
                require (ROOT . '/models/Likes.php');
                $like = new Likes($photo['ID'], $_SESSION['logged_user']);
                $liked = $like->getLike();
            }

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
            $this->commentsModel->image = $_POST['image'];
            $this->commentsModel->userID = $_SESSION['logged_user'];
            $this->commentsModel->text = $_POST['txt'];
            $this->commentsModel->login = $_SESSION['login'];
            try {
                $this->commentsModel->saveComment();
                $comment['Login'] = $_SESSION['login'];
                $comment['Text'] = $_POST['txt'];
                $comment['ID'] = $this->commentsModel->ID;
                include (ROOT . '/views/tpls/comment.tpl.php');
                require_once (ROOT . '/models/User.php');
                $user = new User($_SESSION['logged_user'], null, null, null, null);
                if ($user->Notify > 0) {
                    require_once (ROOT . '/components/SendMail.php');
                    $mail = new SendMail(Array('Login' => $_SESSION['login'], 'image_link' => '/?image=' . $_POST['image']), NULL);
                    $mail->messagetype = 2;
                    $mail->sendEmail();
                }
            } catch (Exception $err) {
                header('HTTP/1.0 400 Bad error');
                echo $err->getMessage();
            }
        } else {
            header("Location: /");
        }
    }

    public function actionRemoveComment()
    {
        if (!empty($_POST['image']) && !empty($_SESSION['logged_user']) && !empty($_POST['ID']))
        {
            $this->commentsModel->ID = $_POST['ID'];
            $this->commentsModel->userID = $_SESSION['logged_user'];
            try {
                $this->commentsModel->removeComment();
                echo $this->commentsModel->ID;
            } catch (Exception $err) {
                header('HTTP/1.0 400 Bad error');
                echo $err->getMessage();
            }
        }
    }

    public function actionRemovePhoto()
    {
        if (is_numeric($_POST['image']) && isset($_SESSION['logged_user']))
        {
            require (ROOT . '/models/Photos.php');
            $img = new Photos($_SESSION['logged_user'], $_POST['image']);
            try {
                $photo = $img->getPhoto();
                $img->deletePhoto();
                chmod(ROOT . '/'. $photo['Link'], 0740);
                unlink(ROOT . '/'. $photo['Link']);
               // echo fileperms(ROOT .'/'. $photo['Link']);
            } catch (Exception $err) {
                header('HTTP/1.0 400 Bad Error');
                echo $err->getMessage();
            }
        }
    }

    public function actionAddLike()
    {
        if (is_numeric($_POST['image']) && isset($_SESSION['logged_user']))
        {
            require (ROOT . '/models/Likes.php');
            $likeModel = new Likes($_POST['image'], $_SESSION['logged_user']);
            $likeModel->addLike();
            $response['op'] = 1;
            $response['img'] = $_POST['image'];
            echo json_encode($response);
        }
    }

    public function actionRemoveLike()
    {
        if (is_numeric($_POST['image']) && isset($_SESSION['logged_user']))
        {
            require (ROOT . '/models/Likes.php');
            $likeModel = new Likes($_POST['image'], $_SESSION['logged_user']);
            $likeModel->removeLike();
            $response['op'] = 2;
            $response['img'] = $_POST['image'];
            echo json_encode($response);
        }
    }

}