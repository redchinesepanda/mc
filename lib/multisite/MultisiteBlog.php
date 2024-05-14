<?php

class MultisiteBlog
{
	public static function set_blog( $blog_id )
	{
		switch_to_blog( $blog_id );
	}

	public static function restore_blog()
	{
		restore_current_blog();
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

	public static function get_sites( $mode = 'all' )
	{
		$sites_args = [
			'number' => 32,
		];

		if ( $mode == 'other' )
		{
			$sites_args[ 'site__not_in' ] = self::get_current_blog_id();
		}

		if ( $mode = 'current' )
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
		return self::get_sites( 'other' );
	}

	// public static function get_other_sites()
	// {
	// 	$sites = get_sites( [
	// 		'site__not_in' => MultisiteBlog::get_current_blog_id(),

	// 		'number' => 32,
	// 	] );

	// 	if ( $sites )
	// 	{
	// 		return $sites;
	// 	}

	// 	return [];
	// }

	public static function get_current_site()
	{
		$sites = self::get_sites( 'current' );

		if ( $sites )
		{
			return array_shift( $sites );
		}

		return null;
	}

	// public static function get_current_site()
	// {
	// 	$current_blog_id = self::get_current_blog_id();

	// 	$sites = get_sites( [
	// 		'ID' => $current_blog_id,

	// 		'number' => 1,
	// 	] );

	// 	if ( $sites )
	// 	{
	// 		return array_shift( $sites );
	// 	}

	// 	return null;
	// }

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