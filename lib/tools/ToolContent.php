<?php

class ToolContent
{
	public static function remove_empty_lines( $content )
	{
		return preg_replace("/&nbsp;/", "", $content);;
	}

	public static function register()
    {
        $handler = new self();

		add_action( 'content_save_pre', [ $handler, 'remove_empty_lines' ] );
    }
}

?>