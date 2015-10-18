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

use PHPMinion\Utilities\ObjectAnalyzer\ObjectAnalysisInterface;
use PHPMinion\Utilities\ObjectAnalyzer\ObjectAnalyzer;

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
     * @var ObjectAnalysisInterface
     */
    private $_objectAnalyzer;

    public function setObjectAnalyzer(ObjectAnalysisInterface $objectAnalyzer)
    {
        $this->_objectAnalyzer = $objectAnalyzer;
    }

    public function getObjectAnalyzer()
    {
        return $this->_objectAnalyzer;
    }

    public function __construct()
    {
        $this->PROJECT_ROOT_PATH = dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR;
        $this->setObjectAnalyzer(new ObjectAnalyzer());
    }

}