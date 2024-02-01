<?php

require_once( 'YoastOG.php' );

class YoastMain
{
    public static function register_functions()
    {
        $handler = new self();

        add_filter( 'wpseo_sitemap_entries_per_page', [ $handler, 'max_entries_per_sitemap' ] );

        // add_filter( 'wpseo_xml_sitemap_post_url', [ $handler, 'sitemap_post_url' ], 10, 2 );
    }

    // public static function sitemap_post_url( $url, $post )
    // {
    //     LegalDebug::debug( [
    //         'YoastMain' => 'sitemap_post_url',

    //         'ID' => $post->ID,

    //         'page_on_front' => get_option( 'page_on_front' ),

    //         'get_permalink' => get_permalink( $post->ID ),

    //         'get_post_permalink' => get_post_permalink( $post->ID ),

    //         // 'url' => $_SERVER[ 'REQUEST_SCHEME' ] . '://' . $_SERVER['HTTP_HOST'],
    //     ] );

    //     if ( $post->ID == get_option( 'page_on_front' ) )
    //     {
    //         return $_SERVER[ 'REQUEST_SCHEME' ] . '://' . $_SERVER['HTTP_HOST'];
    //     }
    
    //     return $url;
    // }
    
    public static function register()
    {
        YoastOG::register();
    }

    public static function max_entries_per_sitemap()
    {
        return 250;
    }

    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/yoast/part-yoast-main.php';

    public static function print()
    {
        $args = self::get();

        echo '<title>' . $args['title'] . '</title>';

        foreach ( $args['meta'] as $key => $value ) {
            echo '<meta name="' . $key . '" content="' . $value . '" />';
        }
    }

    private static function get()
    {
        // $message['function'] = 'get';

        $post = get_post();

        return [
            'title' => YoastSEO()->meta->for_post( $post->ID )->title,

            'meta' =>
            [
                'description' => YoastSEO()->meta->for_post( $post->ID )->description,
            
                'keywords' => 'keywords',
                
                'author' => 'author',

                'viewport' => 'width=device-width, initial-scale=1.0',
            ]
        ];

        // $message['args'] = $args;

        // self::debug( $message );
    }

    public static function get_seo_title() {
        $post = get_post();

        if ( $post ) {
            return YoastSEO()->meta->for_post( $post->ID )->title;
        }

        return '';
    }

    public static function get_seo_description() {
        $post = get_post();

        if ( $post ) {
            return YoastSEO()->meta->for_post( $post->ID )->description;
        }

        return '';
    }

    public static function render()
    {
        load_template( self::TEMPLATE, false, self::get() );
    }

    public static function render_ob()
    {
        ob_start();

        load_template( self::TEMPLATE, false, self::get() );

        $output = ob_get_clean();

        echo $output;
    }
}

?>