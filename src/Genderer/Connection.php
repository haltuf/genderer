<?php

namespace Haltuf\Genderer ;

use Haltuf\Genderer\Utils ;
use Haltuf\Genderer\IConnection ;


class Connection implements IConnection {
	
	private $db ;
	
	
	public function __construct() {
		if( !extension_loaded('sqlite3')) {
			throw new Exception( 'Extension SQLITE3 required by Genderer is not available.' );
		}
		$this->db = new \SQLite3(__DIR__ . '/names.db3');
	}
	
	public function findFirstname( $firstname ) {
		$firstname = Utils::standardize( $firstname );
		$statement = $this->db->prepare( 'SELECT * FROM firstname WHERE name = :name ORDER BY frequency DESC' );
		$statement->bindValue( ':name', $firstname ) ;
		$retval = $this->fetch( $statement->execute());
		return count( $retval ) > 0 ? $retval : $this->findNormalizedFirstname( $firstname ) ;
	}
	
	public function findLastname( $lastname ) {
		$lastname = Utils::standardize( $lastname );
		$statement = $this->db->prepare( 'SELECT * FROM lastname WHERE name = :name ORDER BY frequency DESC' );
		$statement->bindValue( ':name', $lastname ) ;
		$retval = $this->fetch( $statement->execute());
		return count( $retval ) > 0 ? $retval : $this->findNormalizedLastname( $lastname );
	}
	
	private function findNormalizedFirstname( $name ) {
		$normalized = Utils::normalize( $name ) ;
		$statement = $this->db->prepare( 'SELECT * FROM firstname WHERE normalized = :name ORDER BY frequency DESC' );
		$statement->bindValue( ':name', $normalized ) ;
		return $this->fetch( $statement->execute());
	}
	
	private function findNormalizedLastname( $name ) {
		$normalized = Utils::normalize( $name ) ;
		$statement = $this->db->prepare( 'SELECT * FROM lastname WHERE normalized = :name ORDER BY frequency DESC' );
		$statement->bindValue( ':name', $normalized ) ;
		return $this->fetch( $statement->execute());
	}
	
	/**
	 * @param \SQLite3Result $result
	 */
	private function fetch( $result ) {
		
		$retval = array() ;
		
		while( $row = $result->fetchArray()) {
			$retval[] = $row ;
		}
		
		return $retval ;
	}
}