<?php

class LegalHosts
{
	const HOST_EXTERNAL = [
		'www.ukclubsport.com',
	];

	const HOST_PRODUCTION = [
		'mc' => 'match.center',

		'old' => 'old.match.center',

		'oldpl' => 'oldpl.match.center',
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