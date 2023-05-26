<?php

class BaseHeader
{
	const CSS = [
        'legal-header' => LegalMain::LEGAL_URL . '/assets/css/base/header.css',
    ];

    public static function register_style()
    {
        ToolEnqueue::register_style( self::CSS );
    }

	public static function register()
    {
        $handler = new self();

        add_action( 'init', [ $handler, 'location' ] );

		// [legal-menu]

        add_shortcode( 'legal-menu', [ $handler, 'render' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_filter('wp_nav_menu_objects', [ $handler, 'image' ], 10, 2);
    }
	
	const LOCATION = 'legal-main';

	public static function location() {
		register_nav_menu( self::LOCATION, __( 'Legal Review BK', ToolLoco::TEXTDOMAIN ) );
	}

	public static function render() {
		$locations = get_nav_menu_locations();

		$menu_id = ( !empty( $locations[ self::LOCATION ] ) ? $locations[ self::LOCATION ] : 0 );

		$menu_id_translated = apply_filters( 'wpml_object_id', $menu_id, 'nav_menu' );

		$menu_items = wp_get_nav_menu_items( $menu_id_translated );

		return str_replace( [ 'li', 'ul' ], 'div', wp_nav_menu( [
			'theme_location' => self::LOCATION,

			'echo' => false,

			'container' => false,

			'items_wrap' => '<div id="%1$s" class="legal-menu">%3$s</div>',
		] ) );
	}

	const FIELD = [
		'class' => 'menu-item-class',
	];

	function image( $items, $args )
	{
		foreach( $items as &$item ) {
			$item_class = get_field( self::FIELD[ 'class' ], $item );
			
			if( $item_class ) {
				$item->classes[] = 'legal-country ' . $item_class;
			}

			$item_hide = get_field( self::FIELD[ 'class' ], $item );

			if( !empty( $item_hide ) ) {
				$item->title = '';
			}
		}
		
		return $items;
	}
}

?>