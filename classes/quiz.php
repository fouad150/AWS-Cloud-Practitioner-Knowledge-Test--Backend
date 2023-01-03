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
    // $answers_array = [];
    // for ($index = 1; $index <= 5; $index++) {
    //     $array = [];
    //     for ($i = 0; $i < count($data); $i++) {
    //         if ($data[$i]["question_id"] == $index) {
    //             $array[] = $data[$i]["answer"];
    //         }
    //     }
    //     $answers_array[] = $array;
    // }

    // echo '<pre>';
    // var_dump($answers_array);
    // echo '<pre>';

    // global $connection_object;
    // $sql = "SELECT Q.question FROM questions Q";
    // $stmt = $connection_object->getConnection()->query($sql);
    // $questions_data = $stmt->fetchAll();
    // for ($i = 0; $i < count($questions_data); $i++) {
    //     $answers_array[$i]
    // }
}

function getRightAnswers()
{
    global $connection_object;
    $sql = "SELECT * FROM answers,questions WHERE questions.id=answers.question_id and answers.status=1";
    $stmt = $connection_object->getConnection()->query($sql);
    $data = $stmt->fetchAll();
    echo json_encode($data);
}

// echo '<pre>';
// var_dump($data);
// echo '<pre>';