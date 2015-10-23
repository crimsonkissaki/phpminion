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

namespace PHPMinionTest\Utilities\ClassAnalyzer\Mocks;

class VisibilityClass
{

    const CONST_STRING = 'property1 value';
    const CONST_INT = 10;
    const CONST_DOUBLE = 3.14;
    const CONST_BOOL_TRUE = true;
    const CONST_BOOL_FALSE = false;
    const CONST_NULL = null;
    const CONST_ARRAY = ['val1', 'val2'];

    public $public_property1 = 'property1 value';
    public $public_property2 = 10;
    public $public_property3 = 3.14;
    public $public_property4 = true;
    public $public_property5 = false;
    public $public_property6;
    public $public_property7 = ['val1', 'val2'];

    protected $protected_property1 = 'property1 value';
    protected $protected_property2 = 10;
    protected $protected_property3 = 3.14;
    protected $protected_property4 = true;
    protected $protected_property5 = false;
    protected $protected_property6;
    protected $protected_property7 = ['val1', 'val2'];

    private $private_property1 = 'property1 value';
    private $private_property2 = 10;
    private $private_property3 = 3.14;
    private $private_property4 = true;
    private $private_property5 = false;
    private $private_property6;
    private $private_property7 = ['val1', 'val2'];

    static $static_property1 = 'property1 value';
    static $static_property2 = 10;
    static $static_property3 = 3.14;
    static $static_property4 = true;
    static $static_property5 = false;
    static $static_property6;
    static $static_property7 = ['val1', 'val2'];

}