<?php

class ToolShortcode
{
	public static function validate_array( $attr )
    {
        return explode( ',', self::filter_space( $atts[ 'id' ] ) );
    }

	public static function filter_space( $string )
    {
        return preg_replace(
            '/\s*,\s*/',
            
            ',',
            
            filter_var( $string, FILTER_SANITIZE_STRING )
        );
    }
}

?>