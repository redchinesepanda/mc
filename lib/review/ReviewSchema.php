<?php

class ReviewSchema
{
    // const JS = [
    //     'schema' => 'legal-schema',
    // ];

	public static function register()
    {
        $handler = new self();

        add_action( 'wp_head', [ $handler, 'review_ld_json' ] );
	}

    public static function schema_organization()
    {
        return [
            // "@context" => "https://schema.org",
            
            "@type" => "Organization",
            
            "name" => "Match.Center",
            
            "url" => "https://match.center/",

            "logo" => "https://match.center/wp-content/uploads/match-center.png",
        ];
    }

    public static function schema_publisher()
    {
        return [
            // "@context" => "https://schema.org",

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

    public static function schema_author_short()
	{
		return ReviewAuthor::schema_short();
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

    const SHEMA_TYPES = [
        'web-page' => 'WebPage',

        'item-page' => 'ItemPage',

        'review' => 'Review',

        'article' => 'Article',
    ];

    public static function check_type()
    {
        return TemplateMain::check();
    }

    public static function check_review()
    {
        return TemplatePage::check_review();
    }

    public static function check_article()
    {
        return TemplatePage::check_compilation()

            || TemplateSingle::check_bonus()

            || TemplateSingle::check_wiki();
    }

    public static function get_shema_type()
    {
        if ( self::check_type() )
        {
            if ( self::check_review() )
            {
                return self::SHEMA_TYPES[ 'review' ];
            }

            if ( self::check_article() )
            {
                return self::SHEMA_TYPES[ 'article' ];
            }
        }

        return self::SHEMA_TYPES[ 'web-page' ];
    }

    public static function get_url()
    {
        return get_permalink();
    }

    public static function get_date_published()
    {
        return get_the_date();
    }

    public static function schema_webpage()
    {
        return [
            "@context" => "https://schema.org",

            // "@type" => "WebPage",
            
            "@type" => self::get_shema_type(),

			// "name" => YoastMain::get_seo_title(),

            "headline" => YoastMain::get_seo_title(),

            "description" => YoastMain::get_seo_description(),

			"url" => self::get_url(),

            "author" => self::schema_author(),

			"datePublished" => self::get_date_published(),

            "publisher" => self::schema_publisher(),
        ];
    }

	public static function schema()
    {
        // if ( ! ReviewMain::check() )
        // {
        //     return json_encode( [] );
        // }

        $post = get_post();

        if ( empty( $post ) )
        {
            return json_encode( [] );
        }

        $graph = [
            // self::schema_organization(),

            // self::schema_publisher(),

            // self::schema_author(),

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

    public static function get()
    {
        return [
            'schema' => self::schema(),
        ];
    }

    const TEMPLATE = [
        'ld-json' => 'review-schema-main.php',
    ];

    public static function review_ld_json()
    {
        // if ( ReviewMain::check() ) {
        //     echo '<script id="' . self::JS[ 'schema' ] . '" type="application/ld+json">' . self::schema() . '</script>';
        // }

        echo LegalComponents::render_main( self::TEMPLATE[ 'ld-json' ], self::get() );
    }
}

?>