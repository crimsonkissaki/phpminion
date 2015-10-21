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

use PHPMinion\Utilities\EntityAnalyzer\Models\DataTypeModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\ObjectModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\ArrayModel;
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
    public function renderModel(DataTypeModel $model, $level = 0)
    {
        $output = $this->indent($level) . "Object ({$model->getName()})" . PHP_EOL;
        $output .= $this->generateModelSummary($model, $level);

        foreach ($model->getProperties() as $vis => $props) {
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

    private function generateModelSummary(DataTypeModel $model, $level)
    {
        $tldr = '';
        $propCount = 0;
        foreach ($model->getProperties() as $vis => $props) {
            $propCount += ($visProps = count($props));
            $tldr .= $this->indent($level + 2) . $visProps . ' ' . $vis . PHP_EOL;
        }
        $output = $this->indent($level + 1) . "TL;DR :: properties ({$propCount})" . PHP_EOL;

        return $output . $tldr;
    }

    private function generatePropertyOutput(PropertyModel $prop, $level)
    {
        $type = $prop->currentValueDataType;
        echo "--> generating for '{$type}'<BR>";
        $output = $this->indent($level) . "{$prop->visibility} '{$prop->name}' =>";
        $output .= $this->generateValueOutput($prop, $level);

        return $output;
    }

    private function generateValueOutput(PropertyModel $prop, $level)
    {
        switch (true) {
            case (is_bool($prop->currentValue)):
                $output = $this->generateBooleanOutput($prop);
                break;
            case (is_null($prop->currentValue)):
                $output = $this->generateNullOutput();
                break;
            case (is_numeric($prop->currentValue)):
                $output = $this->generateNumericOutput($prop);
                break;
            case (is_string($prop->currentValue)):
                $output = $this->generateStringOutput($prop);
                break;
            //case (is_array($prop->currentValue)):
            case ($prop->currentValue instanceof ArrayModel):
                $output = $this->generateArrayOutput($prop, $level + 1);
                break;
            //case (is_object($prop->currentValue)):
            case ($prop->currentValue instanceof ObjectModel):
                $output = $this->generateObjectOutput($prop, $level + 1);
                break;
            default:
                $output = 'UNKNOWN VAR TYPE';
        }

        return $this->indent($level) . $output;
    }

    /**
     * @param PropertyModel $prop
     * @return string
     */
    private function generateBooleanOutput(PropertyModel $prop)
    {
        $boolText = ($prop->currentValue === true) ? 'true' : 'false';
        $output = " boolean ({$boolText})" . PHP_EOL;

        return $output;
    }

    /**
     * @param PropertyModel $prop
     * @return string
     */
    private function generateNumericOutput(PropertyModel $prop)
    {
        $output = ' ' . gettype($prop->currentValue) . " {$prop->currentValue}" . PHP_EOL;

        return $output;
    }

    /**
     * @param PropertyModel $prop
     * @return string
     */
    private function generateStringOutput(PropertyModel $prop)
    {
        $output = " string '{$prop->currentValue}' (length=" . strlen($prop->currentValue) . ")" . PHP_EOL;

        return $output;
    }

    /**
     * @return string
     */
    private function generateNullOutput()
    {
        $output = " null" . PHP_EOL;

        return $output;
    }

    /**
     * TODO: finish this
     *
     * @param PropertyModel $prop
     * @param int           $level
     * @return string
     */
    private function generateObjectOutput(PropertyModel $prop, $level)
    {
        $output = PHP_EOL . $this->indent($level);
        //$output .= "{$prop->currentValueDataType} {$prop->currentValue}" . PHP_EOL;
        $output .= "object placeholder";

        return $output;
    }

    /**
     * @param PropertyModel $prop
     * @param int           $level
     * @return string
     */
    private function generateArrayOutput(PropertyModel $prop, $level)
    {
        $val = $prop->currentValue;
        $output = PHP_EOL . $this->indent($level);
        $output .= 'array (size=' . count($val) . ')' . PHP_EOL;
        foreach ($val as $k => $v) {
            $subLvl = $level + 1;
            $output .= $this->indent($subLvl) . "{$k} =>" . PHP_EOL;
            // TODO: fix this hackish shyte!
            if ($v instanceof PropertyModel) {
                die("fucking finally!");
            }
            $tmp = new PropertyModel();
            $tmp->currentValue = $v;
            $tmp->currentValueDataType = gettype($v);
            $output .= $this->generateValueOutput($tmp, $subLvl + 1);
        }

        return $output;
    }

}