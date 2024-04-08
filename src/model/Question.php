<?php

namespace app\TPQuizz\model;

class Question{

    private string $_text;
    private ResponseCollection $_responses;
    private int $_id;

    public function __construct(string $text='No title choosen', int $id = 0){
        $this -> _text = $text;
        $this -> _responses = new ResponseCollection();
        $this -> _id = $id;
    }

    public function getTitle():string{
        return $this -> _text;
    }
    
    public function addResponse(Response $response){
        $this -> _responses[] = $response;
    }
    public function getResponses():ResponseCollection{
        return $this -> _responses;
    }

    
    public static function getQuestions(int $numQuizz):QuestionCollection{
        $liste = new QuestionCollection();
        $statement = Database::getInstance() -> getConnexion() -> prepare("select * from question where numQuiz = :numQuizz;");
        $statement -> execute(['numQuizz' => $numQuizz]);
        while ($row = $statement -> fetch()){
            $liste[] = new Question(id:$row['id'],text:$row['text']);
        }
        return $liste;
    }
}