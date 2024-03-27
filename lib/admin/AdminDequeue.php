<?php

class AdminDequeue
{
	public static function register()
	{
        $handler = new self();

		add_action( 'admin_print_styles', [ $handler, 'dequeue_admin_styles' ] );
    }

	const DEQUEUE_CSS_WPML = [
		'wpml-select-2',

		'wpml-postEditTranslationEditor-ui',

		'wpml-wizard',

		'admin-wpml',

		'sitepress-style',

		// not dequeued

		'wpml-tm-styles',

		'wpml-dialog',
	];

	const DEQUEUE_CSS_WPML_OTGS = [

		'otgs-icons',

		'otgs-notices',

		// not dequeued

		'otgs-dialogs',

		'otgsSwitcher',
	];

	const DEQUEUE_CSS_ACF_ADMIN = [
		'acf-global',
	];

	const DEQUEUE_CSS_ACF_DATE_TIME_TICKER = [
		'acf-datepicker',

		'acf-timepicker',
	];

	const DEQUEUE_CSS_ACF_FIELDS = [
		'acf-input',
	];

	const DEQUEUE_CSS_ACF_REPEATER = [
		'acf-pro-input',
	];
	
	const DEQUEUE_CSS_ACF_SELECT = [
		'select2',
	];

	const DEQUEUE_CSS_ACF = [
		...self::DEQUEUE_CSS_ACF_ADMIN,

		...self::DEQUEUE_CSS_ACF_DATE_TIME_TICKER,

		...self::DEQUEUE_CSS_ACF_FIELDS,

		...self::DEQUEUE_CSS_ACF_REPEATER,

		...self::DEQUEUE_CSS_ACF_SELECT,
	];

	const DEQUEUE_CSS_YOAST_ADMIN = [
		'yoast-seo-admin-global',

		'yoast-seo-dismissible',

		'yoast-seo-toggle-switch',

		'yoast-seo-admin-css',

		'yoast-seo-tailwind',

		'yoast-seo-metabox-css',

		'yoast-seo-scoring',

		'yoast-seo-monorepo',

		'yoast-seo-introductions',

		'yoast-seo-ai-generator',

		'yoast-seo-featured-image',

		'yoast-seo-adminbar',
	];

	const DEQUEUE_CSS_YOAST_WIDGET = [
		'yoast-seo-primary-category',

	];

	const DEQUEUE_CSS_YOAST = [
		...self::DEQUEUE_CSS_YOAST_ADMIN,

		...self::DEQUEUE_CSS_YOAST_WIDGET,
	];

	const DEQUEUE_CSS_AFFILIATE_LINKS = [
		'affiliate-links-css',
	];

	const DEQUEUE_CSS_NOTION = [
		'notion-wp-sync-admin-select2',

		'notion-wp-sync-admin',
	];

	const DEQUEUE_CSS_WP_OPTIMIZE = [
		'wp-optimize-global',

		'smush-css',
	];

	const DEQUEUE_CSS_SVG_SUPPORT = [
		'CSS-for-multiselect',

		'bodhi-svgs-admin-edit-post',
	];

	const DEQUEUE_CSS_WP = [
		'mediaelement',

		'wp-mediaelement',

		'imgareaselect',

		'wp-emoji-styles',

		'thickbox',

	];

	// const DEQUEUE_CSS = [
	// 	...self::DEQUEUE_CSS_WPML,

	// 	...self::DEQUEUE_CSS_WPML_OTGS,

	// 	...self::DEQUEUE_CSS_ACF,

	// 	...self::DEQUEUE_CSS_YOAST,

	// 	...self::DEQUEUE_CSS_AFFILIATE_LINKS,

	// 	...self::DEQUEUE_CSS_NOTION,

	// 	...self::DEQUEUE_CSS_WP_OPTIMIZE,

	// 	...self::DEQUEUE_CSS_SVG_SUPPORT,
	// ];

	public static function dequeue_admin_styles()
	{
		self::dequeue_affiliate_links();

		self::dequeue_notion();

		self::dequeue_wpml();

		// self::dequeue_acf();

		self::dequeue_yoast();
	}

	public static function dequeue_affiliate_links()
	{
		if ( !self::check_affiliate_link() )
		{
			ToolEnqueue::dequeue_style( self::DEQUEUE_CSS_AFFILIATE_LINKS );
		}
	}

	public static function dequeue_notion()
	{
		if ( !self::check_notion() )
		{
			ToolEnqueue::dequeue_style( self::DEQUEUE_CSS_NOTION );
		}
	}

	public static function dequeue_wpml()
	{
		// if ( !self::check_wpml() )
		// {
			ToolEnqueue::dequeue_style( self::DEQUEUE_CSS_WPML );

			ToolEnqueue::dequeue_style( self::DEQUEUE_CSS_WPML_OTGS );
		// }
	}

	public static function dequeue_acf()
	{
		// ToolEnqueue::dequeue_style( self::DEQUEUE_CSS_ACF );

		// LegalDebug::debug( [
		// 	'AdminDequeue' => 'dequeue_acf',

		// 	'check_acf_admin' => self::check_acf_admin(),

		// 	'check_post_edit' => self::check_post_edit(),
		// ] );

		// ToolEnqueue::dequeue_style( self::DEQUEUE_CSS_ACF_ADMIN );

		if ( !self::check_acf_admin() )
		{
			ToolEnqueue::dequeue_style( self::DEQUEUE_CSS_ACF_ADMIN );
		}

		if ( self::check_acf_admin() )
		{
			ToolEnqueue::dequeue_style( self::DEQUEUE_CSS_ACF_DATE_TIME_TICKER );

			ToolEnqueue::dequeue_style( self::DEQUEUE_CSS_ACF_FIELDS );

			ToolEnqueue::dequeue_style( self::DEQUEUE_CSS_ACF_REPEATER );

			ToolEnqueue::dequeue_style( self::DEQUEUE_CSS_ACF_SELECT );
		}

		if ( !self::check_post_edit() )
		{
			ToolEnqueue::dequeue_style( self::DEQUEUE_CSS_ACF_DATE_TIME_TICKER );
		}
	}

	public static function dequeue_yoast()
	{
		// LegalDebug::debug( [
		// 	'AdminDequeue' => 'dequeue_yoast',

		// 	// 'check_yoast_admin' => self::check_yoast_admin(),

		// 	'check_post_edit' => self::check_post_edit(),
        // ] );

		// ToolEnqueue::dequeue_style( self::DEQUEUE_CSS_YOAST );

		// if ( !self::check_yoast_admin() )
		// {
		// 	ToolEnqueue::dequeue_style( self::DEQUEUE_CSS_YOAST_WIDGET );
		// }

		if ( self::check_post_edit() )
		{
			ToolEnqueue::dequeue_style( self::DEQUEUE_CSS_YOAST_ADMIN );
		}
	}

	const ARGS = [
		'post' => 'post',

		'page' => 'page',

		'post-type' => 'post_type',
	];

	public static function get_post_type()
	{
		if ( self::check_get_post_type() )
		{
			return $_GET[ self::ARGS[ 'post-type' ] ];
		}

		return null;
	}

	public static function check_get_post_type()
	{
		return !empty( $_GET[ self::ARGS[ 'post-type' ] ] );
	}

	public static function get_post_id()
	{
		if ( self::check_get_post() )
		{
			return $_GET[ self::ARGS[ 'post' ] ];
		}

		return null;
	}

	public static function check_get_post()
	{
		return !empty( $_GET[ self::ARGS[ 'post' ] ] );
	}
	
	public static function check_post_type( $post_type_check, $post_type_current = '', $post_id = null )
	{
		if ( empty( $post_id ) )
		{
			$post_id = self::get_post_id();
		}

		if ( empty( $post_type_current ) )
		{
			$post_type_current = get_post_type( $post_id );
		}

		return $post_type_check === $post_type_current;
	}

	public static function check_pagenow( $page = self::PAGENOW[ 'page' ] )
	{
		global $pagenow;

		return $page === $pagenow;
	}

	const POST_TYPE = [
		'affiliate' => 'affiliate-links',

		'notion' => 'ntwpsync-connection',

		'acf' => 'acf-field-group',

		'post' => 'post',
		
		'page' => 'page',
    ];

	const PAGENOW = [
		'post' => 'post.php',
		
		'edit' => 'edit.php',

		'admin' => 'admin.php',
	];

	public static function check_affiliate_link()
	{
		return self::check_pagenow( self::PAGENOW[ 'post' ] )
			
			&& self::check_post_type( self::POST_TYPE[ 'affiliate' ] );
	}

	public static function check_notion()
	{
		return self::check_pagenow( self::PAGENOW[ 'edit' ] )
			
			&& self::check_post_type( self::POST_TYPE[ 'notion' ], self::get_post_type() )
			
			|| self::check_pagenow( self::PAGENOW[ 'post' ] )
			
			&& self::check_post_type( self::POST_TYPE[ 'notion' ] );
	}

	public static function check_acf_edit()
	{
		return self::check_pagenow( self::PAGENOW[ 'post' ] )
			
			&& self::check_post_type( self::POST_TYPE[ 'acf' ] );
	}

	public static function check_acf_list()
	{
		return self::check_pagenow( self::PAGENOW[ 'edit' ] )
			
			&& self::check_post_type( self::POST_TYPE[ 'acf' ], self::get_post_type() );
	}

	public static function check_acf_admin()
	{
		return self::check_acf_edit()
			
			|| self::check_acf_list();
	}

	public static function check_post_edit()
	{
		return self::check_pagenow( self::PAGENOW[ 'post' ] )
			
			&& self::check_post_type( self::POST_TYPE[ 'post' ] );
	}

	// public static function check_yoast_admin()
	// {
	// 	return self::check_acf_edit()
			
	// 		|| self::check_acf_list();
	// }
}

?>