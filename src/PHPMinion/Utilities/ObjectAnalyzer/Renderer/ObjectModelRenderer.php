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

namespace PHPMinion\Utilities\ObjectAnalyzer\Renderer;

use PHPMinion\Utilities\ObjectAnalyzer\Models\ObjectModel;
use PHPMinion\Utilities\ObjectAnalyzer\Models\PropertyModel;

/**
 * Class ObjectModelTranslator
 *
 * Translates an ObjectModel to something more human-readable
 *
 * @created     October 19, 2015
 * @version     0.1
 */
class ObjectModelRenderer implements ObjectModelRendererInterface
{

    public function renderObjectModel(ObjectModel $model, $indent = 2)
    {
        $output = "Object ({$model->name})".PHP_EOL;
        foreach ($model->properties as $vis => $props) {
            /** @var PropertyModel $prop */
            foreach ($props as $prop) {
                //\application\Utils::dbug($prop, "property", true);
                $output .= $this->generatePropertyOutput($prop, $indent);
            }
        }

        return $output;
    }

    private function generatePropertyOutput(PropertyModel $prop, $indent)
    {
        $type = $prop->currentValueDataType;
        echo "--> generating for '{$type}'<BR>";
        $output = str_repeat(' ', $indent)."{$prop->visibility} '{$prop->name}' =>";
        // number of spaces to put before the line
        switch(strtolower($prop->currentValueDataType)) {
            case 'string':
                $output .= $this->generateStringOutput($prop);
                break;
            case 'null':
                $output .= $this->generateNullOutput($prop);
                break;
            case 'object':
                $output .= $this->generateObjectOutput($prop, $indent);
                break;
            case 'array':
                $output .= $this->generateArrayOutput($prop, $indent);
                break;
            default:
                $output .= " no handler for generating '{$type}'<BR>";
                break;
        }

        return $output;
    }

    private function generateStringOutput(PropertyModel $prop)
    {
        $output = " string '{$prop->currentValue}' (length=".strlen($prop->currentValue).")".PHP_EOL;

        return $output;
    }

    private function generateNullOutput(PropertyModel $prop)
    {
        $output = " null".PHP_EOL;

        return $output;
    }

    private function generateObjectOutput(PropertyModel $prop, $indent)
    {
        $spc = str_repeat(' ', $indent + 2);
        $output = PHP_EOL.$spc."{$prop->currentValueDataType} {$prop->currentValue}".PHP_EOL;

        return $output;
    }

    private function generateArrayOutput(PropertyModel $prop, $indent)
    {
        $spc = str_repeat(' ', $indent + 2);
        $val = $prop->currentValue;
        $output = PHP_EOL.$spc.'array (size=' . count($val) . ')' . PHP_EOL;
        foreach ($val as $k => $v) {
        }

        return $output;
    }

}