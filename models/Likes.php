<?php
/**
 * Created by PhpStorm.
 * User: Виктор
 * Date: 20.01.2019
 * Time: 17:50
 */

class Likes
{
    private $pdo;
    private $usr;
    private $img;

    public function __construct($img, $usr)
    {
        $this->pdo = ConnectDatabase::ConnectDB();
        $this->usr = $usr;
        $this->img = $img;
    }

    public function getLikes()
    {
        $sql = "SELECT FROM Likes (UserID, ImageID) WHERE UserID = :UserID AND ImageID = :ImageID)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':UserID' => $this->usr, ':ImageID' => $this->img));
    }

    public function addLike()
    {
        $sql = "INSERT INTO Likes (UserID, ImageID) VALUES (:UserID, :ImageID)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':UserID' => $this->usr, ':ImageID' => $this->img));
    }

    public function removeLike()
    {
        $sql = "DELETE FROM Likes WHERE UserID = :usr AND ImageID = :img)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':usr' => $this->usr, ':img' => $this->img));
    }
}