<?php

namespace Haltuf\Genderer ;


interface IConnection {
	
	public function findFirstName( $firstname ) ;
	
	public function findLastName( $lastname );
}