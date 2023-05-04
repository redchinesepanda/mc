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

    public static function register_inline_script()
    {
        $name = 'legal-schema';

        wp_register_script( $name, false, [], false, true );

        wp_add_inline_script( $name, self::schema() );

        wp_enqueue_script( $name );

        $post = get_post();

        LegalDebug::debug( [
            '$post' => $post,
        ] );

        if ( !empty( $post ) ) {
            wp_script_add_data( $name, 'data-schema', $post->ID . '-' . $post->post_type . '-legal' );
        }
    }

    public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_script' ] );
        
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
        return json_encode( [
            "@context" => "https://schema.org",

            "@graph" => [
                [
                    "@type" => "WebPage",

			        "@id" => "https://match.center/ng/betting-sites/",
                ],

                [
                    "@type" => "FAQPage",

                    "mainEntity" => [
                        [
                            "@type" => "Question",

                            "name" => "What's the best betting site in Nigeria in 2022?",

                            "acceptedAnswer" => [
                                "@type" => "Answer",

                                "text" => "Every bookmaker has advantages compared to the competitors: high odds, a wide range of markets, good bonus offers, e-sports betting, fast withdrawal and so on. On this page we have highlighted the best betting sites and reputable bookies based on the most important criteria. Still it\u2019s up to you to decide which aspects are more important and which bookmaker is the best.",
                            ]
                        ],
                    ],
                ],
            ],
        ] );
    }
}

?>