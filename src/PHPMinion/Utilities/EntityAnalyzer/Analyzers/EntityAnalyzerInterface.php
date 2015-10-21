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

use PHPMinion\Utilities\EntityAnalyzer\Models\DataTypeModel;

/**
 * EntityAnalyzerInterface
 *
 * Interface for any class used by DbugTools to get
 * object information for debugging.
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 18, 2015
 * @version     0.1
 */
interface EntityAnalyzerInterface
{

    /**
     * Analyzes entities and returns a simplified summary
     *
     * @param  mixed $entity Entity to analyze
     * @return DataTypeModel
     */
    public function analyze($entity);

}