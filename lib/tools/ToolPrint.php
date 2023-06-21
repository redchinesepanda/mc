<?php

class ToolPrint
{
    public static function print_style( $styles = [] )
    {
        foreach ( $styles as $name => $item ) {
            $path = $item;

            $ver = '';

            if ( is_array( $item ) ) {
                $path = $item[ 'path' ];

                $ver = '?ver=' . $item[ 'ver' ];
            }

            echo '<link id="' . $name . '" href="' . $path . $ver . '" rel="stylesheet" />';
        }
    }

    public static function print_script( $styles = [] )
    {
        foreach ( $styles as $name => $item ) {
            $path = $item;

            $ver = '';

            if ( is_array( $item ) ) {
                $path = $item[ 'path' ];

                $ver = '?ver=' . $item[ 'ver' ];
            }

            echo '<script id="' . $name . '" src="' . $path . $ver . '"></script>';
        }
    } 
}

?>