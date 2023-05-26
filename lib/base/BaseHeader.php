<?php

class BaseHeader
{
	public static function register()
    {
        $handler = new self();

        add_action( 'init', [ $handler, 'location' ] );

		// [legal-menu]

        add_shortcode( 'legal-menu', [ $handler, 'render' ] );
    }
	
	const LOCATION = 'legal-main';

	public static function location() {
		register_nav_menu( self::LOCATION, __( 'Legal Review BK', ToolLoco::TEXTDOMAIN ) );
	}

	public static function top( $menu_item_parent ) {
		return ( $menu_item_parent == 0 );
	}

	public static function render() {
		$locations = get_nav_menu_locations();

		$menu_id = ( !empty( $locations[ self::LOCATION ] ) ? $locations[ self::LOCATION ] : 0 );

		$menu_id_translated = apply_filters( 'wpml_object_id', $menu_id, 'nav_menu' );

		$menu_items = wp_get_nav_menu_items( $menu_id_translated );

		$menu_item_parent = array_column( $menu_items, 'menu_item_parent' );

		$handler = new self();
		
		$keys = array_filter( $menu_item_parent, [ $handler, 'top' ] );

		LegalDebug::debug( [
			'locations' => $locations,

			'menu_id' => $menu_id,

			'menu_id_translated' => $menu_id_translated,

			'keys' => $keys,

			'menu_item_parent' => $menu_item_parent,

			'menu_items' => $menu_items,
		] );

		return wp_nav_menu( [
			'theme_location' => self::LOCATION,

			'echo' => false,

			'container' => false,

			'items_wrap' => '<div id="%1$s" class="%2$s">%3$s</div>',
		] );
	}
	
}

?>