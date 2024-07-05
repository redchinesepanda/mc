<?php

class ReviewPage
{
    // const CSS = [
    //     'review-page' => [
    //         'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-page.css',

    //         'ver'=> '1.0.0',
    //     ],
    // ];

    const CSS_NEW = [
        'review-page' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-page-new.css',

            'ver'=> '1.0.0',
        ],
    ];

    public static function register_style()
    {
        if ( TemplatePage::check_review() )
        {
            if ( TemplateMain::check_new() )
            {
                ReviewMain::register_style( self::CSS_NEW );
            }
        }
    }

	public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'init', [ $handler, 'enable_post_tags_for_pages' ] );
    }

    function enable_post_tags_for_pages()
    {  
        register_taxonomy_for_object_type( 'post_tag', 'page' );

        // register_taxonomy_for_object_type( 'category', 'page' );  
    }

	const TEMPLATE = [
        'main' => LegalMain::LEGAL_PATH . '/template-parts/review/review-page.php',

        'new' => LegalMain::LEGAL_PATH . '/template-parts/review/review-page-new.php',
    ];

    public static function render()
    {
        if ( TemplateMain::check_new() )
        {
            return self::render_main( self::TEMPLATE[ 'new' ], [] );
        }

        return self::render_main( self::TEMPLATE[ 'main' ], [] );
    }

    public static function render_main( $template, $args )
    {
        ob_start();

        load_template( $template, false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>