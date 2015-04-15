<?php

use Haltuf\Genderer\Genderer ;

require_once __DIR__ . '/vendor/autoload.php' ;

/**
 * This part is usually done automatically by Nette Framework.
 * Just register extension and use @inject annotation.
 */
	$connection = new \Nette\Database\Connection( 'sqlite:' . __DIR__ . '/src/Genderer/names.db3' );
	$cacheStorage = new \Nette\Caching\Storages\FileStorage( __DIR__ );
	$structure = new \Nette\Database\Structure( $connection, $cacheStorage );
	$context = new \Nette\Database\Context($connection,$structure);
	$driver = new \Haltuf\Genderer\Connection($context);
	$g = new Genderer($driver) ;
/**
 * END OF PART THAT WON'T BE USUALLY IN YOUR SCRIPTS
 */

// Dobrý den, Tomáši Vomáčko
echo "Dobrý den, " . $g->getVocative( "Tomáš Vomáčka" );

// 'm' = male, 'f' = female
echo "Pohlaví: " . $g->getGender( "Tomáš Vomáčka" );

// Works for names with more than two parts
// Dobrý den, MUDr. Tomáši Amosi Březino
echo "Dobrý den, " . $g->getVocative( "MUDr. Tomáš Amos Březina" ) ;