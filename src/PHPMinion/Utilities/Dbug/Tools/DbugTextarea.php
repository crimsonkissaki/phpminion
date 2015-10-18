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
     * @inheritDoc
     */
    public function __construct($toolAlias)
    {
        parent::__construct($toolAlias);
        $this->crumb = new DbugTextareaCrumb($toolAlias);
    }

}