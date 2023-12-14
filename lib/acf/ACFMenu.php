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

        $choices[ 'legal-has-href' ] = 'Has Href';

        $choices[ 'legal-country-rocket' ] = '[ rocket ] Betting sites';

        $choices[ 'legal-country-football' ] = '[ football ] Sports';

        $choices[ 'legal-country-payment' ] = '[ payment ] Payment';

        $choices[ 'legal-country-bonus' ] = '[ bonus ] Bonuses';

        $choices[ 'legal-country-casino' ] = '[ casino ] Casino';

        $choices[ 'legal-country-all' ] = '[ all ] Choose your country';

        if ( !empty( $langs ) ) {
            foreach( $langs as $lang ) {
                $choices[ 'legal-country-' . $lang[ 'code' ] ] = '[ ' . $lang[ 'code' ] . ' ] ' . $lang[ 'native_name' ]; 
            }
        }

        $field[ 'choices' ] = $choices;

        return $field;
    }
}

?>