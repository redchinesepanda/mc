<?php

class MultisiteSite
{
	const NONCE = [
		'check'	=> 'mc-check-',
	];

	const OPTION = [
		'blog-language'	=> 'mc_blog_language',

		'blog-locale'	=> 'mc_blog_locale',
	];

	public static function register_functions_mainsite()
	{
		if ( MultisiteBlog::check_main_blog() )
		{
			$handler = new self();

			add_filter( 'network_edit_site_nav_links', [ $handler, 'mc_siteinfo_tab' ] );

			add_action( 'network_admin_menu', [ $handler, 'mc_siteinfo_page' ] );

			add_action( 'network_admin_edit_mcsiteinfoupdate',  [ $handler, 'mc_siteinfo_save' ] );
		}
	}

	function mc_siteinfo_tab( $tabs )
	{
		$tabs[ 'mc-siteinfo-tab' ] = [
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

				'selected' => 'mc-siteinfo-tab',
			],

			// 'nonce'	=> 'mc-check-' . $id,
			
			'nonce'	=> self::NONCE[ 'check' ] . $id,

			'options' => [
				'mc-blog-language' => [
					'label' => 'MC Blog Language ( en )',

					'name' => self::OPTION[ 'blog-language' ],

					'value' => esc_attr( get_blog_option( $id, self::OPTION[ 'blog-language' ] ) ),
				],

				'mc-blog-locale' => [
					'label' => 'MC Blog Locale ( en_GB )',

					'name' => self::OPTION[ 'blog-locale' ],

					'value' => esc_attr( get_blog_option( $id, self::OPTION[ 'blog-locale' ] ) ),
				],
			],

			
		];
	}

	function mc_siteinfo_page_render()
	{
		echo LegalComponents::render_main( self::TEMPLATE[ 'mc-siteinfo' ], self::mc_siteinfo_page_args() );
	}

	function mc_siteinfo_save()
	{
		$id = absint( $_POST[ 'id' ] );

		check_admin_referer( self::NONCE[ 'check' ] . $id );

		update_blog_option( $id, 'mc_blog_language', sanitize_text_field( $_POST[ 'mc_blog_language' ] ) );
		
		// redirect to /wp-admin/sites.php?page=mishapage&blog_id=ID&updated=true

		wp_safe_redirect( 
			add_query_arg( 
				[
					'page' => 'mcsiteinfo',

					'id' => $id,

					'updated' => 'true'
				],

				network_admin_url( 'sites.php' )
			)
		);

		exit;
	}
}

?>