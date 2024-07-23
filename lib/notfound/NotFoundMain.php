<?php

class NotFoundMain
{
	const CSS = [
        'legal-notfound' => [
			'path' =>  LegalMain::LEGAL_URL . '/assets/css/notfound/notfound.css',

			'ver' => '1.0.3',
		],
    ];

	const CSS_NEW = [
        'legal-notfound' => [
			'path' =>  LegalMain::LEGAL_URL . '/assets/css/notfound/notfound-new.css',

			'ver' => '1.0.0',
		],
    ];

    public static function register_style()
    {
		if ( self::check() )
		{
			if ( TemplateMain::check_new() )
			{
				ToolEnqueue::register_style( self::CSS_NEW );
			}
			else
			{
				ToolEnqueue::register_style( self::CSS );
			}
		}
    }

	public static function register_inline_style()
    {
		if ( self::check() ) {
			ToolEnqueue::register_inline_style( 'legal-notfound', self::inline_style() );
		}
    }

	// public static function check_not_notfound()
    // {
    //     return !is_404(); 
    // }

	public static function check()
    {
		LegalDebug::debug( [
			'NotFoundMain' => 'check',

			'is_page_template' => is_page_template( '404.php' ),
		] );

        return is_404();
    }

	public static function register()
    {
        $handler = new self();

		// [legal-notfound]

        add_shortcode( 'legal-notfound', [ $handler, 'render' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_action( 'set_404', [ $handler, 'register_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );
    }

	public static function inline_style() {
		$style = [];

		$args = WPMLLangSwitcher::get();

		if ( empty( $args[ 'languages' ] ) || empty( $args[ 'active' ] ) ) {
			return '';
		}

		$style_items = array_merge( $args[ 'languages' ], [ $args[ 'active' ] ] );

		foreach ( $style_items as $style_item ) {
			$style[] = '.locale-' . $style_item[ 'id' ] . ' {
				background-image: url(' . $style_item[ 'src' ] . ');
			}';
		}

		return implode( ' ', $style );
	}

	public static function get_cross_args()
	{
		return [
			'posts_per_page' => 3,
            
            'post_type' => 'page',

			'suppress_filters' => 0,

			'tax_query' => [
				[
					'taxonomy' => 'page_type',

					'field' => 'slug',

					'terms' => [
						'legal-cross',

						'legal-cross-casino',
					],

					'operator' => 'IN',
				]
			],

			'orderby' => [
				'menu_order' => 'DESC',

				'modified' => 'DESC',

				'title' => 'ASC',
			],
        ];
	}

	public static function get_label( $post )
	{
		if ( has_term( 'legal-cross-casino', 'page_type', $post ) )
		{
			return __( 'Top Casino', ToolLoco::TEXTDOMAIN );
	   	}

		return __( 'Top Betting', ToolLoco::TEXTDOMAIN );
	}

	public static function parse_posts( $posts )
	{
		$result[ 'items' ][] = [
			'href' => LegalBreadcrumbsMain::get_home_url(),

			'label' => __( 'Home page', ToolLoco::TEXTDOMAIN ),
		];
		
		foreach ( $posts as $post )
		{
			$result[ 'items' ][] = [
				'href' => get_post_permalink( $post->ID ),

				'label' => self::get_label( $post ),
			];
		}

		return $result;
	}
	public static function get_cross()
	{
		$args = self::get_cross_args();

		$posts = get_posts( $args );

		return self::parse_posts( $posts );
	}

	public static function get()
	{
		$labels = [
			'title' => __( BaseMain::TEXT[ 'oops-page-not-found' ], ToolLoco::TEXTDOMAIN ),
			
			'description' => __( BaseMain::TEXT[ 'you-must-have' ], ToolLoco::TEXTDOMAIN ),
		];

		if ( TemplateMain::check_new() )
		{
			return array_merge(
				$labels,
	
				self::get_cross()
			);
		}
		
		$languages = WPMLLangSwitcher::get_not_found();

		// LegalDebug::debug( [
		// 	'function' => 'NotFoundMain::get',
		// 
		// 	'languages' => $languages,
		// ] );

		return array_merge(
			$labels,

			$languages
		);
	}

	const TEMPLATE = [
        'notfound' => LegalMain::LEGAL_PATH . '/template-parts/notfound/part-notfound-main.php',

        'notfound-new' => LegalMain::LEGAL_PATH . '/template-parts/notfound/part-notfound-main-new.php',
    ]; 

    public static function render()
	{
		if ( TemplateMain::check_new() )
		{
			return LegalComponents::render_main( self::TEMPLATE[ 'notfound-new' ], self::get() );
		}

		return LegalComponents::render_main( self::TEMPLATE[ 'notfound' ], self::get() );
	}
}

?>