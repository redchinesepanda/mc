<?php

require_once( 'AffiliateFilter.php' );

require_once( 'AffiliateCategory.php' );

class AffiliateMain
{
	public static function register_functions_admin()
	{
		AffiliateFilter::register_functions_admin();

		AffiliateCategory::register_functions_admin();
	}
}

?>