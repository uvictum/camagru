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
        $this->imgs = new Photos($usr, null);
    }
    public function actionDisplay()
    {
        $liked = Array();
        if (!empty($_SESSION['logged_user'])) {
            $liked = $this->likeModel->getLikes();
        }
        if (!empty($_POST['limitLower']) && !empty($_POST['limitUpper']) &&
        is_numeric($_POST['limitLower']) && is_numeric($_POST['limitUpper'])) {
            $this->imgs->limitLower = $_POST['limitLower'];
            $this->imgs->limitUpper = $_POST['limitUpper'];
            $this->photos = $this->imgs->getPhotos();
            if (!empty($this->photos)) {
                $i = 0;
                foreach($this->photos as $img) {
                    if ($i % 3 == 0) {
                        if ($i != 0) {
                            echo '</div>';
                        }
                        echo '<div class="columns is-multiline">';
                    }
                    $i++;
                    include ROOT . '/views/tpls/main_photo.tpl.php';
                }
            } else {
                header("HTTP 1.0/400 Bad Error");
                echo ('here');
            }
        } else {
            $this->photos = $this->imgs->getPhotos();
            require_once(ROOT.'/views/homepage.php');
        }
    }
}