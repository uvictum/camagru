<?php
/**
 * Created by PhpStorm.
 * User: Виктор
 * Date: 27.06.2018
 * Time: 16:52
 */

class ConnectDatabase
{
    static public function ConnectDB()
    {
        require(ROOT.'/config/database.php');
        try {
            $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return ($pdo);
        }
        catch (PDOException $err) {
            header("Refresh:10");
            echo "No Database found<br>"; //$err->getMessage();
            return(0);
        }
    }
}