<?php

class WikiContent
{
	const CSS = [
        'wiki-content' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-wiki-content.css',

            'ver'=> '1.0.0',
        ],
    ];

    public static function register_style()
    {
        WikiMain::register_style( self::CSS );
    }

	public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

    public static function get_content()
    {
        ob_start();

        the_content();

        $output = ob_get_clean();

        return $output;
    }

	public static function get()
    {
        $post = get_post();
        
		if ( empty( $post ) )
		{
			return [];
        }

		return [
			// 'content' => apply_filters( 'the_content', $post->post_content ),
			
            'content' => self::get_content(),
		];
    }

	const TEMPLATE = [
        'wiki-content' => LegalMain::LEGAL_PATH . '/template-parts/wiki/part-legal-wiki-content.php',
    ];

    public static function render()
    {
        if ( !WikiMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'wiki-content' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>