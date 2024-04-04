<?php

namespace app\TPQuizz\model;

class Question{

    private string $_text;

    public function __construct(string $text='No title choosen'){
        $this -> _text = $text;
    }

    public function getTitle():string{
        return $this -> _text;
    }
}