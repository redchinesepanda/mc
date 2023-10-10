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

	const PLACEHOLDER = [
		'{YEAR}' => self::CLASSES[ 'date-year' ],

		'{MONTH_YEAR}' => self::CLASSES[ 'date-month-year' ],
	];

	public static function check_placeholder( $content )
	{
		$needles = array_keys( self::PLACEHOLDER );

		return array_reduce( $needles , fn( $a, $n ) => $a || str_contains( $content, $n ), false );
	}

    public static function replace_placeholder( $title )
	{
		$current_date = '';

		$current_placeholder = '';

		// LegalDebug::debug( [
		// 	'function' => 'ReviewTitle::replace_placeholder',

		// 	'title' => $title,
		// ] );

		foreach ( self::PLACEHOLDER as $placeholder => $format_key )
		{
			// LegalDebug::debug( [
			// 	'function' => 'ReviewTitle::replace_placeholder',

			// 	'placeholder' => $placeholder,

			// 	'strpos' => strpos( $title, $placeholder ),
			// ] );

			if ( strpos( $title, $placeholder ) !== false )
			{
				$current_date = self::format_date( self::FORMAT[ $format_key ] );

				$current_placeholder = $placeholder;

				// LegalDebug::debug( [
				// 	'function' => 'ReviewTitle::replace_placeholder',
	
				// 	'current_date' => $current_date,
	
				// 	'current_placeholder' => $current_placeholder,
				// ] );

				$title = str_replace( $current_placeholder, $current_date, $title );
			}
		}

		return $title;
	}

    public static function get_format( $node )
	{
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

		return $format;
	}

	const LOCALE = [
		'sr_RS' => 'sr_Latn',
	];

	public static function format_date( $format )
	{
		$locale = WPMLMain::get_locale();

		if ( array_key_exists( $locale, self::LOCALE ) )
		{
			$locale = self::LOCALE[ $locale ];
		}

		$current = new DateTime();

		$formatter = new IntlDateFormatter( $locale, IntlDateFormatter::FULL, IntlDateFormatter::SHORT);

		$formatter->setPattern( $format );

		$result = mb_str_split( $formatter->format( $current ) );

		$result[ 0 ] = mb_strtoupper( $result[ 0 ] );

		return implode( '', $result );
	}

    public static function get_date( $node )
    {
		$format = self::get_format( $node );

		return self::format_date( $format );
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

		$permission_nodes = $nodes->length == 0;

		$permission_placeholders = !self::check_placeholder( $content );

		// if ( $nodes->length == 0 )
		
		if ( $permission_nodes && $permission_placeholders )
		{
			return $content;
		}

		foreach ( $nodes as $id => $node )
		{
			$date = self::get_date( $node );

			$node->textContent = $node->textContent . ' ' . $date;
		}

		return self::replace_placeholder( $dom->saveHTML() );
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
						
						'selector' => 'h1,h2,h3,h4,p',

						'classes' => self::CLASSES[ 'date-year' ],
					],

					[
						'title' => 'H1-H2 Month Year',
						
						'selector' => 'h1,h2,h3,h4,p',

						'classes' => self::CLASSES[ 'date-month-year' ],
					],
				],
			],
		] );
	}
}

?>