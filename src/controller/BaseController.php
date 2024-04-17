<?php

namespace app\TPQuizz\controller;

use app\TPQuizz\router\HttpRequest;
use app\TPQuizz\router\ViewNotFoundException;

abstract class BaseController
{
    protected HttpRequest $_httpRequest;
    protected $_params = [];

    public function __construct($httpRequest)
    {
        $this->_httpRequest = $httpRequest;
        $this->_params = $httpRequest->getParams();
    }

    public function view($filename)
    {
        $viewFile = './../templates/' . $filename . '.php';
        if (file_exists($viewFile)) {
            ob_start();
            // ['id'=>5,'text'=>"Salut"]
            extract($this->_params);
            // extract donnerait
            // $id=5;$text="Salut";
            include($viewFile);
            $content = ob_get_clean();
            include("./../templates/layout.php");
        } else {
            throw new ViewNotFoundException($viewFile);
        }
    }
    public function addParam($name, $value)
    {
        $this->_params[$name] = $value;
    }
}
