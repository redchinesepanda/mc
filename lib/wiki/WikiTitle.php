<?php

class WikiTitle
{
	const CSS = [
        'wiki-about' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/wiki/legal-wiki-title.css',

            'ver'=> '1.0.2',
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

	public static function get()
	{
		$post = get_post();

		if ( !empty( $post ) )
		{
			$published_datetime = get_post_datetime( $post->ID );

			return [
				'title' => $post->post_title,
	
				'date' => __( WikiMain::TEXT[ 'publication-date' ], ToolLoco::TEXTDOMAIN ) . ': ' . $published_datetime->format( 'd/m/Y' ),
			];
		}

		return [];
	}

	const TEMPLATE = [
        'wiki-title' => LegalMain::LEGAL_PATH . '/template-parts/wiki/part-legal-wiki-title.php',
    ];

    public static function render()
    {
		if ( !WikiMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'wiki-title' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>