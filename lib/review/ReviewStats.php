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

		add_filter( 'the_content', [ $handler, 'get_content' ] );
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

					'width' => ( round( ( float ) $faq[ self::ITEM_VALUE ] ) / 10 ) * 100,
				];
			}

			return $args;
		}

        return [];
    }

    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/review/review-stats-table.php';

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE, false, self::get() );

        $output = ob_get_clean();

        return $output;
    }

	const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/review/review-stats.php';

    public static function render_stats( $node )
    {
        ob_start();

        load_template( self::TEMPLATE, false, self::get_stats( $node ) );

        $output = ob_get_clean();

        return $output;
    }

	public static function get_content( $content )
	{
		$dom = new DOMDocument();

		$dom->loadHTML( $content, LIBXML_NOERROR );

		$xpath = new DOMXPath( $dom );

		$nodes = $xpath->query( './/*[contains(@class, \'legal-stats\')]' );

		if ( $nodes->length == 0 ) {
			return $content;
		}

		foreach ( $nodes as $node ) {
			$node->insertBefore( self::render_stats( $node ) );
		}

		return $dom->saveHTML();
	}

	public static function get_stats ( $node )
	{
		$args = [];

		$tbodies = $container->getElementsByTagName( 'tbody ');

		if ( $tbodies->length ) {
			$tbody = $tbodies[ 0 ];

			foreach ( $tbody->getElementsByTagName( 'tr' ) as $tr ) {
				$cells = $tr->getElementsByTagName( 'td' );
				
				if ( $tbodies->length ) {
					$args[] = [
						'title' => $cells[ 0 ]->textContent,

						'width' => ( round( ( float ) $cells[ 1 ]->textContent ) / 10 ) * 100,
		
						// 'value' => $cells[ 1 ]->textContent,
		
						// 'description' => $cells[ 2 ]->textContent,
					];
				}
			}
		}

		return $args;
	}
}

?>