<?php

declare(strict_types=1);

namespace app\TPQuizz\model;

class QuestionCollection extends \ArrayObject
{
    public function offsetSet($index, $newval): void
    {
        if (!($newval instanceof Question)) {
            throw new \InvalidArgumentException("Must be a question");
        }
        parent::offsetSet($index, $newval);
    }
    public static function getQuestions(int $idQuiz): QuestionCollection
    {
        $liste = new QuestionCollection();
        $statement = Database::getInstance()->getConnexion()->prepare('SELECT * FROM question where numQuiz=:numQuiz;');
        $statement->execute(['numQuiz' => $idQuiz]);
        while ($row = $statement->fetch()) {
            $liste[] = new Question(text: $row['text'], id: $row['id']);
        }
        return $liste;
    }
}
