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

use PHPMinion\Utilities\Dbug\Exceptions\DbugException;

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
class DbugCrumb implements DbugCrumbInterface
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
     * Config settings
     *
     * @var array
     */
    public $config = [];

    /**
     * CSS used in render()
     *
     * @var array
     */
    public $cssStyles = [
        'container'  => 'position: relative; background-color: #FFF; font-family: monospace; font-size: 1em; text-align: left; padding-bottom: 0px; margin: 10px; border-radius: 5px; width: -webkit-fit-content; width: -moz-fit-content; width: fit-content;',
        'toolTitle'  => 'position: relative; font-size: 1.2em; border: 1px solid black; border-bottom-style: hidden; border-radius: 5px 5px 0 0; padding: 2px 5px; width: -webkit-fit-content; width: -moz-fit-content; width: fit-content;',
        'pre'        => 'position: relative; background-color: #FFF; font-family: monospace; display: block; margin-top: 0px; border-radius: 5px; border: 1px dashed black;',
        'dbugDiv'    => 'position: relative; background-color: #FFF; margin: 10px;',
        'varDataDiv' => 'position: relative; background-color: #FFF; padding: 5px 10px; border: 1px solid black; width: -webkit-fit-content; width: -moz-fit-content; width: fit-content;',
    ];

    /**
     * Placeholder for valid config parameters and data types
     *
     * Set in DbugToolCrumb
     *
     * @var array
     */
    protected $validConfigParams = [];

    /**
     * @param string $toolAlias
     */
    public function __construct($toolAlias)
    {
        $this->toolAlias = $toolAlias;
        $this->toolTitle = 'Dbug::'.$toolAlias;
    }

    /**
     * @inheritDoc
     */
    public function render(array $config = null)
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

    /**
     * Validates config() arguments for DbugToolCrumb
     *
     * @return bool
     * @throws DbugException
     */
    protected function validateConfigArgs()
    {
        $alias = $this->toolAlias;
        foreach ($this->config as $param => $value) {
            if (empty($this->validConfigParams[$param])) {
                $validParams = implode(', ', array_keys($this->validConfigParams));
                throw new DbugException("'{$alias}' invalid config param: '{$param}'. Valid params: '{$validParams}'");
            }
            if (!in_array(gettype($value), $this->validConfigParams[$param])) {
                $validValues = implode(', ', $this->validConfigParams[$param]);
                $badType = gettype($value);
                throw new DbugException("'{$alias}' invalid config param '{$param}' value datatype: '{$badType}'. Valid datatypes: '{$validValues}'");
            }
        }

        return true;
    }

}