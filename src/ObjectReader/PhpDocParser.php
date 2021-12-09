<?php

namespace Meklis\ArrToObjectMapper\ObjectReader;

class PhpDocParser
{
    protected $property;
    protected $basicTypes = [
        'array' => 'array',
        'string' => 'string',
        'int' => 'integer',
        'integer' => 'integer',
        'bool' => 'boolean',
        'boolean' => 'boolean',
        'float' => 'double',
        'decimal' => 'double',
        'double' => 'double',
        'resource' => 'resource',
    ];

    function __construct(\ReflectionProperty $prop)
    {
        $this->property = $prop;
    }

    function fillProperty(Property $property)
    {
        $type = $this->parseType();
        return $property->setNullAllowed($type['is_null_allowed'])
            ->setArrayOfObjects($type['is_array_of_objects'])
            ->setBasicType($type['is_basic_type'])
            ->setIsObject(!$type['is_basic_type'])
            ->setType($type['type']);
    }

    protected function parseType()
    {
        $data = [
            'is_null_allowed' => false,
            'is_class_name' => false,
            'is_basic_type' => false,
            'is_array_of_objects' => false,
            'type' => null,
        ];

        if (preg_match('/^.*@var (.*)\n.*$/m', $this->property->getDocComment(), $matches)) {
            $elements = explode("|", trim(str_replace(' ', '', $matches[1])));
            foreach ($this->basicTypes as $type => $value) {
                if(in_array($type, $elements)) {
                    $data['is_basic_type'] = true;
                    $data['type'] = $value;
                }
            }
            if(in_array('null', $elements)) {
                $data['is_null_allowed'] = true;
            }
            if(!$data['is_basic_type']) {
                foreach ($elements as $element) {
                    if($element === 'null') continue;
                    if(strpos($element, '[]') !== false) {
                        $data['is_array_of_objects'] = true;
                        $element = str_replace('[]', '', $element);
                    }
                    $data['type'] = class_exists($element) ? $element : $this->findClass($element);
                }
            }
        } else {
            throw new \Exception("Property @var not found in class {$this->property->getDeclaringClass()->getName()} for property {$this->property->getName()}");
        }
        return $data;
    }

    protected function findClass($subobjName) {
        $file = $this->property->getDeclaringClass()->getFileName();
        $content = file_get_contents($file);
        foreach (explode("\n", $content) as $line) {
            if(strpos($line, 'namespace ') !== false && preg_match('/^namespace (.*);/', trim($line), $matches)) {
                $match = trim($matches[1]);
                if(class_exists($match . "\\" .  $subobjName)) {
                    return  $match . "\\" .  $subobjName;
                }
            }
            if(strpos($line, 'use ') !== false && preg_match('/^use (.*\\\([A-Za-z0-9]{1,250}));$/', trim($line), $matches)) {
                $origClass = trim($matches[1]);
                $aliasClass = trim($matches[2]);
                if($subobjName === $aliasClass && class_exists($origClass)) {
                    return $origClass;
                }
            }
            if(strpos($line, 'use ') !== false && preg_match('/^use (.*?) as (.*?);/', trim($line), $matches)) {
                $origClass = trim($matches[1]);
                $aliasClass = trim($matches[2]);
                if($subobjName === $aliasClass && class_exists($origClass)) {
                    return $origClass;
                }
            }
        }
        throw new \Exception("Classname with subobj name={$subobjName} not found");
    }

}