<?php
/**
 * Created by PhpStorm.
 * User: Виктор
 * Date: 04.07.2018
 * Time: 16:26
 */

class Gallery
{
    private $imgs;
    private $photos;
    private $likeModel;

    public function __construct()
    {
        require_once(ROOT . '/models/Photos.php');
        if (isset($_SESSION['logged_user'])) {
            $usr = $_SESSION['logged_user'];
            require_once (ROOT . '/models/Likes.php');
            $this->likeModel = new Likes(null, $usr);
        } else {
            $usr = NULL;
        }
        $this->imgs = new Photos($usr);
    }
    public function actionDisplay()
    {
        $this->photos = $this->imgs->getPhotos(NULL);
        $liked = Array();
        if (!empty($_SESSION['logged_user'])) {
            $liked = $this->likeModel->getLikes();
        }
        require_once(ROOT.'/views/homepage.php');
    }
}