<?php

namespace PHPMinion\Utilities\Debug\Crumbs;

/**
 * DebugCrumb
 *
 * Base Crumb class
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 15, 2015
 * @version     0.1
 */
abstract class DebugCrumb
{

    /**
     * Alias used for DebugTool
     *
     * @var string
     */
    public $toolAlias;

    /**
     * CSS used in render()
     *
     * @var array
     */
    public $cssStyles = [
        'pre'   => 'border: 1px dashed black; width: -webkit-fit-content; width: -moz-fit-content; width: fit-content;',
        'alias' => 'position: relative; top: -9px; left: 10px; background-color: #FFF; width: -webkit-fit-content; width: -moz-fit-content; width: fit-content; padding: 0px 5px;',
        'div'   => 'text-align: left; margin: 0px 25px 25px;',
        'p'     => 'border: 1px solid black; width: -webkit-fit-content; width: -moz-fit-content; width: fit-content; margin: 0px 35px 0px 10px; padding: 10px;',
    ];

}