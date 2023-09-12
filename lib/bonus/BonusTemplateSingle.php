<?php

class BonusTemplateSingle
{
	const TEMPLATE = [
        'legal-bonus-single' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus-single.php',
    ];

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE[ 'legal-bonus-single' ], false, [] );

        $output = ob_get_clean();

        return $output;
    }
}

?>