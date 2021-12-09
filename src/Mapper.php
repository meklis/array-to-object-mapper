<?php

namespace Meklis\ArrToObjectMapper;

use Meklis\ArrToObjectMapper\ObjectReader\ClassReader;
use Meklis\ArrToObjectMapper\ObjectReader\Property;
use stdClass;

class Mapper
{
    protected $recurseLimit = 0;

    protected $strict = true;

    public function __construct($recurseLimit = 50)
    {
        $this->recurseLimit = $recurseLimit;
    }

    /**
     * @return int|mixed
     */
    public function getRecurseLimit()
    {
        return $this->recurseLimit;
    }

    /**
     * @param int|mixed $recurseLimit
     * @return Mapper
     */
    public function setRecurseLimit($recurseLimit)
    {
        $this->recurseLimit = $recurseLimit;
        return $this;
    }

    /**
     * @return bool
     */
    public function isStrict(): bool
    {
        return $this->strict;
    }

    /**
     * @param bool $strict
     * @return Mapper
     */
    public function setStrict(bool $strict): Mapper
    {
        $this->strict = $strict;
        return $this;
    }


    /**
     * @param array $data
     * @param $class
     * @param $recursion
     * @throws \ReflectionException
     */
    public function map(array $data, $class, $recursion = 0)
    {
        if ($recursion >= $this->recurseLimit) {
            throw new \Exception("Max recursion level for mapping");
        }
        $classReader = new ClassReader($this->getObject($class));
        foreach ($classReader->getProperties() as $property) {
            $propertyName = $this->getPropertyName($property, $data);
            //Key in array not found as property
            if (!$propertyName) continue;

            //Check object is not null when strict enabled
            if ($this->isStrict() && !$property->isNullAllowed() && is_null($data[$propertyName])) {
                throw new \Exception("Strict is enabled. Null for property " . get_class($classReader->getObject()) . "::{$propertyName} not allowed");
            }

            $value = $data[$propertyName];

            if ($property->isBasicType() && !$property->isArrayOfElements()) {
                if (!is_null($value)) {
                    $value = $this->formatBasicType($property, $value);
                }
            } elseif ($property->isBasicType() && $property->isArrayOfElements()) {
                foreach ($value as $k => $v) {
                    if (!is_null($v)) {
                        $value[$k] = $this->formatBasicType($property, $v);
                    }
                }
            } elseif ($property->isArrayOfElements() && $data[$propertyName] !== null) {
                $value = [];
                $isAssoc = $this->isAssoc($data[$propertyName]);
                foreach ($data[$propertyName] as $key => $objStruct) {
                    if ($isAssoc) {
                        $value[$key] = $this->map($objStruct, $property->getType(), $recursion++);
                    } else {
                        $value[] = $this->map($objStruct, $property->getType(), $recursion++);
                    }
                }
            } elseif ($property->isObject() && is_array($data[$propertyName])) {
                $value = $this->map($data[$propertyName], $property->getType(), $recursion++);
            }
            $classReader->setProperty($property->getName(), $value);
        }
        return $classReader->getObject();
    }

    private function getObject($class)
    {
        if (is_object($class)) {
            return $class;
        }
        if (class_exists($class)) {
            return new $class;
        }
        return new stdClass();
    }

    protected function getPropertyName(Property $property, $data)
    {
        if (array_key_exists($property->getMapKey(), $data)) {
            return $property->getMapKey();
        } elseif (array_key_exists($property->getMapKeyAsSnakeCase(), $data)) {
            return $property->getMapKeyAsSnakeCase();
        }
        return '';
    }

    protected function formatBasicType(Property $property, $value)
    {
        switch ($property->getType()) {
            case 'integer':
                if (is_numeric($value)) {
                    $value = (int)$value;
                } elseif ($this->isStrict()) {
                    throw new \Exception("Property " . get_class($property->getClassName()) . "::{$property->getName()} must be type of {$property->getType()}, " . gettype($value) . " given");
                }
                break;
            case 'float':
                if (is_numeric($value)) {
                    $value = (float)$value;
                } elseif ($this->isStrict()) {
                    throw new \Exception("Property " . get_class($property->getClassName()) . "::{$property->getName()} must be type of {$property->getType()}, " . gettype($value) . " given");
                }
                break;
            case 'string':
                if (is_string($value)) {
                    $value = (string)$value;
                } elseif ($this->isStrict()) {
                    throw new \Exception("Property " . get_class($property->getClassName()) . "::{$property->getName()} must be type of {$property->getType()}, " . gettype($value) . " given");
                }
                break;
            case 'boolean':
                if (is_bool($value)) {
                    $value = (bool)$value;
                } elseif ($this->isStrict()) {
                    throw new \Exception("Property " . get_class($property->getClassName()) . "::{$property->getName()} must be type of {$property->getType()}, " . gettype($value) . " given");
                }
                break;
        }
        return $value;
    }

    function isAssoc(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }


}
