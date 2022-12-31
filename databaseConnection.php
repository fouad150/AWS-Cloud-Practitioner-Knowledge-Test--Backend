<?php
class DatabaseConnection
{
    private $host = "localhost";
    private $username = "root";
    private $pw = "";
    private $databaseName = "quiz";

    private function connection()
    {
        try {
            $pdo = new PDO("mysql:host=$this->host;dbname=$this->databaseName", $this->username, $this->pw, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Connection failed.";
        }
        return $pdo;
    }
    public function getConnection()
    {
        return $this->connection();
    }
}


$connection = new databaseConnection();

function getData()
{
    global $connection;
    $sql = "SELECT * FROM answers,questions WHERE questions.id=answers.question_id";
    $stmt = $connection->getConnection()->query($sql);
    return $stmt;
}
$result = getData();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $data[] = $row;
}

// echo '<pre>';
// var_dump($data);
// echo '<pre>';

$json = json_encode($data);
echo $json;
