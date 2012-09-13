<?php

require "../vendor/noonat/pecs/lib/pecs.php";
require "../PhEnum.php";

Luegg\PhEnum::enum('Gender')
    ->create(array('Female', 'Male'));

Luegg\PhEnum::enum('Season')
    ->property('temp')
    ->property('rainy')
    ->method('shouldWearJacket', function($season){
            return $season->getTemp() < 15;
        })
    ->method('needUmbrela', function($season){
            return $season->getRainy();
        })
    ->create(array(
            array('Spring', 12, true),
            array('Summer', 20, false),
            array('Fall', 16, true),
            array('Winter', 0, false),
        ));

describe("The enum factory", function(){

});