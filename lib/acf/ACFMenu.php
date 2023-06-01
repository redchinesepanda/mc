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

        $field[ 'choices' ][ 'legal-country-rocket' ] = '[ rocket ] Betting sites';

        $field[ 'choices' ][ 'legal-country-football' ] = '[ football ] Sports';

        $field[ 'choices' ][ 'legal-country-bonus' ] = '[ bonus ] Bonuses';

        $field[ 'choices' ][ 'legal-country-all' ] = '[ all ] Choose your country';

        if ( !empty( $langs ) ) {
            foreach( $langs as $lang ) {
                $field[ 'choices' ][ 'legal-country-' . $lang[ 'code' ] ] = '[ ' . $lang[ 'code' ] . ' ] ' . $lang[ 'native_name' ]; 
            }
        }

        return $field;
    }
}

?>