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

namespace PHPMinionTest\Utilities\ClassAnalyzer\Mocks\Expected\Classes;

use PHPMinion\Utilities\ClassAnalyzer\Models\ClassModel;

/**
 * Class StdClass
 *
 * What the \stdClass ought to look like as a ClassModel
 */
class StdClass
{

    public static function getClassModel()
    {
        $model = new ClassModel();
        $model->setName('stdClass');

        return $model;
    }

}