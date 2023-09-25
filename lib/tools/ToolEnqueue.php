<?php

class ToolEnqueue
{
    public static function register_style( $styles = [] )
    {
        foreach ( $styles as $name => $item ) {
            $path = $item;

            $ver = false;

            if ( is_array( $item ) ) {
                $path = $item[ 'path' ];

                $ver = $item[ 'ver' ];
            }

            wp_enqueue_style( $name, $path, [], $ver );
        }
    }

    public static function register_script( $scripts = [] )
    {
        foreach ( $scripts as $name => $item ) {
            $path = $item;

            $ver = false;

            $deps = [];

            if ( is_array( $item ) ) {
                $path = $item[ 'path' ];

                $ver = $item[ 'ver' ];

                if ( !empty( $item[ 'deps' ] ) )
                {
                    $deps = $item[ 'deps' ];
                }
            }

            wp_register_script( $name, $path, $deps, false, true );

            wp_enqueue_script( $name );
        }
    }

	public static function register_inline_style( $name, $data )
    {
		wp_register_style( $name, false, [], true, true );
		
		wp_add_inline_style( $name, $data );
		
		wp_enqueue_style( $name );
    }

	public static function register_inline_script( $name, $data )
    {
        wp_register_script( $name, false, [], true, true );
        
        wp_localize_script( $name, str_replace( '-', '_', $name ), $data );
        
        wp_enqueue_script( $name );
    }
}

?>