<?php
namespace Luegg\PhEnum;

class EnumGenerator{

    private $enumName;

    private $properties = array();

    private $methods = array();

    private $values = array();

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

    function create($values){
        foreach ($values as $value) {
            if(!is_array($value)){
                $value = array($value);
            }
            $this->values[] = $value;
        }

        $this->_generate();
    }

    private function _generate(){
        $methodMap = $this->_methodMap();
        $inits = $this->_inits();
        $valueMethods = $this->_valueMethods();

        $enum = str_replace(
                array('<enumName>', '<methodMap>', '<inits>', '<valueMethods>'),
                array($this->enumName, $methodMap, $inits, $valueMethods),
                self::$enumCode
            );

        echo '<pre>' . $enum;
        eval($enum);
    }

    private function _methodMap(){
        $methodMap = array();

        foreach ($this->methods as $method) {
            $methodMap[] = sprintf("'%s' => %s,", $method['name'], $method['fn']);
        }

        return implode(PHP_EOL, $methodMap);
    }

    private function _inits(){
        $inits = array();

        foreach($this->values as $ordinal => $value){
            $valueName = array_shift($value);
            $propertyMap = array();

            foreach($this->properties as $propertyName){
                $propertyMap[] = sprintf("'%s' => '%s'", $propertyName, array_shift($value));
            }

            $inits[] = str_replace(
                    array(
                            '<ordinal>', '<valueName>',
                            '<propertyMap>'
                        ),
                    array(
                            $ordinal, $valueName,
                            sprintf("array(%s)", implode(', ', $propertyMap))
                        ),
                    self::$initCode
                );
        }

        return implode(PHP_EOL, $inits);
    }

    private function _valueMethods(){
        $methods = array();

        foreach ($this->values as $ordinal => $value) {
            $valueName = array_shift($value);
            $methods[] = str_replace(
                    array('<ordinal>', '<valueName>'),
                    array($ordinal, $valueName),
                    self::$valueMethodCode
                );
        }

        return implode(PHP_EOL, $methods);
    }

    private static $enumCode = <<<'EOT'
use Luegg\PhEnum;

final class <enumName> extends PhEnum{

    private static $valueMap = array();

    private function __construct($ordinal, $name, $propertyMap){
        $this->ordinal = $ordinal;
        $this->name = $name;
        $this->propertyMap = $propertyMap;
    }

    function __call($name, $arguments){
        $methodMap = array(
<methodMap>
            );

        if(in_array($name, $methodMap)){
            array_unshift($arguments, $this);
            $fn = $methodMap[$name];
            return call_user_func_array($fn, $arguments);
        }

        // If no method found call parent __call for property access
        return parent::__call($name, $arguments);
    }

    static function init(){
<inits>
    }

<valueMethods>
}

<enumName>::init();
EOT;

    private static $initCode = <<<'EOT'
        self::$valueMap[<ordinal>] = new self(<ordinal>, '<valueName>', <propertyMap>);
EOT;

    private static $valueMethodCode = <<<'EOT'
    static function <valueName>(){
        return self::$valueMap[<ordinal>];
    }
EOT;
}