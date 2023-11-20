<?php

class TemplatePage
{
	const TEMPLATE = [
        'legal-template-page' => LegalMain::LEGAL_PATH . '/template-parts/template/legal-template-page.php',
    ];

	public static function render()
    {
		// if ( !BonusMain::check() )
        // {
        //     return '';
        // }

        ob_start();
		
		load_template( self::TEMPLATE[ 'legal-template-page' ], false, [] );

        $output = ob_get_clean();

        return $output;
    }
}

?>