<?php

class ReviewContent
{
	public static function get()
    {
        $content = '';

        if ( !empty( $post = get_post() ) )
        {
            $content = apply_filters( 'the_content', $post->post_content );

            $content = CompilationTabsLink::modify_content( $content );
        }

        return [
			'content' => $content,
		];
    }

	const TEMPLATE = [
        'main' => LegalMain::LEGAL_PATH . '/template-parts/review/review-content.php',
    ];

    public static function render()
    {
		return LegalComponents::render_main( self::TEMPLATE[ 'main' ], self::get() );
    }
}

?>