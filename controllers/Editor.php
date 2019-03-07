<?php
/**
 * Created by PhpStorm.
 * User: Виктор
 * Date: 26.07.2018
 * Time: 15:25
 */

class Editor
{
    public $photo;
    public $view;

    public function __construct()
    {
        if (isset($_SESSION['logged_user'])) {
            $this->view = ROOT . '/views/imgeditor.php';
            require_once(ROOT . '/models/Photos.php');
            $this->photo = new Photos($_SESSION['logged_user'], null);
        } else {
            $this->view = ROOT . '/views/signin.php';
        }
    }

    public function actionImage()
    {
        if (isset($_POST['image'])) {
            $finalimg = $this->mergePhoto(imagecreatefrompng($_POST['image']), imagecreatefrompng($_POST['mask']));
            $filePath = '/images/'. uniqid("", true). '.png';
            if (imagepng($finalimg, ROOT. $filePath)) {
                $this->photo->img = $filePath;
                $this->photo->savePhoto();
                echo $filePath;
            }
            else {
                echo "upload failed";
            }
        } else {
            if (isset($this->photo)) {
                $masks = $this->photo->getMasks();
                $photos = $this->photo->getPhotos();
            }
            require_once($this->view);
        }
    }

    private function mergePhoto($image, $mask)
    {
        imagealphablending($image, true);
        imagesavealpha($image, true);
        if (imagecopy($image, $mask, 0,0, 0, 0, 640, 480)) {
            return($image);
        }
        else {
            return NULL;
        }
    }
}