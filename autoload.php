<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

//Dependecy
require_once 'larium_routing/autoload.php';

require_once 'ClassMap.php';

$classes = array(
    'Larium\\Executor\\Executor' => 'Larium/Executor/Executor.php',
    'Larium\\Executor\\Message' => 'Larium/Executor/Message.php',
);

ClassMap::load(__DIR__ . "/src/", $classes)->register();
