<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/vendor/autoload.php';
use app\TPQuizz\model\Quizz;
use app\TPQuizz\model\Question;
use app\TPQuizz\model\Response;
$json = file_get_contents('Quizz.json');
$json_data = json_decode($json);
$quizz = Quizz::create($json_data);
// echo "SALUT";
// var_dump($quizz );
// var_dump($_SERVER);
// var_dump($_GET);



try{
    // $connexion = new PDO('mysql:host=mysql-srv;dbname=quizz_database','db_user','password');
    // $statement = $connexion->prepare('select * from quizz;');
    // $statement->execute();
    // while ($row = $statement->fetch()){
    //     print_r($row);
    // }

    $liste = Quizz::filter();
    var_dump($liste);
}

catch(PDOexception $e){
    echo "error:" .$e -> getMessage();
}
echo "ECHO";
var_dump(Quizz::findById(1));
echo "ECHO";
var_dump(Quizz::filter('quizz'));
echo "ECHO";
var_dump(Question::getQuestions(1));
echo "ECHO";
var_dump(Response::getResponse(1));