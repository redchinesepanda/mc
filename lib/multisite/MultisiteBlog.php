<?php

class MultisiteBlog
{
	const MODE = [
		'all' => 'all',

		'other' => 'other',

		'current' => 'current',
	];

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

	public static function get_sites( $mode = self::MODE[ 'all' ] )
	{
		$sites_args = [
			'number' => 32,
		];

		if ( $mode == self::MODE[ 'other' ] )
		{
			$sites_args[ 'site__not_in' ] = self::get_current_blog_id();
		}

		if ( $mode = self::MODE[ 'current' ] )
		{
			$sites_args[ 'ID' ] = self::get_current_blog_id();
		}

		$sites = get_sites( $sites_args );

		if ( $sites )
		{
			return $sites;
		}

		return [];
	}

	public static function get_other_sites()
	{
		return self::get_sites( self::MODE[ 'other' ] );
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
}

?>