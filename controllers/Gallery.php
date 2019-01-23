<?php
/**
 * Created by PhpStorm.
 * User: Виктор
 * Date: 04.07.2018
 * Time: 16:26
 */

class Gallery
{
    public $imgs;
    public $photos;

    public function __construct()
    {
        require_once(ROOT . '/models/Photos.php');
        if (isset($_SESSION['logged_user'])) {
            $usr = $_SESSION['logged_user'];
        } else {
            $usr = NULL;
        }
        $this->imgs = new Photos($usr);
    }
    public function actionDisplay()
    {
        $this->photos = $this->imgs->getPhotos(NULL);
        require_once(ROOT.'/views/homepage.php');
    }
}