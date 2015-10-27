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
 * Class ComplexClass
 *
 * What the ComplexClass ought to look like as PropertyModel[]
 */
class ComplexClass
{

    public static function getPropertyModels()
    {
        return [new PropertyModel()];


        $visibilities = ['constant', 'public', 'protected', 'private'];
        $properties = [
            'string' => 'string value',
            'integer' => 10,
            'double' => 3.14,
            'true' => true,
            'false' => false,
            'null' => null,
            'array' => ['', 'val1', 'val2']
        ];

        $finalForm = [];
        foreach ($visibilities as $vis) {
            foreach ($properties as $name => $value) {
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
        }

        foreach (['public', 'protected', 'private'] as $vis) {
            foreach ($properties as $name => $value) {
                $model = new PropertyModel();
                $model->setName("{$vis}_static_{$name}");
                $model->setVisibility('static');
                $model->setIsStatic(true);
                $curVal = $value;
                if (is_array($curVal)) {
                    $curVal[0] = "{$vis} static";
                }
                if (is_string($curVal)) {
                    $curVal = "{$vis} static {$curVal}";
                }
                $model->setCurrentValue($curVal);
                $model->setCurrentValueDataType(gettype($value));
                $finalForm[] = $model;
            }
        }

        return $finalForm;
    }

}