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

namespace PHPMinion\Utilities\EntityAnalyzer\Factories;

use PHPMinion\Utilities\EntityAnalyzer\Analyzers\EntityAnalyzerInterface;
use PHPMinion\Utilities\EntityAnalyzer\Analyzers\ObjectAnalyzer;
use PHPMinion\Utilities\EntityAnalyzer\Analyzers\ArrayAnalyzer;
use PHPMinion\Utilities\EntityAnalyzer\Analyzers\ScalarAnalyzer;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\EntityAnalyzerException;

/**
 * AnalyzerFactory
 *
 * Returns the proper analyzer class for an entity type
 *
 * @created     October 19, 2015
 * @version     0.1
 */
class AnalyzerFactory
{

    /**
     * @var AnalyzerFactory
     */
    private static $_instance;

    /**
     * Array of data analyzers
     *
     * @var array
     */
    private $_analyzers = [];

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new AnalyzerFactory();
        }

        return self::$_instance;
    }

    private function __construct() {}

    /**
     * Returns the proper analyzer class for the entity data type
     *
     * @param  mixed $entity
     * @return EntityAnalyzerInterface
     * @throws EntityAnalyzerException
     */
    public static function getAnalyzer($entity)
    {
        $_this = self::getInstance();
        $dataType = gettype($entity);

        if (isset($_this->_analyzers[$dataType])) {
            return $_this->_analyzers[$dataType];
        }

        $analyzer = false;
        switch (true) {
            case (is_object($entity)):
                $analyzer = new ObjectAnalyzer();
                break;
            case (is_array($entity)):
                $analyzer = new ArrayAnalyzer();
                break;
            case (is_numeric($entity)):
            case (is_null($entity)):
            case (is_string($entity)):
            case (is_bool($entity)):
                $analyzer = new ScalarAnalyzer();
                break;
        }

        if (!$analyzer) {
            throw new EntityAnalyzerException("No Analyzer defined for data type: '{$dataType}'.");
        }

        $_this->_analyzers[$dataType] = $analyzer;

        return $_this->_analyzers[$dataType];
    }

}