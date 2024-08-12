<?php

class LegalHosts
{
	const HOST_EXTERNAL = [
		'www.ukclubsport.com',
	];

	const HOST_PRODUCTION = [
		'mc' => 'match.center',

		'old' => 'old.match.center',

		'cloudways-au' => 'match-center-au.com',

		'cloudways-nz' => 'match-center.nz',

		'cloudways-nl' => 'match-center.nl',

		'cloudways-ro' => 'match-center.ro',

		'cloudways-mt' => 'match-center.mt',

		'cloudways-ar' => 'match-center.ar',

		'cloudways-at' => 'match-center.at',

		'cloudways-de' => 'match-center-de.com',

		'cloudways-cz' => 'match-center.cz',

		'cloudways-pl' => 'match-center.pl',

		'cloudways-ua' => 'match-center-ua.com',

		'cloudways-kz' => 'match-center-kz.com',
	];

	const HOST_DEBUG = [
		'oldpl' => 'oldpl.match.center',

		'test' => 'test.match.center',

		'testkz' => 'testkz.match.center',
	];

	public static function check_external( $host )
	{
		return in_array( $host, self::HOST_EXTERNAL );
    }

	public static function check_host_production()
	{
		if ( in_array( $_SERVER[ 'HTTP_HOST' ], self::HOST_PRODUCTION ) )
		{
			return true;
		}

		return false;
	}

	public static function get_main_host()
	{
		if ( self::check_host_production() )
		{
			return self::get_main_host_production();
		}

		$host = self::HOST_DEBUG;
		
		return array_shift( $host );
	}

	public static function get_main_host_production()
	{
		$host = self::HOST_PRODUCTION;

		return array_shift( $host );
	}
}

?>