<?php

class MultisiteBlog
{
	const MODE = [
		'all' => 'all',

		'other' => 'other',

		'current' => 'current',
	];

	public static function get_domain( $blog_id = '' )
	{
		if ( empty ( $blog_id ) )
		{
			$blog_id = MultisiteBlog::get_current_blog_id();
		}

		$current_blog = self::get_blog_details( $blog_id );

		return $current_blog->domain;
	}

	public static function get_main_domain()
	{
		$main_blog_id = self::get_main_blog_id();

		return self::get_domain( $main_blog_id );
	}

	public static function get_path( $site = null )
	{
		if ( empty( $site ) )
		{
            $site = self::get_current_site();
        }

		if ( ! empty( $site ) )
		{
			if ( $site->path != '/' )
			{
				return $site->path;
			}
		}

		return '/';
	}

	public static function get_siteurl( $blog_id = '' )
	{
		if ( empty ( $blog_id ) )
		{
			$blog_id = self::get_current_blog_id();
		}

		$current_blog = self::get_blog_details( $blog_id );

		return $current_blog->siteurl;
	}

	public static function set_blog( $blog_id )
	{
		switch_to_blog( $blog_id );
	}

	public static function restore_blog()
	{
		restore_current_blog();
	}

	public static function get_site( $id = '' )
	{
		if ( empty ( $id ) )
		{
			$id = self::get_current_blog_id();
		}

		return get_site( $id );
	}

	public static function get_current_blog_id()
	{
		return get_current_blog_id();
	}

	public static function get_main_blog_id()
	{
		return get_main_site_id();
	}

	public static function get_domain_main_blog_id( $domain = '' )
	{
		if ( empty ( $domain ) )
		{
			$domain = self::get_domain();
		}

		$main_site = self::get_domain_main_site( $domain );

		if ( ! empty( $main_site ) )
		{
			return $main_site->blog_id;
		}

		return get_main_site_id();
	}

	public static function get_blog_details( $blog_id )
	{
		return get_blog_details( $blog_id );
	}

	public static function get_meta_query_blog_language( $blog_language )
	{
		return [
			'relation' => 'AND',

			'blog-language' => [
				'key' => MultisiteSiteOptions::OPTIONS[ 'blog-language' ],

				'value' => $blog_language,

				'compare' => '=',
			],
		];
	}

	// public static function get_sites( $mode = self::MODE[ 'all' ], $domain = '', $path = '' )

	public static function get_sites( $mode = self::MODE[ 'all' ], $domain = '', $path = '', $blog_language = '' )
	{
		// $sites_args = [
		// 	'number' => 32,
		// ];
		
		$sites_args = [];

		if ( $mode === self::MODE[ 'other' ] )
		{
			$sites_args[ 'site__not_in' ] = self::get_current_blog_id();
		}

		if ( $mode === self::MODE[ 'current' ] )
		{
			$sites_args[ 'ID' ] = self::get_current_blog_id();
		}

		if ( ! empty( $domain ) )
		{
			$sites_args[ 'domain' ] = $domain;
		}

		if ( ! empty( $path ) )
		{
			$sites_args[ 'path' ] = $path;
		}

		if ( ! empty( $blog_language ) )
		{
			$sites_args[ 'meta_query' ] = self::get_meta_query_blog_language( $blog_language );
		}

		LegalDebug::debug( [
			'MultisiteBlog' => 'get_sites-1',

			'sites_args' => $sites_args,
		] );

		$sites = get_sites( $sites_args );

		if ( $sites )
		{
			return $sites;
		}

		return [];
	}

	public static function get_all_sites( $domain = '' )
	{
		return self::get_sites( self::MODE[ 'all' ], $domain );
	}

	public static function get_other_sites( $domain = '' )
	{
		return self::get_sites( self::MODE[ 'other' ], $domain );
	}

	public static function get_domain_main_site( $domain = '' )
	{
		$main_sites = self::get_sites( self::MODE[ 'all' ], $domain, '/' );

		if ( ! empty( $main_sites ) )
		{
			return array_shift( $main_sites );
		}

		return null;
	}

	public static function get_blog_language_site( $blog_language = '' )
	{
		return self::get_sites( self::MODE[ 'all' ], '', '', $blog_language );
	}

	public static function get_current_site()
	{
		$sites = self::get_sites( self::MODE[ 'current' ] );

		if ( $sites )
		{
			return array_shift( $sites );
		}

		return null;
	}

	public static function get_blog_option( $blog_id, $option )
	{
		return esc_attr( get_blog_option( $blog_id, $option ) );
	}

	public static function update_blog_option( $blog_id, $option, $value )
	{
		update_blog_option( $blog_id, $option, sanitize_text_field( $value ) );
	}

	// const EXCEPTION_BLOG_ID = [
	// 	'cloudways-main' => 21,
	// ];

	// public static function check_exception_blog_id()
	// {
	// 	return in_array( self::get_current_blog_id(), self::EXCEPTION_BLOG_ID );
	// }

	// public static function check_not_exception_blog_id()
	// {
	// 	return ! self::check_exception_blog_id();
	// }

	// public static function check_main_blog()
	// {
	// 	if ( self::get_current_blog_id() == self::get_main_blog_id() )
	// 	{
	// 		return true;
	// 	}

	// 	if ( self::check_exception_blog_id() )
	// 	{
	// 		return true;
	// 	}

	// 	return false;
	// }

	public static function check_main_blog()
	{
		return self::get_current_blog_id() == self::get_main_blog_id();
	}

	public static function check_not_main_blog()
	{
		return ! self::check_main_blog();
	}

	const EXCEPTION_DOMAINS = [
		'cloudways-main' => 'match.center',

		'cloudways-multisite' => 'multisite.match.center',

		'templ-content' => 'content.match.center',

		'old-content' => 'old.match.center',
	];

	public static function check_exception_domain()
	{
		return in_array( self::get_domain(), self::EXCEPTION_DOMAINS );
	}

	public static function check_not_exception_domain()
	{
		return ! self::check_exception_domain();
	}

	public static function check_main_domain()
	{
		$domain = self::get_domain();

		$domain_main_site = self::get_domain_main_site();

		// LegalDebug::debug( [
		// 	'MultisiteBlog' => 'check_main_domain',

		// 	'domain' => $domain,

        //     'domain_main_site' => $domain_main_site,
		// ] );

		if ( $domain == $domain_main_site->domain )
		{
			return true;
		}

		if ( self::check_exception_domain() )
		{
			return true;
		}

		return false;
	}

	public static function check_not_main_domain()
	{
		return ! self::check_main_domain();
	}
	
	// public static function check_main_domain_restricted()
	// {
	// 	$domain = self::get_main_domain();

	// 	return in_array( $domain, ReviewRestricted::DOMAINS );
	// }

	// public static function check_main_domain_not_restricted()
	// {
	// 	return ! self::check_main_domain_restricted();
	// }
}

?>