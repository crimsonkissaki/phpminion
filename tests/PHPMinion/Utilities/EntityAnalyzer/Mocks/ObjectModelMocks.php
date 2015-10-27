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
class ObjectModelMocks extends ModelMock
{

    public static function getSimpleObj()
    {
        $base = self::getBaseTestVals();
        $obj = new \stdClass();
        foreach ($base as $pName => $pValue) {
            $name = "public_{$pName}";
            $obj->$name = $pValue;
        }
        $obj->public_string = sprintf($obj->public_string, 'public');
        $obj->public_array[0] = 'public';

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
            $propModel = self::getModelForType($propValue);
            $propModel->setVisibility('public');
            $model->setValue([$propName => $propModel]);
        }

        return $model;
    }

}