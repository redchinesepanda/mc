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
            $item = BilletMain::get( $billet );

			$item[ 'billet-logo' ] = BilletLogo::get( $item );

			$item[ 'billet-title' ] = BilletTitle::get( $item );

			$item[ 'billet-right' ] = BilletRight::get( $item );

			$item[ 'title' ][ 'label' ] = $item[ 'billet-title' ][ 'label' ];

			$item[ 'title' ][ 'href' ] = $item[ 'billet-title' ][ 'href' ];

			if ( !empty( $item[ 'bonus' ][ 'title' ] ) ) {
				$item[ 'title' ][ 'label' ] = $item[ 'bonus' ][ 'title' ];

				// $item[ 'title' ][ 'href' ] = $item[ 'billet-title' ][ 'href' ];
			}

            // LegalDebug::debug( [
            //     'BilletLogo' => BilletLogo::get( $item ),
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