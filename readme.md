Genderer
========

[![Build Status](https://travis-ci.org/haltuf/genderer.svg?branch=master)](https://travis-ci.org/haltuf/genderer)[![Coverage Status](https://coveralls.io/repos/haltuf/genderer/badge.svg)](https://coveralls.io/r/haltuf/genderer)

Independent library to detect gender by name in Czech language. Also provides 5th grammatical case (vocative) for salutation.
Nezávislá knihovna pro detekci pohlaví podle jména. Kromě toho je schopna dle zadaného jména vrátit 5. pád pro oslovení.

See `example.php` for example of use.

Please be patient, this is my first github project and I use it as a testing playground.

Requirements
------------
- PHP 5.3.1 or higher
- Sqlite3 extension

The library was written as a standalone tool with zero dependencies to other projects.
This way you can use it in any project or framework you like.
If you want to use it in combination with Nette Framework, check out [GenderHelper](https://www.github.com/haltuf/gender-helper).

Installation
------------

Easiest way to install is to add this line to your `composer.json` file:
```
	"require": {
		"haltuf/genderer": "dev-master"
	}
```

or 

```
composer require haltuf/genderer:@dev
```

Usage
-----

```php
use Haltuf\Genderer\Genderer ;

$g = new Genderer ;

// Dobrý den, Tomáši Vomáčko
echo "Dobrý den, " . $g->getVocative( "Tomáš Vomáčka" );

// 'm' = male, 'f' = female
echo "Pohlaví: " . $g->getGender( "Tomáš Vomáčka" );

// Dobrý den, MUDr. Tomáši Amosi Březino
echo "Dobrý den, " . $g->getVocative( "MUDr. Tomáš Amos Březina" ) ;
```

Data source
-----------
The database of names comes from [Trixi blog](http://blog.trixi.cz/2012/08/5-pady-vsech-jmen-osob-v-cr-volne-ke-stazeni/) and is a compilation of the government oficial database (MVCR) and the contribution of authors working on [validace.cz](http://www.validace.cz) project.