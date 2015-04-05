<?php

namespace Haltuf\Genderer ;


class Genderer {
	
	/** @var Nette\Database\Context */
	private $db;

	/*public function __construct( Nette\Database\Context $db ) {
		$this->db = $db;
	}*/
	
	/**
	 * @todo Dependency Injection
	 */
	public function __construct() {
		$connection = new \Nette\Database\Connection( 'sqlite:' . __DIR__ . '/names.db3' );
		$cacheStorage = new \Nette\Caching\Storages\FileStorage( __DIR__ );
		$structure = new \Nette\Database\Structure( $connection, $cacheStorage );
		$this->db = new \Nette\Database\Context( $connection, $structure );
	}
	
	private function findNormalizedFirstname( $name ) {
		$normalized = Utils::normalize( $name ) ;
		return $this->db->table('firstname')->where('normalized',$normalized)->order('frequency DESC') ;
	}
	
	private function findNormalizedLastname( $name ) {
		$normalized = Utils::normalize( $name ) ;
		return $this->db->table('lastname')->where('normalized',$normalized)->order('frequency DESC') ;
	}
	
	public function findFirstname( $firstname ) {
		$firstname = Utils::standardize( $firstname );
		$retval = $this->db->table('firstname')->where('name',$firstname)->order('frequency DESC') ;
		return count( $retval ) > 0 ? $retval : $this->findNormalizedFirstname( $firstname ) ;
	}
	
	public function findLastname( $lastname ) {
		$lastname = Utils::standardize( $lastname );
		$retval = $this->db->table('lastname')->where('name',$lastname)->order('frequency DESC') ;
		return count( $retval ) > 0 ? $retval : $this->findNormalizedLastname( $lastname );
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
			$data = $this->findFirstname( $name ) ;
			return $this->vote( $data ) ;
		}
		
		if( count( $parts ) == 2 ) {		// <firstname lastname>
			$data = $this->findFirstname( $parts[0] ) ;
			$vote1 = $this->vote( $data ) ;
			
			$data = $this->findLastname( $parts[1] ) ;
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
			$data = $this->findFirstname( Utils::standardize( $name )) ;
			return $this->salute( $data, $name );
		}
		
		if( count( $parts ) == 2 ) {		// <firstname lastname>
			$data1 = $this->findFirstname( Utils::standardize( $parts[0] )) ;
			$data2 = $this->findLastname( Utils::standardize( $parts[1] )) ;
			
			return $this->salute( $data1, $parts[0] ) . ' ' . $this->salute( $data2, $parts[1] );
		}
		// @TODO: more than 3 parts
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