<?php

require __DIR__ . '/../../vendor/autoload.php';


$mapper = new \Meklis\ArrToObjectMapper\Mapper();
$mapper->setStrict(true);
$data = json_decode(file_get_contents(__DIR__ . '/classes.json'),true);

$mapped = $mapper->map($data, \Meklis\ArrToObjectMapper\example\Classes\ParentClass::class);

print_r($mapped);
