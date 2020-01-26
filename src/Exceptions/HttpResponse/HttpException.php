<?php

namespace Kravinskiy\LaravelChassis\Exceptions\HttpResponse;

use Kravinskiy\LaravelChassis\Exceptions\Exception;
use Kravinskiy\LaravelChassis\Models\StandardResponse\Message\Message;

class HttpException extends Exception
{
    /**
     * HttpException constructor.
     * @param \Exception $exception
     * @throws Exception
     */
    public function __construct(\Exception $exception)
    {
        $message = new Message($exception->getMessage());
        parent::__construct($message);
        $this->code = $exception->getCode();
    }
}