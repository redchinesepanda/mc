<?php

require_once( 'ReviewAbout.php' );

require_once( 'ReviewAnchors.php' );

require_once( 'ReviewGroup.php' );

require_once( 'ReviewProsCons.php' );

require_once( 'ReviewGallery.php' );

require_once( 'ReviewFAQ.php' );

require_once( 'ReviewStats.php' );

require_once( 'ReviewBonus.php' );

require_once( 'ReviewHowTo.php' );

require_once( 'ReviewBanner.php' );

require_once( 'ReviewAuthor.php' );

require_once( 'ReviewCounter.php' );

require_once( 'ReviewList.php' );

class ReviewMain
{
    const CSS = [
        'review-main' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-main.css',

            'ver' => '1.1.0',
        ],

        'review-overview' => LegalMain::LEGAL_URL . '/assets/css/review/review-overview.css',

        'review-title' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-title.css',

            'ver' => '1.0.2',
        ],

        'review-table' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-table.css',

            'ver' => '1.0.1',
        ],
    ];

    public static function register_style( $styles = [] )
    {
        if ( self::check() ) {
            if ( empty( $styles ) ) {
                $styles = self::CSS;
            }

            ToolEnqueue::register_style( $styles );
        }
    }

    public static function register_script( $scripts = [] )
    {
        if ( self::check() ) {
            if ( empty( $scripts ) ) {
                $styles = self::JS;
            }

            ToolEnqueue::register_script( $scripts );
        }
    }

    const JS = [
        'schema' => 'legal-schema',
    ];

    public static function print()
    {
        if ( self::check() ) {
            echo '<script id="' . self::JS[ 'schema' ] . '" type="application/ld+json">' . self::schema() . '</script>';
        }
    }

    public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_head', [ $handler, 'print' ] );
        
        add_filter( 'content_save_pre' , [ $handler, 'encoding' ], 10, 1);

        ReviewAbout::register();

        ReviewAnchors::register();

        ReviewGroup::register();

        ReviewProsCons::register();

        ReviewGallery::register();

        ReviewFAQ::register();

        ReviewStats::register();

        ReviewBonus::register();

        ReviewHowTo::register();

        ReviewBanner::register();

        ReviewAuthor::register();

        ReviewCounter::register();

        ReviewList::register();
    }

    public static function encoding( $content )
    {
        return ToolEncode::encode( $content );
    }

    public static function check()
    {
        $permission_post_type = is_singular( [ 'legal_bk_review' ] );

        $permission_admin = !is_admin();

        $permission_tax = has_term( 'compilation', 'page_type' ); 
        
        return ( $permission_admin && ( $permission_post_type || $permission_tax ) );
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
                self::schema_organization(),

                LegalBreadcrumbsMain::schema(),

                ReviewHowTo::schema(),

                ReviewFAQ::schema(),

                self::schema_publisher(),
            ],
        ] );
    }

    public static function schema_organization()
    {
        return [
            "@context" => "https://schema.org",
            
            "@type" => "Organization",
            
            "name" => "Match.Center",
            
            "url" => "https://match.center/",

            "logo" => "https://match.center/wp-content/uploads/match-center.png",
        ];
    }

    public static function schema_webpage()
    {
        return [
            "@context" => "https://schema.org",

            "@type" => "WebPage",

            "headline" => YoastMain::get_seo_title(),

            "author" => self::schema_author(),

            "publisher" => self::schema_publisher(),

            "description" => YoastMain::get_seo_description(),
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
        ];
    }
}

?>