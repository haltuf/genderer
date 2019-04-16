<?php

use Haltuf\Genderer\Genderer ;

require_once __DIR__ . '/vendor/autoload.php' ;

$g = new Genderer ;

// Dobrý den, Tomáši Vomáčko
echo "Dobrý den, " . $g->getVocative( "Tomáš Vomáčka" );

// 'm' = male, 'f' = female
echo "Pohlaví: " . $g->getGender( "Tomáš Vomáčka" );

// Works for names with more than two parts
// Dobrý den, MUDr. Tomáši Amosi Březino
echo "Dobrý den, " . $g->getVocative( "MUDr. Tomáš Amos Březina" ) ;

echo "Dobrý den, " . $g->getVocative( "Tomáš Václav" );