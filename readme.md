Genderer
========

[![Build Status](https://travis-ci.org/haltuf/genderer.svg?branch=master)](https://travis-ci.org/haltuf/genderer)[![Coverage Status](https://coveralls.io/repos/haltuf/genderer/badge.svg)](https://coveralls.io/r/haltuf/genderer)

Library to detect gender by name in Czech language. Also provides 5th grammatical case (vocative) for salutation.
Knihovna pro detekci pohlaví podle jména. Kromě toho je schopna dle zadaného jména vrátit 5. pád pro oslovení.

See `example.php` for example of use.

Please be patient, this is my first github project and I use it as a testing playground.

Installation
------------

Easiest way to install is to add this line to your `composer.json` file:
```
{
	"require": {
		"haltuf/genderer": "dev-master"
	}
}
```

or 

```
composer require haltuf/genderer:@dev
```

Then it is neccessary to register extension in config.neon:

```
extensions:
	genderer: Haltuf\Genderer\Bridges\NetteDI\GendererExtension
```

Data source
-----------
The database of names comes from [Trixi blog](http://blog.trixi.cz/2012/08/5-pady-vsech-jmen-osob-v-cr-volne-ke-stazeni/) and is a compilation of the government oficial database (MVCR) and the contribution of authors working on [validace.cz](http://www.validace.cz) project.