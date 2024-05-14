<?php

class MultisiteSite
{
	public static function register_functions_mainsite()
	{
		if ( MultisiteBlog::check_main_blog() )
		{
			$handler = new self();

			add_filter( 'network_edit_site_nav_links', [ $handler, 'mc_siteinfo_tab' ] );

			add_action( 'network_admin_menu', [ $handler, 'mc_siteinfo_page' ] );
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

	function mc_siteinfo_page()
	{
		$handler = new self();

		add_submenu_page( '', 'Edit site', 'Edit site', 'manage_network_options', 'mcsiteinfo', [ $handler, 'mc_siteinfo_page_render' ] );
	}

	const TEMPLATE = [
		'mc-siteinfo' => LegalMain::LEGAL_PATH . '/template-parts/multisite/part-multisite-mc-settings.php',
	];

	function mc_siteinfo_page_args()
	{
		$id = absint( $_REQUEST[ 'id' ] );

		$site = MultisiteBlog::get_site( $id );

		return [
			'id' => $id,

			'title' => $site->blogname,

			'href-visit' => esc_url( get_home_url( $id, '/' ) ),

			'href-dashboard' => esc_url( get_admin_url( $id ) ),

			'network-edit-site-nav' => [
				'blog_id'  => $id,

				'selected' => 'mcsiteinfo',
			],

			'mc-blog-language' => esc_attr( get_blog_option( $id, 'mc_blog_language') ),
		];
	}

	function mc_siteinfo_page_render()
	{
		return LegalComponents::render_main( self::TEMPLATE[ 'mc-siteinfo' ], self::mc_siteinfo_page_args() );
	}
}

?>