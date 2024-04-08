<?php

namespace app\TPQuizz\model;

class Response{

    private string $_text;
    private bool $_isValid;
    private int $_id;

    public function __construct(string $text='No title choosen', bool $isValid=true, int $id=0){
        $this -> _text = $text;
        $this -> _isValid = $isValid;
        $this -> _id = $id;
    }

    public function getText():string{
        return $this -> _text;
    }

    public function isValid():bool{
        return $this -> _isValid;
    }

    public static function getResponse(int $numQuestion):ResponseCollection{
        $liste = new ResponseCollection();
        $statement = Database::getInstance() -> getConnexion() -> prepare("select * from reponse where numQuestion = :numQuestion;");
        $statement -> execute(['numQuestion' => $numQuestion]);
        while ($row = $statement -> fetch()){
            $liste[] = new Response(id:$row['id'],text:$row['text']);
        }
        return $liste;
    }
}