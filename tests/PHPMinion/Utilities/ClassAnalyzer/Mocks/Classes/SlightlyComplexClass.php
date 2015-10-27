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

namespace PHPMinionTest\Utilities\ClassAnalyzer\Mocks\Classes;

use PHPMinionTest\Utilities\ClassAnalyzer\Mocks\Classes\VisibilityClass;

class SlightlyComplexClass
{

    /**
     * @var VisibilityClass
     */
    private $visibilityClass;

    /**
     * @var int
     */
    private $orderId;

    /**
     * @var float
     */
    private $orderTotalCost;

    /**
     * @var array
     */
    private $orderItems = [];

    /**
     * @var string
     */
    private $couponCode;

    public function __construct()
    {
        $this->visibilityClass = new VisibilityClass();
    }
}