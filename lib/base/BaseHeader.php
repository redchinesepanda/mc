<?php

class BaseHeader
{
	const JS = [
        'legal-header' => LegalMain::LEGAL_URL . '/assets/js/base/header.js',
    ];

    public static function register_script()
    {
		BaseMain::register_script( self::JS );
    }

	const CSS = [
        'legal-header' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/base/header.css',

			'ver' => '1.0.5',
		],
    ];

    public static function register_style()
    {
        BaseMain::register_style( self::CSS );
    }

	public static function register_inline_style()
    {
		ToolEnqueue::register_inline_style( 'base-header', self::inline_style() );
    }

	public static function register()
    {
        $handler = new self();

        add_action( 'init', [ $handler, 'location' ] );

		// [legal-menu]

        add_shortcode( 'legal-menu', [ $handler, 'render' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
    }

	public static function inline_style() {
		$style = [];

		$style_items = self::parse_all_inline();

		if ( $style_items == null ) {
			return '';
		}

		foreach ( $style_items as $style_item ) {
			$style[] = '.legal-menu .' . $style_item[ 'class' ] . ' > a { background-image: url(\'' . LegalMain::LEGAL_ROOT . '/wp-content/uploads/flags/' . $style_item[ 'url-part' ] .'.svg\'); }';
		}

		return implode( ' ', $style );
	}

	public static function parse_items_inline()
	{
		$menu_id_translated = BaseMain::get_menu_id( self::LOCATION );

		$menu_items = wp_get_nav_menu_items( $menu_id_translated );

		if ( empty( $menu_items ) ) {
			return [];
		}

		$items = [];

		foreach ( $menu_items as $menu_item ) {
			$item_class = get_field( self::FIELD[ 'class' ], $menu_item );
			
			if( $item_class ) {
				$item_class_elements = explode( '-', $item_class );

				$items[] = [
					'class' => $item_class,

					'url-part' => end( $item_class_elements ),
				];
			}
		}

		return $items;
	}

	public static function search_languages()
	{
		$languages_all = WPMLMain::get_all_languages();

		$code = WPMLMain::current_language();

		// LegalDebug::debug( [
		// 	'code' => $code,
		// ] );

		$search[ 'current' ] = $languages_all[ $code ];

		// LegalDebug::debug( [
		// 	'current' => $search[ 'current' ],
		// ] );

		unset( $languages_all[ $code ] );

		$languages_all = WPMLMain::exclude( $languages_all );

		// LegalDebug::debug( [
		// 	'languages_all' => $languages_all,
		// ] );

		$lang = WPMLMain::get_group_language();

		$search[ 'avaible' ] = WPMLMain::filter_language( $languages_all, $lang );

		return $search;
	}

	public static function get_inline_item( $language )
	{
		return [
			'class' => 'legal-country-' . $language[ 'code' ],

			'url-part' => $language[ 'code' ],
		];
	}

	public static function parse_languages_inline()
	{
		// $languages = WPMLMain::search_language();
		
		$languages = self::search_languages();

		// $items = [];
		
		$items[] = self::get_inline_item( $languages[ 'current' ] );

		foreach ( $languages[ 'avaible' ] as $language ) {
			// $items[] = [
			// 	'class' => 'legal-country-' . $language[ 'code' ],

			// 	'url-part' => $language[ 'code' ],
			// ];

			$items[] = self::get_inline_item( $language );
		} 

		$items[] = [
			'class' => 'legal-country-all',

			'url-part' => 'all',
		];

		return $items;
	}

	public static function parse_all_inline()
	{
		return array_merge( self::parse_items_inline(), self::parse_languages_inline() );
	}

	public static function parse_languages( $languages )
	{
		$item = [
			'title' => '',

			'href' => '#',

			'children' => [],

			'class' => 'menu-item-has-children legal-country legal-country-' . $languages[ 'current' ][ 'code' ],
		];

		foreach ( $languages[ 'avaible' ] as $language ) {
			$title = __( BaseMain::TEXT[ 'betting-sites' ], ToolLoco::TEXTDOMAIN ) . ' ' . ( $language[ 'code' ] != 'en' ? $language[ 'native_name' ] : 'UK' );

			$item[ 'children' ][] = [
				'title' => $title,

				'href' => $language[ 'url' ],

				'class' => 'legal-country legal-country-' . $language[ 'code' ],
			];
		}

		$item[ 'children' ][] = [
			'title' => __( BaseMain::TEXT[ 'choose-your-country' ], ToolLoco::TEXTDOMAIN ),

			'href' => '/choose-your-country/',

			'class' => 'legal-country legal-country-all',
		];

		return $item;
	}

	const TAXONOMY = [
		'type' => 'page_type',
	];

	const TERM = [
		'cross' => 'legal-cross',
	];

	public static function get_cross()
	{
		$posts =  get_posts( [
			'post_type' => 'page',

			'numberposts' => -1,

			'tax_query' => [
				[
					'taxonomy' => self::TAXONOMY[ 'type' ],

					'field' => 'slug',

					'terms' => self::TERM[ 'cross' ],

					'include_children' => false,
				],
			],
		] );

		if ( !empty( $posts ) )
		{
			return array_shift( $posts );
		}

		return null;
	}

	public static function get_cross_urls( $items = [] )
	{
		$urls = [];

		foreach ( $items as $lang => $item )
		{
			$urls[ $lang ] = [
				'url' => get_post_permalink( $item->element_id ),
			];
		}

		return $urls;
	}

	public static function replace_urls( $urls = [] )
	{
		$cross = self::get_cross();

		if ( !empty( $cross ) )
		{
			$cross_trid = WPMLTrid::get_trid( $cross->ID );

			$cross_group = WPMLTrid::get_translation_group( $cross_trid );

			$cross_urls = self::get_cross_urls( $cross_group );

			if ( !empty( $cross_urls ) ) {
				$keys = array_keys( $urls );

				$cross_urls = array_intersect_key(
					$cross_urls, 

					array_flip( $keys )
				);

				return array_replace_recursive( $urls, $cross_urls );
			}
		}

		return $urls;
	}

	const EXCLUDE = [
		'esp',

        'eng',
	];

	// public static function get_menu_languages()
	// {
	// 	$code = WPMLMain::current_language();
		
	// 	$search[ 'avaible' ] = WPMLMain::search_language();

	// 	// LegalDebug::debug( [
	// 	// 	'avaible' => $search[ 'avaible' ],
	// 	// ] );

	// 	$search[ 'current' ] = $search[ 'avaible' ][ $code ];

	// 	unset( $search[ 'avaible' ][ $code ] );
		
	// 	$search[ 'avaible' ] = self::replace_urls( $search[ 'avaible' ] );

	// 	$parse = self::parse_languages( $search );

	// 	return $parse;
	// }

	public static function get_menu_languages()
	{
		$languages_all = WPMLMain::get_all_languages();

		$code = WPMLMain::current_language();

		// LegalDebug::debug( [
		// 	'code' => $code,
		// ] );

		$search[ 'current' ] = $languages_all[ $code ];

		// LegalDebug::debug( [
		// 	'current' => $search[ 'current' ],
		// ] );

		unset( $languages_all[ $code ] );

		$languages_all = WPMLMain::exclude( $languages_all );

		// LegalDebug::debug( [
		// 	'languages_all' => $languages_all,
		// ] );

		$lang = WPMLMain::get_group_language();

		$search[ 'avaible' ] = WPMLMain::filter_language( $languages_all, $lang );

		// LegalDebug::debug( [
		// 	'lang' => $lang,

		// 	'avaible' => $search[ 'avaible' ],
		// ] );
		
		// $search[ 'avaible' ] = WPMLMain::search_language();

		// LegalDebug::debug( [
		// 	'avaible' => $search[ 'avaible' ],
		// ] );

		// $search[ 'current' ] = $search[ 'avaible' ][ $code ];

		// unset( $search[ 'avaible' ][ $code ] );
		
		$search[ 'avaible' ] = self::replace_urls( $search[ 'avaible' ] );

		$parse = self::parse_languages( $search );

		return $parse;
	}
	
	const LOCATION = 'legal-main';

	public static function location()
	{
		register_nav_menu( self::LOCATION, __( BaseMain::TEXT[ 'legal-review-bk-header' ], ToolLoco::TEXTDOMAIN ) );
	}

	public static function parse_items( $items, $parents, $key )
	{
		$post = $items[ $key ];

		$item = [
			'title' => $post->title,

			'href' => $post->url,

			'class' => '',
		];

		$post_class = get_field( self::FIELD[ 'class' ], $post );
			
		if ( $post_class )
		{
			$item[ 'class' ] .= ' legal-country';

			$item[ 'class' ] .= ' ' . $post_class;
		}

		$post_hide = get_field( self::FIELD[ 'hide' ], $post );

		if ( !empty( $post_hide ) )
		{
			$item[ 'title' ] = '';
		}

		if ( !empty( $post->classes ) )
		{
			$item[ 'class' ] .= ' ' . implode( ' ', $post->classes );
		}

		$children = ToolMenu::array_search_values( $post->ID, $parents );

		if ( !empty( $children ) ) {
			$child_keys = array_keys( $children );

			foreach ( $child_keys as $child_key) {
				$item[ 'children' ][] = self::parse_items( $items, $parents, $child_key );
			}

			$item[ 'class' ] .= ' menu-item-has-children';
		}

		return $item;
	}

	public static function get_menu_items()
	{
		$menu_id_translated = BaseMain::get_menu_id( self::LOCATION );

		$menu_items = wp_get_nav_menu_items( $menu_id_translated );

		$items = [];

		if ( $menu_items ) {
			$menu_item_parents = ToolMenu::get_parents( $menu_items );

			$parents_top = ToolMenu::array_search_values( 0, $menu_item_parents );

			$keys = array_keys( $parents_top );

			foreach ( $keys as $key ) {
				$items[] = self::parse_items( $menu_items, $menu_item_parents, $key );
			}
		}
		
		$items[] = self::get_menu_languages();

		return $items;
	}

	public static function get()
	{
		$items = self::get_menu_items();

		return [
			'href' => LegalBreadcrumbsMain::get_home_url(),
			
			'items' => $items,
		];
	}

	const FIELD = [
		'class' => 'menu-item-class',

		'hide' => 'menu-item-hide',
	];

	const TEMPLATE = [
        'header' => LegalMain::LEGAL_PATH . '/template-parts/base/part-header-main.php',

		'item' => LegalMain::LEGAL_PATH . '/template-parts/base/part-header-item.php',
    ];

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE[ 'header' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }

    public static function render_item( $item )
    {
        ob_start();

        load_template( self::TEMPLATE[ 'item' ], false, $item );

        $output = ob_get_clean();

        return $output;
    }
}

?>