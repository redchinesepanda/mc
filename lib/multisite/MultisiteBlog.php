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