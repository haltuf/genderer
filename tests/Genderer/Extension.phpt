<?php

use Tester\Assert ;
use Nette\DI\Compiler;
use Haltuf\Genderer\Bridges\NetteDI\GendererExtension ;

require __DIR__ . '/../bootstrap.php' ;

$loader = new Nette\DI\Config\Loader ;
$config = $loader->load( __DIR__ . '/config.neon' );

$compiler = new Compiler ;
$compiler->addExtension('cache', new Nette\Bridges\CacheDI\CacheExtension(TEMP_DIR));
$compiler->addExtension('genderer', new GendererExtension());
eval($compiler->compile($config, 'Container1'));
$container = new Container1;
$container->initialize();

$service = $container->getService('genderer.service') ;
Assert::type( 'Haltuf\Genderer\Genderer', $service ) ;

$connection = $container->getService('genderer.driver') ;
Assert::type( 'Haltuf\Genderer\Connection', $connection ) ;

Assert::equal( array(
	'id' => 16527,
	'frequency' => 118915,
	'name' => 'Michal',
	'vocative' => 'Michale',
	'gender' => 'm',
	'normalized' => 'MICHAL',
), $connection->findFirstName('Michal')->fetch()->toArray()) ;
