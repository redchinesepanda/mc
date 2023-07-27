<?php

class ToolLoco
{
    const TEXTDOMAIN = 'thrive-theme-child';

    public static function register()
    {
        $handler = new self();
        
        add_action( 'after_setup_theme', [ $handler, 'loco' ] );

        add_filter( 'loco_extracted_template', [ $handler, 'add_custom_string'] , 10, 2 );
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

    public static function add_custom_string( Loco_gettext_Extraction $extraction, $domain )
    {
        LegalDebug::debug( [
            'domain' => $domain,

            'extraction' => $extraction,
        ] );

        if ( self::TEXTDOMAIN === $domain )
        {
            $custom = new Loco_gettext_String( 'Legal Review BK Footer' );

            // $custom->addExtractedComment( 'This is a footer menu location name' );

            // $custom->addFileReferences( 'custom.yml:1' );

            $extraction->addString( $custom, $domain );

            // LegalDebug::debug( [
            //     'domain' => $domain,

            //     'custom' => $custom,

            //     'extraction' => $extraction,
            // ] );
        }
    }
}

?>