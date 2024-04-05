<?php

namespace app\TPQuizz\model;

class Question{

    private string $_text;
    private ResponseCollection $_responses;

    public function __construct(string $text='No title choosen'){
        $this -> _text = $text;
        $this->_responses = new ResponseCollection();
    }

    public function getTitle():string{
        return $this -> _text;
    }
    
    public function addResponse(Response $response){
        $this->_responses[]=$response;
    }
    public function getResponses():ResponseCollection{
        return $this->_responses;
    }

}