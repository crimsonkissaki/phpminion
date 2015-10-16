<?php

namespace PHPMinion\Utilities\Debug\Crumbs;

use PHPMinion\Utilities\Debug\Crumbs\DebugCrumbInterface;

/**
 * DebugDumpCrumb
 *
 * Rendering Crumb for DebugDump tool
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 15, 2015
 * @version     0.1
 */
class DebugDumpCrumb extends DebugCrumb implements DebugCrumbInterface
{

    /**
     * Type of variable
     *
     * @var string
     */
    public $variableType;

    /**
     * Debug information about variable
     *
     * @var string
     */
    public $variableData;

    /**
     * Method where DebugTool was called
     *
     * @var string
     */
    public $callingMethodInfo;

    /**
     * Debug comment
     *
     * @var string
     */
    public $debugComment;

    /**
     * @inheritDoc
     */
    public function render()
    {
        return <<<OUTPUT
<pre style="{$this->cssStyles['pre']}"><div style="{$this->cssStyles['alias']}">{$this->toolAlias}</div>
<div style="{$this->cssStyles['div']}">{$this->callingMethodInfo}

{$this->debugComment}Var Type: {$this->variableType}

<p style="{$this->cssStyles['p']}">{$this->variableData}</p></div></pre>
OUTPUT;
    }

}