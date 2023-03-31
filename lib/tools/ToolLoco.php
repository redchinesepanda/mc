<?php

class ToolLoco
{
    public static function register()
    {
        $handler = new sel

        add_action( 'after_setup_theme', [ $handler, 'loco' ] );
    }
    
    public static function loco() {
        load_child_theme_textdomain( 'thrive-theme-child', LegalMain::LEGAL_PATH . '/languages' );
    }
}

?>