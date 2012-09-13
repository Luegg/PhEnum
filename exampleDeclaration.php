<?php

require 'PhEnum.php';

/*$fns = array(
        'a' => function(){
            return 'a';
        },
    );

class A{
    private static $fns = array(
            'a' => function(){
                return 'a';
            }
        );
}*/

Luegg\PhEnum::enum('Gender')
    ->create(array('Female', 'Male'));

$shouldWearJacket = <<<'EOT'
function($season, $tempILike){
    return $season->getTemp() < $tempILike;
}
EOT;

$needUmbrela = <<<'EOT'
function($season){
    return $season->getRainy();
}
EOT;

Luegg\PhEnum::enum('Season')
    ->property('temp')
    ->property('rainy')
    ->method('shouldWearJacket', $shouldWearJacket)
    ->method('needUmbrela', $needUmbrela)
    ->create(array(
            array('Spring', 12, true),
            array('Summer', 20, false),
            array('Fall', 16, true),
            array('Winter', 0, false),
        ));