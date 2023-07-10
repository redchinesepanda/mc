<?php

class ReviewOffers
{
	const FIELD = [
		'afillate' => 'about-afillate',
	];

	const TAXONOMY = [
		'group' => 'page_group',
	];

	const TERM = [
		'offers' => 'other-offers',
	];

	public static function offer_query( $post )
	{
		return [
			'numberposts' => -1,

            'post_type' => [ 'legal_bk_review', 'page' ],

            'suppress_filters' => 0,

            'exclude' => $post->ID,

			'meta_query' => [
                [
                    'key' => self::FIELD[ 'afillate' ],
                ],
            ]

            'tax_query' => [
                [
                    'taxonomy' => self::TAXONOMY[ 'group' ],

                    'field' => 'slug',

                    'terms' => self::TERM[ 'offers' ],
				],
            ],

            'orderby' => [ 'menu_order' => 'ASC', 'modified' => 'DESC' ],
		];
	}

	public static function parse_offers( $offers )
	{
		
	}

	public static function get_offers()
	{
		$items = [];

		$post = get_post();

		if ( !empty( $post ) )
		{
			$offers = get_posts( self::offer_query( $post ) );

			if ( !empty( $offers ) )
			{

			}
		}

		return $items;
	}

	const TEMPLATE = [
		'offers' => LegalMain::LEGAL_PATH . '/template-parts/review/review-offers.php',
	];

    public static function render_stats()
    {
        ob_start();

        load_template( self::TEMPLATE[ 'offers' ], false, self::get_offers() );

        $output = ob_get_clean();

        return $output;
    }
}

?>