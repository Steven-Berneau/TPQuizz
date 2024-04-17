<?php

declare(strict_types=1);

namespace app\TPQuizz\model;

class ReponseCollection extends \ArrayObject
{
    public function offsetSet($index, $newval): void
    {
        if (!($newval instanceof Reponse)) {
            throw new \InvalidArgumentException("Must be a reponse");
        }
        parent::offsetSet($index, $newval);
    }
    public static function getReponses(int $idQuestion): ReponseCollection
    {
        $liste = new ReponseCollection();
        $statement = Database::getInstance()->getConnexion()->prepare('SELECT * FROM reponse where numQuestion=:numQuestion;');
        $statement->execute(['numQuestion' => $idQuestion]);
        while ($row = $statement->fetch()) {
            $liste[] = new Reponse(text: $row['text'], id: $row['id'], isValid: $row['isValid'] == 1 ? true : false);
        }
        return $liste;
    }
}
