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

    /**
     * @var bool
     */
    private $isNewCustomer;

    /**
     * @var string
     */
    private $customInstructions;

    /**
     * @var \DateTime
     */
    private $orderDate;

    public function __construct()
    {
        $this->visibilityClass = new VisibilityClass();
        $this->orderId = 12345;
        $this->orderTotalCost = 499.95;
        for ($i = 0; $i < 2; $i += 1) {
            $sc = new SimpleClass();
            $sc->property1 = "property {$i}";
            $sc->property2 = $i * $i;
            $sc->property3 = $i * 1.5;
            $sc->property4 = true;
            $sc->property5 = false;
            $sc->property6 = null;
            $sc->property7 = ['specialComponents' => ['red_led', 'blue_backlight', 'rush_shipping']];
            $this->orderItems[] = $sc;
        }
        $this->couponCode = 'ABC123';
        $this->isNewCustomer = true;
        // customInstructions left NULL
        $this->orderDate = new \DateTime("2015-10-27 12:00:00", new \DateTimeZone('America/Chicago'));
    }
}