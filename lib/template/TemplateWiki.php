<?php

class TemplateWiki
{
	const CATEGORY = [
        'wiki-tag',
    ];

	public static function check()
    {
        return has_category( self::CATEGORY );
    }

	const TEMPLATE = [
        'legal-template-wiki' => LegalMain::LEGAL_PATH . '/template-parts/template/legal-template-wiki.php',
    ];

	public static function render()
    {
		if ( !self::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'legal-template-wiki' ], false, [] );

        $output = ob_get_clean();

        return $output;
    }
}

?>