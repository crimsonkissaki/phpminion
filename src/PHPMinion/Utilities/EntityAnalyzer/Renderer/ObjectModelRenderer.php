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

namespace PHPMinion\Utilities\EntityAnalyzer\Renderer;

use PHPMinion\Utilities\EntityAnalyzer\Models\AnalysisModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\PropertyModel;

/**
 * Class ObjectModelTranslator
 *
 * Translates an ObjectModel to something more human-readable
 *
 * @created     October 19, 2015
 * @version     0.1
 */
class ObjectModelRenderer implements ModelRendererInterface
{

    /**
     * @inheritDoc
     */
    public function renderModel(AnalysisModel $model, $level = 0)
    {
        $output = $this->indent($level) . "Object ({$model->name})".PHP_EOL;
        foreach ($model->properties as $vis => $props) {
            /** @var PropertyModel $prop */
            foreach ($props as $prop) {
                //\application\Utils::dbug($prop, "property", true);
                $output .= $this->generatePropertyOutput($prop, $level + 1);
            }
        }

        return $output;
    }

    private function indent($level)
    {
        return str_repeat('  ', $level);
    }

    private function generatePropertyOutput(PropertyModel $prop, $level)
    {
        $type = $prop->currentValueDataType;
        echo "--> generating for '{$type}'<BR>";
        $output = $this->indent($level)."{$prop->visibility} '{$prop->name}' =>";
        // number of spaces to put before the line
        switch(strtolower($prop->currentValueDataType)) {
            case 'string':
                $output .= $this->generateStringOutput($prop);
                break;
            case 'null':
                $output .= $this->generateNullOutput($prop);
                break;
            case 'object':
                $output .= $this->generateObjectOutput($prop, $level + 1);
                break;
            case 'array':
                $output .= $this->generateArrayOutput($prop, $level + 1);
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

    private function generateObjectOutput(PropertyModel $prop, $level)
    {
        $output = PHP_EOL . $this->indent($level);
        $output .= "{$prop->currentValueDataType} {$prop->currentValue}".PHP_EOL;

        return $output;
    }

    private function generateArrayOutput(PropertyModel $prop, $level)
    {
        $val = $prop->currentValue;
        $output = PHP_EOL . $this->indent($level);
        $output .= 'array (size=' . count($val) . ')' . PHP_EOL;
        foreach ($val as $k => $v) {
            $subLvl = $level + 1;
            $output .= $this->indent($subLvl) . "{$k} =>" . PHP_EOL;
            // TODO: array elements should be constructed of propertymodels as well
            // or use an arrayvaluemodel which inherits propertymodel?
        }

        return $output;
    }

}