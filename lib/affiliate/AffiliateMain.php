<?php

require_once( 'AffiliateFilter.php' );

// require_once( 'AffiliateCategory.php' );

require_once( 'AffiliateHref.php' );

class AffiliateMain
{
	public static function register_functions_admin()
	{
		AffiliateFilter::register_functions_admin();

		// AffiliateCategory::register_functions_admin();
		
		AffiliateHref::register_functions_admin();
	}

	// public static function register_functions()
	// {
	// 	// AffiliateCategory::register_functions();
	// }
}

?>