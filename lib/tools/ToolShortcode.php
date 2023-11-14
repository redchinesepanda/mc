<?php

class ToolShortcode
{
	public static function validate_array( $value )
    {
		if ( !is_array( $value ) )
		{
			return explode( ',', self::filter_space( $value ) );
		}

		return $value;
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