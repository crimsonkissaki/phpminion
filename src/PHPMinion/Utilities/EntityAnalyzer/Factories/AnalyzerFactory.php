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
        $dataType = gettype($entity);
        $_this = self::getInstance();

        if (isset($_this->_analyzers[$dataType])) {
            return $_this->_analyzers[$dataType];
        }

        $entityAnalyzer = $_this->getEntityAnalyzer($dataType);

        \PHPMinion\Utils::dbug($entityAnalyzer, "entity analyzer", true);

        return $entityAnalyzer->analyze($entity);
    }

    /**
     * Gets the appropriate EntityEntityAnalyzer class depending on the entity's data type
     *
     * @param string $dataType
     * @return EntityAnalyzerInterface
     * @throws AnalyzerException
     */
    private function getEntityAnalyzer($dataType)
    {
        $analyzer = false;
        switch (strtolower($dataType)) {
            case 'object':
                $analyzer = new ObjectAnalyzer();
                break;
            case 'array':
                $analyzer = new ArrayAnalyzer();
                break;
        }

        if (!$analyzer) {
            throw new AnalyzerException("No Analyzer defined for data type: '{$dataType}'.");
        }

        return $analyzer;
    }

}