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

namespace PHPMinion\Utilities\Debug\Tools;

class DebugDump extends DebugTool implements DebugToolInterface
{

    /**
     * @inheritDoc
     */
    public function analyze(array $args)
    {
        echo "<BR><BR>";
        echo "analyzing in DebugDump:<BR>";

        if (empty($args[0])) {
            die("no var to analyze");
        }

        $var = $args[0];
        $note = (!empty($args[1])) ? $args[1] : null;
        $die = (!empty($args[2])) ? $args[2] : false;

        $output = $this->getSimpleTypeValue($var);

        echo "current output:<BR>";
        echo $output;

        die();
    }

    /**
     * Renders analysis results
     *
     * @return mixed
     */
    public function render()
    {

    }

}