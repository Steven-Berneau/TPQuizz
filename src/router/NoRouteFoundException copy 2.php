<?php
# src/router/NoRouteFoundException.php
declare(strict_types=1);

namespace app\TPQuizz\router;

class NoRouteFoundException extends  \Exception
{
    public function __construct($message = "No route has been set")
    {
        parent::__construct($message, 2);
    }
}
