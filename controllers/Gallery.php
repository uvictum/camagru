<?php
/**
 * Created by PhpStorm.
 * User: Виктор
 * Date: 04.07.2018
 * Time: 16:26
 */

class Gallery
{
    public $img;

    public function __construct()
    {
        $this->img = 11;
    }
    public function actionDisplay()
    {
        echo$this->img."<br></br>";
    }
}