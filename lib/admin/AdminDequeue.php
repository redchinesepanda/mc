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

		'wpml-tm-styles',

		'wpml-postEditTranslationEditor-ui',

		'wpml-dialog',

		'wpml-wizard',

		'admin-wpml',

		'sitepress-style',
	];

	const DEQUEUE_CSS_OTGS = [
		'otgs-dialogs',

		'otgs-icons',

		'otgs-notices',

		'otgsSwitcher',
	];

	const DEQUEUE_CSS_ACF = [
		'acf-global',

		'acf-input',

		'acf-pro-input',

		'acf-datepicker',

		'acf-timepicker',

		'select2',
	];

	const DEQUEUE_CSS_YOAST = [
		'yoast-seo-admin-global',

		'yoast-seo-primary-category',

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

	const DEQUEUE_CSS_AFFILIATE_LINKS = [
		'affiliate-links',
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

	const DEQUEUE_CSS = [
		...self::DEQUEUE_CSS_WPML,

		...self::DEQUEUE_CSS_OTGS,

		...self::DEQUEUE_CSS_ACF,

		...self::DEQUEUE_CSS_YOAST,

		...self::DEQUEUE_CSS_AFFILIATE_LINKS,

		...self::DEQUEUE_CSS_NOTION,

		...self::DEQUEUE_CSS_WP_OPTIMIZE,

		...self::DEQUEUE_CSS_SVG_SUPPORT,
	];

	public static function dequeue_admin_styles()
	{
		if ( self::check_affiliate_link() )
		{
			ToolEnqueue::dequeue_style( self::DEQUEUE_CSS_AFFILIATE_LINKS );
		}
	}

	public static function get_post_id()
	{
		if ( self::check_get_post() )
		{
			return $_GET[ 'post' ];
		}

		return null;
	}

	public static function check_get_post()
	{
		return !empty( $_GET[ 'post' ] );
	}

	// public static function check_post_type( $post_type = 'post' )
	// {
	// 	$post_id = null;

	// 	if ( !empty( $_GET[ 'post' ] ) )
	// 	{
	// 		$post_id = $_GET[ 'post' ];
	// 	}

	// 	return $post_type === get_post_type( $post_id );
	// }
	
	public static function check_post_type( $post_type, $post_id = null )
	{
		if ( empty( $post_id ) )
		{
			$post_id = get_post_id();
		}

		return $post_type === get_post_type( $post_id );
	}

	public static function check_pagenow( $page = 'post.php' )
	{
		global $pagenow;

		return $page === $pagenow;
	}

	public static function check_affiliate_link()
	{
		return self::check_pagenow()
			
			&& self::check_post_type( 'affiliate-links' );
			
			// && self::check_get_post();
	}
}

?>