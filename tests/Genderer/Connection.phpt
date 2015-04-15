<?php

use Tester\Assert ;

require __DIR__ . '/../bootstrap.php' ;


$connection = new \Nette\Database\Connection( 'sqlite:' . __DIR__ . '/../../src/Genderer/names.db3' );
$cacheStorage = new \Nette\Caching\Storages\FileStorage( __DIR__ );
$structure = new \Nette\Database\Structure( $connection, $cacheStorage );
$context = new \Nette\Database\Context($connection,$structure);
$d = new \Haltuf\Genderer\Connection($context);

$firstname = $d->findFirstname('Michal') ;
Assert::type( 'Nette\Database\Table\Selection', $firstname );

$fetched = $firstname->fetch() ;
Assert::type( 'Nette\Database\Table\ActiveRow', $fetched );

Assert::equal( 16527, $fetched->id ) ;
Assert::equal( 118915, $fetched->frequency ) ;
Assert::equal( 'Michal', $fetched->name ) ;
Assert::equal( 'Michale', $fetched->vocative ) ;
Assert::equal( 'm', $fetched->gender ) ;
Assert::equal( 'MICHAL', $fetched->normalized ) ;


$lastname = $d->findLastname('Veselá') ;
Assert::type( 'Nette\Database\Table\Selection', $lastname );

$fetched = $lastname->fetch() ;
Assert::type( 'Nette\Database\Table\ActiveRow', $fetched );

Assert::equal( 118086, $fetched->id ) ;
Assert::equal( 13494, $fetched->frequency ) ;
Assert::equal( 'Veselá', $fetched->name ) ;
Assert::equal( 'Veselá', $fetched->vocative ) ;
Assert::equal( 'f', $fetched->gender ) ;
Assert::equal( 'VESELA', $fetched->normalized ) ;
