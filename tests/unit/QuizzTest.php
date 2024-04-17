<?php

use PHPUnit\Framework\TestCase;
use app\TPQuizz\model\Quizz;

class QuizzTest extends TestCase
{
    public function test_1()
    {
        $quizz = new Quizz();
        $this->assertSame('No title choosen', $quizz->getTitle());
    }
    public function test_2()
    {
        $quizz = new Quizz('Quizz about PHP');
        $this->assertSame('Quizz about PHP', $quizz->getTitle());
    }
}
