<?php
/**
 * Created by PhpStorm.
 * User: Виктор
 * Date: 18.01.2019
 * Time: 13:55
 */

class Comments
{
    /**
     * @var int|PDO
     * @throws Exception
     */

    private $pdo;
    private $ID;
    private $image;
    private $userID;
    private $text;
    private $login;

    public function __construct()
    {
        $this->pdo = ConnectDatabase::ConnectDB();
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function getComments()
    {
        $sql = "SELECT Users.Login, Comments.Text, Comments.Postdate, Comments.ID FROM Comments LEFT JOIN Users ON Comments.UserID = Users.ID WHERE Comments.ImageID = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':id' => $this->image));
        $comments = $statement->fetchAll();
        return($comments);
    }

    public function saveComment()
    {
        $this->checkComment($this->text);
        $sql = "INSERT INTO Comments (UserID, ImageID, Text) VALUES (:UserID, :ImageID, :Text)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':UserID' => $this->userID, ':ImageID' => $this->image, ':Text' => $this->text));
        $this->ID = $this->pdo->lastInsertId();

    }

    public function removeComment()
    {
        $sql = "DELETE FROM Comments WHERE ID = :ID AND UserID = :UserID";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':ID' => $this->ID, ':UserID' => $this->userID));
        if (!$statement->rowCount()) {
            throw new Exception('Nothing was deleted');
        }
    }

    private function checkComment($txt)
    {
        if (empty($txt)) {
            throw new Exception('Comment has empty body');
        } else if (strlen($txt) > 350) {
            throw new Exception('Comment is too long');
        } else {
            return TRUE;
        }
    }

}