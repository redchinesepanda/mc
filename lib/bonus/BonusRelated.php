	<?php

	class BonusRelated
	{
		const CSS = [
			'bonus-related' => [
				'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-related.css',

				'ver'=> '1.0.2',
			],
		];

		public static function register_style()
		{
			BonusMain::register_style( self::CSS );
		}

		public static function register_functions()
		{
			add_image_size( self::SIZE[ 'related' ], 214, 130, false );
		}

		public static function register()
		{
			$handler = new self();

			add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
		}

		const TYPE = [
			'post' => 'post',
		];

		const TAXONOMY = [
			'tag' => 'post_tag',

			'category' => 'category',
		];

		public static function group_posts_categories()
		{
			$categories = wp_get_post_categories(
				BonusMain::get_id(),

				[ 'fields' => 'slugs' ]
			);

			$atts = [
				'terms' => $categories,

				'limit' => 6,

				'current_not_in' => true,

				'duration' => BonusPreview::DURATION[ 'actual' ],
			];

			$atts = shortcode_atts( BonusPreview::PAIRS, $atts, 'legal-bonus' );
			
			return BonusPreview::group_posts( $atts );
		}

		const FIELD = [
			'primary' => '_yoast_wpseo_primary_',
		];

		public static function get_terms( $id )
		{
			// $primary_id = get_post_meta( $id, self::FIELD[ 'primary' ] . self::TAXONOMY[ 'category' ], true );

			// if ( $primary_id )
			// {
			// 	$primary = get_term( $primary_id, self::TAXONOMY[ 'category' ] );

			// 	if( !empty( $primary ) )
			// 	{
			// 		return [ $primary->slug ];
			// 	}
			// }

			// return '';

			return array_column( LegalBreadcrumbsMain::get_terms( BonusMain::get_id() ), 'slug' ); 
		}

		public static function group_posts_actual()
		{
			// $categories = wp_get_post_categories(
			// 	BonusMain::get_id(),

			// 	[ 'fields' => 'slugs' ]
			// );

			$categories = self::get_terms( BonusMain::get_id() );

			// $categories = LegalBreadcrumbsMain::get_terms( BonusMain::get_id() );

			$atts = [
				'terms' => $categories,

				'limit' => 6,

				'current_not_in' => true,

				'duration' => BonusPreview::DURATION[ 'actual' ],
			];
			
			// LegalDebug::debug( [
			// 	'function' => 'group_posts_actual',

			// 	'atts' => $atts,
			// ] );

			$atts = shortcode_atts( BonusPreview::PAIRS, $atts, 'legal-bonus' );
			
			return BonusPreview::group_posts( $atts );
		}

		public static function group_posts_tags()
		{
			$tags = wp_get_post_tags(
				BonusMain::get_id(),

				[ 'fields' => 'names' ]
			);

			$atts = [
				'taxonomy' => '',

				'terms' => [],

				'limit' => 6,

				'tags' => $tags,

				'current_not_in' => true,

				'duration' => BonusPreview::DURATION[ 'actual' ],
			];

			$atts = shortcode_atts( BonusPreview::PAIRS, $atts, 'legal-bonus' );
			
			return BonusPreview::group_posts( $atts );
		}

		const SIZE = [
			'thumbnail' => 'thumbnail',

			'related' => 'legal-bonus-related',
		];

		public static function get_items( $posts = [] )
		{
			$items = [];

			if ( !empty( $posts ) )
			{
				foreach ( $posts as $post )
				{
					$post_url = get_post_permalink( $post->ID );

					$preview = BonusPreview::get_thumbnail( $post->ID, self::SIZE[ 'related' ] );

					if ( !empty( $preview ) )
					{
						$preview[ 'href' ] = $post_url;
					}

					$items[] = [
						'preview' => $preview,

						'title' => [
							'label' => $post->post_title,

							'href' => $post_url,
						],
					];
				}
			}

			return $items;
		}

		public static function get_related_tags()
		{
			return [
				'title' => __( BonusMain::TEXT[ 'best-bookmaker-bonuses' ], ToolLoco::TEXTDOMAIN ),

				'items' => self::get_items( self::group_posts_tags() ),
			];
		}

		public static function get_preview_tags()
		{
			return [
				'title' => __( BonusMain::TEXT[ 'other-bonuses' ], ToolLoco::TEXTDOMAIN ),

				'items' => BonusPreview::get_items( self::group_posts_tags() ),
			];
		}

		public static function get_preview_categories()
		{
			return [
				'title' => __( BonusMain::TEXT[ 'similar-bonuses' ], ToolLoco::TEXTDOMAIN ),

				'items' => BonusPreview::get_items( self::group_posts_categories() ),
			];
		}

		public static function get_preview_actual()
		{
			$title[] = __( BonusMain::TEXT[ 'actual-bonuses' ], ToolLoco::TEXTDOMAIN );

			if ( $name = get_field( BonusAbout::FIELD[ 'bonus-bookmaker-name' ] ) )
			{
				$title[] = $name;
			}

			return [
				'title' => implode( ' ', $title ),

				'items' => BonusPreview::get_items( self::group_posts_actual() ),
			];
		}

		const TEMPLATE = [
			'bonus-related' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus-related.php',
		];

		public static function render_related_tags()
		{
			return self::render( self::get_related_tags() );
		}

		public static function render_preview_tags()
		{
			return BonusPreview::render( self::get_preview_tags() );
		}

		public static function render_preview_categories()
		{
			return BonusPreview::render( self::get_preview_categories() );
		}

		public static function render_preview_actual()
		{
			if ( BonusDuration::check_expired( BonusMain::get_id() ) )
			{
				return BonusPreview::render( self::get_preview_actual() );
			}
			
			return '';
		}

		public static function render( $args )
		{
			if ( !BonusMain::check() )
			{
				return '';
			}

			ob_start();

			load_template( self::TEMPLATE[ 'bonus-related' ], false, $args );

			$output = ob_get_clean();

			return $output;
		}
	}

	?>