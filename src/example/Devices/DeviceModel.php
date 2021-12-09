<?php


namespace Meklis\ArrToObjectMapper\example\Devices;


class DeviceModel
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var string
     */
    protected $vendor;

    /**
     * @var string
     */
    protected $model;

    /**
     * @var string
     */
    protected $type;


    /**
     * @var string|null
     */
    protected $controller;

    /**
     * @var array|null
     */
    protected $collectors;

    /**
     * @var string
     */
    protected $icon;


}