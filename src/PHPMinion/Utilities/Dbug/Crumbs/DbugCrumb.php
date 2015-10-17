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

namespace PHPMinion\Utilities\Dbug\Crumbs;

/**
 * DbugCrumb
 *
 * Base Crumb class
 *
 * Crumbs are used to render the results of DbugTool analysis.
 *
 * Whether or not a DbugTool uses a Crumb class, the analysis
 * results MUST be assigned to DbugTool->dbugResults for proper
 * handling.
 *
 * @created     October 15, 2015
 * @version     0.1
 */
class DbugCrumb
{

    /**
     * Alias used for DbugTool
     *
     * @var string
     */
    public $toolAlias;

    /**
     * Title to display for the tool
     *
     * @var string
     */
    public $toolTitle;

    /**
     * Type of variable
     *
     * @var string
     */
    public $variableType;

    /**
     * Dbug information about variable
     *
     * @var string
     */
    public $variableData;

    /**
     * Method where DbugTool was called
     *
     * @var string
     */
    public $callingMethodInfo;

    /**
     * Dbug comment
     *
     * @var string
     */
    public $dbugComment;

    /**
     * CSS used in render()
     *
     * @var array
     */
    public $cssStyles = [
        'container'  => 'position: relative; font-family: monospace; font-size: 1em; background-color: #FFF; text-align: left; padding-bottom: 0px; margin: 10px; border-radius: 5px; width: -webkit-fit-content; width: -moz-fit-content; width: fit-content;',
        'toolTitle'  => 'position: relative; font-size: 1.2em; border: 1px solid black; border-bottom-style: hidden; border-radius: 5px 5px 0 0; padding: 2px 5px; width: -webkit-fit-content; width: -moz-fit-content; width: fit-content;',
        'pre'        => 'position: relative; display: block; margin-top: 0px; border-radius: 5px; border: 1px dashed black;',
        'dbugDiv'    => 'position: relative; margin: 10px;',
        'varDataDiv' => 'position: relative; padding: 5px 10px; border: 1px solid black; width: -webkit-fit-content; width: -moz-fit-content; width: fit-content;',
    ];

    /**
     * @param string $toolAlias
     */
    public function __construct($toolAlias)
    {
        $this->toolAlias = $toolAlias;
        $this->toolTitle = 'Dbug::'.$toolAlias;
    }

    /**
     * Renders the Crumb to HTML for output
     *
     * @return string
     */
    public function render()
    {
        return <<<OUTPUT
<div style="{$this->cssStyles['container']}">
<div style="{$this->cssStyles['toolTitle']}">{$this->toolTitle}</div>
<pre style="{$this->cssStyles['pre']}"><div style="{$this->cssStyles['dbugDiv']}">{$this->callingMethodInfo}

{$this->dbugComment}Var Type: {$this->variableType}

<div style="{$this->cssStyles['varDataDiv']}">{$this->variableData}</div></div></pre>
</div>
OUTPUT;
    }

}