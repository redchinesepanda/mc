<?php

class ToolEnqueue
{
    public static function register_style( $styles )
    {
        if ( ReviewMain::check() ) {
            foreach ( $styles as $name => $path ) {
                wp_enqueue_style( $name, $path );
            }

			LegalDebug::debug( [
				'function' => 'ToolEnqueue::register_style',

				'styles' => $styles,
			] );
        }
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
}

?>