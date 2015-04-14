<?php

use Tester\Assert ;
use Nette\DI\Compiler;
use Nette\DI\ContainerLoader;
use Haltuf\Genderer\Bridges\NetteDI\GendererExtension ;

require __DIR__ . '/../bootstrap.php' ;
/*
$loader = new ContainerLoader(TEMP_DIR);
$key = 'key';
$className = $loader->load($key, function (Compiler $compiler) {
	$compiler->addExtension('genderer', new GendererExtension());
	$compiler->loadConfig(__DIR__ . '/config.neon');
});
$e = new $className;*/

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