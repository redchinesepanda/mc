<?php

class ReviewContent
{
	public static function get()
    {
        $content = apply_filters( 'the_content', get_the_content() );

        $content = CompilationTabsLink::modify_content( $content );

        return [
			'content' => $content,
		];
    }

	const TEMPLATE = [
        'review-content' => LegalMain::LEGAL_PATH . '/template-parts/review/review-content.php',
    ];

    public static function render()
    {
		ob_start();

        load_template( self::TEMPLATE[ 'review-content' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>