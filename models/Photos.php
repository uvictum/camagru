<?php
/**
 * Created by PhpStorm.
 * User: Виктор
 * Date: 17.07.2018
 * Time: 14:20
 */

class Photos
{
    public $pdo;

    public function __construct()
    {
        $this->pdo = ConnectDatabase::ConnectDB();
    }
}