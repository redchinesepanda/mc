<?php

class ACFMenu
{
    const FIELD = [
        'class' => 'menu-item-class',
    ];

    public static function register()
    {
        $handler = new self();

        add_filter( 'acf/load_field/name=' . self::FIELD[ 'class' ], [ $handler, 'choices' ] );
    }

    function choices( $field )
    {
        $langs = WPMLMain::get_all_languages();

        // LegalDebug::debug( [
        //     'function' => 'ACFMenu::choices',

        //     'langs' => $langs,
        // ] );

        if ( !empty( $langs ) ) {
            foreach( $langs as $lang ) {
                $field[ 'choices' ][ 'legal-country-' . $lang[ 'code' ] ] = '[ ' . $lang[ 'code' ] . ' ] ' . $lang[ 'native_name' ]; 
            }
        }

        return $field;
    }
}

?>