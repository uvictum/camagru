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
    public $usr;

    public function __construct($usr)
    {
        $this->pdo = ConnectDatabase::ConnectDB();
        if (isset($usr)) {
            $this->usr = $usr;
        }
    }

    public function savePhoto($img, $usr)
    {
        $sql = "INSERT INTO Images (UserID, Link) VALUES (:UserId, :Link)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':UserId' => $usr, ':Link' => $img));
    }

    public function getPhotos($id)
    {
        $sql = "SELECT Images.ID, Images.Link, Images.Comments, Images.Likes, Users.Login FROM Images LEFT JOIN Users ON Images.UserID = Users.ID";
        if (!empty($id)) {
            $sql .= " WHERE Users.ID = $id";
        }
        $sql .= " ORDER BY Images.ID DESC";
        $statement = $this->pdo->query($sql);
        $photos = $statement->fetchAll();
        return($photos);
    }

    public function getMasks()
    {
        $sql = "SELECT * FROM Masks";
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $masks= $statement->fetchAll();
        return($masks);
    }

    public function getPhoto($id)
    {
        $sql = "SELECT Images.ID, Images.Link, Images.Comments, Images.Likes, Users.Login FROM Images LEFT JOIN Users ON Images.UserID = Users.ID WHERE Images.ID = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':id' => $id));
        $photo = $statement->fetch(PDO::FETCH_ASSOC);
        return($photo);
    }

    public function deletePhoto($id, $usr)
    {
        $sql = "DELETE FROM Images WHERE Images.UserID = :usr AND Images.ID = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':id' => $id, ':usr' => $usr));
    }
}