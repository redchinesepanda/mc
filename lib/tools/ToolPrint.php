<?php

class ToolPrint
{
    public static function print( $styles = [] )
    {
        foreach ( $styles as $name => $item ) {
            $path = $item;

            $ver = false;

            if ( is_array( $item ) ) {
                $path = $item[ 'path' ];

                $ver = $item[ 'ver' ];
            }

            echo '<link id="' . $name . '" href="' . $path . '" rel="stylesheet" />';
        }
    }
}

?>