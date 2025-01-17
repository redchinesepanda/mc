<?php

class CompilationBonus
{
    const JS = [
        'billet-bonus-tnc' => [

			'path' => LegalMain::LEGAL_URL . '/assets/js/billet/billet-footer.js',

            'ver' => '1.0.0',
        ],
    ];

	public static function register_script()
    {
        ReviewMain::register_script( self::JS );
    }

	public static function register()
    {
        $handler = new self();

		// [legal-compilation-bonus id="1027225"]

        add_shortcode( self::SHORTCODES[ 'bonus' ], [ $handler, 'prepare_bonus' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
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

            // LegalDebug::debug( [
            //     'function' => 'get_billets_bonus',

            //     'args' => $args,
            // ] );
            
            $bonus = BilletBonus::get( $args );

            if ( empty( $bonus[ 'description' ] ) )
            {
                $bonus[ 'description' ] = '';
            }

            if ( empty( $bonus[ 'description-full' ] ) )
            {
                $bonus[ 'description-full' ] = '';
            }

            $play = BilletRight::get( $args );

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

                    'nofollow' => $logo[ 'logo' ][ 'nofollow' ],

                    'alt' => $title[ 'label' ],
                ],

                'title' => [
                    'href' => $title[ 'href' ],

                    'nofollow' => $title[ 'nofollow' ],

                    'label' => $title_label,
                ],

                'description' => $bonus[ 'description' ],

                'description-full' => $bonus[ 'description-full' ],

                'bonus-href' => $bonus[ 'href' ],

                'button-tnc' => __( BilletMain::TEXT[ 'read-more' ], ToolLoco::TEXTDOMAIN ),

                'link-tnc' => __( BilletMain::TEXT[ 'full-tnc' ], ToolLoco::TEXTDOMAIN ),

                'tnc-class' => BilletBonus::get_tnc_class(),

                'review' => [
                    'href' => $logo[ 'review' ][ 'href' ],

                    'label' => $logo[ 'review' ][ 'label' ],
                ],

                'button' => [
                    'href' => $play[ 'play' ][ 'href' ],

                    'label' => $play[ 'play' ][ 'label' ],

                    'nofollow' => $play[ 'play' ][ 'nofollow' ],
                ],
            ];

            // LegalDebug::debug( [
            //     'function' => 'CompilationBonus::get_billets_bonus',

            //     // 'args' => $args,

            //     // 'logo' => $logo,

            //     // 'title' => $title,

            //     'bonus' => $bonus,

            //     // 'play' => $play,
            // ] );

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