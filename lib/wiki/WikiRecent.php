<?php

class WikiRecent
{
	const CSS = [
        'legal-wiki-recent' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/wiki/legal-wiki-recent.css',

			'ver' => '1.0.7',
		],
    ];

	const CSS_NEW = [
        'legal-wiki-recent-new' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/wiki/legal-wiki-recent-new.css',

			'ver' => '1.0.0',
		],
    ];

	/* public static function register_style()
    {
		WikiMain::register_style( self::CSS );
    } */

	public static function register_style()
    {
		if ( TemplateMain::check_new() )
		{
			WikiMain::register_style( self::CSS_NEW );
		}
		else
		{
			WikiMain::register_style( self::CSS );
		}
    }

	public static function register()
    {
        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	const TAXONOMY = [
		'category' => 'category',
	];

	const CATEGORY = [
		'wiki',

		'wiki-tag',

		'wiki-tag-eng',

		'wiki-tag-esp',

		'wiki-tag-au',

		'wiki-tag-bp',

		'wiki-tag-sv',

		'wiki-tag-ru',

		'wiki-tag-da',
	];

	public static function query_recent( $id = 0 )
	{
		return [
			'numberposts' => 6,

            'post_type' => [ 'post' ],

            'post_status' => 'publish',

            // 'suppress_filters' => 0,

            'exclude' => $id,

            'tax_query' => [
                [
                    'taxonomy' => self::TAXONOMY[ 'category' ],

                    'field' => 'slug',

                    'terms' => self::CATEGORY,

					'operator' => 'IN',
				],
            ],

            'orderby' => [ 'menu_order' => 'ASC', 'modified' => 'DESC' ],
		];
	}

	public static function parse_posts_recent( $posts )
	{
		$items = [];

		if ( !empty( $posts ) )
		{
			foreach ( $posts as $post )
			{
				$published_datetime = get_post_datetime( $post->ID );

				$items[] = [
					'href' => get_post_permalink( $post->ID ),

					'title' => $post->post_title,

					'published' => $published_datetime->format( 'd.m.Y' ),
				];
			}
		}

		return $items;
	}

	public static function get_recent_items()
	{
		$post = get_post();

		if ( !empty( $post ) )
		{
			$query = self::query_recent( $post->ID );

			$posts = get_posts( $query );

			return self::parse_posts_recent( $posts );
		}
		
		return [];
	}

	public static function get_recent_args()
	{
		return [
			'title' => __( WikiMain::TEXT[ 'recent-articles' ], ToolLoco::TEXTDOMAIN ),

			'items' => self::get_recent_items(),
		];
	}

	const TEMPLATE = [
        'recent-main' => LegalMain::LEGAL_PATH . '/template-parts/wiki/part-legal-wiki-recent.php',

        'recent-new' => LegalMain::LEGAL_PATH . '/template-parts/wiki/part-legal-wiki-recent-new.php',
    ];

	public static function render()
    {
        if ( !WikiMain::check() )
        {
            return '';
        }

        if ( TemplateMain::check_new() )
        {
            return LegalComponents::render_main( self::TEMPLATE[ 'recent-new' ], self::get_recent_args() );
        }

        return LegalComponents::render_main( self::TEMPLATE[ 'recent-main' ], self::get_recent_args() );
    }

	// public static function render()
    // {
	// 	if ( !WikiMain::check() )
    //     {
    //         return '';
    //     }

    //     ob_start();

    //     load_template( self::TEMPLATE[ 'recent-main' ], false, self::get_recent_args() );

    //     $output = ob_get_clean();

    //     return $output;
    // }
}

?>