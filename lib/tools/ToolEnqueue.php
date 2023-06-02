<?php

class ToolEnqueue
{
    public static function register_style( $styles )
    {
        // if ( ReviewMain::check() ) {
            foreach ( $styles as $name => $path ) {
                wp_enqueue_style( $name, $path );
            }
        // }
    }

    public static function register_script( $scripts )
    {
        if ( ReviewMain::check() ) {
            foreach ( $scripts as $name => $path ) {
                wp_register_script( $name, $path, [], false, true );

                wp_enqueue_script( $name );
            }
        }
    }

	public static function register_inline_style( $name, $data )
    {
		wp_register_style( $name, false, [], true, true );
		
		wp_add_inline_style( $name, $data );
		
		wp_enqueue_style( $name );
    }
}

?>