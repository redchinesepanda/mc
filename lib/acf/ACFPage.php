<?php

class ACFPage
{
    const FIELD = 'page-translation-group';

    const JS = Template::LEGAL_URL . '/assets/js/acf/acf-page.js';

    public static function register_script()
    {
        wp_register_script( 'acf-page', self::JS, [], false, true);

        wp_enqueue_script( 'acf-page' );
    }

    public static function register()
    {
        $handler = new self();

        add_filter( 'acf/load_field/name=' . self::FIELD, [ $handler, 'choices' ] );

        add_action( 'admin_enqueue_scripts', [ $handler, 'register_script' ] );
    }

    function choices( $field )
    {
        // $message['function'] = 'ACFPage::choices';

        $items = WPMLTrid::get();

        // $message['items'] = $items;

        if ( !empty( $items ) ) {
            foreach( $items as $item ) {
                $field['choices'][$item->legal_trid] = $item->legal_title . ' [' . $item->legal_language_codes . ']'; 
            }
        }

        // $message['choices'] = $field['choices'];

        // self::debug( $message );

        return $field;
    }

    public static function debug( $message )
    {
        echo '<pre>WPMLLangSwitcher::debug: ' . print_r( $message, true ) . '</pre>';
    }
}

?>