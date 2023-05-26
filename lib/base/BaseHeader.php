<?php

class BaseHeader
{
	public static function register()
    {
        $handler = new self();

        add_action( 'init', [ $handler, 'location' ] );
    }
	
	public static function location() {
		register_nav_menu( 'legal-main', __( 'Legal Review BK', ToolLoco::TEXTDOMAIN ) );
	}
}

?>