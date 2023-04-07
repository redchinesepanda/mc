<?php

class ACFCompilation
{
    const FIELD = 'compilation-lang';

    public static function register()
    {
        $handler = new self();

        add_filter( 'acf/load_field/name=' . self::FIELD, [ $handler, 'choices' ] );
    }

    public static function choices( $choices )
    {
        $languages = WPMLLangSwitcher::choises();

        foreach( $languages as $language ) {
            $choices[ $language['language_code'] ] = $language['native_name'] . ' [' . $language['language_code'] . ']';
        }

        self::debug( [
            'choices' => $choices,
        ] );

        return $choices;
    }

    public static function debug( $message )
    {
        echo ( '<pre>' . __CLASS__ . '::debug: ' . print_r( $message, true ) . '</pre>' );
    }
}

?>