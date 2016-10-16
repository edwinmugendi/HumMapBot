<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Default Cache Driver
	|--------------------------------------------------------------------------
	|
	| This option controls the default cache "driver" that will be used when
	| using the Caching library. Of course, you may use other drivers any
	| time you wish. This is the default when another is not specified.
	|
	| Supported: "file", "database", "apc", "memcached", "redis", "array"
	|
	*/

	'driver' => 'redis',

	/*
	|--------------------------------------------------------------------------
	| Database Cache Table
	|--------------------------------------------------------------------------
	|
	| When using the "database" cache driver we need to know the table that
	| should be used to store the cached items. A default table name has
	| been provided but you're free to change it however you deem fit.
	|
	*/

	'table' => 'cache',
	/*
	|--------------------------------------------------------------------------
	| Cache Key Prefix
	|--------------------------------------------------------------------------
	|
	| When utilizing a RAM based store such as APC or Memcached, there might
	| be other applications utilizing the same cache. So, we'll specify a
	| value to get prefixed to all our keys so we can avoid collisions.
	|
	*/

	'prefix' => 'laravel',

);
