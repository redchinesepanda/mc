<?php

require_once( 'YoastOG.php' );

class YoastMain
{
    public static function register()
    {
        YoastOG::register();
    }

    public static function register_functions()
    {
        $handler = new self();

        add_filter( 'wpseo_sitemap_entries_per_page', [ $handler, 'max_entries_per_sitemap' ] );

        // add_filter( 'wpseo_xml_sitemap_post_url', [ $handler, 'sitemap_post_url' ], 10, 2 );

        \add_filter( 'wpseo_indexable_forced_included_post_types', [ $handler, 'include_post_types' ] );

        \add_action( 'init', [ $handler, 'init' ] );

        \add_filter( 'wpseo_force_creating_and_using_attachment_indexables', '__return_true' );

        add_action( 'wpseo_register_extra_replacements', [ $handler, 'register_my_plugin_extra_replacements' ] );
    }

    function register_my_plugin_extra_replacements()
    {
        // wpseo_register_var_replacement( '%%billetsamount%%', 'retrieve_billetsamount_replacement', 'advanced', 'this is a help text for myvar1' );
        
        wpseo_register_var_replacement( '%%billetsamount%%', 'retrieve_billetsamount_replacement', 'basic', 'This is a current tabs unique billets amount' );
        
        // wpseo_register_var_replacement( 'myvar2', array( 'class', 'method_name' ), 'basic', 'this is a help text for myvar2' );
    }

    function retrieve_billetsamount_replacement( $var1 )
    {
        return CompilationTabs::get_billets_amount();
    }

    public static function include_post_types( $post_types )
    {
        $post_types[] = 'attachment';

        return $post_types;
    }

    public static function init( $post_types )
    {
        $handler = new self();

        \add_filter( 'wpseo_indexable_excluded_post_types', [ $handler, 'exclude_post_types' ] );
    }
    
    public static function exclude_post_types( $post_types )
    {
        $filtered_post_types = [];

        foreach ( $post_types as $post_type )
        {
           if ( $post_type !== 'attachment' )
           {
              $filtered_post_types[] = $post_type;
           }
        }

        return $filtered_post_types;
    }

    public static function max_entries_per_sitemap()
    {
        return 250;
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

    const PLACEHOLDER = [
        'billets-amount' => '{billets-amount}',
    ];

    public static function get_seo_title()
    {
        if ( !LegalMain::check_plugins() )
        {
            return '';
        }

        $post = get_post();

        if ( $post )
        {
            // $title = YoastSEO()->meta->for_post( $post->ID )->title;

            // if ( str_contains( $title, self::PLACEHOLDER[ 'billets-amount' ] ) )
            // {

            //     $title = str_replace( self::PLACEHOLDER[ 'billets-amount' ], CompilationTabs::get_billets_amount(), $title );
            // }

            // return $title;

            return YoastSEO()->meta->for_post( $post->ID )->title;
        }

        return '';
    }

    public static function get_seo_description()
    {
        $post = get_post();

        if ( $post )
        {
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