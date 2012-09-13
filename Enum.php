<?php

namespace Luegg\PhEnum;

function define($name, $types){
    return Enum::define($name, $types);
}

abstract class Enum{

    private static $classCode = <<<'EOT'
<namespace>

use Luegg\PhEnum\Enum;

class <enumName> extends Enum{
    protected static $map = array();

    protected $ordinal;

    protected $name;

    private function __construct($ordinal, $name){
        $this->ordinal = $ordinal;
        $this->name = $name;
    }

    static function init(){
        <init>
    }

    <methods>
}

<enumName>::init();
EOT;

    private static $initCode = <<<'EOT'
        self::$map[<ordinal>] = new <enumName>(<ordinal>, "<typeName>");
EOT;

    private static $methodCode = <<<'EOT'
    static function <typeName>(){
        return self::$map[<ordinal>];
    }
EOT;

    static function lookup($ordinal){
        return static::$map[$ordinal];
    }

    function __toString(){
        return $this->name;
    }

    function name(){
        return $this->name;
    }

    function ordinal(){
        return $this->ordinal;
    }

    static function define($enumName, $typeNames){
        $parts = explode("\\", $enumName);
        $enumName = array_pop($parts);
        $namespace = implode("\\", $parts);

        foreach ($typeNames as $key => $typeName) {
            $types[] = array(
                    'ordinal' => $key,
                    'name' => $typeName,
                );
        }

        $inits = self::createInits($enumName, $types);
        $methods = self::createMethods($enumName, $types);
        $class = self::createClass($namespace, $enumName, $inits, $methods);

        eval($class);
    }

    private static function createInits($enumName, $types){
        $code = self::$initCode;
        return array_map(function($type) use ($enumName, $code){
                return str_replace(
                        array("<typeName>", "<ordinal>", "<enumName>"),
                        array($type['name'], $type['ordinal'], $enumName),
                        $code
                    );
            }, $types);
    }

    private static function createMethods($enumName, $types){
        $code = self::$methodCode;
        return array_map(function($type) use ($enumName, $code){
                return str_replace(
                        array("<typeName>", "<ordinal>", "<enumName>"),
                        array($type['name'], $type['ordinal'], $enumName),
                        $code
                    );
            }, $types);
    }

    private static function createClass($namespace, $enumName, $inits, $methods){
        if($namespace)
            $namespace = sprintf("namespace %s;", $namespace);
        return str_replace(
                array("<namespace>", "<enumName>", "<init>", "<methods>"),
                array($namespace, $enumName, implode(PHP_EOL, $inits), implode(PHP_EOL, $methods)),
                self::$classCode
            );
    }
}