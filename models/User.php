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
    public function createNew(array $userdata, $token)
    {
        $sql = "INSERT INTO 'Users' Login = :login, Pass = :pass, Hash = :hash, Activate = 0";
        $userdata['pass'] = hash('whirlpool', $userdata['pass']);
        $userdata['hash'] = $token;
        $statement = $this->pdo->prepare($sql);
        $statement->execute($userdata);
    }

    public function getUserData()
    {
        $sql = "SELECT * FROM 'Users' WHERE Login = :login AND Pass = :pass";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':login' => $_POST['username'], ':pass' => hash('whirlpool', $_POST['pass'])));
        $userdata = $statement->fetchAll();
        return $userdata;
    }

    public function checkUser()
    {
        $sql = "SELECT COUNT(*) FROM 'Users' WHERE Login = :login AND Pass = :pass";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':login' => $_POST['username'], ':pass' => hash('whirlpool', $_POST['pass'])));
        if ($statement->fetchColumn() == 1) {
            return 1;
        }
        else {
            return 0;
        }
    }
    public static function checkLogEmail($username, $email)
    {
        $sql = "SELECT COUNT(*) FROM 'Users' WHERE Login = :login OR Email = :email";
        $pdo = ConnectDatabase::ConnectDB();
        $statement = $pdo->prepare($sql);
        $statement->execute(array(':login' => $username, ':email' => $email));
        if ($statement->fetchColumn()) {
            return 1;
        }
        else {
            return 0;
        }
    }

    public function activateUser($email, $token)
    {
        $sql = "UPDATE 'Users' SET Active = 1 WHERE Email = :email AND Hash = :token";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':email' => $email, ':token' => $token));
        if ($statement->fetchColumn()) {
            return 1;
        } else {
            return 0;
        }
    }
}