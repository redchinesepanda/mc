<?php

class CompilationBonus
{
	public static function register()
    {
        $handler = new self();

		// [legal-compilation-bonus id="1027225"]

        add_shortcode( self::SHORTCODES[ 'bonus' ], [ $handler, 'prepare_bonus' ] );
    }

    public static function get_billets_bonus( $posts, $filter )
    {
        $billets = CompilationMain::get_billets( $posts, $filter );

        $items = [];

        foreach ( $billets as $index => $billet )
        {
            $args = BilletMain::get( $billet );

            $logo = BilletLogo::get( $args );

            $title = BilletTitle::get( $args );
            
            $bonus = BilletBonus::get( $args );

            $play = BilletRight::get( $args );

			// $item[ 'billet-logo' ] = BilletLogo::get( $item );

			// $item[ 'billet-title' ] = BilletTitle::get( $item );

			// $item[ 'billet-right' ] = BilletRight::get( $item );

			// $item[ 'title' ][ 'label' ] = $item[ 'billet-title' ][ 'label' ];

			// $item[ 'title' ][ 'href' ] = $item[ 'billet-title' ][ 'href' ];

			// if ( !empty( $item[ 'bonus' ][ 'title' ] ) ) {
			// 	// $item[ 'title' ][ 'label' ] = $item[ 'bonus' ][ 'title' ];
				
            //     $item[ 'title' ][ 'label' ] = $bonus[ 'title' ];

            //     $item[ 'description' ] = $bonus[ 'description' ];

			// 	// $item[ 'title' ][ 'href' ] = $item[ 'billet-title' ][ 'href' ];
			// }

            $title_label = $title[ 'label' ];

            if ( !empty( $bonus[ 'title' ] ) )
            {
                $title_label = $bonus[ 'title' ];
            }

            $item = [
                'selector' => $args[ 'selector' ],

                'font' => $logo[ 'review' ][ 'font' ],

                'color' => $args[ 'color' ],

                'logo' => [
                    'class' => $logo[ 'logo' ][ 'class' ],

                    'href' => $logo[ 'logo' ][ 'href' ],

                    'src' => $logo[ 'logo' ][ 'src' ],

                    'alt' => $title[ 'label' ],
                ],

                'title' => [
                    'href' => $title[ 'href' ],

                    'label' => $title_label,
                ],

                'description' => $bonus[ 'description' ],

                'review' => [
                    'href' => $logo[ 'review' ][ 'href' ],

                    'label' => $logo[ 'review' ][ 'label' ],
                ],

                'button' => [
                    'href' => $play[ 'play' ][ 'href' ],

                    'label' => $play[ 'play' ][ 'label' ],
                ],
            ];

            LegalDebug::debug( [
                'function' => 'CompilationBonus::get_billets_bonus',

                // 'args' => $args,

                // 'logo' => $logo,

                // 'title' => $title,

                'bonus' => $bonus,

                // 'play' => $play,
            ] );

            $items[] = $item;
        }

        return $items;
    }

	public static function get_bonus( $id )
    {
        $id = CompilationMain::check_id( $id );

        $posts = CompilationMain::get_posts( $id );

        return [
            'billets' => self::get_billets_bonus( $posts, CompilationMain::get_filter( $id ) ),

            'settings' => CompilationMain::get_settings( $id ),
        ];
    }

	const SHORTCODES = [
        // 'tabs' => 'legal-tabs',

        'bonus' => 'legal-compilation-bonus',
    ];

	const PAIRS = [
        'compilation' => [
            'id' => 0,
        ],
	];

	public static function prepare_bonus( $atts )
    {
		$atts = shortcode_atts( self::PAIRS[ 'compilation' ], $atts, self::SHORTCODES[ 'bonus' ] );

		// $args = self::get( $atts[ 'id' ] );
		
        $args = self::get_bonus( $atts[ 'id' ] );

		return self::render_bonus( $args );
	}

	const TEMPLATE = [
        'legal-compilation-bonus' => LegalMain::LEGAL_PATH . '/template-parts/compilation/part-compilation-bonus.php',
    ];

    public static function render_bonus(  $args = []  )
    {
        ob_start();

        load_template( self::TEMPLATE[ 'legal-compilation-bonus' ], false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>