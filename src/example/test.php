<?php

require __DIR__ . '/../../vendor/autoload.php';


$mapper = new \Meklis\ArrToObjectMapper\Mapper();

$data = json_decode(file_get_contents(__DIR__ . '/device.json'),true);
print_r($mapper->map($data, \Meklis\ArrToObjectMapper\example\Devices\Device::class));