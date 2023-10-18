<?php

class TemplateWiki
{
    const CSS = [
        'legal-template-wiki' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/template/template-wiki.css',

			'ver' => '1.0.7',
		],
    ];

	public static function register_style()
    {
        ToolEnqueue::register_style( self::CSS );
    }

	public static function register()
    {
        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	// const CATEGORY = [
    //     'wiki-tag',
    // ];

	// const TAXONOMY = [
    //     'type' => 'page_type',
    // ];

	// const PAGE_TYPE = [
    //     'wiki' => 'legal-wiki',
    // ];

	// public static function check_post_type()
    // {
    //     return is_singular( 'post' );
    // }

	// public static function check_page_type()
    // {
    //     return has_term( self::PAGE_TYPE[ 'wiki' ], self::TAXONOMY[ 'type' ] );
    // }

	// public static function check_not_page_type()
    // {
    //     return !has_term( self::PAGE_TYPE[ 'wiki' ], self::TAXONOMY[ 'type' ] );
    // }

	// public static function check_category()
    // {
    //     return has_category( self::CATEGORY );
    // }

	// public static function check_thrive()
    // {
    //     return self::check_post_type() && self::check_category() && self::check_not_page_type();
    // }

    // public static function check()
    // {
    //     return self::check_post_type() && self::check_category() && self::check_page_type();
    // }

	const TEMPLATE = [
        'legal-template-wiki' => LegalMain::LEGAL_PATH . '/template-parts/template/legal-template-wiki.php',

        'legal-template-wiki-thrive' => LegalMain::LEGAL_PATH . '/template-parts/template/legal-template-wiki-thrive.php',
    ];

	public static function render_wiki()
    {
		if ( !WikiMain::check() )
        {
            return '';
        }

        return self::render_main( self::TEMPLATE[ 'legal-template-wiki' ] );
    }

	public static function render_wiki_thrive()
    {
		if ( !WikiMain::check_thrive() )
        {
            return '';
        }

        return self::render_main( self::TEMPLATE[ 'legal-template-wiki-thrive' ] );
    }

	public static function render_main( $template, $args = [] )
    {
        ob_start();

        load_template( $template, false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>