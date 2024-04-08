<?php
use PHPUnit\Framework\TestCase;
use app\TPQuizz\model\Question;
class QuestionTest extends TestCase
{
    public function test_1()
    {
        $question = new Question();
        $this->assertSame('No title choosen', $question -> getTitle());
    }
    public function test_2()
    {
        $question = new Question('Quizz about PHP');
        $this->assertSame('Quizz about PHP', $question -> getTitle());
    }
}    