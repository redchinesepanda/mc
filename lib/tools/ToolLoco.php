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

    public static function __( $string, $textdomain, $locale )
    {
        global $l10n;

        if ( isset( $l10n[ $textdomain ] ) ) $backup = $l10n[ $textdomain ];

        load_textdomain( $textdomain, LegalMain::LEGAL_PATH . '/languages/'. $locale . '.mo');

        $translation = __( $string, $textdomain );
        if ( isset( $backup ) ) $l10n[ $textdomain ] = $backup;

        return $translation;
      }
}

?>