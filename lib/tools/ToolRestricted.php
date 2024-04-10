<?php

class ToolRestricted
{
	const RESTRICTED_PRODUCTION = [
		'es.match.center' => [
			'es'
		],
	];

	const RESTRICTED_DEBUG = [
		'oldpl.match.center' => [
			'pl'
		],

		'oldes.match.center' => [
			'es'
		],

		// 'oldca.match.center' => [
		// 	'ca',

		// 	'ca-fr',
		// ],

		// 'es.match.center' => [
		// 	'es'
		// ],
	];

	const SHORTCODES = [
		'restricted' => 'legal-restricted',
	];

	public static function register()
    {
        $handler = new self();

		// [legal-restricted][/legal-restricted]

		add_shortcode( self::SHORTCODES[ 'restricted' ], [ $handler, 'prepare' ] );
    }

	public static function prepare( $atts, $content = '' )
    {
		// $atts = shortcode_atts( self::PAIRS, $atts, self::SHORTCODES[ 'restricted' ] );

		if ( self::check_domain_restricted() )
		{
			return '';
		}

		return $content;
	}

	public static function get_host()
	{
		// return $_SERVER[ 'HTTP_HOST' ];
		
		return ToolRobots::get_host();
	}

	public static function get_restricted()
	{
		// if ( LegalMain::check_host_production() )
		
		if ( LegalHosts::check_host_production() )
        {
            return self::RESTRICTED_PRODUCTION;
        }

		return self::RESTRICTED_DEBUG;
	}

	public static function get_restricted_language_host( $language )
	{
		$restricted = self::get_restricted();

		$result = false;

		foreach ( $restricted as $host => $languages )
		{
			if ( in_array( $language, $languages ) )
            {
                $result = $host;

				break;
            }
		}

		return $result;
	}

	public static function get_restricted_languages_current()
	{
		$restricted = self::get_restricted();
			
		return $restricted[ self::get_host() ];
	}

	public static function get_restricted_languages()
	{
		if ( self::check_domain() )
		{
			// return $restricted[ $_SERVER[ 'HTTP_HOST' ] ];

			// $restricted = self::get_restricted();
			
			// return $restricted[ self::get_host() ];

			return self::get_restricted_languages_current();
		}

		// return call_user_func_array( 'array_merge', $restricted );

		return self::get_restricted_languages_all();
	}

	public static function get_restricted_languages_all()
	{
		$restricted = self::get_restricted();

		// LegalDebug::debug( [
		// 	'ToolNotFound' => 'get_restricted_languages_all',

		// 	'restricted' => $restricted,
		// ] );

		if ( count( $restricted ) > 1 )
		{
			return call_user_func_array( 'array_merge', $restricted );
		}

		return array_shift( $restricted );
	}

	public static function get_default_language( $host = '' )
	{
		if ( empty( $host ) )
		{
			// $host = $_SERVER[ 'HTTP_HOST' ];
			
			$host = self::get_host();
		}

		$restricted = self::get_restricted();

		// if ( self::check_domain() )
		
		if ( self::check_domain( $host ) )
		{
			// return array_shift( $restricted[ $_SERVER[ 'HTTP_HOST' ] ] );

			return array_shift( $restricted[ $host ] );
		}

		return 'en';
	}

	public static function check_domain_restricted()
	{
		return self::check_domain();
	}

	public static function check_domain( $host = '' )
	{
		if ( empty( $host ) )
		{
            // $host = $_SERVER[ 'HTTP_HOST' ];
            
			$host = self::get_host();
        }

		$restricted = self::get_restricted();

		// LegalDebug::debug( [
		// 	'ToolNotFound' => 'check_domain',

		// 	'host' => $host,

        //     'restricted' => $restricted,
        // ] );

		// if ( array_key_exists( $_SERVER[ 'HTTP_HOST' ], $restricted ) )
		
		if ( array_key_exists( $host, $restricted ) )
		{
			return true;
		}

		return false;
	}

	public static function check_language( $languages = [] )
	{
		$result = false;

		$language = WPMLMain::current_language();

		$restricted = [];

		if ( empty( $languages ) )
		{
			$restricted = self::get_restricted();
		}
		else
		{
			$restricted[] = $languages;
		}
	
		foreach ( $restricted as $languages )
		{
			if ( in_array( $language, $languages ) )
			{
				$result = true;
			}
		}

		return $result;
	}

	public static function check_restricted_domain_and_not_language()
	{
		return self::check_domain() && !self::check_language( self::get_restricted_languages() );
	}

	public static function check_restricted_not_domain_and_language()
	{
		// return !self::check_domain() && self::check_language();
	
		// Временно для не ограниченных доменов доступны все страны

		return false;
	}

	public static function check_restricted()
	{
		// LegalDebug::debug( [
		// 	'ToolNotFound' => 'check_restricted',

		// 	'check_domain' => self::check_domain(),

		// 	'check_language' => self::check_language(),
		// ] );

		// return self::check_domain() && !self::check_language()
			
		// 	|| !self::check_domain() && self::check_language();

		return self::check_restricted_domain_and_not_language()

			|| self::check_restricted_not_domain_and_language();
	}
}

?>