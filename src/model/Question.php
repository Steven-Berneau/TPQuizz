<?php

declare(strict_types=1);

namespace app\TPQuizz\model;

class Question
{
    private string $_text;
    private int $_id;
    private Quizz $_quiz;
    public function __construct(string $text, int $id = 0)
    {
        $this->_id = $id;
        $this->_text = $text;
    }
    public function getId(): int
    {
        return $this->_id;
    }
    public function getQuiz(): Quizz
    {
        return $this->_quiz;
    }
    public function setQuiz(Quizz $quiz)
    {
        $this->_quiz = $quiz;
    }
    public function getText(): string
    {
        return $this->_text;
    }
    /**MISE EN PLACE COLLECTION */
    public function getReponses(): ReponseCollection
    {
        $liste = new ReponseCollection();
        //préparation de la requête avec appel du singleton DATABASE
        $statement = Database::getInstance()->getConnexion()->prepare('select * from reponse where numQuestion=:id;');
        $statement->execute(['id' => $this->getId()]);
        while ($row = $statement->fetch()) {
            $reponse = new Reponse(id: $row['id'], text: $row['text'], isValid: $row['isValid'] == 1 ? true : false);
            // il faut faire le lien entre le quiz et la question via la clé étrangère
            $reponse->setQuestion($this);
            $liste[] = $reponse;
        }
        return $liste;
    }
    /** IMPLEMENTATION DU CRUD */

    public static function create(Question $question, Quizz $quizz): int
    {
        $statement = Database::getInstance()->getConnexion()->prepare("INSERT INTO question (text,numQuiz) values (:text,:numQuiz);");
        $statement->execute(['text' => $question->getText(), 'numQuiz' => $quizz->getId()]);
        return (int)Database::getInstance()->getConnexion()->lastInsertId();
    }
    public static function read(int $id): ?Question
    {
        $statement = Database::getInstance()->getConnexion()->prepare('select * from question where id =:id;');
        $statement->execute(['id' => $id]);
        if ($row = $statement->fetch()) {
            $question = new Question(id: $row['id'], text: $row['text']);
            $question->setQuiz(Quizz::read($row['numQuiz']));
            return $question;
        }
        return null;
    }
    public static function update(Question $question)
    {
        $statement = Database::getInstance()->getConnexion()->prepare('UPDATE question set text=:text, numQuiz =:numQuiz WHERE id =:id');
        $statement->execute(['text' => $question->getText(), 'numQuiz' => $question->getQuiz()->getId(), 'id' => $question->getId()]);
    }
    public static function delete(Question $question)
    {
        $statement = Database::getInstance()->getConnexion()->prepare('DELETE FROM question WHERE id =:id');
        $statement->execute(['id' => $question->getId()]);
    }
}
