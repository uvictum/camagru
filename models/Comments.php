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

    public function __construct()
    {
        $this->pdo = ConnectDatabase::ConnectDB();
    }

    public function getComments($id)
    {
        $sql = "SELECT Users.Login, Comments.Text, Comments.Postdate FROM Comments LEFT JOIN Users ON Comments.UserID = Users.ID WHERE Comments.ImageID = :id";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(':id' => $id));
        $comments = $statement->fetchAll();
        return($comments);
    }

    public function saveComment($img, $usr, $txt, $login)
    {
        try {
            $this->checkComment($txt);
            $sql = "INSERT INTO Comments (UserID, ImageID, Text) VALUES (:UserID, :ImageID, :Text)";
            $statement = $this->pdo->prepare($sql);
            $statement->execute(array(':UserID' => $usr, ':ImageID' => $img, ':Text' => $txt));
            print(json_encode(array($login, $txt)));
        } catch (Exception $error) {
            header('HTTP/1.0 400 Bad error');
            echo $error->getMessage();
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