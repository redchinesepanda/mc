<?php

class ACFCompilation
{
    const FIELD = [
        'lang' => 'compilation-lang',
    ];

    public static function register()
    {
        $handler = new self();

        add_filter( 'acf/load_field/name=' . self::FIELD[ 'lang' ], [ $handler, 'choices' ] );
    }

    public static function choices( $field )
    {
        $languages = WPMLLangSwitcher::choises();

        foreach( $languages as $language )
        {
            $field[ 'choices' ][ $language[ 'language_code' ] ] = $language[ 'native_name' ] . ' [' . $language[ 'language_code' ] . ']';
        }

        return $field;
    }
}

?>