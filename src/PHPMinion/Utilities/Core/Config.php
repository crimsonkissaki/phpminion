<?php

namespace PHPMinion\Utilities\Core;

/**
 * Config.php
 *
 * Configuration settings for PHPMinion
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 10, 2015
 * @version     0.1
 */
class Config
{

    /**
     * Path to PHPMinion
     *
     * @var string
     */
    public $PATH_TO_PHPMINION;

    /**
     * Path to the project root
     *
     * @var string
     */
    public $PROJECT_ROOT_PATH;

    public function __construct()
    {
        $this->PATH_TO_PHPMINION = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR;
        $this->PROJECT_ROOT_PATH = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . DIRECTORY_SEPARATOR;
    }

}