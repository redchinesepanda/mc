<?php

class ReviewSchema
{
    const JS = [
        'schema' => 'legal-schema',
    ];

	public static function register()
    {
        $handler = new self();

        add_action( 'wp_head', [ $handler, 'review_ld_json' ] );
	}

    public static function review_ld_json()
    {
        if ( ReviewMain::check() ) {
            echo '<script id="' . self::JS[ 'schema' ] . '" type="application/ld+json">' . self::schema() . '</script>';
        }
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

    public static function schema_publisher()
    {
        return [
            "@context" => "https://schema.org",

            "@type" => "Organization",

            "name" => "Match.Center",

            "legalName" => "Match.Center",

			"url" => get_site_url(),

			"logo" => [
				"@type" => "ImageObject",

				"url" => LegalMain::LEGAL_URL . '/assets/img/base/header/header-logo-mc-desktop.svg',
			],
        ];
    }

    public static function schema_author()
	{
		return ReviewAuthor::schema();
	}

    // public static function schema_author()
    // {
    //     return [
    //         "@context" => "https://schema.org",

    //         "@type" => "Person",

    //         "name" => "Andrew Heaford",

    //         "url" => "https://match.center/ng/about-us/#our-team",

    //         "image" => "https://match.center/wp-content/uploads/andy-scaled-e1657268424214.jpg",

    //         "jobTitle" => "Site manager",

    //         "worksFor" => self::schema_publisher(),
    //     ];
    // }

    public static function schema_webpage()
    {
        return [
            "@context" => "https://schema.org",

            "@type" => "WebPage",

			"name" => YoastMain::get_seo_title(),

            // "headline" => YoastMain::get_seo_title(),

            "description" => YoastMain::get_seo_description(),

			"url" => get_post_permalink(),

            "author" => self::schema_author(),

			"datePublished" => get_the_date(),

            "publisher" => self::schema_publisher(),
        ];
    }

	public static function schema()
    {
        if ( ! ReviewMain::check() )
        {
            return json_encode( [] );
        }

        $post = get_post();

        if ( empty( $post ) ) {
            return json_encode( [] );
        }

        $graph = [
            // self::schema_organization(),

            // self::schema_publisher(),

            self::schema_webpage(),
        ];

        $breadcrumbs = LegalBreadcrumbsMain::schema();

        if ( !empty( $breadcrumbs ) )
        {
            $graph[] = $breadcrumbs;
        }

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

        // return json_encode(
        //     [
        //         "@context" => "https://schema.org",

        //         "@graph" => $graph,
        //     ],

        //     JSON_UNESCAPED_UNICODE
        // );
        
        return json_encode(
            [
                "@context" => "https://schema.org",

                "@graph" => $graph,
            ]
        );
    }
}

?>