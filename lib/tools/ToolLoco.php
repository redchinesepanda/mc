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
        return __( $string, ToolLoco::TEXTDOMAIN );
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

            ToolLoco::TEXTDOMAIN
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

	// public static function translate_plural( $pattern, $value )
	
    // public static function translate_plural( $pattern, $values )
	// {
	// 	// return sprintf(
		
    //     return vsprintf(
	// 		_n(
	// 			$pattern[ 'single' ],

	// 			$pattern[ 'plural' ],
			
	// 			$values[ 0 ],

	// 			ToolLoco::TEXTDOMAIN
	// 		),
			
	// 		$values
	// 	);
	// }

    public static function translate_locale( $string, $locale )
    {
        return self::get_translation_locale( $string, ToolLoco::TEXTDOMAIN, $locale );
    }

    public static function get_translation_locale( $string, $textdomain, $locale )
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