<?php

class TemplateNotFound
{
	const TEMPLATE = [
        'legal-template-notfound' => LegalMain::LEGAL_PATH . '/template-parts/template/legal-template-notfound.php',
    ];

	public static function render()
    {
		ob_start();
		
		load_template( self::TEMPLATE[ 'legal-template-notfound' ], false, [] );

        $output = ob_get_clean();

        return $output;
    }
}

?>