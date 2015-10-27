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
use PHPMinion\Utilities\EntityAnalyzer\Models\ScalarModel;

/**
 * Class ArrayModelMocks
 *
 * Mocks for use in testing ArrayModel creation
 *
 * Most will be hand-built to ensure testing consistency
 */
class ArrayModelMocks extends ModelMock
{

    public static function getTwoElementArray()
    {
        return ['val1', 'val2'];
    }

    /**
     * Returns an ArrayModel created from 2 simple elements
     *
     * @return ArrayModel
     */
    public static function getMock_twoElementArr()
    {
        $model = self::createArrayModels(self::getTwoElementArray());

        return $model;
    }

    public static function getAssociativeArray()
    {
        return ['key1' => 'val1', 'key2' => 'val2'];
    }

    public static function getMock_associativeArr()
    {
        $model = self::createArrayModels(self::getAssociativeArray());

        return $model;
    }

    public static function getNestedArray()
    {
        return [
            'key1' => 'val1',
            'key2' => [
                'subKey1' => 'subVal1',
                'subKey2' => 10,
                'subKey3' => 3.14,
            ]
        ];
    }

    public static function getMock_nestedArr()
    {
        $model = self::createArrayModels(self::getNestedArray());

        return $model;
    }

}