<?php

class TemplateWiki
{
	const CATEGORY = [
        'wiki-tag',
    ];

	const TAXONOMY = [
        'type' => 'page_type',
    ];

	const PAGE_TYPE = [
        'wiki' => 'legal-wiki',
    ];

	public static function check_post_type()
    {
        return is_singular( 'post' );
    }

	public static function check_page_type()
    {
        return has_term( self::PAGE_TYPE[ 'wiki' ], self::TAXONOMY[ 'type' ] );
    }

	public static function check_not_page_type()
    {
        return !has_term( self::PAGE_TYPE[ 'wiki' ], self::TAXONOMY[ 'type' ] );
    }

	public static function check_category()
    {
        return has_category( self::CATEGORY );
    }

	public static function check_thrive()
    {
        return self::check_post_type() && self::check_category() && self::check_not_page_type();
    }

    public static function check()
    {
        return self::check_post_type() && self::check_category() && self::check_page_type();
    }

	const TEMPLATE = [
        'legal-template-wiki-thrive' => LegalMain::LEGAL_PATH . '/template-parts/template/legal-template-wiki-thrive.php',

        'legal-template-wiki' => LegalMain::LEGAL_PATH . '/template-parts/template/legal-template-wiki.php',
    ];

	public static function render_wiki()
    {
		if ( !self::check() )
        {
            return '';
        }

        return render_main( self::TEMPLATE[ 'legal-template-wiki' ] );
    }

	public static function render_wiki_thrive()
    {
		if ( !self::check_thrive() )
        {
            return '';
        }

        return render_main( self::TEMPLATE[ 'legal-template-wiki-thrive' ] );
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