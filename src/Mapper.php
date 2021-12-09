<?php

namespace Meklis\ArrToObjectMapper;

use Meklis\ArrToObjectMapper\ObjectReader\ClassReader;
use stdClass;

class Mapper
{
    protected $recurseLimit = 0;

    protected $strict = true;

    public function __construct($recurseLimit = 50) {
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
     * @return object
     * @throws \ReflectionException
     */
    public function map(array $data, $class, $recursion = 0): object
    {
        if($recursion >= $this->recurseLimit) {
            throw new \Exception("Max recursion level for mapping");
        }
        $classReader = new ClassReader($this->getObject($class));
        foreach ($classReader->getProperties() as $property) {
            if(!isset($data[$property->getMapKey()])) continue;

            if($this->strict && $this->validateType($property->getType(), $data[$property->getMapKey()]))

            if($property->isObject()) {
                $value = $this->map($data[$property->getMapKey()], $property->getType(), $recursion++);
            } else {
                $value = $data[$property->getMapKey()];
            }
            $classReader->setProperty($property->getName(), $value);
        }
        return $classReader->getObject();
    }

    private function getObject($class) {
        if(is_object($class)) {
            return $class;
        }
        if(class_exists($class)) {
            return  new $class;
        }
        return new stdClass();
    }

    protected function validateType($type, $value) {
        $realType = gettype($value);
        if($type !== $realType && !class_exists($type)) {
            throw new \Exception("incorrect type $realType, must be $type");
        }
        return $this;
    }
}