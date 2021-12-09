<?php


namespace Meklis\ArrToObjectMapper\example\Devices;



class DeviceInterface
{

    const TYPE_ETHER = 'ETH';
    const TYPE_SFP = 'SFP';
    const TYPE_PON = 'PON';
    const TYPE_ONU = 'ONU';
    const TYPE_UNI = 'UNI';

    /**
     */
    protected $created_at;

    /**
     */
    protected $updated_at;

    /**
     * @var int
     */
    protected $device_id;

    /**
     * @var Device
     */
    protected ?Device $device = null;

    /**
     * @var int
     */
    protected $bind_key = -1;

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $type = '';

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var string
     */
    protected $billing_link = '';

    /**
     * @var string
     */
    protected $ip = '';

    /**
     * @var string
     */
    protected $agreement = '';

    /**
     * @var string
     */
    protected $description = '';


}
