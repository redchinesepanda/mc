<?php

class ToolLoco
{
    const TEXTDOMAIN = 'thrive-theme-child';

    public static function register()
    {
        $handler = new self();
        
        add_action( 'after_setup_theme', [ $handler, 'loco' ] );
    }
    
    public static function loco() {
        load_child_theme_textdomain( self::TEXTDOMAIN, LegalMain::LEGAL_PATH . '/languages' );
    }
}

?>