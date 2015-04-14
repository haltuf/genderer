<?php

use Tester\Assert ;

require __DIR__ . '/../bootstrap.php' ;


$connection = new \Nette\Database\Connection( 'sqlite:' . __DIR__ . '/../../src/Genderer/names.db3' );
$cacheStorage = new \Nette\Caching\Storages\FileStorage( __DIR__ );
$structure = new \Nette\Database\Structure( $connection, $cacheStorage );
$context = new \Nette\Database\Context($connection,$structure);
$driver = new \Haltuf\Genderer\Connection($context);
$o = new \Haltuf\Genderer\Genderer($driver) ;

// test gender recognition
Assert::same( "m", $o->getGender( "Miloš" )) ;
Assert::same( "m", $o->getGender( "Miloš Zeman" )) ;

Assert::same( "f", $o->getGender( "Dagmar" )) ;
Assert::same( "f", $o->getGender( "Dagmar Patrasová" )) ;

Assert::same( "m", $o->getGender( "Přemysl" )) ;
Assert::same( "m", $o->getGender( "Premysl" )) ;

Assert::same( "m", $o->getGender( "Přemysl Houžvička" )) ;
Assert::same( "m", $o->getGender( "Premysl Houzvicka" )) ;

Assert::same( "f", $o->getGender( "KATEŘINA" )) ;
Assert::same( "f", $o->getGender( "KATEŘINA PŘIBYLOVÁ" )) ;


// test vocative
Assert::same( "Michale", $o->getVocative( "Michal" )) ;
Assert::same( "Nikolo", $o->getVocative( "Nikola" )) ;

Assert::same( "Michale Haltufe", $o->getVocative( "Michal Haltuf" )) ;
Assert::same( "Hano Teslíková", $o->getVocative( "Hana Teslíková" )) ;


// test more than 2 parts of name, unknown parts etc.
Assert::same( "ing. Michale", $o->getVocative( "ing. Michal" )) ;
Assert::same( "ing. Haltufe", $o->getVocative( "ing. Haltuf" )) ;
Assert::same( "ing. Michale Haltufe", $o->getVocative( "ing. Michal Haltuf" )) ;
Assert::same( "Magdaléno Dobromilo Retigová", $o->getVocative( "Magdaléna Dobromila Retigová" )) ;
//Assert::same( "prof. ing. Václave Václavoviči Tolstoji, CSc.", $o->getVocative( "prof. ing. Václav Václavovič Tolstoj, CSc." )) ; @todo
