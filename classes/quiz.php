<?php
include "databaseConnection.php";
$connection_object = new databaseConnection();

if (isset($_GET["right_answers_array"])) {
    getRightAnswers();
} else {
    getData();
}

function getData()
{
    global $connection_object;
    $sql = "SELECT A.answer,A.question_id,Q.* FROM answers A,questions Q WHERE Q.id=A.question_id";
    $stmt = $connection_object->getConnection()->query($sql);
    $data = $stmt->fetchAll();
    echo json_encode($data);
}

function getRightAnswers()
{
    global $connection_object;
    $sql = "SELECT * FROM answers,questions WHERE questions.id=answers.question_id and answers.status=1";
    $stmt = $connection_object->getConnection()->query($sql);
    $data = $stmt->fetchAll();
    echo json_encode($data);
}
