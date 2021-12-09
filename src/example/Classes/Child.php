<?php


namespace Meklis\ArrToObjectMapper\example\Classes;



class Child
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Child | null
     */
    protected ?Child $child;

    /**
     * @var string[]
     */
    protected $params = [];


}
