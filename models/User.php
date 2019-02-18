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
   // private $validator;
    private $ID;
    private $Login;
    private $Pass;
    private $Email;
    private $Hash;
    private $Notify;
    private $Activate;
    private $updateLine;

    public function __construct($ID, $Login, $Pass, $Email, $Hash)
    {
        $this->pdo = ConnectDatabase::ConnectDB();
        $this->updateLine  = Array();
       // $this->validator = new Validator();
        if (!empty($ID)) {
            $this->ID = $ID;
            $this->setUserData();
        } elseif (!empty($Login) && !empty($Pass)) {
            $this->checkUserExists($Login, $Pass);
        } elseif (!empty($Email) && !empty($Hash)) {
            $this->activateUserEx($Email, $Hash);
        } elseif (!empty($Email) && !empty($Login)) {
            $this->checkLogEmail($Login, $Email);
        } else {
            throw new Exception("Empty data was submitted");
        }
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
        $this->updateLine[] = $name; //функция добавить в массив элемент
    }

    public function saveUser()
    {
        if ($this->ID) {
            $sql = "UPDATE Users$this->updateLine SET $this->updateLine WHERE ID = :ID";
            $userdata = $this->bindParams(Array());
            $statement = $this->pdo->prepare($sql);
            $statement->execute($userdata);
        } else {
            $sql = "INSERT INTO Users(Login, Pass, Email, Hash) VALUES (:Login, :Pass, :Email, :Hash)";
            $this->updateLine = Array("Login", "Pass", "Email", "Hash");
            $userdata = $this->bindParams(Array());
            //var_dump($userdata);
            $userdata[':Pass'] = hash('whirlpool', $userdata[':Pass']);
            $statement = $this->pdo->prepare($sql);
            $statement->execute($userdata);
        }
    }

    private function setUserData()
    {
        $sql = "SELECT * FROM Users WHERE ID = :ID";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':ID' => $this->ID));
        $userdata = $statement->fetch(PDO::FETCH_ASSOC);
        $this->bindParams($userdata);
    }

    private function bindParams($userdata)
    {
        if (!empty($userdata)) {
            foreach ($userdata as $key => $val) {
                $this->$key = $val;
            }
        } else {
            foreach ($this->updateLine as $item) {
                $userdata[':' . $item] = $this->$item;
            }
        }
        return $userdata;
    }

    private function checkUserExists($Login, $Pass)
    {
        $sql = "SELECT * FROM Users WHERE Login = :login AND Pass = :pass";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':login' => $Login, ':pass' => hash('whirlpool', $Pass)));
        $userdata = $statement->fetch(PDO::FETCH_ASSOC);
        if (empty($userdata)) {
            throw new Exception("Wrong login or password");
        }
        $this->bindParams($userdata);
    }

    private function activateUserEx($email, $token)
    {
        $sql = "SELECT * FROM Users WHERE Email = :email AND Hash = :token";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':email' => $email, ':token' => $token));
        $userdata = $statement->fetch(PDO::FETCH_ASSOC);
        if (empty($userdata)) {
            throw new Exception("token expired or invalid");
        }
        $this->bindParams($userdata);
    }
}