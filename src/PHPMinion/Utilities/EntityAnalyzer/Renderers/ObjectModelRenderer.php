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

namespace PHPMinion\Utilities\EntityAnalyzer\Renderers;

use PHPMinion\Utilities\EntityAnalyzer\Models\DataTypeModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\ArrayModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\ObjectModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\ScalarModel;

/**
 * Class ObjectModelRenderer
 *
 * Renders an ObjectModel to something more human-readable
 *
 * @created     October 19, 2015
 * @version     0.1
 */
class ObjectModelRenderer extends DataTypeModelRenderer implements ModelRendererInterface
{

    /**
     * @inheritDoc
     */
    public function renderModel(DataTypeModel $model, $level = 0)
    {
        $output = $this->indent($level) . "Object ({$model->getClassName()})" . PHP_EOL;
        $output .= $this->generateModelSummary($model, $level);

        /**
         * if object properties exist, it should be in format:
         * [
         *   visibility => [
         *     property name => <datatype>Model,
         *     property name => <datatype>Model,
         *   ],
         *   ...
         * ]
         * etc.
         */

        $objProps = $model->getValue();

        /*
        echo __METHOD__ . " :: " . __LINE__ . "<BR>";
        echo "class properties:<BR>";
        var_dump($objProps);
        */

        if (empty($objProps)) {
            return $output;
        }

        foreach ($objProps as $visibility => $propsInVis) {
            /** @var DataTypeModel $propModel */
            foreach ($propsInVis as $propName => $propModel) {
                /*
                echo "'{$propName}'s model:<BR>";
                echo "<PRE>";
                print_r($propModel);
                echo "</PRE>";
                echo "<BR><BR>";
                */
                //\application\Utils::dbug($propModel, "property '{$propName}'", true);
                $output .= $this->generateModelOutput($propName, $propModel, $level + 1);
            }
        }

        return $output;
    }

    /**
     * TL;DR the object
     *
     * TODO: make sure tests cover null values (empty objects)
     *
     * @param DataTypeModel $model
     * @param               $level
     * @return string
     */
    private function generateModelSummary(DataTypeModel $model, $level)
    {
        $tldr = '';
        $propCount = 0;
        $output = $this->indent($level + 1) . "TL;DR :: properties ({$propCount})" . PHP_EOL;
        $objProps = $model->getValue();

        if (empty($objProps)) {
            return $output;
        }

        foreach ($objProps as $vis => $props) {
            $propCount += ($visProps = count($props));
            $tldr .= $this->indent($level + 2) . $visProps . ' ' . $vis . PHP_EOL;
        }

        return $output . $tldr;
    }

    /**
     * @param string        $name
     * @param DataTypeModel $model
     * @param int           $level
     * @return string
     */
    private function generateModelOutput($name, DataTypeModel $model, $level)
    {
        $type = $model->getDataType();
        echo "--> generating for '{$type}'<BR>";
        $output = $this->indent($level) . "{$model->getVisibility()} '{$name}' =>";
        $output .= $this->generateValueOutput($model, $level);

        return $output;
    }

    /**
     * Converts a model's data into a readable value
     *
     * @param DataTypeModel $model
     * @param               $level
     * @return string
     */
    private function generateValueOutput(DataTypeModel $model, $level)
    {
        switch (true) {
            case (is_bool($model->getValue())):
                $output = $this->generateBooleanOutput($model);
                break;
            case (is_null($model->getValue())):
                $output = $this->generateNullOutput();
                break;
            case (is_numeric($model->getValue())):
                $output = $this->generateNumericOutput($model);
                break;
            case (is_string($model->getValue())):
                $output = $this->generateStringOutput($model);
                break;
            //case (is_array($model->getValue())):
            case ($model->getValue() instanceof ArrayModel):
                $output = $this->generateArrayOutput($model, $level + 1);
                break;
            //case (is_object($model->getValue())):
            case ($model->getValue() instanceof ObjectModel):
                $output = $this->generateObjectOutput($model, $level + 1);
                break;
            default:
                $output = 'UNKNOWN VAR TYPE';
        }

        return $this->indent($level) . $output;
    }

    /**
     * @param DataTypeModel $model
     * @return string
     */
    private function generateBooleanOutput(DataTypeModel $model)
    {
        $boolText = ($model->getValue() === true) ? 'true' : 'false';
        $output = " boolean ({$boolText})" . PHP_EOL;

        return $output;
    }

    /**
     * @param DataTypeModel $model
     * @return string
     */
    private function generateNumericOutput(DataTypeModel $model)
    {
        $output = ' ' . gettype($model->getValue()) . " {$model->getValue()}" . PHP_EOL;

        return $output;
    }

    /**
     * @param DataTypeModel $model
     * @return string
     */
    private function generateStringOutput(DataTypeModel $model)
    {
        $output = " string '{$model->getValue()}' (length=" . strlen($model->getValue()) . ")" . PHP_EOL;

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
     * @param DataTypeModel $model
     * @param int           $level
     * @return string
     */
    private function generateObjectOutput(DataTypeModel $model, $level)
    {
        $output = PHP_EOL . $this->indent($level);
        //$output .= "{$model->getValue()} {$model->getValue()}" . PHP_EOL;
        $output .= "object placeholder";

        return $output;
    }

    /**
     * @param DataTypeModel $model
     * @param int           $level
     * @return string
     */
    private function generateArrayOutput(DataTypeModel $model, $level)
    {
        $val = $model->getValue();
        $output = PHP_EOL . $this->indent($level);
        $output .= 'array (size=' . count($val) . ')' . PHP_EOL;
        foreach ($val as $k => $v) {
            $subLvl = $level + 1;
            $output .= $this->indent($subLvl) . "{$k} =>" . PHP_EOL;
            // TODO: fix this hackish shyte!
            if ($v instanceof DataTypeModel) {
                die("fucking finally!");
            }
            die("whatever");
            /*
            $tmp = new DataTypeModel();
            $tmp->currentValue = $v;
            $tmp->currentValueDataType = gettype($v);
            */
            $output .= $this->generateValueOutput($tmp, $subLvl + 1);
        }

        return $output;
    }

}