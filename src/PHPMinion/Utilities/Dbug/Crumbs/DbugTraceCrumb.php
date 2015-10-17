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
 * DbugTraceCrumb
 *
 * Rendering Crumb for DbugTrace tool
 *
 * @created     October 16, 2015
 * @version     0.1
 */
class DbugTraceCrumb extends DbugCrumb implements DbugCrumbInterface
{

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

<div style="{$this->cssStyles['varDataDiv']}">{$this->variableData}</div></div></pre>
</div>
OUTPUT;
    }

}