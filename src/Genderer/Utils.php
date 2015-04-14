<?php

namespace Haltuf\Genderer ;

use Nette\Utils\Strings ;


final class Utils {
	
	/**
	 * Returns the normalized version of the name:
	 * Removes all diacritics.
	 * Makes everything uppercase.
	 * 
	 * @param string $name
	 * @return string
	 */
	public static function normalize( $name ) {
		return Strings::toAscii( Strings::upper( $name )) ;
	}
	
	/**
	 * Returns standardized version of the name:
	 * Leaves diacritics intact.
	 * Makes sure that first letter is uppercase and the rest is lowercase.
	 * 
	 * @param string $name
	 * @return string
	 */
	public static function standardize( $name ) {
		return Strings::firstUpper( Strings::lower( $name )) ;
	}
}
