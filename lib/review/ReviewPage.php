<?php

class ReviewPage
{
    const CSS = [
        'review-page' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-page.css',

            'ver'=> '1.0.0',
        ],
    ];

    public static function register_style()
    {
        ReviewMain::register_style( self::CSS );
    }

	public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	const TEMPLATE = [
        'legal-review-page' => LegalMain::LEGAL_PATH . '/template-parts/review/review-page.php',
    ];

    public static function render()
    {
        // if ( !BonusMain::check() )
        // {
        //     return '';
        // }

        ob_start();

        load_template( self::TEMPLATE[ 'legal-review-page' ], false, [] );

        $output = ob_get_clean();

        return $output;
    }
}

?>