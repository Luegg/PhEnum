<?php
namespace Luegg;

require 'PhEnum/EnumGenerator.php';

class PhEnum{

    static function enum($name){
        return new \Luegg\PhEnum\EnumGenerator($name);
    }
}