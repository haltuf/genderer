<?php

/**
 * Test: doesn't throw Nette\DI\ServiceCreationException: "Multiple services
 * of type Nette\Database\Context found"
 */

use Tester\Assert ;
use Nette\Configurator ;

require __DIR__ . '/../bootstrap.php' ;

$configurator = new Configurator ;
$configurator->setTempDirectory(TEMP_DIR);
$configurator->addConfig(__DIR__ . '/withdatabase.neon');
$container = $configurator->createContainer();

$service = $container->getService('genderer.service') ;
Assert::type( 'Haltuf\Genderer\Genderer', $service ) ;


class UserManager {
	
	/** @var Nette\Database\Context */
	private $database;

	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
	}
}
