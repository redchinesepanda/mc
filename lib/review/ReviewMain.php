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

require_once( 'ReviewOffers.php' );

require_once( 'ReviewTitle.php' );

class ReviewMain
{
	const TEXT = [
		'alexander-kachalov' => 'Alexander Kachalov',

		'app' => 'App',

		'bet-here' => 'Bet here',

		'bonus' => 'Bonus',

		'bookmaker-review' => 'Bookmaker Review',

		'bookmaker-lightbox' => 'Bookmaker Lightbox',

		'borja-imbergamo' => 'Borja Imbergamo',

		'claim-bonus' => 'Claim Bonus',

		'download' => 'Download',

		'get-bonus' => 'Get Bonus',

		'how-to-play' => 'How to play',

		'overall-rating' => 'Overall Rating',

		'page-contents' => 'Page contents',

		'promo-code' => 'Promo Code',

		'rating' => 'Rating',

		'registration' => 'Registration',

		'review' => 'Review',
        
		'valentin-axani' => 'Valentin Axani',

		'website-manager' => 'Website Manager',

		'website-administrator' => 'Website Administrator',

		'withdrawal' => 'Withdrawal',
	];

    const CSS = [
        'review-main' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-main.css',

            'ver' => '1.2.2',
        ],

        'review-overview' => LegalMain::LEGAL_URL . '/assets/css/review/review-overview.css',

        'review-table' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-table.css',

            'ver' => '1.0.8',
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

    public static function register_inline_style( $name = '', $data = '' )
    {
		if ( self::check() ) {
            ToolEnqueue::register_inline_style( $name, $data );
        }
    }

    public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_head', [ $handler, 'print' ] );

        // add_filter( 'content_save_pre' , [ $handler, 'encoding' ], 10, 1);

        ReviewAbout::register();

        ReviewAnchors::register();

        ReviewGroup::register();

        // ReviewProsCons::register();

        ReviewGallery::register();

        ReviewFAQ::register();

        ReviewStats::register();

        ReviewBonus::register();

        ReviewHowTo::register();

        ReviewBanner::register();

        // ReviewAuthor::register();

        // ReviewCounter::register();

        // ReviewList::register();

        // ReviewOffers::register();

        // ReviewTitle::register();
    }

    public static function encoding( $content )
    {
        return ToolEncode::encode( $content );
    }

    const TAXONOMY = [
        'page_type' => 'page_type',
    ];

    const TERMS = [
        'promo-codes',

        'bonus',

        'review',

        'app',

        'registration',

        'how-to-play',

        'withdrawal',

        'obzor-bk',

        'obzor-bk-betera',

        'obzor-bk-1xbet',

        'compilation',
    ];

    public static function check()
    {
        $permission_admin = !is_admin();

        $permission_post_type = is_singular( [ 'page', 'legal_bk_review' ] );
        
        $permission_term = has_term( self::TERMS, self::TAXONOMY[ 'page_type' ] );

        // $permission_post_single = is_singular( [ 'post', 'page' ] );
        
        $permission_post_single = is_singular( [ 'post' ] );

        $result = ( $permission_admin && $permission_post_type && $permission_term ) || $permission_post_single;

        // LegalDebug::debug( [
        //     'permission_admin' => $permission_admin ? 'true' : 'false',

        //     'permission_post_type' => $permission_post_type ? 'true' : 'false',

        //     'permission_term' => $permission_term ? 'true' : 'false',

        //     'permission_post_single' => $permission_post_single ? 'true' : 'false',

        //     'result' => $result ? 'true' : 'false',
        // ] );
        
        return $result;
    }

    public static function schema()
    {
        if ( !self::check() )
        {
            return json_encode( [] );
        }

        $post = get_post();

        if ( empty( $post ) ) {
            return json_encode( [] );
        }

        $graph = [
            self::schema_organization(),

            LegalBreadcrumbsMain::schema(),

            self::schema_publisher(),
        ];

        $faq = ReviewFAQ::schema();

        if ( !empty( $faq ) )
        {
            $graph[] = $faq;
        }

        $hwto = ReviewHowTo::schema();

        if ( !empty( $hwto ) )
        {
            $graph[] = $hwto;
        }

        return json_encode( [
            "@context" => "https://schema.org",

            "@graph" => $graph,
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