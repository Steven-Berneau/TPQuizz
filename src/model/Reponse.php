<?php

declare(strict_types=1);

namespace app\TPQuizz\model;

class Reponse
{
    private string $_text;
    private int $_id;
    private bool $_isValid;
    private Question $_question;
    public function __construct(string $text, int $id = 0, bool $isValid = false)
    {
        $this->_id = $id;
        $this->_text = $text;
        $this->_isValid = $isValid;
    }
    public function getText(): string
    {
        return $this->_text;
    }
    public function getIsValid(): bool
    {
        return $this->_isValid;
    }
    public function getId(): int
    {
        return $this->_id;
    }
    public function setQuestion(Question $question)
    {
        $this->_question = $question;
    }
    public function getQuestion(): Question
    {
        return $this->_question;
    }

    /** IMPLEMENTATION DU CRUD */

    public static function create(Reponse $reponse, Question $question): int
    {
        $statement = Database::getInstance()->getConnexion()->prepare("INSERT INTO reponse (text,isValid,numQuestion) values (:text,:isValid,:numQuestion);");
        // le type booleen est un short int dans MYSQL et un booleen en PHP
        $statement->execute(['text' => $reponse->getText(), 'isValid' => $reponse->getIsvalid() == true ? 1 : 0, 'numQuestion' => $question->getId()]);
        return (int)Database::getInstance()->getConnexion()->lastInsertId();
    }
    public static function read(int $id): ?Reponse
    {
        $statement = Database::getInstance()->getConnexion()->prepare('select * from reponse where id =:id;');
        $statement->execute(['id' => $id]);
        if ($row = $statement->fetch()) {
            // le type booleen est un short int dans MYSQL et un booleen en PHP
            $reponse = new Reponse(id: $row['id'], text: $row['text'], isValid: $row['isValid'] == 1 ? true : false);
            $reponse->setQuestion(Question::read($row['numQuestion']));
            return $reponse;
        }
        return null;
    }
    public static function update(Reponse $reponse)
    {
        $statement = Database::getInstance()->getConnexion()->prepare('UPDATE reponse set text=:text, numQuestion =:numQuestion, set isValid=:isValid WHERE id =:id');
        $statement->execute(['text' => $reponse->getText(), 'numQuestion' => $reponse->getQuestion()->getId(), 'isValid' => $reponse->getIsValid(), 'id' => $reponse->getId()]);
    }
    public static function delete(Reponse $reponse)
    {
        $statement = Database::getInstance()->getConnexion()->prepare('DELETE FROM reponse WHERE id =:id');
        $statement->execute(['id' => $reponse->getId()]);
    }
}
