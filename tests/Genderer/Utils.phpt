<?php

use Tester\Assert,
	Haltuf\Genderer\Utils ;

require __DIR__ . '/../bootstrap.php' ;



Assert::same( "KATERINA", Utils::normalize( "Kateřina" )) ;
Assert::same( "Kateřina", Utils::standardize( "KATEŘINA" )) ;

