<?php

require_once( 'AffiliateFilter.php' );

class AffiliateMain
{
	public static function register_functions_admin()
	{
		AffiliateFilter::register_functions_admin();
	}
}

?>