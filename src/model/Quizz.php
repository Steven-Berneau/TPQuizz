<?php

namespace app\TPQuizz\model;

class Quizz{

    private string $_title;

    public function __construct(string $title='No title choosen'){
        $this ->_title = $title;
    }

    public function getTitle():string{
        return $this -> _title;
    }
}