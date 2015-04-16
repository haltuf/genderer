<?php

namespace Haltuf\Genderer ;


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
		return self::toAscii( self::upper($name));
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
		return self::firstUpper( self::lower( $name )) ;
	}
	
	
	
	/**
	 * To prevent any dependencies, the following code is part of the Nette Framework (http://nette.org)
	 * Copyright (c) 2004, 2014 David Grudl (http://davidgrudl.com)
	 * All rights reserved.
	 * 
	 * Redistribution and use in source and binary forms, with or without modification,
	 * are permitted provided that the following conditions are met:
	 * 
	 * - Redistributions of source code must retain the above copyright notice,
	 * this list of conditions and the following disclaimer.
	 * 
	 * - Redistributions in binary form must reproduce the above copyright notice,
	 * this list of conditions and the following disclaimer in the documentation
	 * and/or other materials provided with the distribution.
	 * 
	 * - Neither the name of "Nette Framework" nor the names of its contributors
	 * may be used to endorse or promote products derived from this software
	 * without specific prior written permission.
	 * 
	 * This software is provided by the copyright holders and contributors "as is" and
	 * any express or implied warranties, including, but not limited to, the implied
	 * warranties of merchantability and fitness for a particular purpose are
	 * disclaimed. In no event shall the copyright owner or contributors be liable for
	 * any direct, indirect, incidental, special, exemplary, or consequential damages
	 * (including, but not limited to, procurement of substitute goods or services;
	 * loss of use, data, or profits; or business interruption) however caused and on
	 * any theory of liability, whether in contract, strict liability, or tort
	 * (including negligence or otherwise) arising in any way out of the use of this
	 * software, even if advised of the possibility of such damage.
	 */
	
	
	/**
	 * Converts to ASCII.
	 * @param  string  UTF-8 encoding
	 * @return string  ASCII
	 */
	public static function toAscii($s)
	{
		$s = preg_replace('#[^\x09\x0A\x0D\x20-\x7E\xA0-\x{2FF}\x{370}-\x{10FFFF}]#u', '', $s);
		$s = strtr($s, '`\'"^~?', "\x01\x02\x03\x04\x05\x06");
		$s = str_replace(
			array("\xE2\x80\x9E", "\xE2\x80\x9C", "\xE2\x80\x9D", "\xE2\x80\x9A", "\xE2\x80\x98", "\xE2\x80\x99", "\xC2\xB0"),
			array("\x03", "\x03", "\x03", "\x02", "\x02", "\x02", "\x04"), $s
		);
		if (class_exists('Transliterator') && $transliterator = \Transliterator::create('Any-Latin; Latin-ASCII')) {
			$s = $transliterator->transliterate($s);
		}
		if (ICONV_IMPL === 'glibc') {
			$s = str_replace(
				array("\xC2\xBB", "\xC2\xAB", "\xE2\x80\xA6", "\xE2\x84\xA2", "\xC2\xA9", "\xC2\xAE"),
				array('>>', '<<', '...', 'TM', '(c)', '(R)'), $s
			);
			$s = @iconv('UTF-8', 'WINDOWS-1250//TRANSLIT//IGNORE', $s); // intentionally @
			$s = strtr($s, "\xa5\xa3\xbc\x8c\xa7\x8a\xaa\x8d\x8f\x8e\xaf\xb9\xb3\xbe\x9c\x9a\xba\x9d\x9f\x9e"
				. "\xbf\xc0\xc1\xc2\xc3\xc4\xc5\xc6\xc7\xc8\xc9\xca\xcb\xcc\xcd\xce\xcf\xd0\xd1\xd2\xd3"
				. "\xd4\xd5\xd6\xd7\xd8\xd9\xda\xdb\xdc\xdd\xde\xdf\xe0\xe1\xe2\xe3\xe4\xe5\xe6\xe7\xe8"
				. "\xe9\xea\xeb\xec\xed\xee\xef\xf0\xf1\xf2\xf3\xf4\xf5\xf6\xf8\xf9\xfa\xfb\xfc\xfd\xfe"
				. "\x96\xa0\x8b\x97\x9b\xa6\xad\xb7",
				"ALLSSSSTZZZallssstzzzRAAAALCCCEEEEIIDDNNOOOOxRUUUUYTsraaaalccceeeeiiddnnooooruuuuyt- <->|-.");
			$s = preg_replace('#[^\x00-\x7F]++#', '', $s);
		} else {
			$s = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $s); // intentionally @
		}
		$s = str_replace(array('`', "'", '"', '^', '~', '?'), '', $s);
		return strtr($s, "\x01\x02\x03\x04\x05\x06", '`\'"^~?');
	}
	
	/**
	 * Convert first character to upper case.
	 * @param  string  UTF-8 encoding
	 * @return string
	 */
	public static function firstUpper($s)
	{
		return self::upper(self::substring($s, 0, 1)) . self::substring($s, 1);
	}
	
	/**
	 * Convert to lower case.
	 * @param  string  UTF-8 encoding
	 * @return string
	 */
	public static function lower($s)
	{
		return mb_strtolower($s, 'UTF-8');
	}

	/**
	 * Convert to upper case.
	 * @param  string  UTF-8 encoding
	 * @return string
	 */
	public static function upper($s)
	{
		return mb_strtoupper($s, 'UTF-8');
	}
	
	/**
	 * Returns a part of UTF-8 string.
	 * @param  string
	 * @param  int in characters (code points)
	 * @param  int in characters (code points)
	 * @return string
	 */
	public static function substring($s, $start, $length = NULL)
	{
		if (function_exists('mb_substr')) {
			if ($length === NULL && PHP_VERSION_ID < 50408) {
				$length = self::length($s);
			}
			return mb_substr($s, $start, $length, 'UTF-8'); // MB is much faster
		} elseif ($length === NULL) {
			$length = self::length($s);
		} elseif ($start < 0 && $length < 0) {
			$start += self::length($s); // unifies iconv_substr behavior with mb_substr
		}
		return iconv_substr($s, $start, $length, 'UTF-8');
	}
	
	/**
	 * Returns number of characters (not bytes) in UTF-8 string.
	 * That is the number of Unicode code points which may differ from the number of graphemes.
	 * @param  string
	 * @return int
	 */
	public static function length($s)
	{
		return function_exists('mb_strlen') ? mb_strlen($s, 'UTF-8') : strlen(utf8_decode($s));
	}
}
