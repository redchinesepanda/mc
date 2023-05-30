<?php

require_once( 'BaseHeader.php' );

require_once( 'BaseFooter.php' );

class BaseMain
{
	public static function register()
    {
        BaseHeader::register();

        BaseFooter::register();
    }

    public static function get_menu_id()
	{
		$locations = get_nav_menu_locations();

		$menu_id = ( !empty( $locations[ self::LOCATION ] ) ? $locations[ self::LOCATION ] : 0 );

		// $menu_id_translated = apply_filters( 'wpml_object_id', $menu_id, 'nav_menu' );
		
        $menu_id_translated = WPMLMain::translated_menu_id( $menu_id );

		return $menu_id_translated;
	}
}

?>