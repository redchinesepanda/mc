<?php

class BaseHeader
{
	const CSS = [
        'legal-header-main' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/base/header-main.css',

			'ver' => '1.1.7',
		],
    ];

	const CSS_NEW = [
        'legal-header-new' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/base/header-new.css',

			'ver' => '1.1.7',
		],

        // 'legal-header-selectors' => [
		// 	'path' => LegalMain::LEGAL_URL . '/assets/css/base/header-selectors.css',

		// 	'ver' => '1.0.0',
		// ],
    ];

    public static function register_style()
    {
		if ( TemplateMain::check_new() )
		{
			BaseMain::register_style( self::CSS_NEW );
		}
		else
		{
			BaseMain::register_style( self::CSS );
		}
    }

	public static function register_inline_style()
    {
		ToolEnqueue::register_inline_style( 'base-header', self::inline_style() );
    }

	const JS = [
        'legal-header-main' => [
			'path' => LegalMain::LEGAL_URL . '/assets/js/base/header-main.js',

			'ver' => '1.0.2',
		],

        'legal-header-open' => [
			'path' => LegalMain::LEGAL_URL . '/assets/js/base/header-open.js',

			'ver' => '1.0.0',
		],
    ];

	const JS_NEW = [
        'legal-header-main' => [
			'path' => LegalMain::LEGAL_URL . '/assets/js/base/header-main.js',

			'ver' => '1.0.1',
		],

        'legal-header-menu' => [
			'path' => LegalMain::LEGAL_URL . '/assets/js/base/header-menu.js',

			'ver' => '1.0.0',
		],

        'legal-header-cut' => [
			'path' => LegalMain::LEGAL_URL . '/assets/js/base/header-cut.js',

			'ver' => '1.0.0',

			'deps' => [ 'legal-header-menu' ],
		],

        'legal-header-has-href' => [
			'path' => LegalMain::LEGAL_URL . '/assets/js/base/header-has-href.js',

			'ver' => '1.0.1',
		],
    ];

    public static function register_script()
    {
		if ( TemplateMain::check_new() )
		{
			BaseMain::register_script( self::JS_NEW );

			ToolEnqueue::localize_script( self::get_localize() );
		}
		else
		{
			BaseMain::register_script( self::JS );
		}
    }

	public static function register_functions()
	{
		$handler = new self();

        add_action( 'init', [ $handler, 'location' ] );
	}

	public static function register()
    {
        $handler = new self();

		// [legal-menu]

        add_shortcode( 'legal-menu', [ $handler, 'render' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
    }

	public static function get_localize()
	{
		return [
			'legal-header-cut' => [
				'object_name' => 'legalHeaderCutText',
	
				'data' => [
					'default' => __( BaseMain::TEXT[ 'show-all' ], ToolLoco::TEXTDOMAIN ),
	
					'active' => __( BaseMain::TEXT[ 'hide' ], ToolLoco::TEXTDOMAIN ),
				],
			],
		];
	}

	// public static function check_url_part( $item )
    // {
    //     return $item[ 'url-part' ] != 'all';
    // }

    // public static function filter_style_items( $items )
    // {
    //     $handler = new self();

    //     return array_filter( $items, [ $handler, 'check_url_part' ] );
    // }

	public static function inline_style()
	{
		$style = [];

		$style_items = self::parse_all_inline();

		if ( $style_items == null ) {
			return '';
		}

		$code = WPMLMain::current_language();

		$new = TemplateMain::check_new();

		if ( $new )
		{
			// $style_items = self::filter_style_items( $style_items );

			$style_items[ count( $style_items ) - 1 ][ 'url-part' ] = 'all-new';
		}

		foreach ( $style_items as $style_item )
		{
			if ( str_contains( $style_item[ 'class' ], 'legal-country' ) )
			{
				$style[] = '.legal-menu .' . $style_item[ 'class' ] . ' > a::before { background-image: url(\'' . LegalMain::LEGAL_ROOT . '/wp-content/uploads/flags/' . $style_item[ 'url-part' ] .'.svg\'); }';
			}

			if ( $new && $style_item[ 'url-part' ] == $code )
			{
				$style[] = '.legal-header .legal-header-control:not( .legal-active )::before { background-image: url(\'' . LegalMain::LEGAL_ROOT . '/wp-content/uploads/flags/' . $style_item[ 'url-part' ] .'.svg\'); }';
			}
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

		foreach ( $menu_items as $menu_item )
		{
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

	public static function get_language_current( &$languages )
	{
		$code = WPMLMain::current_language();

		if ( array_key_exists( $code, $languages ) )
		{
			$result = $languages[ $code ];

			unset( $languages[ $code ] );
			
			return $result;
		}

		return [];
	}

	public static function get_languages_avaible( $languages )
	{
		// if ( !ToolNotFound::check_domain_restricted() )
		
		// if ( !ToolRestricted::check_domain_restricted() )
		// {
			$languages = WPMLMain::exclude( $languages );
		
			$lang = WPMLMain::get_group_language();
	
			return WPMLMain::filter_language( $languages, $lang );
		// }

		// return [];
	}

	public static function search_languages()
	{
		$search = [
			'current' => [],

			'avaible' => [],
		];

		$all_languages = WPMLMain::get_all_languages();

		LegalDebug::debug( [
			'BaseHeader' => 'search_languages',

			'all_languages' => $all_languages,

			'get_sites' => MultisiteBlog::get_sites(),

			'sites_to_languages' => MultisiteSiteSwitcher::sites_to_languages( $sites ),
		] );

		// if ( empty( $all_languages ) )
		// {
		// 	$all_languages = MultisiteSiteswitcher::get_sites();
		// }

		if ( !empty( $all_languages ) )
		{
			$search[ 'current' ] = self::get_language_current( $all_languages );

			$search[ 'avaible' ] = self::get_languages_avaible( $all_languages );

			// $code = WPMLMain::current_language();
	
			// $search[ 'current' ] = $all_languages[ $code ];
	
			// unset( $all_languages[ $code ] );
	
			// $all_languages = WPMLMain::exclude( $all_languages );
	
			// $lang = WPMLMain::get_group_language();
	
			// $search[ 'avaible' ] = WPMLMain::filter_language( $all_languages, $lang );
		}
		
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
		$languages = self::search_languages();

		if ( !empty( $languages[ 'current' ] ) )
		{
			$items[] = self::get_inline_item( $languages[ 'current' ] );
		}

		foreach ( $languages[ 'avaible' ] as $language ) {
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

	const ROOT_URL_EXCEPTIONS = [
		'en',
	];
	
	public static function check_root_url( $language )
	{
		$url = $language[ 'url' ];

		$path = trim( parse_url( $url, PHP_URL_PATH ), '/' );

		$path_array = explode( '/', $path );

		$path_count = count( $path_array );

		$amount = 1;

		if ( in_array( $language[ 'code' ], self::ROOT_URL_EXCEPTIONS ) )
		{
			$amount = 0;
		}

		// $result = $path_count <= 1;
		
		$result = $path_count <= $amount;

		return $result;
	}

	const PREFIX = [
		'en',

		'es',

		'br',
	]; 

	public static function get_title_prefix( $language )
	{
		// LegalDebug::debug( [
		// 	'function' => 'BaseHeader::get_title_prefix',

		// 	'language' => $language,
		// ] );

		$prefix = '';

		if ( !TemplateMain::check_new() && !in_array( WPMLMain::current_language(), self::PREFIX ) )
		{
			$prefix = __( BaseMain::TEXT[ 'betting-sites' ], ToolLoco::TEXTDOMAIN );

			if ( self::get_casino_permission() )
			{
				$prefix = __( BaseMain::TEXT[ 'online-casinos' ], ToolLoco::TEXTDOMAIN );
			}

			// if ( self::check_root_url( $language[ 'url' ] ) )
			
			if ( self::check_root_url( $language ) )
			{
				$prefix = __( BaseMain::TEXT[ 'gambling-sites' ], ToolLoco::TEXTDOMAIN );
			} 
		}

		return $prefix;
	}

	public static function prepare_data_attr( $value, $name )
	{
		return $name . '="' . $value . '"';
	}

	public static function get_data_attr_language( $languages )
	{
		$handler = new self();
		
		$language = [];

		if ( !empty( $languages[ 'current' ] ) )
		{
			$language = $languages[ 'current' ];
		}

		$data = [
			'data-name-code' => '',

			'data-name-default' => '',

			'data-name-alternate' => __( BaseMain::TEXT[ 'choose-your-country' ], ToolLoco::TEXTDOMAIN ),
		];

		if ( !empty( $language[ 'language_code' ] ) )
		{
			$data[ 'data-name-code' ] = strtoupper(  $language[ 'language_code' ] );
		}

		if ( !empty( $language[ 'translated_name' ] ) )
		{
			$data[ 'data-name-default' ] = strtoupper( $language[ 'translated_name' ] );
		}

		return implode( ' ', array_map( [ $handler, 'prepare_data_attr' ], $data, array_keys( $data ) ) );
	}

	public static function get_data_attr_cut_control()
	{
		$handler = new self();

		$data = [
			'data-content-default' => __( BaseMain::TEXT[ 'show-all' ], ToolLoco::TEXTDOMAIN ),

			'data-content-active' => __( BaseMain::TEXT[ 'hide' ], ToolLoco::TEXTDOMAIN ),
		];

		return implode( ' ', array_map( [ $handler, 'prepare_data_attr' ], $data, array_keys( $data ) ) );
	}

	public static function get_data_attr_columns( $item )
	{
		$handler = new self();

		$data = [
			'data-columns' => count( array_chunk( $item[ 'children' ], 6 ) ),
		];

		return implode( ' ', array_map( [ $handler, 'prepare_data_attr' ], $data, array_keys( $data ) ) );
	}

	// public static function get_data_attr_current( $current, $item )
	// {
	// 	return implode(
	// 		' ',

	// 		[
	// 			self::get_data_attr_language( $current ),

	// 			self::get_data_attr_columns( $item ),
	// 		]
	// 	);
	// }

	// public static function get_url()
	// {
	// 	return ToolRobots::get_scheme(). '://'. LegalMain::get_main_host();
	// }

	public static function get_href()
	{
		$href = '/choose-your-country/';

		// if ( ToolRestricted::check_domain_restricted() )
		// {
			// $href = self::get_url() . $href;
		// }

		return $href;
	}

	public static function get_item_all_countries()
	{
		// if ( !ToolNotFound::check_domain_restricted() )
		// {
			$title = ToolLoco::translate( BaseMain::TEXT[ 'choose-your-country' ] );
	
			if ( TemplateMain::check_new() )
			{
				$title = ToolLoco::translate( BaseMain::TEXT[ 'all-countries' ] );
			}
	
			return [
	
				'title' => $title,
				
				'href' => self::get_href(),
	
				'class' => 'legal-country legal-country-all',
	
				'data' => '',
			];
		// }

		// return [];
	}

	public static function get_item_main( $languages )
	{
		return [
			'title' => '',

			'href' => '#',

			'children' => [],
			
			'class' => self::get_item_class( $languages ),
			
			'data' => self::get_data_attr_language( $languages ),
		];
	}

	public static function get_item_class( $languages )
	{
		$code = WPMLMain::current_language();

		if ( !empty( $languages[ 'current' ][ 'code' ] ) )
		{
			$code = $languages[ 'current' ][ 'code' ];
		}

		$classes = [
			'legal-country',

			'legal-country-' . $code,
		];

		if ( !empty( $languages[ 'avaible' ] ) )
		{
			$classes[] = 'menu-item-has-children';
		}

		return implode( ' ', $classes );
	}

	public static function parse_languages( $languages )
	{
		$item = self::get_item_main( $languages );

		if ( !empty( $languages[ 'avaible' ] ) )
		{
			foreach ( $languages[ 'avaible' ] as $language )
			{
				$label = $language[ 'code' ] != 'en' ? $language[ 'native_name' ] : 'UK';
	
				$prefix = self::get_title_prefix( $language );
	
				$title = $prefix . ' ' . $label;
	
				$item[ 'children' ][] = [
					'title' => $title,
					
					'href' => apply_filters( 'mc_url_restricted', $language[ 'url' ] ),
	
					'class' => 'legal-country legal-country-' . $language[ 'code' ],
	
					'data' => '',
				];
			}
		}

		if ( $item_all_countries = self::get_item_all_countries() )
		{
			$item[ 'children' ][] = $item_all_countries;
		}

		// $title = __( BaseMain::TEXT[ 'choose-your-country' ], ToolLoco::TEXTDOMAIN );

		// if ( TemplateMain::check_new() )
		// {
		// 	$title = __( BaseMain::TEXT[ 'all-countries' ], ToolLoco::TEXTDOMAIN );
		// }

		// $href = self::get_href();

		// $item[ 'children' ][] = [

		// 	'title' => $title,
			
		// 	'href' => $href,

		// 	'class' => 'legal-country legal-country-all',

		// 	'data' => '',
		// ];

		return $item;
	}

	const TAXONOMY = [
		'type' => 'page_type',
	];

	const TERM = [
		'cross' => 'legal-cross',

		'cross-casino' => 'legal-cross-casino',

		'casino' => 'casino',
	];

	public static function get_cross( $terms = '' )
	{
		if ( empty( $terms ) )
		{
			$terms = self::TERM[ 'cross' ];
		}

		$posts =  get_posts( [
			'post_type' => 'page',

			'numberposts' => -1,

			'tax_query' => [
				[
					'taxonomy' => self::TAXONOMY[ 'type' ],

					'field' => 'slug',

					'terms' => $terms,

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
				'url' => strtok( get_post_permalink( $item->element_id ), '?' ),
			];
		}

		return $urls;
	}

	public static function get_casino_permission()
	{
		return has_term( [ self::TERM[ 'casino' ], self::TERM[ 'cross-casino' ] ], self::TAXONOMY[ 'type' ] );
	}

	public static function get_page_urls( $post )
	{
		$trid = WPMLTrid::get_trid( $post->ID );

		$group = WPMLTrid::get_translation_group( $trid );

		return self::get_cross_urls( $group );
	}

	public static function get_home_page()
	{
		return get_post( get_option( 'page_on_front' ) );
	}

	public static function get_cross_page()
	{
		$permission_casino = self::get_casino_permission();

		if ( $permission_casino )
		{
			return self::get_cross( self::TERM[ 'cross-casino' ] );
		}
		else
		{
			return self::get_cross();
		}

		return null;
	}

	public static function replace_urls_iteration( $urls, $replace_urls = [] )
	{
		if ( !empty( $replace_urls ) ) {
			$keys = array_keys( $urls );

			$replace_urls = array_intersect_key(
				$replace_urls, 

				array_flip( $keys )
			);

			return array_replace_recursive( $urls, $replace_urls );
		}

		return $urls;
	}

	public static function replace_urls_compare( $language_a, $language_b )
	{
		return strcmp( $language_a[ 'url' ], $language_b[ 'url' ] );
	}

	public static function replace_urls_group( $urls_home, $urls_cross )
	{
		$handler = new self();

		$urls_uintersect = array_uintersect( $urls_home, $urls_cross, [ $handler, 'replace_urls_compare' ] );

		$urls_udiff = array_udiff( $urls_cross, $urls_home, [ $handler, 'replace_urls_compare' ] );

		$urls = array_merge( $urls_udiff, $urls_uintersect );

		return $urls;
	}
	
	public static function replace_urls( $urls = [] )
	{
		$home = self::get_home_page();

		$home_urls_replaced = [];

		if ( !empty( $home ) )
		{
			$home_urls_all = self::get_page_urls( $home );
			
			$home_urls_replaced = self::replace_urls_iteration( $urls, $home_urls_all );
		}

		$cross = self::get_cross_page();

		$cross_urls_replaced = [];

		if ( !empty( $cross ) )
		{
			$cross_urls_all = self::get_page_urls( $cross );

			$cross_urls_replaced = self::replace_urls_iteration( $urls, $cross_urls_all );
		}		

		$urls = self::replace_urls_group( $home_urls_replaced, $cross_urls_replaced );

		return $urls;
	}

	const EXCLUDE = [
		'esp',

        'eng',
	];

	public static function get_menu_languages()
	{
		$search = self::search_languages();
		
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

		$href = $post->url;

		if ( $post->type == 'custom' )
		{
			$href = apply_filters( 'mc_url_restricted', $post->url );
		}

		$item = [
			'title' => $post->title,

			// 'href' => $post->url,
			
			'href' => $href,

			'class' => '',

			'data' => '',
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

		if ( $menu_items )
		{
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

	// public static function filter_has_children( $item )
    // {
    //     if ( !empty( $item[ 'children' ] ) )
    //     {
    //         return true;
    //     }

    //     return false;
    // }

	// public static function filter_no_children( $item )
    // {
    //     if ( empty( $item[ 'children' ] ) )
    //     {
    //         return true;
    //     }

    //     return false;
    // }

	// public static function set_cut( &$item )
    // {
    //     if ( !empty( $item[ 'children' ] ) )
    //     {
    //         $visible = array_slice( $item[ 'children' ], 0, 6 );

	// 		$cut = array_slice( $item[ 'children' ], 6 );

	// 		// LegalDebug::debug( [
	// 		// 	'visible' => $visible,

	// 		// 	'cut' => $cut,
	// 		// ] );

	// 		foreach( $cut as &$cut_item )
	// 		{
	// 			$cut_item[ 'class' ] = 'legal-cut-item';
	// 		}

	// 		$cut_control = [
	// 			'title' => '',

	// 			'href' => '#',

	// 			'class' => 'legal-cut-control',

	// 			'data' => self::get_data_attr_cut_control(),
	// 		];

	// 		$item[ 'children' ] = array_merge( $visible, $cut );
    //     }
    // }

	// public static function group_children( $children )
	// {
	// 	if ( !empty( $children ) )
	// 	{
	// 		$handler = new self();

	// 		$no_children = array_filter( $children, [ $handler, 'filter_no_children' ] );
	
	// 		$has_children = array_filter( $children, [ $handler, 'filter_has_children' ] );

	// 		foreach( $has_children as &$item )
	// 		{
	// 			self::set_cut( $item );
	// 		}

	// 		return array_merge( array_chunk( $no_children, 6 ), array_chunk( $has_children, 1 ) );
	// 	}

	// 	return [];
	// }

	// public static function group_items( &$items )
	// {
	// 	foreach ( $items as &$item )
	// 	{
	// 		// if ( !empty( $item[ 'children' ] ) )
	// 		// {
	// 			$item[ 'groups' ] = self::group_children( $item[ 'children' ] );

	// 			$item[ 'children' ] = [];
	// 		// }
	// 	}

	// 	// return $items;
	// }

	public static function get_logo()
	{
		if ( TemplateMain::check_new() )
		{
			return [
				'href' => LegalBreadcrumbsMain::get_home_url(),
				
				'img' => [
					'src' => LegalMain::LEGAL_URL . '/assets/img/base/header/header-logo-mc-desktop.svg',

					'width' => 120,

					'height' => 48,

					'alt' => 'Match.Center',
				],
	
				'source' => [
					[
						'srcset' => LegalMain::LEGAL_URL . '/assets/img/base/header/header-logo-mc-mobile.svg',

						'media' => '(max-width: 959px)',

						'width' => 48,

						'height' => 48,
					],
				],
			];
		}

		return [
			'href' => LegalBreadcrumbsMain::get_home_url(),

			'img' => [
				'src' => LegalMain::LEGAL_URL . '/assets/img/base/header/mc-logo.png',

				'width' => 213,

				'height' => 21,

				'alt' => 'Match.Center',
			],

			'source' => [],
		];
	}

	public static function get()
	{
		return [
			// 'href' => LegalBreadcrumbsMain::get_home_url(),

			'logo' => self::get_logo(),
			
			'items' => self::get_menu_items(),
		];
	}

	const FIELD = [
		'class' => 'menu-item-class',

		'hide' => 'menu-item-hide',
	];

	const TEMPLATE = [
        'header-main' => LegalMain::LEGAL_PATH . '/template-parts/base/part-header-main.php',

        // 'header-new' => LegalMain::LEGAL_PATH . '/template-parts/base/part-header-new.php',

        // 'header-group' => LegalMain::LEGAL_PATH . '/template-parts/base/part-header-group.php',

		'header-item' => LegalMain::LEGAL_PATH . '/template-parts/base/part-header-item.php',

		// 'header-item-new' => LegalMain::LEGAL_PATH . '/template-parts/base/part-header-item-new.php',
		
		'header-logo' => LegalMain::LEGAL_PATH . '/template-parts/base/part-header-logo.php',
    ];

    public static function render()
    {
        return LegalComponents::render_main( self::TEMPLATE[ 'header-main' ], self::get() );
    }

	// public static function render_group( $group )
    // {
    //     return self::render_main( self::TEMPLATE[ 'header-group-main' ], $group );
    // }

    public static function render_item( $item )
    {
        return LegalComponents::render_main( self::TEMPLATE[ 'header-item' ], $item );
    }

    public static function render_logo( $logo )
    {
        return LegalComponents::render_main( self::TEMPLATE[ 'header-logo' ], $logo );
    }

	// public static function render_main( $template, $args )
    // {
    //     ob_start();

    //     load_template( $template, false, $args );

    //     $output = ob_get_clean();

    //     return $output;
    // }
}

?>