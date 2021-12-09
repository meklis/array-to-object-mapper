<?php

namespace Meklis\ArrToObjectMapper\ObjectReader;

class ClassReader
{
    protected $reflectionClass;
    protected $object;

    function __construct($class)
    {
        if (!is_object($class)) {
            $reflect = new $class;
        } else {
            $reflect = $class;
        }
        $this->object = $reflect;
        $this->reflectionClass = new \ReflectionClass($reflect);
    }

    /**
     * @return Property[]
     * @throws \ReflectionException
     */
    function getProperties()
    {
        $props = [];
        foreach ($this->reflectionClass->getProperties() as $prop) {
            $props[] = $this->getProperty($prop->getName());
        }
        return $props;
    }

    /**
     * @param $name
     * @return Property
     * @throws \ReflectionException
     */
    function getProperty($name)
    {
        $prop = $this->reflectionClass->getProperty($name);
        $prop->setAccessible(true);
        $doc = new PhpDocParser($prop);
        $property = (new Property())
            ->setName($prop->getName())
            ->setMapKey($prop->getName())
            ->setClassName(get_class($this->object));
        return $doc->fillProperty($property);
    }

    function setProperty($name, $value)
    {
        $prop = $this->reflectionClass->getProperty($name);
        $prop->setAccessible(true);
        $prop->setValue($this->object, $value);
        return $this;
    }

    function setProperties(array $mappedArray)
    {
        foreach ($mappedArray as $name => $value) {
            $this->setProperty($name, $value);
        }
        return $this;
    }

    function getObject()
    {
        return $this->object;
    }
 
}
