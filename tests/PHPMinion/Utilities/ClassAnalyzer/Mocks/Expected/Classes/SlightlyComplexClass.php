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
 * Class SlightlyComplexClass
 *
 * What the SlightlyComplexClass ought to look like as a ClassModel
 */
class SlightlyComplexClass
{

    public static function getClassModel()
    {
        $path = 'PHPMinionTest\Utilities\ClassAnalyzer\Mocks\Classes';
        $model = new ClassModel();
        $model->setName($path.'\SlightlyComplexClass');
        $model->setNameSpace($path);
        $model->setUses(array(
            $path.'\VisibilityClass',
        ));

        return $model;
    }

}