<?php

namespace PHPMinion\Utilities\Core;

use PHPMinion\PHPMinion;

/**
 * Class Common
 *
 * Methods used throughout PHPMinion
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 9, 2015
 * @version     0.1
 */
class Common
{

    /**
     * Gets a file path relative to project root
     *
     * @param  string $path
     * @return string
     */
    public function getRelativeFilePath($path)
    {
        $root = PHPMinion::getInstance()->getConfig('PROJECT_ROOT_PATH');

        return str_replace($root, '', $path);
    }

    /**
     * Returns a string inside a <span> with font-color
     *
     * @param string $var
     * @param string $color
     * @return string
     */
    public function colorize($var, $color = '#F00;')
    {
        return "<span style='color: {$color}; text-align: left;'>{$var}</span>";
    }

    /**
     * Gets details of method that called a Util method
     *
     * @param int $levels   Where the calling method's info is in debug_backtrace()
     *                      Default is 4 since this will likely be called from
     *                      inside a Utils method.
     * @return array
     */
    public function getMethodInfo($levels = 4)
    {
        $trace = debug_backtrace();

        return [
            'file' => $this->getRelativeFilePath($trace[$levels - 1]['file']),
            'class' => ((!empty($trace[$levels]['class'])) ? $this->getRelativeFilePath($trace[$levels]['class']) : null),
            'func' => $func = $trace[$levels]['function'],
            'line' => $trace[$levels - 1]['line'],
        ];
    }

}