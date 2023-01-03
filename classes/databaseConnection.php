<?php
class DatabaseConnection
{
    private $host = "localhost";
    private $username = "root";
    private $pw = "";
    private $databaseName = "quiz";

    public function getConnection()
    {
        try {
            $pdo = new PDO("mysql:host=$this->host;dbname=$this->databaseName", $this->username, $this->pw, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Connection failed.";
        }
        return $pdo;
    }
}


