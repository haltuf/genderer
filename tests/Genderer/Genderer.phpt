<?php

use Tester\Assert ;
use Haltuf\Genderer\Genderer ;

require __DIR__ . '/../bootstrap.php' ;

$o = new Genderer ;

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

// test gender recognition - more than 2 parts
Assert::same( "m", $o->getGender( "Jan Amos Komenský" )) ;
Assert::same( "m", $o->getGender( "prof. ing. Jan Amos Komenský CSc." )) ;

Assert::same( "f", $o->getGender( "Magdalena Dobromila Rettigová" )) ;
Assert::same( "f", $o->getGender( "doc. Magdalena Dobromila Rettigová DrSc." )) ;

// test gender stat
Assert::same( array('m' => 295627, 'f' => 1), $o->getGenderStat( "Jan" )) ;
Assert::same( array('m' => 39), $o->getGenderStat( "Amos Komenský" )) ;
Assert::same( array('m' => 295666, 'f' => 1), $o->getGenderStat( "Jan Amos Komenský" )) ;
Assert::same( array('m' => 295666, 'f' => 1), $o->getGenderStat( "prof. ing. Jan Amos Komenský CSc." )) ;


// test vocative
Assert::same( "Michale", $o->getVocative( "Michal" )) ;
Assert::same( "Nikolo", $o->getVocative( "Nikola" )) ;

Assert::same( "Michale Haltufe", $o->getVocative( "Michal Haltuf" )) ;
Assert::same( "Hano Teslíková", $o->getVocative( "Hana Teslíková" )) ;


// test more than 2 parts of name, unknown parts etc.
Assert::same( "ing. Michale", $o->getVocative( "ing. Michal" )) ;
Assert::same( "ing. Haltufe", $o->getVocative( "ing. Haltuf" )) ;
Assert::same( "ing. Michale Haltufe", $o->getVocative( "ing. Michal Haltuf" )) ;
Assert::same( "Magdaléno Dobromilo Rettigová", $o->getVocative( "Magdaléna Dobromila Rettigová" )) ;

// @todo parts divided not only by space, but also comma
//Assert::same( "prof. ing. Václave Václavoviči Tolstoji, CSc.", $o->getVocative( "prof. ing. Václav Václavovič Tolstoj, CSc." )) ;


// test empty input
Assert::same( "", $o->getGender( "" )) ;
Assert::same( array(), $o->getGenderStat( "" )) ;
Assert::same( "", $o->getVocative( "" )) ;