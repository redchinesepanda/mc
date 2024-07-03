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

    public static function schema_web_site()
    {
        return [
            "@context" => "https://schema.org",
            
            "@type" => "WebSite",
            
            "name" => "Match.Center",
            
            "url" => self::get_site_url(),
        ];
    }

    public static function schema_organization()
    {
        return [
            // "@context" => "https://schema.org",
            
            "@type" => "Organization",
            
            "name" => "Match.Center",
            
            "url" => self::get_site_url(),

            "logo" => self::shema_logo(),
        ];
    }

    public static function schema_publisher()
    {
        return [
            // "@context" => "https://schema.org",

            "@type" => "Organization",

            "name" => self::get_name(),

            "legalName" => self::get_name(),

			"url" => self::get_site_url(),

			// "logo" => [
			// 	"@type" => "ImageObject",

			// 	// "url" => LegalMain::LEGAL_URL . '/assets/img/base/header/header-logo-mc-desktop.svg',
				
            //     "url" => self::get_logo_url(),
			// ],

			"logo" => self::shema_logo(),
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
        // return get_the_date();

        // ISO 8601

        // LegalDebug::debug( [
        //     'get_the_date' => get_the_date( 'c' ),
        // ] );
        
        return get_the_date( 'c' );
    }

    public static function get_site_url()
    {
        return get_site_url();
    }

    public static function shema_logo()
    {
        return [
            "@type" => "ImageObject",

            "url" => LegalMain::LEGAL_URL . '/assets/img/base/header/header-logo-mc-desktop.svg',
        ];
    }

    public static function get_name()
    {
        return "Match.Center";
    }

    public static function get_item_rewived()
    {
        $review_about = ReviewAbout::get( [] );

        if ( ! empty( $review_about ) )
        {
            return $review_about;
        }

        return [];
    }

    public static function get_item_rewived_name( $review_about )
    {
        if ( ! empty( $review_about[ 'title' ] ) )
        {
            return $review_about[ 'title' ];
        }

        return self::get_name();
    }

    public static function get_item_rewived_logo( $review_about )
    {
        if ( ! empty( $review_about[ 'logo' ] ) )
        {
            return $review_about[ 'logo' ];
        }

        return self::get_name();
    }

    public static function schema_item_rewived( $review_about )
    {
        return [
            "@type" => "Organization",

            "name" => self::get_item_rewived_name( $review_about ),

            "url" => self::get_url(),
        ];
    }

    public static function schema_review()
    {
        $review_about = self::get_item_rewived();

        return [
            "@context" => "https://schema.org",

            "@type" => "Review",

            "itemReviewed" => self::schema_item_rewived( $review_about ),

            "author" => self::schema_author_short(),

            "datePublished" => self::get_date_published(),

            // "reviewRating" => [],

            "reviewBody" => YoastMain::get_seo_description(),
        ];
    }

    public static function shema_main_entity()
    {
        return [
            "@type" => "Product",

            "name" => "Betberry.io",

            "description" => "Букмекерская контора Betberry.io предлагает широкий выбор ставок и привлекательные бонусы.",

            "aggregateRating" => [
                "@type" => "AggregateRating",

                "ratingValue" => "4.5",

                "reviewCount" => "150",
            ],
        ];
    }

    public static function schema_item_page()
    {
        return [
            "@context" => "https://schema.org",

            "@type" => "ItemPage",

            "name" => YoastMain::get_seo_title(),

            "description" => YoastMain::get_seo_description(),

            "url" => self::get_url(),

            "author" => self::schema_author_short(),

            "datePublished" => self::get_date_published(),

            "publisher" => self::schema_publisher(),

            "mainEntity" => self::shema_main_entity(),
        ];
    }

    public static function schema_product()
    {
        return [
            "@context" => "https://schema.org",

            "@type" => "WebPage",

            "name" => YoastMain::get_seo_title(),

            "description" => YoastMain::get_seo_description(),

            "url" => self::get_url(),

            "brand" => [],

            "aggregateRating" => [],

            "review" => [],

            "offers" => [],
        ];
    }

    public static function schema_webpage_correct()
    {
        return [
            "@context" => "https://schema.org",

            "@type" => "WebPage",

            "name" => YoastMain::get_seo_title(),

            "description" => YoastMain::get_seo_description(),

            "url" => self::get_url(),

            "author" => self::schema_author_short(),

            "datePublished" => self::get_date_published(),

            "publisher" => self::schema_publisher(),
        ];
    }

    public static function schema_article()
    {
        $review_about = self::get_item_rewived();
        
        return [
            "@context" => "https://schema.org",

            "@type" => "Article",

            "headline" => YoastMain::get_seo_title(),

            "description" => YoastMain::get_seo_description(),

            "url" => self::get_url(),

            "author" => self::schema_author_short(),

            "datePublished" => self::get_date_published(),

            "publisher" => self::schema_publisher(),

            "image"=> self::get_item_rewived_logo( $review_about ),
	        
            "articleBody" => YoastMain::get_seo_description(),
        ];
    }

    public static function schema_base()
    {
        return [
            "@context" => "https://schema.org",

            "author" => self::schema_author_short(),

            "datePublished" => self::get_date_published(),
        ];
    }

    public static function schema_main_entity_of_page()
    {
        // "mainEntityOfPage": {
        //     "@type": "WebPage",
        //     "@id": "https://match.center/br/betberry-io/"
        // }

        // "mainEntityOfPage": "http://cathscafe.example.com/",
          
        return self::get_url();
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

            // "author" => self::schema_author(),

            "author" => self::schema_author_short(),

			"datePublished" => self::get_date_published(),

            "publisher" => self::schema_publisher(),

            "mainEntityOfPage" => self::schema_main_entity_of_page(),
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
            self::schema_organization(),

            self::schema_web_site(),

            self::schema_webpage(),

            self::schema_author(),
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

        // LegalDebug::debug( [
        //     'ReviewSchema' => 'schema',
            
        //     'graph' => $graph,
        // ] );
        
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
        'ld-json' => LegalMain::LEGAL_PATH . '/template-parts/review/review-schema-main.php',
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