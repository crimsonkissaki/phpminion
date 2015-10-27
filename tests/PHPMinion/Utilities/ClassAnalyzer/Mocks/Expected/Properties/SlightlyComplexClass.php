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

namespace PHPMinionTest\Utilities\ClassAnalyzer\Mocks\Expected\Properties;

use PHPMinion\Utilities\ClassAnalyzer\Models\PropertyModel;
use PHPMinionTest\Utilities\ClassAnalyzer\Mocks\Classes\SimpleClass;
use PHPMinionTest\Utilities\ClassAnalyzer\Mocks\Classes\VisibilityClass as VisClass;

/**
 * Class SlightlyComplexClass
 *
 * What the SlightlyComplexClass ought to look like as PropertyModel[]
 */
class SlightlyComplexClass
{

    public static function getPropertyModels()
    {
        $expectedProperties = [];

        $visClass = new PropertyModel();
        $visClass->setName('visibilityClass');
        $visClass->setVisibility('private');
        $visClass->setCurrentValue(new VisClass());
        $visClass->setCurrentValueDataType('object');
        $visClass->setClassName('VisibilityClass');
        $visClass->setClassNamespace('PHPMinionTest\Utilities\ClassAnalyzer\Mocks\Classes');
        $expectedProperties[] = $visClass;

        $orderId = new PropertyModel();
        $orderId->setName('orderId');
        $orderId->setVisibility('private');
        $orderId->setCurrentValue(12345);
        $orderId->setCurrentValueDataType('integer');
        $expectedProperties[] = $orderId;

        $orderTotalCost = new PropertyModel();
        $orderTotalCost->setName('orderTotalCost');
        $orderTotalCost->setVisibility('private');
        $orderTotalCost->setCurrentValue(499.95);
        $orderTotalCost->setCurrentValueDataType('double');
        $expectedProperties[] = $orderTotalCost;

        $orderItem = new PropertyModel();
        $orderItem->setName('orderItems');
        $orderItem->setVisibility('private');
        $orderItems = [];
        for ($i = 0; $i < 2; $i += 1) {
            $sc = new SimpleClass();
            $sc->property1 = "property {$i}";
            $sc->property2 = $i * $i;
            $sc->property3 = $i * 1.5;
            $sc->property4 = true;
            $sc->property5 = false;
            $sc->property6 = null;
            $sc->property7 = ['specialComponents' => ['red_led', 'blue_backlight', 'rush_shipping']];
            $orderItems[] = $sc;
        }
        $orderItem->setCurrentValue($orderItems);
        $orderItem->setCurrentValueDataType('array');
        $expectedProperties[] = $orderItem;

        $isNewCustomer = new PropertyModel();
        $isNewCustomer->setName('isNewCustomer');

        $couponCode = new PropertyModel();
        $couponCode->setName('couponCode');
        $couponCode->setVisibility('private');
        $couponCode->setCurrentValue('ABC123');
        $couponCode->setCurrentValueDataType('string');
        $expectedProperties[] = $couponCode;

        $isNewCustomer = new PropertyModel();
        $isNewCustomer->setName('isNewCustomer');
        $isNewCustomer->setVisibility('private');
        $isNewCustomer->setCurrentValue(true);
        $isNewCustomer->setCurrentValueDataType('boolean');
        $expectedProperties[] = $isNewCustomer;

        $customInstructions = new PropertyModel();
        $customInstructions->setName('customInstructions');
        $customInstructions->setVisibility('private');
        $customInstructions->setCurrentValue(null);
        $customInstructions->setCurrentValueDataType('null');
        $expectedProperties[] = $customInstructions;

        $orderDate = new PropertyModel();
        $orderDate->setName('orderDate');
        $orderDate->setVisibility('private');
        $orderDate->setCurrentValue(new \DateTime("2015-10-27 12:00:00", new \DateTimeZone('America/Chicago')));
        $orderDate->setCurrentValueDataType('object');
        $orderDate->setClassName('DateTime');
        $orderDate->setClassNamespace(null);
        $expectedProperties[] = $orderDate;

        return $expectedProperties;
    }

}