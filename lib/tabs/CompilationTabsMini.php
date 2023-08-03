<?php

class CompilationTabsMini
{
	const CSS = [
        'tabs-mini' => LegalMain::LEGAL_URL . '/assets/css/tabs/tabs-mini.css',
    ];

	public static function register_style( $styles = [] )
    {
        if ( self::check() ) {
            if ( empty( $styles ) ) {
                $styles = self::CSS;
            }

            ToolEnqueue::register_style( $styles );
        }
    }

	public static function check()
    {
        return LegalComponents::check();
    }

	public static function register()
    {
        $handler = new self();

        // [legal-tabs-mini id='269090']

        add_shortcode( 'legal-tabs-mini', [ $handler, 'prepare' ] );
    }

	const PAIRS = [
		'id' => 0,

		'profit' => false,
	];

    const FIELD = [
        'title' => 'tabs-mini-title',

        'image' => 'tabs-mini-image',

        'description' => 'tabs-mini-description',

        'label' => 'tabs-mini-label',
    ];

	public static function prepare_tab_mini( $id )
    {
		$profit = self::get_filter_profit( $id );

        $class = $profit ? 'legal-profit' : 'legal-default';

        return [
            'id' => $id,

            'title' => get_field( self::FIELD[ 'title' ], $id ),

            'url' => get_field( self::FIELD[ 'image' ], $id ),

            'description' => get_field( self::FIELD[ 'description' ], $id ),

			'items' => self::get_items_mini( $id, $profit ),

            'button' => [
                'label' => get_field( self::FIELD[ 'label' ], $id ),

                'href' => get_post_permalink( $id ),
            ],

            'class' => $class,
		];
	}

	public static function filter_space( $string )
    {
        return preg_replace(
            '/\s*,\s*/',
            
            ',',
            
            filter_var( $string, FILTER_SANITIZE_STRING )
        );
    }

	public static function sort_profit( $a, $b )
    {
        if ( $a[ 'profit' ] > $b[ 'profit' ] )
        {
            return 1;
        }
        
        if ( $a[ 'profit' ] < $b[ 'profit' ] )
        {
            return -1;
        }

        return 0;
    }

	public static function get_items_mini( $id, $profit = false )
    {
        $items = [];
        
        $tabs = get_field(CompilationTabs::TABS[ 'items' ], $id );

        if ( $tabs )
        {
            $sets = [];

            // $limit = 3;
            
            $limit = $profit ? -1 : 3;

            foreach ( $tabs as $tab )
            {
                $compilations = ( !empty( $tab[ CompilationTabs::TAB[ 'compilations' ] ] ) ? $tab[ CompilationTabs::TAB[ 'compilations' ] ] : [] );

                foreach ( $compilations as $compilation )
                {
                    $ids = CompilationMain::get_ids( $compilation, $limit );

                    $amount = count( $ids );

                    $rest = $limit - $amount;

                    if ( $rest >= 0 )
                    {
                        $limit = $rest;
                    }

                    $sets[] = $ids;

                    if ( $limit == 0 )
                    {
                        break 2;
                    }
                }

                if ( $limit == 0 )
                {
                    break;
                }
            }

            $billets = array_unique( call_user_func_array( 'array_merge' , $sets ) );

            foreach ( $billets as $billet )
            {
                $items[] = BilletMain::get_mini( $billet, $profit );
            }

            if ( $profit )
            {
                $handler = new self();

                usort( $items, [ $handler, 'sort_profit' ] );

                $items = array_slice( $items, 0, 3 );
            }
        }

        return $items;
    }

	public static function prepare( $atts )
    {
		$atts = shortcode_atts( self::PAIRS, $atts, 'legal-tabs-mini' );

        $atts[ 'profit' ] = wp_validate_boolean( $atts[ 'profit' ] );

        $pages = explode( ',', self::filter_space( $atts[ 'id' ] ) );

        $args = [];

        foreach ( $pages as $page )
        {
            $args[] = self::prepare_tab_mini( $page );
        }

		return self::render_tabs_mini( $args );
	}

	public static function get_filter_profit( $id )
    {
        $items = [];
        
        $tabs = get_field( CompilationTabs::TABS[ 'items' ], $id );

        $profit = true;

        if ( $tabs )
        {
            $sets = [];

            $limit = 3;

            foreach ( $tabs as $tab )
            {
                $compilations = ( !empty( $tab[ CompilationTabs::TAB[ 'compilations' ] ] ) ? $tab[ CompilationTabs::TAB[ 'compilations' ] ] : [] );

                foreach ( $compilations as $compilation )
                {
                    $compilation_profit = CompilationMain::get_filter_profit( $compilation );

                    $profit = $profit && $compilation_profit;
                }
            }
        }

        return $profit;
    }

	const TEMPLATE = [
        'mini' => LegalMain::LEGAL_PATH . '/template-parts/tabs/part-tabs-mini.php',
    ];

	public static function render_tabs_mini( $args )
    {
        ob_start();

        load_template( self::TEMPLATE[ 'mini' ], false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>