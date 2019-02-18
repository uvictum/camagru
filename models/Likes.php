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

    public function __construct()
    {
        $this->pdo = ConnectDatabase::ConnectDB();
    }

    public function addLike($img, $usr)
    {
        $sql = "INSERT INTO Likes (UserID, ImageID) VALUES (:UserID, :ImageID)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':UserID' => $usr, ':ImageID' => $img));
    }

    public function removeLike($img, $usr)
    {
        $sql = "DELETE FROM Likes WHERE UserID = :usr AND ImageID = :img)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':usr' => $usr, ':img' => $img));
    }
}