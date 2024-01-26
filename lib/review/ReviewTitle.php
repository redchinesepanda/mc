<?php

class ReviewTitle
{
	const CSS = [
        'review-title' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-title.css',

            'ver' => '1.0.8',
        ],
    ];

	const CSS_NEW = [
        'review-title-new' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-title-new.css',

			'ver' => '1.0.0',
		], 
    ];

	const CSS_TITLE_ICONS = [
		'review-title-icons' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-title-icons.css',

            'ver' => '1.0.1',
        ],
		
        'legal-template-font-mc-icons-title' => [
			'path' => LegalMain::LEGAL_URL . '/assets/font/font-mc-icons-title.css',

			'ver' => '1.0.0',
		],
    ];

	public static function check_contains_title_icons()
    {
        return LegalComponents::check_contains( self::CLASSES[ 'h3' ] );
    }

	public static function register_style()
    {
		if ( TemplateMain::check_code() )
		{
			ReviewMain::register_style( self::CSS_NEW );

			if ( self::check_contains_title_icons() )
			{
				ReviewMain::register_style( self::CSS_TITLE_ICONS );
			}
		}
		else
		{
			ReviewMain::register_style( self::CSS );
		}
    }

	public static function inline_style( $container = '.tcb-post-content' )
	{
		$style = [];

		foreach ( self::CLASSES_SPORT as $name => $item )
		{
			$style[] = $container . ' .legal-header-' . $name . '::before { background-image: url(\'' . LegalMain::LEGAL_URL . '/assets/img/review/header/review-' . $name .'.svg\'); }';
		}

		return implode( ' ', $style ); 
	}

	public static function register_inline_style()
    {
		ToolEnqueue::register_inline_style( 'review-title', self::inline_style() );
    }

	public static function register_functions()
	{
		$handler = new self();

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_header' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_header_date' ] );
	}

	public static function register()
    {
		LegalDebug::debug( [
			self::check_contains_title(),
		] );

        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );

		add_filter( 'the_content', [ $handler, 'modify_content' ] );
    }

	public static function check_contains_title()
    {
		$result = false;

		foreach (
			array_merge(
				self::CLASSES,

				array_keys( self::PLACEHOLDER )
			) as $item
		)
		{
			$result = $result || LegalComponents::check_contains( $item );
		}

        // return LegalComponents::check_contains( self::CLASSES[ 'date-year' ] )

		// 	|| LegalComponents::check_contains( self::CLASSES[ 'date-month-year' ] )
			
		// 	|| $result;

		return $result;
    }

	const CLASSES = [
		'h3' => 'legal-header-3',

		'date-year' => 'legal-header-year',

		'date-month-year' => 'legal-header-month-year',
	];

	const CLASSES_SPORT = [
		'basketball' => 'legal-header-basketball',

		'cricket' => 'legal-header-cricket',

		'deposit' => 'legal-header-deposit',

		'esports' => 'legal-header-esports',

		'features' => 'legal-header-features',

		'football' => 'legal-header-football',

		'handball' => 'legal-header-handball',

		'history' => 'legal-header-history',

		'hockey' => 'legal-header-hockey',

		'horceracing' => 'legal-header-horceracing',

		'mma' => 'legal-header-mma',

		'motorsport' => 'legal-header-motorsport',

		'rugby' => 'legal-header-rugby',

		'tennis' => 'legal-header-tennis',

		'volleyball' => 'legal-header-volleyball',

		'widthdraw' => 'legal-header-widthdraw',
	];

	const FORMAT = [
        self::CLASSES[ 'date-year' ] => 'y',

        // self::CLASSES[ 'date-month-year' ] => 'MMMM y',
        
		self::CLASSES[ 'date-month-year' ] => 'LLLL y',
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
		
		if ( $permission_nodes && $permission_placeholders )
		{
			return $content;
		}

		foreach ( $nodes as $id => $node )
		{
			$date = self::get_date( $node );

			if ( $node->childNodes->length != 0 )
			{
				$lastTextNode = null;

				foreach( $node->childNodes as $childNode )
				{
					if ( $childNode->nodeType == XML_TEXT_NODE )
					{
						$lastTextNode = $childNode;
					}
				}

				if ( !empty( $lastTextNode ) )
				{
					$lastTextNode->textContent = $lastTextNode->textContent . ' ' . $date;
				}
			}
		}

		// return self::replace_placeholder( $dom->saveHTML() );
		
		// return $dom->saveHTML();

		// return $content;

		// Работает1 начало

		// return html_entity_decode( $dom->saveHTML() );

		// Работает1 конец

		// Работает 2 начало
		
		// return $dom->saveHTML( $dom );

		return self::replace_placeholder( $dom->saveHTML( $dom ) );

		// Работает 2 конец
	}

	public static function style_formats_header( $settings )
	{
		$items = [];

		foreach ( self::CLASSES_SPORT as $name => $item )
		{
			$items[] = [
				'title' => 'H3 ' . ucfirst( $name ),
				
				'selector' => 'h3',

				'classes' => self::CLASSES[ 'h3' ] . ' ' . $item,
			];
		}

		return ToolTinyMCE::style_formats_check( $settings, [
			[
				'title' => 'Title with Image',

				'items' => $items,
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