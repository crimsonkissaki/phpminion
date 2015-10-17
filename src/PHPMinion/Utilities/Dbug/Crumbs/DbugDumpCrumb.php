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
 * DbugDumpCrumb
 *
 * Rendering Crumb for DbugDump tool
 *
 * @created     October 15, 2015
 * @version     0.1
 */
class DbugDumpCrumb extends DbugCrumb implements DbugCrumbInterface
{

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
     * @inheritDoc
     */
    public function render()
    {
        return <<<OUTPUT
<div style="{$this->cssStyles['container']}">
<div style="{$this->cssStyles['toolAlias']}">{$this->toolAlias}</div>
<pre style="{$this->cssStyles['pre']}"><div style="{$this->cssStyles['dbugDiv']}">{$this->callingMethodInfo}

{$this->dbugComment}Var Type: {$this->variableType}

<div style="{$this->cssStyles['varDataDiv']}">{$this->variableData}</div></div></pre>
</div>
OUTPUT;
    }

}