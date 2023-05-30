<?php

class BaseFooter
{
	const CSS = [
        'legal-footer' => LegalMain::LEGAL_URL . '/assets/css/base/footer.css',
    ];

    public static function register_style()
    {
        ToolEnqueue::register_style( self::CSS );
    }

	public static function register()
    {
        $handler = new self();

        add_action( 'init', [ $handler, 'location' ] );

		// [legal-footer]

        add_shortcode( 'legal-footer', [ $handler, 'render' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		// add_filter( 'wp_nav_menu_objects', [ $handler, 'image' ], 10, 2 );
    }

	const LOCATION = 'legal-footer';

	public static function location()
	{
		register_nav_menu( self::LOCATION, __( 'Legal Review BK Footer', ToolLoco::TEXTDOMAIN ) );
	}

	public static function array_search_values( $m_needle, $a_haystack, $b_strict = false){
		return array_intersect_key( $a_haystack, array_flip( array_keys( $a_haystack, $m_needle, $b_strict)));
	}

	public static function parse( $items, $parents, $key )
	{
		$post = $items[ $key ];

		$item[ 'title' ] = $post->title;

		$item[ 'href' ] = $post->url;

		$children = self::array_search_values( $post->ID, $parents );

		if ( !empty( $children ) ) {
			$child_keys = array_keys( $children );

			foreach ( $child_keys as $child_key) {
				$item[ 'children' ][] = self::parse( $items, $parents, $child_key );
			}
		}

		return $item;
	}

	public static function get_parents( $menu_items )
	{
		return array_map( function( $menu_item ) {
			return $menu_item->menu_item_parent;
		}, $menu_items );
	}

	public static function get_menu_items()
	{
		$menu_id_translated = BaseMain::get_menu_id( self::LOCATION );

		$menu_items = wp_get_nav_menu_items( $menu_id_translated );

		$menu_item_parents = self::get_parents( $menu_items );

		$parents_top = self::array_search_values( 0, $menu_item_parents );

		$keys = array_keys( $parents_top );

		$items = [];

		foreach ( $keys as $key ) {
			$items[] = self::parse( $menu_items, $menu_item_parents, $key );
		}

		return $items;
	}

	public static function get()
	{
		$items = self::get_menu_items();

		return  [
			'end' => array_slice( $items, -2, 2, true ),

			'items' => $items,

			'copy' => [
				'year' => '2021-2023',
				
				'company' => 'Match.Center',
				
				'reserved' => 'All rights reserved'
			],

			'text' => [
				'Match.Center is not a gambling operator (we do not accept any bets). The content of this website is strictly for information purposes and does not constitute advice. We only review gambling operators who are licenced by their respective local and international regulators. We only claim information to be correct at the time of posting.',

				'Always gamble responsibly and never risk money that you can not afford to lose!'
			],
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