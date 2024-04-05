<?php
declare(strict_types=1);
require_once dirname(__DIR__) . '/vendor/autoload.php';
use app\TPQuizz\model\Quizz;
$json = file_get_contents('Quizz.json');
$json_data = json_decode($json);

// var_dump($json_data);

$quizz = Quizz::create($json_data);
echo "SALUT";
var_dump($quizz );
// var_dump($_SERVER);
// var_dump($_GET);
