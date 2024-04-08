<?php

namespace app\TPQuizz\model;

class Quizz{

    private string $_title;
    private QuestionCollection $_questions;
    private int $_id;


    public function __construct(string $title = 'No title choosen', int $id = 0){
        $this -> _title = $title;
        $this -> _questions = new QuestionCollection();
    }

    public function getTitle():string{
        return $this -> _title;
    }

    public function getQuestions():QuestionCollection{
        return $this -> _questions;
    }

    public function addQuestion(Question $question){
        $this -> _questions[] = $question;
    }



    public static function create($pJsonObject):Quizz{

        $quizz = new Quizz($pJsonObject -> title);
        foreach ($pJsonObject -> questions as $key => $questionJson) {
            $question = new Question( $questionJson -> text);
            foreach ($questionJson -> responses as $key => $responseJson) {
                $response = new Response($responseJson -> text,$responseJson -> isValid);
                $question -> addResponse($response);
            }
            $quizz -> addQuestion($question);
        }

        return $quizz;
    }

    public static function list():\ArrayObject{
        $liste = new \ArrayObject();
        $statement=Database::getInstance()->getConnexion()->prepare('select * from quiz;');
        $statement->execute();
        while ($row = $statement->fetch()) {
            $liste[] = new Quizz(id:$row['id'],title:$row['title']);
        }
        return $liste;
    }

    public static function filter(string $text=""):\ArrayObject{
        $liste = new \ArrayObject();
        $statement = Database::getInstance() -> getConnexion() -> prepare("select * from quizz where title like :textSearched;");
        $statement -> execute(['textSearched' => '%'.$text.'%']);
        while ($row = $statement -> fetch()){
            $liste[] = new Quizz(id:$row['id'],title:$row['title']);
        }
        return $liste;
    }

    public static function findById(int $id):?Quizz{
        $statement = Database::getInstance() -> getConnexion() -> prepare('select * from quizz where id =:id;');
        $statement -> execute (['id' => $id]);
        if ($row = $statement -> fetch())
        return new Quizz (id:$row['id'],title:$row['title']);
        return NULL;
    }
}