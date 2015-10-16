<?php
/**
 * @copyright Copyright (c) 2015, StoneEagle.com
 */

namespace PHPMinion\Utilities\Debug\Exceptions;


class DebugException extends \Exception
{

    public function __construct($msg, $code = 0, \Exception $prev = null)
    {
        parent::__construct($msg, $code, $prev);
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}