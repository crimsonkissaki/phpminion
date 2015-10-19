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

namespace PHPMinion\Utilities\EntityAnalyzer\Analyzers;

use PHPMinion\Utilities\EntityAnalyzer\Analyzers\ObjectAnalyzer;
use PHPMinion\Utilities\EntityAnalyzer\Analyzers\ArrayAnalyzer;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\AnalyzerException;

/**
 * Class EntityAnalyzer
 *
 * Entry point for entity analysis.
 * Calls the proper analysis handlers for various datatypes that
 * need more rigorous handling.
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 18, 2015
 * @version     0.1
 */
class EntityAnalyzer implements AnalyzerInterface
{

    /**
     * @var ObjectAnalyzer
     */
    private $_objectAnalyzer;

    /**
     * @var ArrayAnalyzer
     */
    private $_arrayAnalyzer;

    public function __construct()
    {
        $this->_objectAnalyzer = new ObjectAnalyzer();
        $this->_arrayAnalyzer = new ArrayAnalyzer();
    }

    /**
     * @inheritDoc
     * @throws AnalyzerException
     */
    public function analyze($entity)
    {
        if (is_object($entity)) {
            return $this->_objectAnalyzer->analyze($entity);
        }

        if (is_array($entity)) {
            return $this->_arrayAnalyzer->analyze($entity);
        }

        throw new AnalyzerException("EntityAnalyzer only accepts objects or arrays: '" . gettype($entity) . "' provided.");
    }

}