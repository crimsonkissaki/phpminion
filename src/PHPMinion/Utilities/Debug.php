<?php

/**
 * Custom utilities for developing
 *
 * (c) Evan Johnson
 */

namespace PHPMinion\Utilities;

use PHPMinion\PHPMinion;
use Doctrine\Common\Util\Debug as DoctrineDebug;
use Doctrine\Common\Persistence\Proxy;

/**
 * Class Debug
 *
 * TODO: maybe some of these should be sub-classes?
 *   that way i can make them more easily configurable ...
 *
 * @package PHPMinion\Utilities
 */
class Debug
{

    const DBUG_STYLES = <<<OUTPUT
<style type="text/css">
    ._dbugPre {
        width: -webkit-fit-content;
        width: -moz-fit-content;
        width: fit-content;
    }
    ._dbugDiv {
        text-align: left;
        margin: 25px;
    }
    ._dbugP {
        border: 1px solid black;
        width: -webkit-fit-content;
        width: -moz-fit-content;
        width: fit-content;
        margin: 0px 35px 0px 10px;
        padding: 10px;
    }
</style>
OUTPUT;

    /**
     * Custom Debug CSS stylings
     *
     * @var string
     */
    private $debugStyles;

    /**
     * String to use for new lines
     *
     * Used for swapping between CLI and browser debugging
     *
     * @var string
     */
    private $newLineStr = '<br>';

    /**
     * @param string $styles
     */
    public function setDebugStyles($styles)
    {
        $this->debugStyles = $styles;
    }

    /**
     * @return string
     */
    public function getDebugStyles()
    {
        return $this->debugStyles;
    }

    /**
     * @param string $str  String to use for creating new lines.
     *                     Set to "\n" for CLI debugging, "<br>" for browser.
     */
    public function setNewLineStr($str)
    {
        $this->newLineStr = $str;
    }

    /**
     * @return string
     */
    public function getNewLineStr()
    {
        return $this->newLineStr;
    }

    public function __construct()
    {
        // Attempt to detect CLI instances and set newline appropriately
        if (strpos(php_sapi_name(), 'cli') !== false) {
            $this->setNewLineStr("\n");
        }
    }

    /**
     * A more user-friendly variable debugger
     *
     * This should be able to prevent certain problems that large objects/arrays
     * cause in debugging, such as recursive Doctrine objects or bloody huge
     * domain objects causing out of memory errors.
     *
     * Objects are parsed using Reflection, and their contents displayed
     * in a slimmed down var_dumped array.
     *
     * @param mixed      $var
     * @param null       $txt
     * @param bool|false $die
     */
    public function debugDump($var, $txt = null, $die = false)
    {
        $br = $this->getNewLineStr();
        $hr = '<hr style="width: 25%; margin-left: 0;">';
        $note = (is_null($txt)) ? '' : self::color($txt) . "\n\n";
        $method = $this->getMethodInfo();
        $varType = gettype($var);
        $varValue = $this->getVariableTypeDetailed($var);
        $styles = $this->DBUG_STYLES;

        echo <<<OUTPUT
{$styles}

<pre class="_dbugPre"><div class="_dbugDiv">{$method['class']}->{$method['func']}() :: {$method['line']}

{$note}Var Type: {$varType}

<p class="_dbugP">{$varValue}</p></div></pre>
OUTPUT;

        if ($die) {
            die($br.self::color('Killed by '.__METHOD__).$br);
        }
    }

    /**
     * Outputs a lightweight debug backtrace
     *
     * @param string|null $txt      Notes to display with trace
     * @param bool|false  $die      Kill PHP after execution?
     * @param int         $lvls     How far back in the trace to output
     */
    public function debugTrace($txt = null, $die = false, $lvls = 2)
    {
        // debug_backtrace index of 2 gets "calling method's" info
        // so we start here
        $defaultBacktraceIndex = 2;
        $note = (is_null($txt)) ? '' : $this->colorize($txt) . "\n\n";
        $styles = $this->DBUG_STYLES;
        $title = $this->colorize('Dbug Trace:', 'blue');

        $trace = '';
        for ($i = 0; $i <= $lvls; $i += 1 ) {
            $nextDebugIndex = $defaultBacktraceIndex + $lvls - $i;
            $method = $this->getMethodInfo($nextDebugIndex);
            $trace .= "{$method['class']}->{$method['func']}() :: {$method['line']}\n";
        }

        echo <<<OUTPUT
{$styles}

<pre class="_dbugPre"><div class="_dbugDiv">{$title}

{$note}<p class="_dbugP">{$trace}</p></div></pre>
OUTPUT;

        if ($die) {
            die('<br>'.$this->colorize('Killed by '.__METHOD__).'<br>');
        }
    }


    public function debugColor($var, $color = '#F00;', $die = false)
    {
        $method = self::getMethodInfo();
        $styles = self::DBUG_STYLES;
        $methodData = "{$method['class']}->{$method['func']}() :: {$method['line']}";
        $varValue = self::color($var, $color);

        echo <<<OUTPUT
{$styles}

<div class="_dbugDiv">{$methodData}
<BR>
{$varValue}
</div>
OUTPUT;

        if ($die) {
            die('<BR><BR>Killed by '.__METHOD__.'<BR><BR>');
        }
    }

    /**
     * Outputs a simple variable type, e.g. BOOL, INT, etc.
     *
     * @param            $var
     * @param null       $txt
     * @param bool|false $die
     */
    public function debugType($var, $txt = null, $die = false)
    {
        $method = self::getMethodInfo();
        $methodData = "{$method['class']}->{$method['func']}() :: {$method['line']}";
        $styles = self::DBUG_STYLES;
        $note = (is_null($txt)) ? '' : $txt . " :: ";
        $varOutput = strtoupper(gettype($var)) . ' (' . self::getVariableTypeSimple($var) . ')';
        $varType = self::color($varOutput, 'purple');

        echo <<<OUTPUT
{$styles}

<div class="_dbugDiv">{$methodData}
<BR>
{$note}{$varType}
</div>
OUTPUT;

        if ($die) {
            die('<BR><BR>Killed by '.__METHOD__.'<BR><BR>');
        }
    }

    /**
     * Writes data to a log file
     *
     * Because sometimes you don't want to mess with Monolog.
     *
     * If no file is specified, it writes to <projectRoot>\phpMinionDebug.log
     *
     * @param mixed       $data
     * @param int         $eol      Number of new lines to append to $data
     * @param string|bool $file     File to write to
     * @param bool        $reset    If true the file will be erased before writing
     */
    public function debugLog($data, $eol = 1, $file = false, $reset = false)
    {
        if (!$file) {
            $file = PHPMinion::getInstance()->getProjectRoot() . 'phpMinionDebug.log';
        }

        if( is_array($data) || is_object($data) ) {
            ob_start();
            print_r($data);
            $output = ob_get_clean();
        } else {
            $output = $data;
        }

        $writeMode = ($reset) ? 'w' : 'a';
        $fh = fopen( $file, $writeMode ) or die( "myLog() cannot open '{$file}' for writing." );
        fwrite( $fh, $output . str_repeat(PHP_EOL, $eol));
        fclose( $fh );
    }

    /**
     * Gets a file path relative to project root
     *
     * @param  string $path
     * @return string
     */
    private function getProjectRelPath($path)
    {
        $root = PHPMinion::getInstance()->getProjectRoot();

        return str_replace($root, '', $path);
    }

    /**
     * Wraps a string with a <span> element with font-color
     *
     * @param string $var
     * @param string $color
     * @return string
     * @throws \InvalidArgumentException
     */
    public function colorize($var, $color = '#F00;')
    {
        if (!is_string($var)) {
            throw new \InvalidArgumentException(__METHOD__.' only accepts strings: '.gettype($var).' provided.');
        }

        return "<span style='color: {$color}; text-align: left;'>{$var}</span>";
    }

    /**
     * Gets details of the method that called a Util method
     *
     * @param int $levels   Where the calling method's info is in debug_backtrace()
     *                      Default is 2 since this will likely be called from
     *                      inside a Utils method.
     * @return array
     */
    public function getMethodInfo($levels = 2)
    {
        /**
         * E.g. calling getMethodInfo from StyleFactorys->getCompleteStyleClass() :: 164
         * 0: (current method)
         *  file:       file calling most recent called function      (StylesFactory)
         *  line:       line number where call ocurred                (164)
         *  function:   most recent called function                   (getMethodInfo)
         *  class:      class owning most recent called function      (Utils)
         *  <details about calling environment>
         *  type:       string                                        ('::')
         *  args:       args passed to most recent called function    (0)
         *
         * 1: (previous method)
         *  file:       file calling most recent called function      (StylesFactory)
         *  line:       line number where call ocurred                (118)
         *  function:   most recent called function                   (getCompleteStyleClass)
         *  class:      class owning most recent called function      (StylesFactory)
         *  <details about calling environment>
         *  object:     calling object data dump                      (StylesFactory)
         *
         * 2: (etc)
         */

        $trace = debug_backtrace();

        return [
            'file' => $this->getProjectRelPath($trace[$levels - 1]['file']),
            'class' => $this->getProjectRelPath($trace[$levels]['class']),
            'func' => $func = $trace[$levels]['function'],
            'line' => $trace[$levels - 1]['line'],
        ];
    }

    /**
     * Returns a string representation of a variable type
     *
     * @param   mixed       $var
     * @return  string
     */
    public function getVariableTypeSimple($var)
    {
        switch (true) {
            case ($var === false):
                return 'FALSE';
            case ($var === true):
                return 'TRUE';
            case ($var === null):
                return 'NULL';
            case (is_numeric($var)):
                return strtoupper(gettype($var)) . '('.$var.')';
            case (is_array($var)):
                return '['.count($var).']';
            case (is_string($var)):
                return "'{$var}'";
            case (is_object($var)):
                return get_class($var);
            default:
                return 'UNKNOWN';
        }
    }

    /**
     * Similar to getVariableTypeSimple(), but returns a full
     * data dump of arrays/objects.
     *
     * @param  mixed    $var
     * @return string
     */
    public function getVariableTypeDetailed($var)
    {
         switch (true) {
             case (is_array($var)):
                 ob_start();
                 print_r($var);
                 return ob_get_clean();
             case (is_object($var)):
                 return $this->getObjectValue($var);
             default:
                 return $this->getVariableTypeSimple($var);
        }
    }

    /**
     * Converts an object into a more human-readable array representation
     *
     * Includes all parameter values including protected/private/static.
     *
     * @param  object $var
     * @return string
     */
    public function getObjectValue($var)
    {
        ob_start();
        echo 'Class type: ' . get_class($var) . '<BR>';

        if ($var instanceof Proxy) {
            //DoctrineDebug::dump($var, 1);
            echo "stupid doctrine object";
            $obj = new ClassDetails();
            print_r($obj->getClassDetails($var));
        } else {
            $obj = new ClassDetails();
            print_r($obj->getClassDetails($var));
        }

        return ob_get_clean();
    }

}

/**
 * Used to get details for classes that are largely private/protected
 *
 * @package application
 */
class ClassDetails
{

    private $className;

    private $classInstance;

    private $classProperties;

    private $propertiesDetails;

    private $output;

    /**
     * Gets data from a largely non-public class
     *
     * @param   object  $class
     * @return  array
     */
    public function getClassDetails($class)
    {
        $this->ensureIsObject($class);
        $this->getClassProperties();
        $this->getClassPropertiesDetails();
        $this->formatClassData();

        return $this->output;
    }

    /**
     * Ensures we have a valid object to work with
     *
     * @param object|string $class
     * @return object
     * @throws \InvalidArgumentException
     */
    private function ensureIsObject($class)
    {
        if (is_object($class)) {
            $this->classInstance = $class;
            return;
        }

        if (is_string($class)) {
            if (! class_exists($class)) {
                throw new \InvalidArgumentException("Utils::ClassDetails => '{$class}' does not exist");
            }

            $this->classInstance = new $class();
            return;
        }

        throw new \InvalidArgumentException("Utils::ClassDetails => Unable to get details of non-object classes");
    }

    /**
     * Gets the properties of a class
     *
     * TODO: needs to also grab inherited properties
     */
    private function getClassProperties()
    {
        $class = new \ReflectionClass($this->classInstance);

        $this->className = $class->getName();

        $props = [];
        $props['constant'] = $class->getConstants();
        $props['private'] = $class->getProperties(\ReflectionProperty::IS_PRIVATE);
        $props['protected'] = $class->getProperties(\ReflectionProperty::IS_PROTECTED);
        $props['public'] = $class->getProperties(\ReflectionProperty::IS_PUBLIC);
        $props['static'] = $class->getProperties(\ReflectionProperty::IS_STATIC);

        $this->classProperties = $props;
    }

    /**
     * Gets an array of PropertyData objects for the class's properties
     */
    private function getClassPropertiesDetails()
    {
        $propertyObjects = [];
        foreach ($this->classProperties as $visibility => $properties) {
            if (!empty($properties)) {
                $propertyObjects[$visibility] = $this->getPropertiesDetails($visibility, $properties);
            }
        }

        $this->propertiesDetails = $propertyObjects;
    }

    /**
     * Gets details for an array of properties
     *
     * Constants are a problem here since they're set as an associative array
     * and not numeric, so 'as key => value' works while 'as $property' does not.
     *
     * @param   string $visibility Visibility scope of properties
     * @param   array  $properties Array of \ReflectionProperties objects
     * @return  array
     */
    private function getPropertiesDetails($visibility, $properties)
    {
        $results = [];
        foreach ($properties as $key => $value) {
            // it causes problems down the line to have static
            // properties set in the other visibilities
            $prop = $this->getPropertyDetails($visibility, $key, $value);
            if ($visibility !== 'static' && empty($prop->isStatic)) {
                array_push($results, $prop);
            }
            if ($visibility === 'static') {
                array_push($results, $prop);
            }
        }

        return $results;
    }

    /**
     * Gets details for a single class property
     *
     * Looping through an array of all class properties returned by
     * a \ReflectionClass's getProperties() method returns is interesting
     * because 'constant' properties are returned as an associative array
     * of 'name' => 'value', while every other visibility level is returned
     * as a numerically indexed array of 'N' => \ReflectionProperty objects.
     *
     * @param    string        $visibility Property visibility
     * @param    string|int    $key        Property name or a numeric index
     * @param    string|object $value      Property value or \ReflectionProperty object
     * @return  PropertyData
     */
    private function getPropertyDetails($visibility, $key, $value)
    {
        $result = new \stdClass();
        $result->name = (is_object($value)) ? $value->name : $key;
        $result->visibility = $visibility;
        $result->isStatic = (is_object($value)) ? $value->isStatic() : false;
        $result->value = $this->getPropertyValue($visibility, $value);
        // this will require the class methods
        //$result->setter = $this->findPropertySetterIfExists($result->name, $this->methods);
        $result->dataType = gettype($result->value);
        if (is_object($result->value)) {
            $classData = $this->getValueClassData($result->value);
            $result->className = $classData['className'];
            $result->classNamespace = $classData['classNamespace'];
        }
        return $result;
    }

    /**
     * Gets the value for a property, if any
     *
     * 'Constant' properties just need the value string returned.
     * All other visibility levels are a \ReflectionProperty object
     * whose getValue() method requires an actual instance of the
     * owning class to determine the default value.
     *
     * @param   string        $visibility Property visibility
     * @param   string|object $value      String or \ReflectionProperty object
     * @return  string
     */
    private function getPropertyValue($visibility, $value)
    {
        if ($visibility === 'constant') {
            return $value;
        }
        if ($value->isPrivate() || $value->isProtected()) {
            $value->setAccessible(true);
        }
        // do not have to pass a class instance if you use ReflectionClass::getDefaultProperties
        return (is_object($this->classInstance)) ? $value->getValue($this->classInstance) : 'unknown';
    }

    /**
     * Gets class data for values that are objects
     *
     * This method consumes the return value of a \ReflectionProperty
     * object's getValue() method, and if the default value is an object
     * getValue() returns an instance of that object.
     *
     * @param   object $value Instance of a default value object
     * @return  array
     */
    private function getValueClassData($value)
    {
        $className = get_class($value);
        if (($pos = strrpos($className, '\\')) === false) {
            $data['className'] = $className;
            $data['classNamespace'] = "";
        } else {
            $data['className'] = substr($className, $pos + 1);
            $data['classNamespace'] = substr($className, 0, $pos);
        }
        return $data;
    }

    /**
     * Formats class details in human readable text
     */
    private function formatClassData()
    {
        $output = ['name' => $this->className];
        foreach ($this->propertiesDetails as $visibility => $visData) {
            $output['properties'][$visibility] = [];
            foreach ($visData as $data) {
                $output['properties'][$visibility][$data->name] = $this->getFormattedPropertyValue($data);
            }
        }

        $this->output = $output;
    }

    private function getFormattedPropertyValue($data)
    {
        $tmp = "({$data->dataType}) ";
        if (is_object($data->value)) {
            return $tmp. "'{$data->className}'";
        }
        // yellow-ish
        if (is_numeric($data->value)) {
            return $tmp . $this->color($data->value, '#E8E82C;');
        }
        // dark green
        if (is_string($data->value)) {
            return $tmp . $this->color("'{$data->value}'", '#199C19');
        }
        if (is_array($data->value)) {
            return $data->value;
        }
        if (is_null($data->value)) {
            return $this->color('(NULL)');
        }
        if (is_bool($data->value)) {
            return $tmp . $this->color(($data->value ? 'TRUE' : 'FALSE'), '#00F');
        }

        return $this->color("<undefined type> {$data->value}");
    }

    private function color($var, $color = '#F00;')
    {
        return "<span style='color: {$color};'>" . htmlentities($var) . "</span>";
    }

}
