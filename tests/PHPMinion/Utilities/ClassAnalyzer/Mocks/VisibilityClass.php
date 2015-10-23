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

    const CONSTANT_STRING = 'constant string value';
    const CONSTANT_INTEGER = 10;
    const CONSTANT_DOUBLE = 3.14;
    const CONSTANT_TRUE = true;
    const CONSTANT_FALSE = false;
    const CONSTANT_NULL = null;
    const CONSTANT_ARRAY = ['constant', 'val1', 'val2'];

    public $public_string = 'public string value';
    public $public_integer = 10;
    public $public_double = 3.14;
    public $public_true = true;
    public $public_false = false;
    public $public_null;
    public $public_array = ['public', 'val1', 'val2'];

    protected $protected_string = 'protected string value';
    protected $protected_integer = 10;
    protected $protected_double = 3.14;
    protected $protected_true = true;
    protected $protected_false = false;
    protected $protected_null;
    protected $protected_array = ['protected', 'val1', 'val2'];

    private $private_string = 'private string value';
    private $private_integer = 10;
    private $private_double = 3.14;
    private $private_true = true;
    private $private_false = false;
    private $private_null;
    private $private_array = ['private', 'val1', 'val2'];

    public static $public_static_string = 'public static string value';
    public static $public_static_integer = 10;
    public static $public_static_double = 3.14;
    public static $public_static_true = true;
    public static $public_static_false = false;
    public static $public_static_null;
    public static $public_static_array = ['public static', 'val1', 'val2'];

    protected static $protected_static_string = 'protected static string value';
    protected static $protected_static_integer = 10;
    protected static $protected_static_double = 3.14;
    protected static $protected_static_true = true;
    protected static $protected_static_false = false;
    protected static $protected_static_null;
    protected static $protected_static_array = ['protected static', 'val1', 'val2'];

    private static $private_static_string = 'private static string value';
    private static $private_static_integer = 10;
    private static $private_static_double = 3.14;
    private static $private_static_true = true;
    private static $private_static_false = false;
    private static $private_static_null;
    private static $private_static_array = ['private static', 'val1', 'val2'];

}