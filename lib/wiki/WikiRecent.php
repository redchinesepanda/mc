<?php

class WikiRecent
{
	const CSS = [
        'legal-wiki-recent' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/wiki/legal-wiki-recent.css',

			'ver' => '1.0.7',
		],
    ];

	public static function register_style()
    {
		WikiMain::register_style( self::CSS );
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
		'wiki-tag',

		// 'wiki-tag-en',

		// 'wiki-tag-es',
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
				$items[] = [
					'href' => get_post_permalink( $post->ID ),

					'title' => $post->post_title,
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

			LegalDebug::debug( [
				'function' => 'get_recent_items',

				'query' => $query,

				'posts' => count( $posts ),
			] );

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
        'legal-wiki-recent' => LegalMain::LEGAL_PATH . '/template-parts/wiki/part-legal-wiki-recent.php',
    ];

	public static function render()
    {
		if ( !WikiMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'legal-wiki-recent' ], false, self::get_recent_args() );

        $output = ob_get_clean();

        return $output;
    }
}

?>