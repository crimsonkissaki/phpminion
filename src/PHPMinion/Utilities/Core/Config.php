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

namespace PHPMinion\Utilities\Core;

use PHPMinion\Utilities\EntityAnalyzer\Analyzers\EntityAnalyzerInterface;
use PHPMinion\Utilities\EntityAnalyzer\Analyzers\EntityAnalyzer;

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
     * Path to the project root
     *
     * @var string
     */
    public $PROJECT_ROOT_PATH;

    /**
     * Class used to analyze objects in DbugTools
     *
     * @var EntityAnalyzerInterface
     */
    private $_entityAnalyzer;

    public function setEntityAnalyzer(EntityAnalyzerInterface $entityAnalyzer)
    {
        $this->_entityAnalyzer = $entityAnalyzer;
    }

    public function getEntityAnalyzer()
    {
        return $this->_entityAnalyzer;
    }

    public function __construct()
    {
        $this->PROJECT_ROOT_PATH = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR;
        $this->setEntityAnalyzer(new EntityAnalyzer());
    }

}