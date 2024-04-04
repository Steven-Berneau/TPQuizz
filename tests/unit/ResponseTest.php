<?php
use PHPUnit\Framework\TestCase;
use app\TPQuizz\model\Response;
class ResponseTest extends TestCase
{
    public function test_1()
    {
        $response = new Response();
        $this->assertSame('No title choosen', $response->getText());
        $this->assertSame(true, $response->isValid());
    }
    public function test_2()
    {
        $response = new Response('Quizz about PHP');
        $this->assertSame('Quizz about PHP', $response->getText());
    }
}    