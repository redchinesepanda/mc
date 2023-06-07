<?php

require_once( 'BaseHeader.php' );

require_once( 'BaseFooter.php' );

class BaseMain
{
	public static function register_style( $styles = [] )
    {
        if ( self::check() ) {
            ToolEnqueue::register_style( $styles );
        }
    }

    public static function register_script( $scripts = [] )
    {
        if ( self::check() ) {
            ToolEnqueue::register_script( $scripts );
        }
    }

	public static function register_inline_style( $name = '', $data = '' )
    {
		if ( self::check() ) {
            ToolEnqueue::register_inline_style( $name, $data );
        }
    }

	public static function check()
    {
        $lang = WPMLMain::current_language();

        $permission_lang = in_array( $lang, [ 'ke', 'ro', 'en', 'ng', 'mx' ] );
        
        return $permission_lang;
    }

	public static function register()
    {
        BaseHeader::register();

        BaseFooter::register();
    }

    public static function get_menu_id( $location )
	{
		$locations = get_nav_menu_locations();

		$menu_id = ( !empty( $locations[ $location ] ) ? $locations[ $location ] : 0 );

		// $menu_id_translated = apply_filters( 'wpml_object_id', $menu_id, 'nav_menu' );
		
        $menu_id_translated = WPMLMain::translated_menu_id( $menu_id );

		return $menu_id_translated;
	}
}

?>