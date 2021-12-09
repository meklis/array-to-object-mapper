# Simple mapper to objects from array 

### Features:
* Map nested structures
* Work with doc comments
* Detecting variable type from @var declaration
* Working with private and protected properties 
* Strict mode allow check variable type (only for basic types)
* Working with map|array of objects 
* Auto detect and map properties with camelCase and snake_case

### Install
``` 
composer require meklis/array-to-object-mapper
```

### Usage example
**See full example of usage in src/example**


ParentClass.php
```php
class ParentClass
{
    /**
     * @var int
     */
    protected $id;

    /**
     * String with camelCases
     * @var string
     */
    protected $testString;

    /**
     * @var string
     */
    protected $variable_with_snake_case;

    /**
     * @var Child
     */
    protected $child;

    /**
     * @var Child[]
     */
    protected $childs;
}
```
Child.php   
```php
class Child
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var Child | null
     */
    protected ?Child $child;

    /**
     * @var array
     */
    protected $params = [];
}
```

classes.json
```json
{
  "id": 144,
  "test_string": "This is test string",
  "variable_with_snake_case": "Variable with snake case",
  "child": {
    "id": 1,
    "child": null,
    "params": ["param1", "param2", "param3"]
  },
  "childs": [
    {
      "id": 1,
      "child": {
        "id": 6,
        "params": ["param1", "param2", "param3"]
      },
      "params": ["param1", "param2", "param3"]
    },
    {
      "id": 3,
      "child": null,
      "params": ["param1", "param2", "param3"]
    },
    {
      "id": 4,
      "child": null,
      "params": ["param1", "param2", "param3"]
    }
  ]
}
```

test.php - Testing file 
```php
require __DIR__ . '/../../vendor/autoload.php';

use \Meklis\ArrToObjectMapper\Mapper;
use \Meklis\ArrToObjectMapper\example\Classes\ParentClass;

$mapper = new Mapper();
$mapper->setStrict(true);
$data = json_decode(file_get_contents(__DIR__ . '/classes.json'),true);

$mapped = $mapper->map($data, ParentClass::class);

print_r($mapped);

// OUTPUT
/*
Meklis\ArrToObjectMapper\example\Classes\ParentClass Object
(
    [id:protected] => 144
    [testString:protected] => This is test string
    [variable_with_snake_case:protected] => Variable with snake case
    [child:protected] => Meklis\ArrToObjectMapper\example\Classes\Child Object
        (
            [id:protected] => 1
            [child:protected] => 
            [params:protected] => Array
                (
                    [0] => param1
                    [1] => param2
                    [2] => param3
                )

        )

    [childs:protected] => Array
        (
            [0] => Meklis\ArrToObjectMapper\example\Classes\Child Object
                (
                    [id:protected] => 1
                    [child:protected] => Meklis\ArrToObjectMapper\example\Classes\Child Object
                        (
                            [id:protected] => 6
                            [params:protected] => Array
                                (
                                    [0] => param1
                                    [1] => param2
                                    [2] => param3
                                )

                        )

                    [params:protected] => Array
                        (
                            [0] => param1
                            [1] => param2
                            [2] => param3
                        )

                )

            [1] => Meklis\ArrToObjectMapper\example\Classes\Child Object
                (
                    [id:protected] => 3
                    [child:protected] => 
                    [params:protected] => Array
                        (
                            [0] => param1
                            [1] => param2
                            [2] => param3
                        )

                )

            [2] => Meklis\ArrToObjectMapper\example\Classes\Child Object
                (
                    [id:protected] => 4
                    [child:protected] => 
                    [params:protected] => Array
                        (
                            [0] => param1
                            [1] => param2
                            [2] => param3
                        )

                )

        )

)
 */
```
