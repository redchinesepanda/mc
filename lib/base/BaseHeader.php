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
        'legal-header' => LegalMain::LEGAL_URL . '/assets/css/base/header.css',
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

	public static function parse_languages( $languages )
	{
		$item = [
			'title' => '',

			'href' => '#',

			'children' => [],

			'class' => 'menu-item-has-children legal-country legal-country-' . $languages[ 'current' ][ 'code' ],
		];

		foreach ( $languages[ 'avaible' ] as $language ) {
			$title = __( 'Betting Sites', ToolLoco::TEXTDOMAIN ) . ' ' . ( $language[ 'code' ] != 'en' ? $language[ 'native_name' ] : 'UK' );

			$item[ 'children' ][] = [
				'title' => $title,

				'href' => $language[ 'url' ],

				'class' => 'legal-country legal-country-' . $language[ 'code' ],
			];
		}

		$item[ 'children' ][] = [
			'title' => __( 'Choose your country', ToolLoco::TEXTDOMAIN ),

			'href' => '/choose-your-country/',

			'class' => 'legal-country legal-country-all',
		];

		return $item;
	}

	public static function get_menu_languages()
	{
		$code = WPMLMain::current_language();
		
		$search[ 'avaible' ] = WPMLMain::search_language();

		$search[ 'current' ] = $search[ 'avaible' ][ $code ];

		unset( $search[ 'avaible' ][ $code ] );

		$parse = self::parse_languages( $search );

		return $parse;
	}

	public static function parse_items_inline()
	{
		$menu_id_translated = BaseMain::get_menu_id( self::LOCATION );

		$menu_items = wp_get_nav_menu_items( $menu_id_translated );

		if ( empty( $menu_items ) ) {
			return null;
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

	public static function parse_languages_inline()
	{
		$languages = WPMLMain::search_language();

		$items = [];

		foreach ( $languages as $language ) {
			$items[] = [
				'class' => 'legal-country-' . $language[ 'code' ],

				'url-part' => $language[ 'code' ],
			];
		}

		return $items;
	}

	public static function parse_all_inline()
	{
		return array_merge( self::parse_items_inline(), self::parse_languages_inline() );
	}
	
	const LOCATION = 'legal-main';

	public static function location()
	{
		register_nav_menu( self::LOCATION, __( 'Legal Review BK Header', ToolLoco::TEXTDOMAIN ) );
	}

	public static function parse( $items, $parents, $key )
	{
		$post = $items[ $key ];

		$item = [
			'title' => $post->title,

			'href' => $post->url,

			'class' => '',
		];

		$post_class = get_field( self::FIELD[ 'class' ], $post );
			
		if( $post_class ) {
			$item[ 'class' ] .= ' legal-country';

			$item[ 'class' ] .= ' ' . $post_class;
		}

		$post_hide = get_field( self::FIELD[ 'hide' ], $post );

		if( !empty( $post_hide ) ) {
			$item[ 'title' ] = '';
		}

		$children = ToolMenu::array_search_values( $post->ID, $parents );

		if ( !empty( $children ) ) {
			$child_keys = array_keys( $children );

			foreach ( $child_keys as $child_key) {
				$item[ 'children' ][] = self::parse( $items, $parents, $child_key );
			}

			$item[ 'class' ] .= ' menu-item-has-children';
		}

		return $item;
	}

	public static function get_menu_items()
	{
		$menu_id_translated = BaseMain::get_menu_id( self::LOCATION );

		$menu_items = wp_get_nav_menu_items( $menu_id_translated );

		$menu_item_parents = ToolMenu::get_parents( $menu_items );

		$parents_top = ToolMenu::array_search_values( 0, $menu_item_parents );

		$keys = array_keys( $parents_top );

		$items = [];

		foreach ( $keys as $key ) {
			$items[] = self::parse( $menu_items, $menu_item_parents, $key );
		}
		
		$items[] = self::get_menu_languages();

		return $items;
	}

	public static function get()
	{
		$items = self::get_menu_items();

		return [
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