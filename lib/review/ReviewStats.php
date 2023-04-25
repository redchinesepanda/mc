<?php

class ReviewStats
{
    const CSS = [
        'review-stats' => LegalMain::LEGAL_URL . '/assets/css/review/review-stats.css',
    ];

    public static function register_style()
    {
        foreach ( self::CSS as $name => $path ) {
            wp_enqueue_style( $name, $path );
        }
    }

    public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		// [legal-stats]

		add_shortcode( 'legal-stats', [ $handler, 'render' ] );
    }

    const FIELD = 'review-stats';

    const ITEM_TITLE = 'item-title';
    
	const ITEM_VALUE = 'item-value';

    const ITEM_DESCRIPTION = 'item-description';

    public static function get()
    {
        $faqs = get_field( self::FIELD );
        
        if ( $faqs ) {
			foreach( $faqs as $key => $faq ) {
				$args[] = [
					'title' => $faq[ self::ITEM_TITLE ],

					'value' => $faq[ self::ITEM_VALUE ],

					'description' => $faq[ self::ITEM_DESCRIPTION ],

					'width' => round( ( ( float ) $faq[ self::ITEM_VALUE ] ) / 10 ) * 100,
				];
			}

			LegalDebug::debug( [
				'float' => ( ( float ) $faq[ self::ITEM_VALUE ] ),

				'round' => round( ( float ) $faq[ self::ITEM_VALUE ] ),

				'10' => ( float ) $faq[ self::ITEM_VALUE ] ) / 10,

				'100' => round( ( ( float ) $faq[ self::ITEM_VALUE ] ) / 10 ) * 100,
			] );

			return $args;
		}

        return [];
    }

    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/review/review-stats.php';

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE, false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>