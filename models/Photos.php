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
    private $usr;
    private $img;
    private $id;

    public function __construct($usr, $id)
    {
        $this->pdo = ConnectDatabase::ConnectDB();
        if (isset($usr)) {
            $this->usr = $usr;
        }
        if (isset($id)) {
            $this->id = $id;
        }
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function savePhoto()
    {
        $sql = "INSERT INTO Images (UserID, Link) VALUES (:UserId, :Link)";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':UserId' => $this->usr, ':Link' => $this->img));
    }

    public function getPhotos()
    {
        $sql = "SELECT Images.ID, Images.Link, Images.Comments, Images.Likes, Users.Login FROM Images LEFT JOIN Users ON Images.UserID = Users.ID";
        if (!empty($id)) {
            $sql .= " WHERE Users.ID = $this->usr";
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

    public function getPhoto()
    {
        $sql = "SELECT Images.ID, Images.Link, Images.Comments, Images.Likes, Users.Login FROM Images LEFT JOIN Users ON Images.UserID = Users.ID WHERE Images.ID = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':id' => $this->id));
        $photo = $statement->fetch(PDO::FETCH_ASSOC);
        return($photo);
    }

    public function deletePhoto()
    {
        $sql = "DELETE FROM Images WHERE Images.UserID = :usr AND Images.ID = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':id' => $this->id, ':usr' => $this->usr));
    }
}