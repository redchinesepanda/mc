<?php

class ReviewFAQ
{
    const CSS = [
        'review-faq' => LegalMain::LEGAL_URL . '/assets/css/review/review-faq.css',
    ];

    public static function register_style()
    {
        foreach ( self::CSS as $name => $path ) {
            wp_enqueue_style( $name, $path );
        }
    }

    const JS = [
        'review-faq' => LegalMain::LEGAL_URL . '/assets/js/review/review-faq.js',
    ];

    public static function register_script()
    {
        foreach ( self::JS as $name => $path ) {
            wp_register_script( $name, $path, [], false, true );

            wp_enqueue_script( $name );
        }
    }

    public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
    }

    const FIELD = 'review-faq';

    const ITEM_TITLE = 'item-title';

    const ITEM_CONTENT = 'item-content';

    public static function get()
    {
        $faqs = get_field( self::FIELD );
        
        if ( $faqs ) {
			foreach( $faqs as $key => $faq ) {
				$args[] = [
					'title' => $faq[ self::ITEM_TITLE ],

					'content' => $faq[ self::ITEM_CONTENT ],
				];
			}

			return $args;
		}

        return [];
    }

    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/review/review-faq.php';

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE, false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>