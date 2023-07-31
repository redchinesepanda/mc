<?php

class BonusMain
{
	public static function register()
    {
        $handler = new self();

        // [legal-bonus post_type='legal_bk_review' taxonomy='page_type' terms='review']

        add_shortcode( 'legal-bonus', [ $handler, 'prepare' ] );
    }

	const PAIRS = [
		'post_type' => 'post',

		'taxonomy' => 'category',

		'terms' => [ 'bonusy-kz' ],
	];

	public static function get_args( $atts )
    {
		return [
            'numberposts' => -1,
            
            'post_type' => $atts[ 'post_type' ],

			'suppress_filters' => 0,
            
            'orderby' => [ 'date ' => 'DESC', 'title' => 'ASC' ],

			'tax_query' => [

				'taxonomy' => $atts[ 'taxonomy' ],

				'field' => 'slug',

				'terms' => $atts[ 'terms' ],
			],
        ];
    }

	public static function get_items( $atts )
	{
		$items = [];

		$posts = get_posts( self::get_args( $atts ) );

		if ( !empty( $posts ) )
		{
			foreach ( $posts as $post )
			{
				$items[] = [
					'id' => $post->ID,

					'title' => $post->post_title,
				];
			}
		}

		return $items;
	}

	public static function prepare( $atts )
    {
		$atts = shortcode_atts( self::PAIRS, $atts, 'legal-bonus' );

		$items = self::get_items( $atts );

		$args = [
			'items' => $items,
		];

		return self::render( $args );
	}

	const TEMPLATE = [
        'legal-bonus' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus.php',
    ];

    public static function render( $args )
    {
        ob_start();

        load_template( self::TEMPLATE[ 'legal-bonus' ], false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>