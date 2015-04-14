<?php

namespace Haltuf\Genderer ;

use Haltuf\Genderer\Utils ;
use Haltuf\Genderer\IConnection ;


class Connection implements IConnection {
	
	private $context ;
	
	
	public function __construct( \Nette\Database\Context $context ) {
		$this->context = $context ;
	}
	
	public function findFirstname( $firstname ) {
		$firstname = Utils::standardize( $firstname );
		$retval = $this->context->table('firstname')->where('name',$firstname)->order('frequency DESC') ;
		return count( $retval ) > 0 ? $retval : $this->findNormalizedFirstname( $firstname ) ;
	}
	
	public function findLastname( $lastname ) {
		$lastname = Utils::standardize( $lastname );
		$retval = $this->context->table('lastname')->where('name',$lastname)->order('frequency DESC') ;
		return count( $retval ) > 0 ? $retval : $this->findNormalizedLastname( $lastname );
	}
	
	private function findNormalizedFirstname( $name ) {
		$normalized = Utils::normalize( $name ) ;
		return $this->context->table('firstname')->where('normalized',$normalized)->order('frequency DESC') ;
	}
	
	private function findNormalizedLastname( $name ) {
		$normalized = Utils::normalize( $name ) ;
		return $this->context->table('lastname')->where('normalized',$normalized)->order('frequency DESC') ;
	}
}