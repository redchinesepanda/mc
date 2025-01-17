<?php

// https://rudrastyh.com/wordpress-multisite/custom-tabs-with-options.html

class MultisiteSiteOptions
{
	const SETTINGS = [
		'page' => 'mcsiteinfo',

		'tab' => 'mc-siteinfo-tab',

		'action' => 'mcsiteinfoupdate',
	];

	const NONCE = [
		'check'	=> 'mc-check-',
	];

	const OPTIONS = [
		'blog-language'	=> 'mc_blog_language',

		'blog-locale'	=> 'mc_blog_locale',

		'blog-label'	=> 'mc_blog_label',
	];

	public static function register_functions_mainsite()
	{
		if ( MultisiteBlog::check_main_blog() )
		{
			$handler = new self();

			add_filter( 'network_edit_site_nav_links', [ $handler, 'mc_siteinfo_tab' ] );

			add_action( 'network_admin_menu', [ $handler, 'mc_siteinfo_page' ] );

			add_action( 'network_admin_edit_mcsiteinfoupdate', [ $handler, 'mc_siteinfo_save' ] );

			add_action( 'network_admin_notices', [ $handler, 'mc_siteinfo_notice_render' ] );
		}
	}

	public static function mc_siteinfo_tab( $tabs )
	{
		$tabs[ self::SETTINGS[ 'tab' ] ] = [
			'label' => 'MC Siteinfo',

			'url' => add_query_arg( 'page', self::SETTINGS[ 'page' ], 'sites.php' ), 

			'cap' => 'manage_sites'
		];

		return $tabs;
	}

	public static function mc_siteinfo_page()
	{
		$handler = new self();

		add_submenu_page( '', 'Edit site', 'Edit site', 'manage_network_options', self::SETTINGS[ 'page' ], [ $handler, 'mc_siteinfo_page_render' ] );
	}

	public static function mc_siteinfo_page_args()
	{
		$id = absint( $_REQUEST[ 'id' ] );

		$site = MultisiteBlog::get_site( $id );

		return [
			'action' => self::SETTINGS[ 'action' ],

			'id' => $id,

			'title' => $site->blogname,

			'href-visit' => esc_url( get_home_url( $id, '/' ) ),

			'href-dashboard' => esc_url( get_admin_url( $id ) ),

			'network-edit-site-nav' => [
				'blog_id'  => $id,

				'selected' => self::SETTINGS[ 'tab' ],
			],
			
			'nonce'	=> self::NONCE[ 'check' ] . $id,

			'options' => [
				'mc-blog-language' => [
					'label' => 'MC Blog Language ( en )',

					'name' => self::OPTIONS[ 'blog-language' ],
					
					'value' => MultisiteBlog::get_blog_option( $id, self::OPTIONS[ 'blog-language' ] ),
				],

				'mc-blog-locale' => [
					'label' => 'MC Blog Locale ( en_GB )',

					'name' => self::OPTIONS[ 'blog-locale' ],

					'value' => MultisiteBlog::get_blog_option( $id, self::OPTIONS[ 'blog-locale' ] ),
				],

				'mc-blog-label' => [
                    'label' => 'MC Blog Label ( United Kingdom )',

					'name' => self::OPTIONS[ 'blog-label' ],

					'value' => MultisiteBlog::get_blog_option( $id, self::OPTIONS[ 'blog-label' ] ),
				] ,
			],
		];
	}

	const TEMPLATE = [
		'mc-siteinfo' => LegalMain::LEGAL_PATH . '/template-parts/multisite/part-multisite-mc-settings.php',

		'mc-siteinfo-notice' => LegalMain::LEGAL_PATH . '/template-parts/multisite/part-multisite-mc-settings-notice.php',
	];

	public static function mc_siteinfo_page_render()
	{
		echo LegalComponents::render_main( self::TEMPLATE[ 'mc-siteinfo' ], self::mc_siteinfo_page_args() );
	}

	public static function mc_siteinfo_save()
	{
		$id = absint( $_POST[ 'id' ] );

		check_admin_referer( self::NONCE[ 'check' ] . $id );

		foreach ( self::OPTIONS as $option )
		{
			// update_blog_option( $id, $option, sanitize_text_field( $_POST[ $option ] ) );

			MultisiteBlog::update_blog_option( $id, $option, $_POST[ $option ] );
		}

		wp_safe_redirect( 
			add_query_arg( 
				[
					'page' => self::SETTINGS[ 'page' ],

					'id' => $id,

					'updated' => 'true'
				],

				network_admin_url( 'sites.php' )
			)
		);

		exit;
	}

	public static function mc_siteinfo_notice_args()
	{
		return [
			'message' => 'Congratulations!',

			'button' => 'Dismiss this notice',
		];
	}

	public static function check_page()
	{
		return isset( $_GET[ 'page' ] )
		
			&& self::SETTINGS[ 'page' ] === $_GET[ 'page' ];
	}

	public static function check_state()
	{
		return isset( $_GET[ 'updated' ] );
	}

	public static function mc_siteinfo_notice_check()
	{
		return self::check_state()
		    
			&& self::check_page();
	}

	public static function mc_siteinfo_notice_render()
	{
		if( self::mc_siteinfo_notice_check() )
		{
			echo LegalComponents::render_main( self::TEMPLATE[ 'mc-siteinfo-notice' ], self::mc_siteinfo_notice_args() );
		}
	}

	public static function get_blog_language( $current_blog_id = 0 )
	{
		if ( empty( $current_blog_id ) )
		{
			$current_blog_id = MultisiteBlog::get_current_blog_id();
		}

        $blog_language = MultisiteBlog::get_blog_option( $current_blog_id, self::OPTIONS[ 'blog-language' ] );

        return $blog_language;
	}

	public static function get_blog_locale( $current_blog_id = 0 )
	{
		if ( empty( $current_blog_id ) )
		{
			$current_blog_id = MultisiteBlog::get_current_blog_id();
		}

        $blog_locale = MultisiteBlog::get_blog_option( $current_blog_id, self::OPTIONS[ 'blog-locale' ] );

        return $blog_locale;
	}
}

?>