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
use PHPMinion\Utilities\EntityAnalyzer\Analyzers\SimpleAnalyzer;
use PHPMinion\Utilities\EntityAnalyzer\Models\DataTypeModel;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\AnalyzerException;

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
     * @return DataTypeModel
     */
    public static function getAnalyzer($entity)
    {
        $_this = self::getInstance();
        $entityAnalyzer = $_this->getEntityAnalyzer($entity);

        \PHPMinion\Utils::dbug($entityAnalyzer, "entity analyzer", true);

        return $entityAnalyzer->analyze($entity);
    }

    /**
     * Gets the appropriate EntityEntityAnalyzer class depending on the entity's data type
     *
     * @param mixed $entity
     * @return EntityAnalyzerInterface
     * @throws AnalyzerException
     */
    private function getEntityAnalyzer($entity)
    {
        $dataType = gettype($entity);

        if (isset($this->_analyzers[$dataType])) {
            return $this->_analyzers[$dataType];
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
                $analyzer = new SimpleAnalyzer();
                break;
        }

        if (!$analyzer) {
            throw new AnalyzerException("No Analyzer defined for data type: '{$dataType}'.");
        }

        $this->_analyzers[$dataType] = $analyzer;

        return $this->_analyzers[$dataType];
    }

}