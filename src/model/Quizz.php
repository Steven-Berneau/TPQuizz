<?php

declare(strict_types=1);

namespace app\TPQuizz\model;

class Quizz
{
    private string $_title;
    private int $_id;
    private QuestionCollection $_questions;
    public function __construct(string $title = 'No title choosen', int $id = 0)
    {
        $this->_title = $title;
        $this->_id = $id;
        $this->_questions = new QuestionCollection();
    }
    #region getters et setters
    public function getTitle(): string
    {
        return $this->_title;
    }
    public function setTitle(string $title)
    {
        $this->_title = $title;
    }
    public function getId(): int
    {
        return $this->_id;
    }
    #endregion
    /**
     * La liste des questions est systématiquement rechargée depuis la base de données lors que l'appel à la méthode getQuestion: cela nous assure d'avoir toujours les questions à jour. Attention que mettre en cache soulagerait le serveur de base de données. D'un autre côté, les questions ne sont chargées que lorsqu'on le demande.
     */
    public function getQuestions(): QuestionCollection
    {
        $liste = new QuestionCollection();
        //préparation de la requête avec appel du singleton DATABASE
        $statement = Database::getInstance()->getConnexion()->prepare('select * from question where numQuiz=:id;');
        $statement->execute(['id' => $this->getId()]);
        while ($row = $statement->fetch()) {
            $question = new Question(id: $row['id'], text: $row['text']);
            // il faut faire le lien entre le quiz et la question via la clé étrangère
            $question->setQuiz($this);
            $liste[] = $question;
        }
        return $liste;
    }
    /**
     * LIEN AVEC LA BASE DE DONNEES
     */
    public static function list(): \ArrayObject
    {
        $liste = new \ArrayObject();
        $statement = Database::getInstance()->getConnexion()->prepare('select * from quiz;');
        $statement->execute();
        while ($row = $statement->fetch()) {
            $liste[] = new Quizz(id: $row['id'], title: $row['title']);
        }
        return $liste;
    }
    public static function filter(string $texte): \ArrayObject
    {
        $liste = new \ArrayObject();
        $statement = Database::getInstance()->getConnexion()->prepare("select * from quiz where title like :textSearched;");
        $statement->execute(['textSearched' => '%' . $texte . '%']);
        while ($row = $statement->fetch()) {
            $liste[] = new Quizz(id: $row['id'], title: $row['title']);
        }
        return $liste;
    }
    /** IMPLEMENTATION DU CRUD */
    public static function read(int $id): ?Quizz
    {
        $statement = Database::getInstance()->getConnexion()->prepare('select * from quiz where id =:id;');
        $statement->execute(['id' => $id]);
        if ($row = $statement->fetch())
            return new Quizz(id: $row['id'], title: $row['title']);
        return null;
    }

    public static function create(Quizz $quiz): int
    {
        $statement = Database::getInstance()->getConnexion()->prepare("INSERT INTO quiz (title) values (:title);");
        $statement->execute(['title' => $quiz->getTitle()]);
        return (int)Database::getInstance()->getConnexion()->lastInsertId();
    }
    public static function update(Quizz $quiz)
    {
        $statement = Database::getInstance()->getConnexion()->prepare('UPDATE quiz set title=:title WHERE id =:id');
        $statement->execute(['title' => $quiz->getTitle(), 'id' => $quiz->getId()]);
    }
    public static function delete(Quizz $quiz)
    {
        $statement = Database::getInstance()->getConnexion()->prepare('DELETE FROM quiz WHERE id =:id');
        $statement->execute(['id' => $quiz->getId()]);
    }

    public static function loadFromJson($data)
    {
        foreach ($data as $q) {
            $quiz = new Quizz($q->title);
            $id = Quizz::create($quiz);
            $quiz = Quizz::read($id);
            echo "id=" . $id;
            foreach ($q->questions as $quest) {
                $question = new Question($quest->text);
                $question->setQuiz($quiz);
                $id = Question::create($question, $quiz);
                $question = Question::read($id);
                foreach ($quest->responses as $rep) {
                    $reponse = new Reponse(text: $rep->text, isValid: $rep->isValid);
                    $reponse->setQuestion($question);
                    $id = Reponse::create($reponse, $question);
                }
            }
        }
    }
}
