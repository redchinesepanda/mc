<?php

class BaseFooter
{
	const CSS = [
        'legal-footer-main' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/base/footer-main.css',

			'ver' => '1.0.5',
		],
    ];

	const CSS_NEW = [
        'legal-footer-new' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/base/footer-new.css',

			'ver' => '1.0.0',
		],
    ];

    public static function register_style()
    {
		if ( TemplateMain::check_code() )
		{
			BaseMain::register_style( self::CSS_NEW );
		}
		else
		{
			BaseMain::register_style( self::CSS );
    }

	public static function register_functions()
	{
		$handler = new self();

        add_action( 'init', [ $handler, 'location' ] );
	}

	public static function register()
    {
        $handler = new self();

		// [legal-footer]

        add_shortcode( 'legal-footer', [ $handler, 'render' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		// add_filter( 'wp_nav_menu_objects', [ $handler, 'image' ], 10, 2 );
    }

	const LOCATION = 'legal-footer';

	public static function location()
	{
		register_nav_menu( self::LOCATION, __( BaseMain::TEXT[ 'legal-review-bk-footer' ], ToolLoco::TEXTDOMAIN ) );
	}

	const ITEM = [
		'width' => 'menu-item-width',
	];

	public static function parse_items( $items, $parents, $key )
	{
		$post = $items[ $key ];

		$item[ 'title' ] = $post->title;

		$item[ 'href' ] = $post->url;

		$class = get_field( self::ITEM[ 'width' ], $post->ID );

		$item[ 'class' ] = ( $class ? $class : '' );

		if ( !empty( $post->classes ) )
		{
			$item[ 'class' ] .= ' ' . implode( ' ', $post->classes );
		}
		
		$children = ToolMenu::array_search_values( $post->ID, $parents );

		if ( !empty( $children ) ) {
			$child_keys = array_keys( $children );

			foreach ( $child_keys as $child_key) {
				$item[ 'children' ][] = self::parse_items( $items, $parents, $child_key );
			}
		}

		return $item;
	}

	public static function get_menu_items()
	{
		$menu_id_translated = BaseMain::get_menu_id( self::LOCATION );

		$menu_items = wp_get_nav_menu_items( $menu_id_translated );

		$items = [];

		if ( $menu_items) {
			$menu_item_parents = ToolMenu::get_parents( $menu_items );

			$parents_top = ToolMenu::array_search_values( 0, $menu_item_parents );

			$keys = array_keys( $parents_top );

			foreach ( $keys as $key ) {
				$items[] = self::parse_items( $menu_items, $menu_item_parents, $key );
			}
		}

		return $items;
	}

	const TAXONOMY = [
		'media' => 'media_type',
	];

	const SIZE = [
        'logo' => 'legal-footer-logo',
    ];

	const FIELD = [
        'href' => 'media-href',

        'order' => 'media-order',
    ];

	public static function get_items()
	{
		$posts = get_posts( self::query() );

		$items = [];

		foreach ( $posts as $post ) {
			$image = wp_get_attachment_image_src( $post->ID, 'full' );

			$href = get_field( self::FIELD[ 'href' ], $post->ID );

			$alt = get_post_meta( $post->ID, '_wp_attachment_image_alt', true );

			// LegalDebug::debug( [
			// 	'ID' => $post->ID,
			// ] );

			if ( $image ) {
				$items[] = [
					'href' => ( $href ? $href : '#' ),
					
					'src' => $image[ 0 ],
	
					'width' => $image[ 1 ],
					
					'height' => $image[ 2 ],
	
					'alt' => ( $alt ? $alt : 'Match.Center' ),

					'class' => 'legal-image-' . $post->ID,
				];
			}
		}

		return $items;
	}

	public static function query()
	{
		return [
			'posts_per_page' => -1,
			
			'post_type' => 'attachment',

			'tax_query' => [
				[
					'taxonomy' => self::TAXONOMY[ 'media' ],

					'terms' => [ 'footer', 'footer-' . WPMLMain::current_language() ],

					'field' => 'slug',

					'operator' => 'IN',
				],
			],

			'meta_key' => self::FIELD[ 'order' ],

			'order' => 'ASC',

			'orderby' => 'meta_value',
		];
	}

	public static function get()
	{
		$items = self::get_menu_items();

		$end = array_splice( $items, -2 );

		return  [
			'class' => 'footer-' . WPMLMain::current_language(),

			'end' => $end,

			'items' => $items,

			'logo' => self::get_items(),

			'copy' => [
				'year' => '2021-2023',
				
				'company' => __( BaseMain::TEXT[ 'match-center' ], ToolLoco::TEXTDOMAIN ),
				
				'reserved' => __( BaseMain::TEXT[ 'all-rights-reserved' ], ToolLoco::TEXTDOMAIN )
			],

			'text' => __( BaseMain::TEXT[ 'match-center-is-not' ], ToolLoco::TEXTDOMAIN ),
		];
	}

	const TEMPLATE = [
        'footer' => LegalMain::LEGAL_PATH . '/template-parts/base/part-footer-main.php',

        'item' => LegalMain::LEGAL_PATH . '/template-parts/base/part-footer-item.php',
    ];

    public static function render()
    {
        ob_start();

        load_template( self::TEMPLATE[ 'footer' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }

    public static function render_item( $item )
    {
        ob_start();

        load_template( self::TEMPLATE[ 'item' ], false, $item );

        $output = ob_get_clean();

        return $output;
    }
}

?>