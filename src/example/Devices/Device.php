<?php


namespace Meklis\ArrToObjectMapper\example\Devices;





class Device
{
    /**
     * @var string
     */
    protected $ip = '0.0.0.0';

    /**
     * @var string
     */
    protected $location = '';


    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var DeviceModel | null
     */
    protected  $model;

    /**
     * @var DeviceAccess|null
     */
    protected ?DeviceAccess $access;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var string
     */
    protected $updated_at;

    /**
     * @var false|string
     */
    protected $created_at;


    /**
     * @var string
     */
    protected $mac;

    /**
     * @var string
     */
    protected $serial;

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation(string $location): void
    {
        $this->location = $location;
    }



}