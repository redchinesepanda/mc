<?php

class WPMLLangSwitcher
{
    const TEMPLATE = Template::LEGAL_PATH . '/template-parts/wpml/wpml-lang-switcher.php';

    const CSS = Template::LEGAL_URL . '/assets/css/wpml/wpml-lang-switcher.css';

    public static function register_script()
    {
        wp_enqueue_style( 'wpml-lang-switcher', self::CSS );
    }

    public static function register() {
        $handler = new self();

        // [legal-lang-switcher]

        add_shortcode( 'legal-lang-switcher', [ $handler, 'render' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
    }

    private static function get_all() {
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

    private static function get_active( &$args )
    {
        $args_active = array_column( $args, 'active' );

        $key = array_search( 1, $args_active );

        $active = array_splice( $args, $key, 1 );

        return self::map( array_shift( $active ) );
    }

    private static function map( $args )
    {
        $mapped['title'] = $args['native_name'];

        $mapped['href'] = $args['url'];

        $mapped['src'] = $args['country_flag_url'];

        $mapped['alt'] = $args['translated_name'] . '-flag';

        return $mapped;
    }

    public static function get()
    {
        $languages = self::get_all();

        $args['active'] = self::get_active( $languages );

        foreach ( $languages as $lang ) {
            $args['languages'][] = self::map( $lang );
        }

        return $args;
    }

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE, false, self::get() );

        $output = ob_get_clean();

        return $output;
    }

    public static function debug( $message )
    {
        echo '<pre>WPMLLangSwitcher::debug: ' . print_r( $message, true ) . '</pre>';
    }
}

?>