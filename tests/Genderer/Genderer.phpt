<?php

use Tester\Assert ;

require __DIR__ . '/../bootstrap.php' ;



$o = new \Haltuf\Genderer\Genderer ;

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
//Assert::same( "ing. Michale Haltufe", $o->getVocative( "ing. Michal Haltuf" )) ;