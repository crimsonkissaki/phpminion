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

namespace PHPMinion\Utilities\EntityAnalyzer\Models;

/**
 * Class ArrayModel
 *
 * Model to hold array data
 *
 * @created     October 18, 2015
 * @version     0.1
 */
class ArrayModel extends EntityModel
{

    /**
     * Array of keys => data models
     *
     * @var array
     */
    public $elements = [];

}