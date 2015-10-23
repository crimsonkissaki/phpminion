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

    const CONST_STRING = 'const string value';
    const CONST_INT = 10;
    const CONST_DOUBLE = 3.14;
    const CONST_BOOL_TRUE = true;
    const CONST_BOOL_FALSE = false;
    const CONST_NULL = null;
    const CONST_ARRAY = ['const', 'val1', 'val2'];

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

    public static $static_string = 'public static string value';
    public static $static_integer = 10;
    public static $static_double = 3.14;
    public static $static_true = true;
    public static $static_false = false;
    public static $static_null;
    public static $static_array = ['public static', 'val1', 'val2'];

}