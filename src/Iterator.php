<?php
namespace SimpleIterator;


class Iterator
{
    /**
     * @var array
     */
    private $functions = [];

    /**
     * @var array
     */
    private $arrayData = [];

    private $everyOneActive = false;


    public function __construct(array $array)
    {
        $this->arrayData = $array;
    }

    public function iterate()
    {
        $array = $this->arrayData;
        $this->nextArray($array);
    }

    private function nextArray($array, String $namespace = null)
    {
        $index = key($array);
        if (is_array($array[$index])) {
            $subNamespace = $namespace ? $namespace.'.'.$index : $index;
            $this->everyHas($index, $array[$index]);
            $this->nextArray($array[$index], $subNamespace);
        } else {
            $this->everyOne($array[$index]);
            $this->executeFunctions($namespace, $array[$index]);
        }

        unset($array[$index]);

        if (count($array)) {
            $this->nextArray($array, $namespace);
        }
    }

    /**
     * Execute function if have on namespace registered!
     * @param String $namespace
     * @param $valueItem
     */
    private function executeFunctions(String $namespace, $valueItem)
    {
        if (isset($this->functions[$namespace])) {
            $fun = $this->functions[$namespace];
            $fun($valueItem);
        }

    }

    /**
     * Execute everyone function if is active
     * @param $data
     */
    private function everyOne($data)
    {
        if ($this->everyOneActive) {
            $this->executeFunctions('everyOne', $data);
        }
    }

    private function everyHas($key, $data)
    {
        $this->executeFunctions('every.'.$key, $data);
    }

    /**
     * Register function on level key
     * They function have a var
     * example: register('users.0.name', function(item))
     * @param $namespaceLevel
     * @param callable $fun
     */
    public function register($namespaceLevel, callable $fun)
    {
        $this->functions[$namespaceLevel] = $fun;

        if ($namespaceLevel === 'everyOne') {
            $this->everyOneActive = true;
        }
    }

}