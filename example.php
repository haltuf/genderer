<?php

require_once __DIR__ . '/vendor/autoload.php' ;

$g = new Haltuf\Genderer\Genderer ;
echo "Dobrý den, " . $g->getVocative( "Tomáš Vomáčka" );

// 'm' = male, 'f' = female
echo "Pohlaví: " . $g->getGender( "Tomáš Vomáčka" );