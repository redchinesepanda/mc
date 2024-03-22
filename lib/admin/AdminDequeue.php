<?php

class AdminDequeue
{
	public static function register()
	{
        $handler = new self();

		add_action( 'admin_print_styles', [ $handler, 'dequeue_admin_styles' ] );
    }

	const DEQUEUE_CSS = [
		'wpml-select-2',

		'smush',

		'acf-global',

		'affiliate-links',

		'mediaelement',

		'wp-mediaelement',

		'imgareaselect',

		'bodhi-svgs-admin-edit-post',

		'CSS-for-multiselect',

		'wp-optimize-global',

		'wpml-tm-styles',

		'wpml-postEditTranslationEditor-ui',

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

		'admin-wpml',

		'notion-wp-sync-admin-select2',

		'notion-wp-sync-admin',

		'yoast-seo-adminbar',

		'wp-emoji-styles',

		'sitepress-style',

		'otgs-dialogs',

		'wpml-dialog',

		'otgs-icons',

		'wpml-wizard',

		'thickbox',

		'otgs-notices',

		'acf-input',

		'acf-pro-input',

		'select2',

		'acf-datepicker',

		'acf-timepicker',

		'otgsSwitcher',

		
	];

	public static function dequeue_admin_styles()
	{
		ToolEnqueue::dequeue_style( self::DEQUEUE_CSS );
	}
}

?>