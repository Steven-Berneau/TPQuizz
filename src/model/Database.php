<?php

namespace app\TPQuizz\model;

class Database{

    private static ?Database $_instance = NULL;
    private ?\PDO $_connexion = NULL;
    
    private function __construct(){
        $this -> _connexion = new \PDO ('mysql:host=mysql-srv;dbname=quizz_database','db_user','password');
    }

    public static function getInstance(){
        if(self::$_instance == NULL)
        self::$_instance = new Database();
    return self::$_instance;
    }

    public function getConnexion():\PDO{
        return $this -> _connexion;
    }
}