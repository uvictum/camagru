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
        $sql = "INSERT INTO Users(Login, Pass, Email, Hash) VALUES (:Username, :Pass, :Email, :Hash)";
        $userdata['Pass'] = hash('whirlpool', $userdata['Pass']);
        $userdata['Hash'] = $token;
        print_r($userdata);
        $statement = $this->pdo->prepare($sql);
        $statement->execute($userdata);
    }

    public function getUserData($login)
    {
        $sql = "SELECT * FROM Users WHERE Login = :login OR Email = :email";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':login' => $login, 'email' => $login));
        $userdata = $statement->fetch(PDO::FETCH_ASSOC);
        return $userdata;
    }

    public function checkUser()
    {
        $sql = "SELECT * FROM Users WHERE Login = :login AND Pass = :pass";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':login' => $_POST['username'], ':pass' => hash('whirlpool', $_POST['pass'])));
        $newuser = $statement->fetch(PDO::FETCH_ASSOC);
        if (!empty($newuser)) {
            if ($newuser['ID'] == $_SESSION['logged_user']) {
                return 3;
            }
            if ($newuser['Activate'] == 1) {
                return 1;
            }
            else {
                return 2;
            }
        }
        else {
            return 0;
        }
    }

    public static function checkLogEmail($username, $email)
    {
        $sql = "SELECT COUNT(*) FROM Users WHERE Login = :login OR Email = :email";
        $pdo = ConnectDatabase::ConnectDB();
        $statement = $pdo->prepare($sql);
        $statement->execute(array(':login' => $username, ':email' => $email));
        if ($statement->fetchColumn() == 1) {
            return 1;
        }
        else {
            return 0;
        }
    }

    public function activateUser($email, $token)
    {
        $sql = "UPDATE Users SET Activate = 1 WHERE Email = :email AND Hash = :token";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':email' => $email, ':token' => $token));
        return $statement->rowCount();
    }

    public function updateUser($userid, $newvalue, $field)
    {
        $sql = "UPDATE Users SET ".ucfirst($field)."=:val WHERE ID = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':val' => $newvalue, ':id' => $userid));
        return $statement->rowCount();
    }
}