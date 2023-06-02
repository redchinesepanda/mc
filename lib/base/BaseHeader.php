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

		add_filter('wp_nav_menu_objects', [ $handler, 'image' ], 10, 2);
    }

	public static function inline_style() {
		$style = [];

		$style_items = self::get_menu_items();

		if ( $style_items == null ) {
			return '';
		}

		foreach ( $style_items as $style_item ) {
			$style[] = '.legal-menu .' . $style_item[ 'class' ] . ' > a { background-image: url(\'' . LegalMain::LEGAL_ROOT . '/wp-content/uploads/flags/' . $style_item[ 'url-part' ] .'.svg\'); }';
		}

		return implode( ' ', $style );
	}

	public static function get_menu_items()
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
	
	const LOCATION = 'legal-main';

	public static function location()
	{
		register_nav_menu( self::LOCATION, __( 'Legal Review BK Header', ToolLoco::TEXTDOMAIN ) );
	}

	public static function get()
	{
		$menu_id_translated = BaseMain::get_menu_id( self::LOCATION );

		return str_replace( [ 'li', 'ul' ], 'div', wp_nav_menu( [
			'theme_location' => self::LOCATION,

			'echo' => false,

			'container' => false,

			'items_wrap' => '<div id="%1$s" class="legal-menu">%3$s</div>',
		] ) );
	}

	const FIELD = [
		'class' => 'menu-item-class',

		'hide' => 'menu-item-hide',
	];

	function image( $items, $args )
	{
		foreach( $items as &$item ) {
			$item_class = get_field( self::FIELD[ 'class' ], $item );
			
			if( $item_class ) {
				$item->classes[] = 'legal-country';

				$item->classes[] = $item_class;
			}

			$item_hide = get_field( self::FIELD[ 'hide' ], $item );

			if( !empty( $item_hide ) ) {
				$item->title = '';
			}
		}
		
		return $items;
	}

	const TEMPLATE = [
        'header-menu' => LegalMain::LEGAL_PATH . '/template-parts/base/part-header.php',
    ];

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE[ 'header-menu' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>