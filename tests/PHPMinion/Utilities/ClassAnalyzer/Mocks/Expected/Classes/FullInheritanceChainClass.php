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
 * Class FullInheritanceChainClass
 *
 * What the FullInheritanceChainClass ought to look like as a ClassModel
 */
class FullInheritanceChainClass
{

    public static function getClassModel()
    {
        $path = 'PHPMinionTest\Utilities\ClassAnalyzer\Mocks\Classes';
        $model = new ClassModel();
        $model->setName($path.'\FullInheritanceChainClass');
        $model->setNameSpace($path);
        $model->setUses(array(
            $path.'\SimpleClass',
            $path.'\SimpleInterface',
            $path.'\VisibilityClassAsPropertyModels',
        ));
        $model->setExtends($path.'\SimpleClass');
        $model->setImplements(array(
            $path.'\SimpleInterface',
        ));

        return $model;
    }

}