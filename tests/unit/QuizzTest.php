<?php
use PHPUnit\Framework\TestCase;
use app\TPQuizz\model\Quizz;
use app\TPQuizz\model\Question;
class QuizzTest extends TestCase
{
    public function test_1(){
        $quizz = new Quizz();
        $this->assertSame('No title choosen', $quizz->getTitle());
    }

    public function test_2(){
        $quizz = new Quizz('Quizz about PHP');
        $this->assertSame('Quizz about PHP', $quizz->getTitle());
    }

    public function test3(){
        $quizz = new Quizz('Quizz about PHP');
        $quizz->addQuestion(new Question('What is a Constructor?'));
        $quizz->addQuestion(new Question('what is an Attribute?'));
        $this->assertSame('Quizz about PHP', $quizz->getTitle());
        $this->assertSame(2, $quizz->getQuestions()->count());
    }

}