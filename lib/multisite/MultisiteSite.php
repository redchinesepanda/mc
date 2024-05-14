<?php

class MultisiteSite
{
	public static function register_functions_mainsite()
	{
		if ( MultisiteBlog::check_main_blog() )
		{
			$handler = new self();

			add_filter( 'network_edit_site_nav_links', [ $handler, 'mc_siteinfo_tab' ] );

		}
	}

	function mc_siteinfo_tab( $tabs )
	{
		$tabs[ 'site-misha' ] = [
			'label' => 'MC Siteinfo',

			'url' => add_query_arg( 'page', 'mcsiteinfo', 'sites.php' ), 

			'cap' => 'manage_sites'
		];

		return $tabs;

	}
}

?>