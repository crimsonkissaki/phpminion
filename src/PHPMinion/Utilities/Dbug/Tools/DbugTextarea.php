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

namespace PHPMinion\Utilities\Dbug\Tools;

use PHPMinion\Utilities\Dbug\Crumbs\DbugTextareaCrumb;
use PHPMinion\Utilities\Dbug\Exceptions\DbugException;

class DbugTextarea extends DbugDump implements DbugToolInterface
{
    /**
     * Valid config parameters and data types
     *
     * @var array
     */
    protected $validConfigParams = [
        'colCount' => ['integer'],
        'rowCount' => ['integer'],
    ];

    /**
     * @inheritDoc
     */
    public function __construct($toolAlias)
    {
        parent::__construct($toolAlias);
        $this->crumb = new DbugTextareaCrumb($toolAlias);
    }

    /**
     * Sets config options for DbugTextarea
     *
     * @param string $param
     * @param mixed  $value
     * @return DbugToolInterface
     * @throws DbugException
     */
    public function config($param, $value)
    {
        $this->validateConfigArgs($param, $value);

        $func = 'set'.ucfirst($param);
        if (method_exists($this->crumb, $func)) {
            call_user_func_array([$this->crumb, $func], [$value]);
        }

        return $this;
    }

}