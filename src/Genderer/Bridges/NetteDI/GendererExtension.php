<?php

namespace Haltuf\Genderer\Bridges\NetteDI; 

use Nette\DI\CompilerExtension ;



class GendererExtension extends CompilerExtension {
	
	private $defaults = array(
		'dsn' => 'sqlite:names.db3',
		'user' => NULL,
		'password' => NULL,
		'options' => NULL,
		'driver' => 'Haltuf\Genderer\Connection'
	);
	
	public function loadConfiguration() {
		
		$container = $this->getContainerBuilder() ;
		$config = $this->getConfig($this->defaults) ;
		
		$connection = $container->addDefinition($this->prefix("connection"))
			->setClass('Nette\Database\Connection', array($config['dsn'], $config['user'], $config['password'], $config['options']));
		
		$structure = $container->addDefinition($this->prefix("structure"))
			->setClass('Nette\Database\Structure')
			->setArguments(array($connection));
		
		$context = $container->addDefinition($this->prefix("context"))
			->setClass('Nette\Database\Context', array($connection, $structure));
		
		$driver = $container->addDefinition($this->prefix("driver"))
			->setClass($config['driver'], array($context));
		
		$service = $container->addDefinition($this->prefix('service'))
			->setClass('Haltuf\Genderer\Genderer', array( $driver ));
	}
}