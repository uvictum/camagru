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
        if (!empty($ID)) {
            $this->ID = $ID;
            $this->setUserData();
        } elseif (!empty($Login) && !empty($Pass) && !empty($Email) && !empty($Hash)) {
            $this->Login = $Login;
            $this->Pass = $Pass;
            $this->Email = $Email;
            $this->Hash = $Hash;
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
        if ($this->$name != $value && strlen($value)) {
            $this->updateLine[] = $name;
            $this->$name = $value;
        } elseif ($name != 'Pass' && !strlen($value)) {
            throw new Exception("Empty $name was passed!");
        }
    }

    public function saveUser()
    {
        if ($this->ID) {
            $params = $this->updateLineTransform();
            if (empty($params)) {
                throw new Exception('Nothing to change');
            }
            $sql = "UPDATE Users SET $params WHERE ID = $this->ID";
        } else {
            $sql = "INSERT INTO Users(Login, Pass, Email, Hash) VALUES (:Login, :Pass, :Email, :Hash)";
            $this->updateLine = Array("Login", "Pass", "Email", "Hash");
        }
        require_once (ROOT. '/components/Validator.php');
        $validator = new Validator($this->updateLine, $this);
        $validator->validateParams();
        $userdata = $this->bindParams(Array());
        $statement = $this->pdo->prepare($sql);
        $statement->execute($userdata);
    }

    private function updateLineTransform()
    {
        $params = '';
        $counter = 0;
        $total = count($this->updateLine);
        foreach ($this->updateLine as $item) {
            $counter++;
            $params .= "$item = :$item";
            $params .= $counter == $total ? '' : ', ';
        }
        return $params;
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
            if (array_key_exists(':Pass', $userdata)) {
                $userdata[':Pass'] = hash('whirlpool', $userdata[':Pass']);
            }
        }
        return $userdata;
    }

    public function checkUnique($param, $value)
    {
        $sql = "SELECT $param FROM Users WHERE $param = :param";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':param' => $value));
        $userdata = $statement->fetch(PDO::FETCH_ASSOC);
        if (empty($userdata)) {
            return true;
        }
        return false;
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

    private function checkLogEmail($Login, $Email)
    {
        if ($Login === $Email) {
            $sql = "SELECT * FROM Users WHERE Login = :login OR Email = :login";
            $statement = $this->pdo->prepare($sql);
            $statement->execute(array(':login' => $Login));
            $userdata = $statement->fetch(PDO::FETCH_ASSOC);
            if (empty($userdata)) {
                throw new Exception("This user doesn't exist");
            }
            $this->bindParams($userdata);
        } else {
            throw new Exception("Wrong data submitted");
        }
    }
}