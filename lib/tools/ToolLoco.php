<?php

class ToolLoco
{
    const TEXTDOMAIN = 'mc-theme'; 

    public static function register()
    {
        $handler = new self();
        
        add_action( 'after_setup_theme', [ $handler, 'loco' ] );

        add_filter( 'loco_extracted_template', [ $handler, 'add_custom_string'] , 10, 2 );

        add_filter( 'loco_extracted_template', [ $handler, 'add_custom_string_plural'] , 10, 2 );
    }
    
    public static function loco() {
        load_child_theme_textdomain( self::TEXTDOMAIN, LegalMain::LEGAL_PATH . '/languages' );
    }

    public static function translate( $string )
    {
        return __( $string, self::TEXTDOMAIN );
    }

	public static function fill_pattern( $pattern, $value )
    {
        return sprintf(
            self::get_pattern( $pattern, $value ),
			
			$value
		);
    }

	public static function fill_pattern_values( $pattern, $values )
    {
        return vsprintf(
            self::get_pattern( $pattern, $values[ 0 ] ),
			
			$values
		);
    }

	public static function get_pattern( $pattern, $value )
    {
        return _n(
            $pattern[ 'single' ],

            $pattern[ 'plural' ],
        
            $value,

<<<<<<< HEAD
            ToolLoco::TEXTDOMAIN
=======
            self::TEXTDOMAIN
>>>>>>> 34b2d3c93fd6666bc9ca6e2d4e4c76cfba7f79d5
        );
    }

    public static function translate_plural( $pattern, $values )
    {
        if ( is_array( $values ) )
        {
            return self::fill_pattern_values( $pattern, $values );
        }

        return self::fill_pattern( $pattern, $values );
    }
<<<<<<< HEAD

    public static function translate_locale( $string, $locale )
    {
        return self::get_translation_locale( $string, ToolLoco::TEXTDOMAIN, $locale );
    }

    public static function get_translation_locale( $string, $textdomain, $locale )
=======
    
    public static function translate_locale( $string, $locale )
>>>>>>> 34b2d3c93fd6666bc9ca6e2d4e4c76cfba7f79d5
    {
        global $l10n;

        $backup_l10n_item = '';
        
        if ( !empty( $l10n[ self::TEXTDOMAIN ] ) )
        {
            $backup_l10n_item = $l10n[ self::TEXTDOMAIN ];
        }

        load_textdomain( self::TEXTDOMAIN, LegalMain::LEGAL_PATH . '/languages/'. $locale . '.mo');

        $translation = __( $string, self::TEXTDOMAIN );

        if ( !empty( $backup_l10n_item ) )
        {
            $l10n[ self::TEXTDOMAIN ] = $backup_l10n_item;
        }

        return $translation;
    }

    public static function add_custom_string( Loco_gettext_Extraction $extraction, $domain )
    {
        if ( self::TEXTDOMAIN === $domain )
        {
            $lines = array_merge(
                BilletMain::TEXT,

                BaseMain::TEXT,

                ReviewMain::TEXT,

                array_keys( ReviewAnchors::TEXT_ANCHORS ),
                
                ReviewAnchors::TEXT_ANCHORS,

                BonusMain::TEXT,

                WikiMain::TEXT,
            );

            foreach ( $lines as $line )
            {
                $custom = new Loco_gettext_String( $line );
    
                // $custom->addExtractedComment( 'This is a footer menu location name' );
    
                // $custom->addFileReferences( 'custom.yml:1' );
    
                $extraction->addString( $custom, $domain );
            }
        }
    }

    public static function add_custom_string_plural( Loco_gettext_Extraction $extraction, $domain )
    {
        if ( self::TEXTDOMAIN === $domain )
        {
            $lines = array_merge(
                BonusMain::TEXT_PLURAL
            );

            foreach ( $lines as $line )
            {
                $custom = new Loco_gettext_String( $line[ 'single' ] );

                $custom->pluralize( $line[ 'plural' ] );
    
                $extraction->addString( $custom, $domain );
            }
        }
    }
}

?>