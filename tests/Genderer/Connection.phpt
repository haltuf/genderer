<?php

use Tester\Assert ;

require __DIR__ . '/../bootstrap.php' ;


$d = new \Haltuf\Genderer\Connection;

$firstname = $d->findFirstname('Michal') ;
Assert::type( 'array', $firstname );

$f = reset($firstname) ;

Assert::equal( 16527, $f['id'] ) ;
Assert::equal( 118915, $f['frequency'] ) ;
Assert::equal( 'Michal', $f['name'] ) ;
Assert::equal( 'Michale', $f['vocative'] ) ;
Assert::equal( 'm', $f['gender'] ) ;
Assert::equal( 'MICHAL', $f['normalized'] ) ;


$lastname = $d->findLastname('Veselá') ;
Assert::type( 'array', $lastname );

$fetched = reset( $lastname ) ;

Assert::equal( 118086, $fetched['id'] ) ;
Assert::equal( 13494, $fetched['frequency'] ) ;
Assert::equal( 'Veselá', $fetched['name'] ) ;
Assert::equal( 'Veselá', $fetched['vocative'] ) ;
Assert::equal( 'f', $fetched['gender'] ) ;
Assert::equal( 'VESELA', $fetched['normalized'] ) ;
