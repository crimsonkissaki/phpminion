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

namespace PHPMinion\Utilities\Dbug\Models;

/**
 * Class TraceModel
 *
 * Holds edited debug_backtrace() information for use in DbugTools
 *
 * @created     October 16, 2015
 * @version     0.1
 */
class TraceModel
{

    /**
     * Function name
     *
     * @var string
     */
    public $function;

    /**
     * Line number
     *
     * @var int
     */
    public $line;

    /**
     * File name
     *
     * @var string
     */
    public $file;

    /**
     * Class name
     *
     * @var string
     */
    public $class;

    /**
     * Current object
     *
     * @var object
     */
    public $object;

    /**
     * Call type
     *
     * Method = ->
     * Static = ::
     * Function = ''
     *
     * @var string
     */
    public $type;

    /**
     * Function args or included file names
     *
     * @var string
     */
    public $args = [];

}