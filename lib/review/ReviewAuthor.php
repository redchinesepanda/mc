<?php

class ReviewAuthor
{
    const CSS = [
        'review-author' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-author.css',

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

        // [legal-author]

        add_shortcode( 'legal-author', [ $handler, 'render' ] );
    }

    public static function get( $args )
    {
        return [
			'name' => __( 'Valentin Axani', ToolLoco::TEXTDOMAIN ),

			'duty' => __( 'Website Manager', ToolLoco::TEXTDOMAIN ),

			'file' => 'valentin-axani.webp',
		];
    }

    const TEMPLATE = [
		'review-author' =>  LegalMain::LEGAL_PATH . '/template-parts/review/review-button.php',
	];

    public static function render( $args )
    {
        ob_start();

        load_template( self::TEMPLATE[ 'review-author' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>