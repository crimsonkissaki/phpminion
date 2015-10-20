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
     * @inheritDoc
     */
    public function render()
    {
        $this->validateConfigArgs();

        $preCss = $this->cssStyles['pre'];
        if (!empty($this->config['scroll'])) {
            $preCss = $this->cssStyles['pre'] . " overflow-y: scroll; height: {$this->config['scroll']};";
        }

        return <<<OUTPUT
<div style="{$this->cssStyles['container']}">
<div style="{$this->cssStyles['toolTitle']}">{$this->toolTitle}</div>
<pre style="{$preCss}"><div style="{$this->cssStyles['dbugDiv']}">{$this->callingMethodInfo}
{$this->dbugComment}
<div style="{$this->cssStyles['varDataDiv']}">{$this->variableData}</div></div></pre>
</div>
OUTPUT;
    }

}