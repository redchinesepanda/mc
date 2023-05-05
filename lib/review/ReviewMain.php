<?php

require_once( 'ReviewAbout.php' );

require_once( 'ReviewAnchors.php' );

require_once( 'ReviewGroup.php' );

require_once( 'ReviewProsCons.php' );

require_once( 'ReviewGallery.php' );

require_once( 'ReviewFAQ.php' );

require_once( 'ReviewStats.php' );

require_once( 'ReviewBonus.php' );

class ReviewMain
{
    const CSS = [
        'review-main' => LegalMain::LEGAL_URL . '/assets/css/review/review-main.css',

        'review-overview' => LegalMain::LEGAL_URL . '/assets/css/review/review-overview.css',

        'review-list' => LegalMain::LEGAL_URL . '/assets/css/review/review-list.css',

        'review-title' => LegalMain::LEGAL_URL . '/assets/css/review/review-title.css',

        'review-table' => LegalMain::LEGAL_URL . '/assets/css/review/review-table.css',
    ];

    public static function register_style()
    {
        foreach ( self::CSS as $name => $path ) {
            wp_enqueue_style( $name, $path );
        }
    }

    const JS = [
        'schema' => 'legal-schema',
    ];

    // public static function register_inline_script()
    // {
    //     // wp_register_script( self::NAME[ 'schema' ], false, [], false, true );
        
    //     wp_register_script( self::NAME[ 'schema' ], self::schema(), [], false, true );

    //     // wp_add_inline_script( self::NAME[ 'schema' ], self::schema() );

    //     wp_enqueue_script( self::NAME[ 'schema' ] );
    // }

    public static function print()
    {
        echo '<script id="' . self::JS[ 'schema' ] . '" type="application/ld+json">' . self::schema() . '</script>';
    }

    public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        // add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_script' ] );

        // add_filter( 'script_loader_tag', [ $handler, 'add_type_attribute' ], 10, 3 );

        add_action( 'wp_head', 'print' );
        
        add_filter( 'content_save_pre' , [ $handler, 'encoding' ], 10, 1);

        ReviewAbout::register();

        ReviewAnchors::register();

        ReviewGroup::register();

        ReviewProsCons::register();

        ReviewGallery::register();

        ReviewFAQ::register();

        ReviewStats::register();

        ReviewBonus::register();
    }

    public static function encoding( $content )
    {
        return ToolEncode::encode( $content );
    }

    public static function is_front()
    {
        return ( !is_admin() && is_page() );
    }

    public static function schema()
    {
        $post = get_post();

        if ( empty( $post ) ) {
            return json_encode( [] );
        }

        return json_encode( [
            "@context" => "https://schema.org",

            "@graph" => [
                self::schema_webpage(),

                LegalBreadcrumbsMain::schema(),

                ReviewFAQ::schema(),
            ],
        ] );
    }

    public static function schema_webpage()
    {
        return [
            "@context" => "https://schema.org",

            "@type" => "WebPage",

            "name" => YoastMain::get_seo_title(),

            "description" => YoastMain::get_seo_description(),

            "publisher" => self::schema_publisher(),

            "author" => self::schema_author(),
        ];
    }

    public static function schema_author()
    {
        return [
            "@context" => "https://schema.org",

            "@type" => "Person",

            "name" => "Andrew Heaford",

            "url" => "https://match.center/ng/about-us/#our-team",

            "image" => "https://match.center/wp-content/uploads/andy-scaled-e1657268424214.jpg",

            "jobTitle" => "Site manager",

            "worksFor" => self::schema_publisher(),
        ];
    }

    public static function schema_publisher()
    {
        return [
            "@context" => "https://schema.org",

            "@type" => "Organization",

            "name" => "Match.Center",

            "legalName" => "Match.Center",

            "logo" => [
                "@context" => "https://schema.org",

                "@type" => "ImageObject",

                "contentUrl" => "https://match.center/wp-content/uploads/match-center.png",

                "height" => '20 px',

                "width" => '213 px',
            ],
        ];
    }

    // public static function add_type_attribute( $tag, $handle, $src ) {
    //     if ( $handle !== self::NAME[ 'schema' ] ) {
    //         return $tag;
    //     }

    //     // LegalDebug::debug( [
    //     //     '$tag' => $tag,
            
    //     //     '$handle' => $handle,

    //     //     '$src' => $src,
    //     // ] );

    //     return str_replace( 'text/javascript', 'application/ld+json', $tag );

    //     // $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';

    //     return $tag;
    // }
}

?>