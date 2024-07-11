<?php

class BrandFilter
{
	const POST_TYPE = [
		'brand' => 'legal_brand',

		'billet' => 'legal_billet',
	];

	const QUERY_VARS = [
		'ids' => 'legal-brand-ids',
	];

	const FIELD = [
        'brand' => 'billet-brand',
    ];

	public static function register_functions_admin()
	{
        $handler = new self();

        add_action( 'restrict_manage_posts', [ $handler, 'render_brand_fileter' ] );

		add_filter( 'parse_query', [ $handler, 'wpse45436_posts_filter' ] );
    }

	public static function get_posts_ids()
	{
		$args = [
            'post_type' => self::POST_TYPE[ 'billet' ],

			'posts_per_page' => -1,

			'fields' => 'ids',
        ];

        $posts = get_posts( $args );

		return $posts;
	}

	public static function get_brand_ids()
	{
		$posts_ids = self::get_posts_ids();

		if ( !empty( $posts_ids ) )
		{
			$brand_ids = [];

			foreach ( $posts_ids as $post_id )
			{
				$brand_id = get_field( self::FIELD[ 'brand' ], $post_id );

				if ( $brand_id )
				{
					$brand_ids[] = $brand_id;
				}
			}

			return $brand_ids;
		}

		return [];
	}

	public static function get_brand_filter()
	{
		// $type = self::POST_TYPE[ 'brand' ];
		
		$type = '';

		if ( isset( $_GET[ 'post_type' ] ) )
		{
			$type = $_GET['post_type'];
		}

		// LegalDebug::debug( [
		// 	'BrandFilter' => 'get_brand_filter',

		// 	'type' => $type,
		// ] );

		//only add filter to post type you want
		if ( self::POST_TYPE[ 'brand' ] == $type )
		{
			//change this to the list of values you want to show
			//in 'label' => 'value' format

			$current_v = isset($_GET[ self::QUERY_VARS[ 'ids' ] ])? $_GET[ self::QUERY_VARS[ 'ids' ] ]:'';

			$values = [
				// 'label' => 'value', 
				// 'label1' => 'value1',
				// 'label2' => 'value2',
				
				'Brands of current language' => self::get_brand_ids(),
			];

			$options = [
				[
					'label' => ToolLoco::translate( 'Filter By ' ),

					'value' => '',

					'selected' => '',
				]
			];

			foreach ( $values as $label => $value )
			{
                $options[ ] = [
					'label' => $label,

					'value' => $value,

					'selected' => $value == $current_v ? ' selected="selected"' : '',
				];
            }

			$args = [
				'select' => [
					'name' => self::QUERY_VARS[ 'ids' ],

					'options' => $options,
				],
			];

			return $args;
		}

		return [];
	}

	const TEMPLATE = [
		'brand-filter' => LegalMain::LEGAL_PATH . '/template-parts/brand/part-brand-filter.php',
	];

	public static function render_brand_fileter()
	{
		echo LegalComponents::render_main( self::TEMPLATE[ 'brand-filter' ], self::get_brand_filter() );
	}

	public static function wpse45436_posts_filter( $query )
	{
		global $pagenow;

		// $type = self::POST_TYPE[ 'brand' ];
		
		$type = '';

		if (isset($_GET['post_type'])) {
			$type = $_GET['post_type'];
		}
		if ( self::POST_TYPE[ 'brand' ] == $type && is_admin() && $pagenow=='edit.php' && isset($_GET[ self::QUERY_VARS[ 'ids' ] ]) && $_GET[ self::QUERY_VARS[ 'ids' ] ] != '')
		{
			// $query->query_vars['meta_key'] = 'META_KEY';
			// $query->query_vars['meta_value'] = $_GET[ self::QUERY_VARS[ 'ids' ] ];

			$query->query_vars['post__in'] = $_GET[ self::QUERY_VARS[ 'ids' ] ];
		}
	}
}

?>