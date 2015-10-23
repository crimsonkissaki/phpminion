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

namespace PHPMinionTest\Utilities\EntityAnalyzer\Mocks;

use PHPMinion\Utilities\Core\Common;
use PHPMinion\Utilities\EntityAnalyzer\Models\DataTypeModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\ArrayModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\ObjectModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\PropertyModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\ScalarModel;

/**
 * Class ObjectModelMocks
 *
 * Mocks for use in testing ObjectModel creation
 *
 * Most will be hand-built to ensure testing consistency
 */
class ObjectModelMocks
{

    public static function getSimpleObj()
    {
        $obj = new \stdClass();
        $obj->prop1 = 'val1';
        $obj->prop2 = 10;
        $obj->prop3 = 3.14;
        $obj->prop4 = true;
        $obj->prop5 = false;

        return $obj;
    }

    /**
     * Creates a mock ObjectModel from a simple object
     *
     * @return ObjectModel
     */
    public static function getMock_SimpleObj()
    {
        $obj = self::getSimpleObj();
        $model = new ObjectModel($obj);

        foreach ($obj as $propName => $propValue) {
            $property = new ScalarModel($propValue);
            $property->setValue($propValue);
            $model->addProperty('public', $propName, $property);
        }

        return $model;
    }

}