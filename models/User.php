<?php
/**
 * Created by PhpStorm.
 * User: Виктор
 * Date: 27.06.2018
 * Time: 16:32
 */

class User
{
    public $pdo;

    public function __construct()
    {
        $this->pdo = ConnectDatabase::ConnectDB();
    }
    public function createNew()
    {
        $this->pdo->query();
    }

    public function getUserData()
    {
        $this->pdo->query();

    }
}