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

		$current_blog = MultisiteBlog::get_blog_details( $blog_id );

		return $current_blog->domain;
	}

	public static function get_siteurl( $blog_id = '' )
	{
		if ( empty ( $blog_id ) )
		{
			$blog_id = MultisiteBlog::get_current_blog_id();
		}

		$current_blog = MultisiteBlog::get_blog_details( $blog_id );

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

	public static function get_site( $id )
	{
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

	public static function get_blog_details( $blog_id )
	{
		return get_blog_details( $blog_id );
	}

	public static function get_sites( $mode = self::MODE[ 'all' ], $domain = '', $path = '' )
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

		if ( !empty( $domain ) )
		{
			$sites_args[ 'domain' ] = $domain;
		}

		if ( !empty( $path ) )
		{
			$sites_args[ 'path' ] = $path;
		}

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

	public static function check_main_blog()
	{
		return self::get_current_blog_id() == self::get_main_blog_id();
	}

	public static function check_not_main_blog()
	{
		return !self::check_main_blog();
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

		return false;
	}

	public static function check_not_main_domain()
	{
		return ! self::check_main_domain();
	}
}

?>