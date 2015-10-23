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

namespace PHPMinion\Utilities\EntityAnalyzer\Factories;

use PHPMinion\Utilities\EntityAnalyzer\Workers\DataTypeWorkerInterface;
use PHPMinion\Utilities\EntityAnalyzer\Workers\ArrayWorker;
use PHPMinion\Utilities\EntityAnalyzer\Workers\ObjectWorker;
use PHPMinion\Utilities\EntityAnalyzer\Workers\ScalarWorker;
//use PHPMinion\Utilities\EntityAnalyzer\Workers\ResourceWorker;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\EntityAnalyzerException;

/**
 * WorkerFactory
 *
 * Returns the proper worker class for an entity type
 *
 * @created     October 19, 2015
 * @version     0.1
 */
class WorkerFactory
{

    /**
     * @var WorkerFactory
     */
    private static $_instance;

    /**
     * Array of data workers
     *
     * @var array
     */
    private $_workers = [];

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new WorkerFactory();
        }

        return self::$_instance;
    }

    private function __construct() {}

    /**
     * Returns the proper analyzer class for the entity data type
     *
     * @param  mixed $entity
     * @return DataTypeWorkerInterface
     * @throws EntityAnalyzerException
     */
    public static function getWorker($entity)
    {
        $_this = self::getInstance();
        $dataType = gettype($entity);

        if (isset($_this->_workers[$dataType])) {
            return $_this->_workers[$dataType];
        }

        $worker = false;
        switch (true) {
            case (is_object($entity)):
                $worker = new ObjectWorker($entity);
                break;
            case (is_array($entity)):
                $worker = new ArrayWorker($entity);
                break;
            case (is_numeric($entity)):
            case (is_null($entity)):
            case (is_string($entity)):
            case (is_bool($entity)):
                $worker = new ScalarWorker($entity);
                break;
            /*
            case (is_resource($entity)):
                $worker = new ResourceWorker();
                break;
            */
        }

        if (!$worker) {
            throw new EntityAnalyzerException("No Worker defined for data type: '{$dataType}'.");
        }

        $_this->_workers[$dataType] = $worker;

        return $_this->_workers[$dataType];
    }

}