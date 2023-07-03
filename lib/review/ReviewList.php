<?php

class ReviewList
{
    const CSS = [
        'review-list' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-list.css',

            'ver' => '1.0.4',
        ],
    ];

    public static function register_style()
    {
        ReviewMain::register_style( self::CSS );
    }

    public static function register_inline_style()
    {
		if ( ReviewMain::check() ) {
			ToolEnqueue::register_inline_style( 'legal-notfound', self::inline_style() );
		}
    }

    public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );
    }

    public static function inline_style() {
		$style = [];

		$args = self::get_lists();

		if ( empty( $args ) ) {
			return '';
		}

        LegalDebug::debug( [
            'args' => $args,
        ] );

		// $style_items = array_merge( $args[ 'languages' ], [ $args[ 'active' ] ] );

		// foreach ( $style_items as $style_item ) {
		// 	$style[] = '.locale-' . $style_item[ 'id' ] . ' {
		// 		background-image: url(' . $style_item[ 'src' ] . ');
		// 	}';
		// }

		return implode( ' ', $style );
	}

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );

        return $xpath->query( './/ul[contains(@class, \'' . self::CLASSES[ 'base' ] . '\')]' );
	}

    public static function get_lists()
    {
        $post = get_post();

		if ( empty( $post ) ) {
			return [];
		}

		$dom = LegalDOM::get_dom( $post->post_content );

        return self::get_nodes( $dom );
    }

    const CLASSES = [
        'list-3' => 'legal-list-3',

        'list-4' => 'legal-list-4',

        'base' => 'legal-list-image',
    ];

    public static function style_formats_list( $settings )
	{
		return ToolTinyMCE::style_formats_check( $settings, [
			[
				'title' => 'List',

				'items' => [
					[
						'title' => 'List 3 Columns',
						
						'selector' => 'ul,ol',

						'classes' => self::CLASSES[ 'list-3' ],
					],
					[
						'title' => 'List 4 Columns',
						
						'selector' => 'ul,ol',

						'classes' => self::CLASSES[ 'list-4' ],
					],
					[
						'title' => 'List With Image',
						
						'selector' => 'ul',

						'classes' => self::CLASSES[ 'base' ],
					],
				],
			],
		] );
	}
}

?>