<?php

namespace Meklis\ArrToObjectMapper\ObjectReader;

class Property
{
    protected $name;
    protected $type;
    protected $mapKey;
    protected $nullAllowed;
    protected $className;
    protected $arrayOfObjects;
    protected $basicType;
    protected $isObject;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Property
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return Property
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMapKey()
    {
        return $this->mapKey;
    }

    /**
     * @return mixed
     */
    public function getMapKeyAsSnakeCase()
    {
        return ltrim(strtolower(preg_replace('/[A-Z]([A-Z](?![a-z]))*/', '_$0', $this->mapKey)), '_');
    }

    /**
     * @param mixed $mapKey
     * @return Property
     */
    public function setMapKey($mapKey)
    {
        $this->mapKey = $mapKey;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isNullAllowed()
    {
        return $this->nullAllowed;
    }

    /**
     * @param mixed $nullAllowed
     * @return Property
     */
    public function setNullAllowed($nullAllowed)
    {
        $this->nullAllowed = $nullAllowed;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param mixed $className
     * @return Property
     */
    public function setClassName($className)
    {
        $this->className = $className;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isArrayOfObjects()
    {
        return $this->arrayOfObjects;
    }

    /**
     * @param mixed $arrayOfObjects
     * @return Property
     */
    public function setArrayOfObjects($arrayOfObjects)
    {
        $this->arrayOfObjects = $arrayOfObjects;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isBasicType()
    {
        return $this->basicType;
    }

    /**
     * @param mixed $basicType
     * @return Property
     */
    public function setBasicType($basicType)
    {
        $this->basicType = $basicType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isObject()
    {
        return $this->isObject;
    }

    /**
     * @param mixed $isObject
     * @return Property
     */
    public function setIsObject($isObject)
    {
        $this->isObject = $isObject;
        return $this;
    }


}
