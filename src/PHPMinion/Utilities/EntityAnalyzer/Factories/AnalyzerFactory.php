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

use PHPMinion\Utilities\EntityAnalyzer\Analyzers\ObjectAnalyzer;
use PHPMinion\Utilities\EntityAnalyzer\Analyzers\ArrayAnalyzer;
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
     * Returns the proper analyzer class for the entity data type
     *
     * @param  mixed $entity
     * @return ArrayAnalyzer|ObjectAnalyzer
     * @throws AnalyzerException
     */
    public static function getAnalyzer($entity)
    {
        if (is_object($entity)) {
            return new ObjectAnalyzer();
        }
        if (is_array($entity)) {
            return new ArrayAnalyzer();
        }

        throw new AnalyzerException("No analyzer available in AnalyzerFactory for data type '" . gettype($entity) . "'.");
    }

}