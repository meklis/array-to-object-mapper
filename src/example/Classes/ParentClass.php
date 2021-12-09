<?php
namespace Meklis\ArrToObjectMapper\example\Classes;
class ParentClass
{
    /**
     * @var int
     */
    protected $id;

    /**
     * String with camelCases
     * @var string
     */
    protected $testString;

    /**
     * @var string
     */
    protected $variable_with_snake_case;

    /**
     * @var Child
     */
    protected $child;

    /**
     * @var Child[]
     */
    protected $childs;
}
