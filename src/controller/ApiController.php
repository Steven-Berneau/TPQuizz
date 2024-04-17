<?php

declare(strict_types=1);

namespace app\TPQuizz\controller;


class ApiController extends BaseController
{
    public function index()
    {
        $this->addParam('message', "Salut");
        $this->view('api/index');
    }
}
