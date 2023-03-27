<?php

class ACFPage
{
    const FIELD = 'page-translation-group';

    public static function register()
    {
        $handler = new self();

        add_filter( 'acf/load_field/name=' . self::FIELD, [ $handler, 'choices' ] );
    }

    function choices( $field )
    {
        $items = WPMLLangSwitcher::get();

        if ( !empty( $items ) ) {
            foreach( $items as $item ) {
                $field['choices'][$item->legal_trid] = $item->legal_title . ' [' . $item->legal_language_codes . ']'; 
            }
        }

        return $field;
    }
}

?>