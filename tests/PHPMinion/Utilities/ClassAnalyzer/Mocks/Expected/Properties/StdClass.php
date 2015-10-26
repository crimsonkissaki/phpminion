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

namespace PHPMinionTest\Utilities\ClassAnalyzer\Mocks\Expected\Properties;

use PHPMinion\Utilities\ClassAnalyzer\Models\PropertyModel;

/**
 * Class StdClass
 *
 * What the \stdClass properties as PropertyModel[]
 */
class StdClass
{

    public static function getPropertyModels()
    {
        $stdValues = [
            'string' => 'string value',
            'integer' => 10,
            'double' => 3.14,
            'true' => true,
            'false' => false,
            'null' => null,
            'array' => ['', 'val1', 'val2']
        ];

        $props = [];
        $vis = 'public';
        foreach ($stdValues as $name => $value) {
            $model = new PropertyModel();
            $name = "{$vis}_{$name}";
            if ($vis === 'constant') {
                $name = strtoupper($name);
            }
            $model->setName($name);
            $model->setVisibility($vis);
            $model->setIsStatic(false);
            $curVal = $value;
            if (is_array($curVal)) {
                $curVal[0] = $vis;
            }
            if (is_string($curVal)) {
                $curVal = "{$vis} {$curVal}";
            }
            $model->setCurrentValue($curVal);
            $model->setCurrentValueDataType(gettype($value));
            $finalForm[] = $model;
        }

        return $props;
    }

}