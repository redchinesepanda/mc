<?php

class ReviewContent
{
	// const CSS = [
    //     'bonus-content' => [
    //         'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-content.css',

    //         'ver'=> '1.0.1',
    //     ],
    // ];

    // public static function register_style()
    // {
    //     BonusMain::register_style( self::CSS );
    // }

	// public static function register()
    // {
    //     $handler = new self();

    //     add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    // }

	// const FIELD = [
	// 	'bonus-content' => 'text-bonus',
	// ];

    // const ALLOWED = [
    //     'a',

    //     'h2',

    //     'h3',

    //     'h4',

    //     'p',

    //     'div',

    //     'ul',

    //     'ol',

    //     'li',

    //     'table',

    //     'th',

    //     'tr',

    //     'td',

    //     'strong',
    // ];

	public static function get()
    {
        $post = get_post();

        $content = '';
        
		if ( !empty( $post ) )
		{
			$content = $post->post_conntent;
        }

		return [
			'content' => $content,
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