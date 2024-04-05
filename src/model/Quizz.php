<?php

namespace app\TPQuizz\model;

class Quizz{

    private string $_title;
    private QuestionCollection $_questions;
  


    public function __construct(string $title ='No title choosen'){
        $this->_title = $title;
        $this->_questions = new QuestionCollection();
    }

    public function getTitle():string{
        return $this ->_title;
    }

    public function getQuestions():QuestionCollection{
        return $this->_questions;
    }

    public function addQuestion(Question $question){
        $this->_questions[]=$question;
    }



    public static function create($pJsonObject):Quizz{

        $quizz = new Quizz( $pJsonObject->title);
        foreach ($pJsonObject->questions as $key => $questionJson) {
            $question = new Question( $questionJson->text);
            foreach ($questionJson->responses as $key => $responseJson) {
                $response = new Response($responseJson->text,$responseJson->isValid);
                $question->addResponse($response);
            }
            $quizz->addQuestion($question);
        }

        return $quizz ;
    }
}