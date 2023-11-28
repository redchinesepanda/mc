<?php

class ReviewContent
{
	public static function get()
    {
        return [
			'content' => apply_filters( 'the_content', get_the_content() ),
		];
    }

	const TEMPLATE = [
        'review-content' => LegalMain::LEGAL_PATH . '/template-parts/review/review-content.php',
    ];

    public static function render()
    {
		// if ( !BonusMain::check() )
        // {
        //     return '';
        // }

        ob_start();

        load_template( self::TEMPLATE[ 'review-content' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>