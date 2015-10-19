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

namespace PHPMinion\Utilities\EntityAnalyzer\Models;

/**
 * Class PropertyModel
 *
 * Model to hold object property data returned by PropertyWorker
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 18, 2015
 * @version     0.1
 */
class PropertyModel extends AnalysisModel
{

    /**
     * Name of the property
     *
     * @var string
     */
    public $name;

    /**
     * Visibility of the property
     *
     * Values are public, public, protected.
     *
     * @var string
     */
    public $visibility;

    /**
     * Is the property static
     *
     * @var bool
     */
    public $isStatic;

    /**
     * Setter method if any
     *
     * @var string
     */
    public $setter;

    /**
     * Current property value, if any
     *
     * @var mixed
     */
    public $currentValue;

    /**
     * Current property value data type
     *
     * @var string
     */
    public $currentValueDataType;

    /**
     * Default property value, if any
     *
     * @var mixed
     */
    public $defaultValue;

    /**
     * Default property value data type
     *
     * @var string
     */
    public $defaultValueDataType;

    /**
     * Class name of object property types
     *
     * @var string
     */
    public $className;

    /**
     * Class namespace of object property types
     *
     * @var string
     */
    public $classNamespace;

    /**
     * Any comments that need to be displayed above the property in the mock
     *
     * @var string
     */
    public $comments;

    /**
     * ORM data obtained from Entity class
     *
     * @var OrmData
    public $ormData;
     */

}