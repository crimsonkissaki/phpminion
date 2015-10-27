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
 * Class ModelMock
 *
 * Mocks for use in testing ObjectModel creation
 *
 * Most will be hand-built to ensure testing consistency
 */
class ModelMock
{

    public static function getBaseTestVals()
    {
        $obj = new \stdClass();
        // use sprintf($obj->string, $visibility)
        $obj->string = '%s string value';
        $obj->integer = 10;
        $obj->double = 3.14;
        $obj->true = true;
        $obj->false = false;
        $obj->null = null;
        // $obj->array[0] = $visibility
        $obj->array = ['', 'val1', 'val2'];

        return $obj;
    }

    /**
     * Purposefully ignores objects
     *
     * @param  mixed $data
     * @return ArrayModel|ScalarModel
     */
    public static function getModelForType($data)
    {
        switch (true) {
            case (is_null($data)):
            case (is_scalar($data)):
                $model = new ScalarModel($data);
                break;
            case (is_array($data)):
                $model = self::createArrayModels($data);
                break;
        }

        return $model;
    }

    /**
     * Builds a basic ArrayModel result
     *
     * @param  array $array
     * @return ArrayModel
     */
    public static function createArrayModels(array $array)
    {
        $model = new ArrayModel($array);
        foreach ($array as $key => $value) {
            $model->setValue($key, self::getModelForType($value));
        }

        return $model;
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
            $model->setValue($propName, $propModel);
        }

        return $model;
    }

}