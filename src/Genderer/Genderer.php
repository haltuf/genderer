<?php

namespace Haltuf\Genderer ;

use Haltuf\Genderer\IConnection ;


class Genderer {
	
	/** @var Haltuf\Genderer\IConnection */
	private $db;

	
	public function __construct( IConnection $db ) {
		$this->db = $db ;
	}
	
	/**
	 * Returns 'm' or 'f' depending on the gender of the name.
	 * 
	 * @param string $name
	 * @return string
	 */
	public function getGender( $name ) {
		$stat = $this->getGenderStat( $name ) ;
		arsort( $stat );
		return current( array_keys( $stat ));
	}
	
	/**
	 * Returns associative array with keys 'f' and 'm' and values
	 * sum of the frequency of names occuring in Czech population.
	 * Can be used for the probabilistic estimate of a name belonging to either 'f' or 'm' gender.
	 * 
	 * @param string $name
	 * @return string
	 */
	public function getGenderStat( $name ) {
		
		$parts = explode( " ", $name ) ;
		
		if( count( $parts ) == 1 ) {		// just firstname
			$data = $this->db->findFirstname( $name ) ;
			return $this->vote( $data ) ;
		}
		
		if( count( $parts ) == 2 ) {		// <firstname lastname>
			$data = $this->db->findFirstname( $parts[0] ) ;
			$vote1 = $this->vote( $data ) ;
			
			$data = $this->db->findLastname( $parts[1] ) ;
			$vote2 = $this->vote( $data ) ;
			
			$vote = array();
			foreach (array_keys($vote1 + $vote2) as $key) {
				$vote[$key] = (isset($vote1[$key]) ? $vote1[$key] : 0) + (isset($vote2[$key]) ? $vote2[$key] : 0);
			}
			
			return $vote ;
		}
		
		// @TODO: more than 3 parts
	}
	
	/**
	 * Returns the 5th grammatical case (vocative) of the given name.
	 * 
	 * @param string $name
	 * @return string
	 */
	public function getVocative( $name ) {
		$parts = explode( " ", $name ) ;
		
		if( count( $parts ) == 1 ) {		// just firstname
			$data = $this->db->findFirstname( Utils::standardize( $name )) ;
			return $this->salute( $data, $name );
		}
		
		if( count( $parts ) == 2 ) {		// <firstname lastname>
			$data1 = $this->db->findFirstname( Utils::standardize( $parts[0] )) ;
			$data2 = $this->db->findLastname( Utils::standardize( $parts[1] )) ;
			
			return $this->salute( $data1, $parts[0] ) . ' ' . $this->salute( $data2, $parts[1] );
		}
		
		if( count( $parts > 2 )) {			// more complicated input
			
			$retval = array() ;
			
			foreach( $parts as $part ) {
				$data = $this->db->findFirstName( $part ) ;
				if( count( $data ) == 0 ) {
					$data = $this->db->findLastName( $part ) ;
				}
				$retval[] = $this->salute( $data, $part );
			}
			
			return implode( ' ', $retval );
		}
	}
	
	private function vote( $data ) {
		$vote = array() ;
		foreach( $data as $d ) {
			if(array_key_exists( $d->gender, $vote )) {
				$vote[$d->gender] += $d->frequency ;
			} else {
				$vote[$d->gender] = $d->frequency ;
			}
		}
		return $vote ;
	}
	
	private function salute( $data, $default = '' ) {
		return count( $data ) > 0 ? $data->fetch()->vocative : $default ;
	}
}
