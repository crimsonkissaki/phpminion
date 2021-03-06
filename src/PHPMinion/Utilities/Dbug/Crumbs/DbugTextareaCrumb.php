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
 * DbugTextareaCrumb
 *
 * Rendering Crumb for DbugTextarea tool
 *
 * @created     October 17, 2015
 * @version     0.1
 */
class DbugTextareaCrumb extends DbugCrumb implements DbugCrumbInterface
{

    protected $validConfigParams = [
        'cols' => ['integer'],
        'rows' => ['integer'],
    ];

    /**
     * Number of rows in textarea
     *
     * @var int
     */
    protected $rows = 25;

    /**
     * Number of columns in textarea
     *
     * @var int
     */
    protected $cols = 100;

    /**
     * @param int $rowCount
     * @return DbugTextareaCrumb
     * @throws DbugException
     */
    public function setRowCount($rowCount)
    {
        if (!is_int($rowCount)) {
            throw new DbugException("DbugTextareaCrumb->setRowCount() only accepts integer values.");
        }
        $this->rowCount = $rowCount;

        return $this;
    }

    /**
     * @param int $colCount
     * @return DbugTextareaCrumb
     * @throws DbugException
     */
    public function setColCount($colCount)
    {
        if (!is_int($colCount)) {
            throw new DbugException("DbugTextareaCrumb->setColCount() only accepts integer values.");
        }
        $this->colCount = $colCount;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->validateConfigArgs();

        $cols = (!empty($this->config['cols'])) ? $this->config['cols'] : $this->cols;
        $rows = (!empty($this->config['rows'])) ? $this->config['rows'] : $this->rows;

        return <<<OUTPUT
<div style="{$this->cssStyles['container']}">
<div style="{$this->cssStyles['toolTitle']}">{$this->toolTitle}</div>
<pre style="{$this->cssStyles['pre']}"><div style="{$this->cssStyles['dbugDiv']}">{$this->callingMethodInfo}

{$this->dbugComment}Var Type: {$this->variableType}

<textarea rows="{$rows}" cols="{$cols}" style="{$this->cssStyles['varDataDiv']}">{$this->variableData}</textarea></div></pre>
</div>
OUTPUT;
    }

}