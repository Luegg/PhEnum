<?php
namespace Luegg;

require 'PhEnum/EnumGenerator.php';

abstract class PhEnum{

    static function enum($name){
        return new \Luegg\PhEnum\EnumGenerator($name);
    }

    protected $name;

    protected $ordinal;

    protected $propertyMap = array();

    public function name(){
        return $this->name;
    }

    public function ordinal(){
        return $this->ordinal;
    }

    public function __call($name, $arguments){
        if(strpos($name, 'get') === 0){
            $propertyName = strtolower(substr($name, 3));
            return $this->propertyMap[$propertyName];
        }
    }
}