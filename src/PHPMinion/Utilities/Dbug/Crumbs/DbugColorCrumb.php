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
 * DbugColorCrumb
 *
 * Rendering Crumb for DbugColor tool
 *
 * @created     October 15, 2015
 * @version     0.1
 */
class DbugColorCrumb extends DbugCrumb implements DbugCrumbInterface
{

    /**
     * @inheritDoc
     */
    public function render()
    {
        return <<<OUTPUT
<div style="{$this->cssStyles['container']}">
<div style="{$this->cssStyles['toolTitle']}">{$this->toolTitle}</div>
<pre style="{$this->cssStyles['pre']}"><div style="{$this->cssStyles['dbugDiv']}">{$this->callingMethodInfo}

<div style="{$this->cssStyles['varDataDiv']}">{$this->variableData}</div></div></pre>
</div>
OUTPUT;
    }

}