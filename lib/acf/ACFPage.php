<?php

class ACFPage
{
    const FIELD_TRID = 'page-translation-group';

    const FIELD_LABEL = 'page-translation-group-label';

    const JS = Template::LEGAL_URL . '/assets/js/acf/acf-page.js';

    public static function register_script()
    {
        wp_register_script( 'acf-page', self::JS, [], false, true);

        wp_enqueue_script( 'acf-page' );
    }

    public static function register()
    {
        $handler = new self();

        add_filter( 'acf/load_field/name=' . self::FIELD_TRID, [ $handler, 'choices' ] );

        add_action( 'admin_enqueue_scripts', [ $handler, 'register_script' ] );
    }

    public static function choices( $field )
    {
        $items = WPMLTrid::get();

        if ( !empty( $items ) ) {
            foreach( $items as $item ) {
                $title = get_post_meta( $item->legal_element_id, self::FIELD_LABEL, true );

                if ( $title ) {
                    $item->legal_title .= ' ( ' . $title . ' )';
                }

                $field['choices'][$item->legal_trid] = $item->legal_title . ' [' . $item->legal_language_codes . ']'; 
            }
        }

        $field['default_value'] = WPMLTrid::get_trid();

        return $field;
    }

    public static function debug( $message )
    {
        echo '<pre>WPMLLangSwitcher::debug: ' . print_r( $message, true ) . '</pre>';
    }
}

?>