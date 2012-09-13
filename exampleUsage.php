<?php

require 'exampleDeclaration.php';

$peter = Gender::Male();
$alice = Gender::Female();

var_dump($peter == $alice);
var_dump($peter == Gender::Male());

$now = Season::Fall();

var_dump($now->getRainy());

var_dump($now->needUmbrela());
var_dump(Season::Summer()->needUmbrela());