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

namespace PHPMinion\Utilities\ClassAnalyzer\ClassAnalysis;

use PHPMinion\Utilities\ClassAnalyzer\Models\ClassModel;
use PHPMinion\Utilities\ClassAnalyzer\Workers\TokenWorker;
use PHPMinion\Utilities\ClassAnalyzer\Exceptions\ClassAnalyzerException;

/**
 * Class PropertyModel
 *
 * Model to hold object property data
 *
 * @created     October 23, 2015
 * @version     0.1
 */
class ClassAnalysis
{

    /**
     * Gets basic information about a class
     *
     * @param object           $class
     * @param \ReflectionClass $refClass
     * @return ClassModel
     */
    public function analyze($class, \ReflectionClass $refClass)
    {
        $model = new ClassModel();
        $model->setName($refClass->getName());
        $model->setNameSpace($refClass->getNamespaceName());
        $model->setUses($this->getClassUseStatements($refClass));
        $model->setExtends($this->getParentClass($refClass));
        $model->setImplements($refClass->getInterfaceNames());

        return $model;
    }

    /**
     * Gets any use statements from a class
     *
     * @param \ReflectionClass $refClass
     * @return array
     * @throws ClassAnalyzerException
     */
    private function getClassUseStatements(\ReflectionClass $refClass)
    {
        $uses = [];
        if ($fileName = $refClass->getFileName()) {
            $tokenWorker = new TokenWorker();
            $uses = $tokenWorker->getTextByTokens($fileName, TokenWorker::USE_T, ';', false);
            foreach ($uses as $k => $v) {
                $uses[$k] = trim($v);
            }
        }

        return $uses;
    }

    /**
     * Checks if a class extends another class
     *
     * @param \ReflectionClass $refClass
     * @return null|string
     */
    private function getParentClass(\ReflectionClass $refClass)
    {
        if ($parent = $refClass->getParentClass()) {
            return $parent->getName();
        }

        return null;
    }

}