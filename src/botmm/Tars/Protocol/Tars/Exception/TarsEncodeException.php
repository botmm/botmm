<?php


namespace botmm\Tars\protocol\tars\exception;

use Exception;
use RuntimeException;

class TarsEncodeException extends RuntimeException
{
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}