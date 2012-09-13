<?php
namespace Luegg\PhEnum;

class EnumGenerator{

    private $enumName;

    private $properties = array();

    private $methods = array();

    function __construct($enumName){
        $this->enumName = $enumName;
    }

    function property($name){
        $this->properties[] = $name;

        return $this;
    }

    function method($name, $fn){
        $this->methods[] = array(
                'name' => $name, 'fn' => $fn,
            );

        return $this;
    }

    function create($types){


        return $this;
    }
}