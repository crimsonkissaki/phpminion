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
use PHPMinion\Utilities\EntityAnalyzer\Renderers\ArrayModelRenderer;
use PHPMinion\Utilities\EntityAnalyzer\Models\ObjectModel;
use PHPMinion\Utilities\EntityAnalyzer\Renderers\ObjectModelRenderer;
use PHPMinion\Utilities\EntityAnalyzer\Models\ScalarModel;
use PHPMinion\Utilities\EntityAnalyzer\Renderers\ScalarModelRenderer;

/**
 * Class ArrayModelMocks
 *
 * Mocks for use in testing ArrayModel creation
 *
 * Most will be hand-built to ensure testing consistency
 */
class ArrayModelMocks
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
        $arr = self::getTwoElementArray();
        $model = new ArrayModel($arr);

        foreach ($arr as $k => $v) {
            $eleModel = new ScalarModel($v);
            $eleModel->setValue($v);
            $model->addElement($k, $eleModel);
        }

        return $model;
    }

    public static function getAssociativeArray()
    {
        return ['key1' => 'val1', 'key2' => 'val2'];
    }

    public static function getMock_associativeArr()
    {
        $arr = self::getAssociativeArray();
        $model = new ArrayModel($arr);

        foreach ($arr as $k => $v) {
            $eleModel = new ScalarModel($v);
            $eleModel->setValue($v);
            $model->addElement($k, $eleModel);
        }

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
        $arr = self::getNestedArray();
        $model = new ArrayModel($arr);

        foreach ($arr as $key => $value) {
            if (!is_array($value) && !is_object($value)) {
                $eleModel = new ScalarModel($value);
                $eleModel->setValue($value);
            }
            if (is_array($value)) {
                $eleModel = new ArrayModel($value);
                foreach ($value as $subK => $subV) {
                    $subModel = new ScalarModel($subV);
                    $subModel->setValue($subV);
                    $eleModel->addElement($subK, $subModel);
                }
            }
            $model->addElement($key, $eleModel);
        }

        return $model;
    }

}