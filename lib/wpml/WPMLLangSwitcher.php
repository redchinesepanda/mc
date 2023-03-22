<?php

class WPMLLangSwitcher
{
    public static function register() {
        $message[] = 'WPMLLangSwitcher::register';

        $handler = new self();

        // [legal-lang-switcher]

        add_shortcode( 'legal-lang-switcher', [ $handler, 'get' ] );

        self::debug( $message );
    }

    function get_all() {
        $languages = apply_filters(
            'wpml_active_languages',

            NULL,
            [
                'skip_missing' => 0,

                'orderby' => 'id',

                'order' => 'asc',
            ]
        );

        return $languages;
    }

    public static function get_active( &$args )
    {
        $args_active = array_column( $args, 'active' );

        $key = array_search( true, $args_active );

        $active = array_splice( $args, $key, 1 );

        return self::map( $active[0] );
    }

    private static function map( $args )
    {
        $mapped['title'] = $args['native_name'];

        $mapped['href'] = $args['url'];

        $mapped['src'] = $args['country_flag_url'];

        $mapped['alt'] = $args['translated_name'] . '-flag';

        return $mapped;
    }

    public function get()
    {
        $message['function'] = 'WPMLLangSwitcher::get';

        $languages = self::get_all();

        // $message['languages'] = $languages;

        $args['active'] = self::get_active( $languages );

        foreach ( $languages as $lang ) {
            $args['languages'][] = self::map( $lang );
        }

        $message['args'] = $args;

        self::debug( $message );
    }

    public static function debug( $message )
    {
        echo '<pre>WPMLLangSwitcher::debug: ' . print_r( $message, true ) . '</pre>';
    }
}

?>