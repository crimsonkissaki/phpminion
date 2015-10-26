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

use PHPMinionTest\Utilities\ClassAnalyzer\Mocks\SimpleClass;
use PHPMinionTest\Utilities\ClassAnalyzer\Mocks\SimpleInterface;
use PHPMinionTest\Utilities\ClassAnalyzer\Mocks\VisibilityClassAsPropertyModels;

class FullInheritanceChainClass extends SimpleClass implements SimpleInterface
{

    private $private_property = 'fullInheritanceChainClass private property';

    public function interfaceFunction($interfaceArg)
    {
        return $interfaceArg;
    }

    /**
     * @param  int $withThis
     * @return int
     */
    public function doSomething($withThis)
    {
        $returnThis = $withThis * 2;

        return $returnThis;
    }

}