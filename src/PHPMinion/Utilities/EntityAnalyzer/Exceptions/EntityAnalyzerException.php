<?php
/**
 * PHPMinion
 *
 * A suite of tools to facilitate development and debugging.
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 9, 2015
 * @version     0.1
 */

namespace PHPMinion\Utilities\EntityAnalyzer\Exceptions;

use PHPMinion\Utilities\Core\Exceptions\PHPMinionException;

/**
 * Class EntityAnalyzerException
 *
 * All EntityAnalyzer utility exceptions inherit from this class.
 */
class EntityAnalyzerException extends PHPMinionException
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