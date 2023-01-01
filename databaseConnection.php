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

$connection_object = new databaseConnection();


// if(isset($_GET["data_array"])) getData();
if(isset($_GET["right_answers_array"])){
    getRightAnswers();
}else{
    getData();
}


function getData()
{
     global $connection_object;
    $sql = "SELECT A.answer,A.question_id,Q.* FROM answers A,questions Q WHERE Q.id=A.question_id";
    $stmt = $connection_object->getConnection()->query($sql);
    $data=$stmt->fetchAll();
    echo json_encode($data);
}

function getRightAnswers()
{
    global $connection_object;
    $sql = "SELECT * FROM answers,questions WHERE questions.id=answers.question_id and answers.status=1";
    $stmt = $connection_object->getConnection()->query($sql);
    $data=$stmt->fetchAll();
    echo json_encode($data);
}

// echo '<pre>';
// var_dump($data);
// echo '<pre>';

