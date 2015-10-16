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

use PHPMinion\Utilities\Dbug\Crumbs\DbugCrumbInterface;

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

<div style="{$this->cssStyles['varDataDiv']}">{$this->dbugComment}</div></div></pre>
</div>
OUTPUT;
    }

}