<?php

class ReviewTitle
{
	const CSS = [
        'review-title' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-title.css',

            'ver' => '1.0.2',
        ],
    ];

	public static function register_style( $styles = [] )
    {
        ReviewMain::register_style( self::CSS );
    }

	public static function register()
    {
        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_header' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_header_date' ] );

		add_filter( 'the_content', [ $handler, 'modify_content' ] );
    }

	const CLASSES = [
		'date-year' => 'legal-header-year',

		'date-month-year' => 'legal-header-month-year',

		'h3' => 'legal-header-3',

		'history' => 'legal-header-history',

		'features' => 'legal-header-features',

		'football' => 'legal-header-football',

		'tennis' => 'legal-header-tennis',

		'basketball' => 'legal-header-basketball',

		'horceracing' => 'legal-header-horceracing',

		'deposit' => 'legal-header-deposit',

		'widthdraw' => 'legal-header-widthdraw',

		'esports' => 'legal-header-esports',
	];

	const FORMAT = [
        self::CLASSES[ 'date-year' ] => 'y',

        self::CLASSES[ 'date-month-year' ] => 'MMMM y',
        
		// self::CLASSES[ 'date-month-year' ] => 'LLLL y',
    ];

    public static function get_date( $node )
    {
		$current = new DateTime();

		$format = self::FORMAT[ self::CLASSES[ 'date-year' ] ];

		$classes = explode( ' ', $node->getAttribute( 'class' ) );

		foreach ( $classes as $class )
		{
			if ( array_key_exists( $class, self::FORMAT ) )
			{
				$format = self::FORMAT[ $class ];

				break;
			}
		}
		
		$locale = WPMLMain::get_locale();

		$formatter = new IntlDateFormatter( $locale, IntlDateFormatter::FULL, IntlDateFormatter::SHORT);

		$formatter->setPattern( $format );
		
		return $formatter->format( $current );

		// $result = $formatter->format( $current );

		// $result[ 0 ] = mb_strtoupper( $result[ 0 ] );

		// return $result;
    }

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );
		
		return $xpath->query( '//*[contains(@class, \'' . self::CLASSES[ 'date-year' ] . '\')] | //*[contains(@class, \'' . self::CLASSES[ 'date-month-year' ] . '\')]' );
	}

	public static function modify_content( $content )
	{
		if ( !ReviewMain::check() ) {
			return $content;
		}

		$dom = LegalDOM::get_dom( $content );

        $nodes = self::get_nodes( $dom );

		if ( $nodes->length == 0 ) {
			return $content;
		}

		foreach ( $nodes as $id => $node )
		{
			$date = self::get_date( $node );

			$node->textContent = $node->textContent . ' ' . $date;
		}

		return $dom->saveHTML();
	}

	public static function style_formats_header( $settings )
	{
		return ToolTinyMCE::style_formats_check( $settings, [
			[
				'title' => 'Title with Image',

				'items' => [
					[
						'title' => 'H3 History',
						
						'selector' => 'h3',

						'classes' => self::CLASSES[ 'h3' ] . ' ' . self::CLASSES[ 'history' ],
					],

					[
						'title' => 'H3 Features',
						
						'selector' => 'h3',

						'classes' => self::CLASSES[ 'h3' ] . ' ' . self::CLASSES[ 'features' ],
					],

					[
						'title' => 'H3 Football',
						
						'selector' => 'h3',

						'classes' => self::CLASSES[ 'h3' ] . ' ' . self::CLASSES[ 'football' ],
					],

					[
						'title' => 'H3 Tennis',
						
						'selector' => 'h3',

						'classes' => self::CLASSES[ 'h3' ] . ' ' . self::CLASSES[ 'tennis' ],
					],

					[
						'title' => 'H3 Basketball',
						
						'selector' => 'h3',

						'classes' => self::CLASSES[ 'h3' ] . ' ' . self::CLASSES[ 'basketball' ],
					],

					[
						'title' => 'H3 Horceracing',
						
						'selector' => 'h3',

						'classes' => self::CLASSES[ 'h3' ] . ' ' . self::CLASSES[ 'horceracing' ],
					],

					[
						'title' => 'H3 Deposit',
						
						'selector' => 'h3',

						'classes' => self::CLASSES[ 'h3' ] . ' ' . self::CLASSES[ 'deposit' ],
					],

					[
						'title' => 'H3 Widthdraw',
						
						'selector' => 'h3',

						'classes' => self::CLASSES[ 'h3' ] . ' ' . self::CLASSES[ 'widthdraw' ],
					],

					[
						'title' => 'H3 E-Sports',
						
						'selector' => 'h3',

						'classes' => self::CLASSES[ 'h3' ] . ' ' . self::CLASSES[ 'esports' ],
					],
				],
			],
		] );
	}

	public static function style_formats_header_date( $settings )
	{
		return ToolTinyMCE::style_formats_check( $settings, [
			[
				'title' => 'Title other',

				'items' => [
					[
						'title' => 'H1-H2 Year',
						
						'selector' => 'h1,h2',

						'classes' => self::CLASSES[ 'date-year' ],
					],

					[
						'title' => 'H1-H2 Month Year',
						
						'selector' => 'h1,h2',

						'classes' => self::CLASSES[ 'date-month-year' ],
					],
				],
			],
		] );
	}
}

?>