<?php
class Setup
{
    private $pdo;

    public function __construct()
    {
        if (file_exists(ROOT.'/config/database.php')) {
            include(ROOT.'/config/database.php');
        }
        try {
            $this->pdo = new PDO("mysql:localhost", $DB_USER, $DB_PASSWORD);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $err) {
            echo "Connection failed :" . $err->getMessage();
        }
    }

    public function SetupDB()
    {
        $this->pdo->query('CREATE DATABASE camagrudb');
        include(ROOT . '/config/database.php');
        $pdqry = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $qry = file_get_contents(ROOT.'/sqls/setupdb.sql');
        $pdqry->query($qry);
        $res = ConnectDatabase::ConnectDB();
        if ($res) {
            echo 'database created successfully!<br>';
        }
        header("Refresh:2");
    }
}