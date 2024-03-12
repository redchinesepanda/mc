<?php

require_once ( 'CompilationMini.php' );

require_once ( 'CompilationBonus.php' );

require_once ( 'CompilationPage.php' );

require_once ( 'CompilationAbout.php' );

class CompilationMain
{
    const HANDLE = [
        'main' => 'compilation-main',

        'style' => 'compilation-style',

        'bonus' => 'compilation-bonus',

        'attention' => 'compilation-attention',
    ];

    const CSS = [
        self::HANDLE[ 'main' ] => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/compilation/compilation-main.css',

            'ver' => '1.0.2',
        ],

        self::HANDLE[ 'bonus' ] => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/compilation/compilation-bonus.css',

            'ver' => '1.0.0',
        ],
    ];

    const CSS_NEW = [
        'compilation-main-new' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/compilation/compilation-main-new.css',

			'ver' => '1.0.0',
		],

        'compilation-bonus-new' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/compilation/compilation-bonus-new.css',

			'ver' => '1.0.0',
		],
    ];

/* 	public static function register_style( $styles = [] )
    {
        if ( self::check() ) {
            if ( empty( $styles ) ) {
                $styles = self::CSS;
            }

            ToolEnqueue::register_style( $styles );
        }
    } */

    public static function register_style( $styles = [] )
    {
        if ( self::check() ) {
            if ( empty( $styles ) ) {
                if ( TemplateMain::check_new() )
                {
                    $styles = self::CSS_NEW;
                }
                else
                {
                    $styles = self::CSS;
                }
            }

            ToolEnqueue::register_style( $styles );
        }
    }

    public static function register_inline_style()
    {
        if ( self::check() )
        {
            ToolEnqueue::register_inline_style( self::HANDLE[ 'style' ], self::get_inline_style() );
        }
    }

    public static function get_inline_style()
    {
        $output = [];

        $compilations_ids = self::get_compilations_shortcode_id();

        if ( !empty( $compilations_ids ) )
        {
            foreach ( $compilations_ids as $compilation_id )
            {
                $output[] = CompilationMain::render_style( $compilation_id );
            }
        }

        return implode( PHP_EOL, $output );
    }

    const JS = [
        'compilation-tooltip' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/compilation/compilation-tooltip.js',

            'ver' => '1.0.0',
        ],
    ];

    public static function register_script()
    {
        if ( TemplateMain::check_new() )
        {
            ToolEnqueue::register_script( self::JS );
        }
    }

    public static function print()
    {
        BilletMain::print();

        ToolPrint::print_style( self::CSS );
    }

	public static function check()
    {
        return LegalComponents::check();
    }

    public static function register()
    {
        $handler = new self();

		// [legal-tabs]

        add_shortcode( self::SHORTCODES[ 'tabs' ], [ $handler, 'render_compilation' ] );

		// [legal-compilation id="1027562"]

        add_shortcode( self::SHORTCODES[ 'compilation' ], [ $handler, 'prepare_compilation' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );
        
        add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
    
        add_filter( 'posts_where', [ $handler, 'compilation_posts_where' ] );

        CompilationBonus::register();

        CompilationPage::register();

        CompilationAbout::register();
    }

    public static function register_functions()
    {
        CompilationAbout::register_functions();
    }

    const SHORTCODES_INLINE = [
        self::SHORTCODES[ 'compilation' ],

        // CompilationBonus::SHORTCODES[ 'bonus' ],
    ];

    public static function get_attr_id( $matches )
    {
        $compilations_ids = [];

        if ( !empty( $matches ) )
        {
            foreach ( $matches as $match )
            {
                $atts = shortcode_parse_atts( $match[ 3 ] );

                if ( !empty( $atts[ 'id' ] ) )
                {
                    $compilations_ids[] = $atts[ 'id' ];
                }
            }
        }

        return $compilations_ids;
    }
    public static function get_compilations_shortcode_id()
    {
        $matches = [];

        $post = get_post();

        if ( $post )
        {
            $regex = get_shortcode_regex( self::SHORTCODES_INLINE );

            $amount = preg_match_all( 
                '/' . $regex . '/', 
    
                $post->post_content,
    
                $matches,
    
                PREG_SET_ORDER
            );
        }

        return self::get_attr_id( $matches );
    }

    public static function get_billets( $posts, $filter )
    {
        // LegalDebug::debug( [
        //     'function' => 'CompilationMain::get_billets',

        //     'filter' => $filter,
        // ] );

        $data = [];

        foreach ( $posts as $index => $post ) {
            $data[] = [
                'index' => ( $index + 1 ),

                'id' => $post->ID,
            
                'filter' => $filter,
            ];
        }

        return $data;
    }
    
    const ATTENTION = [
        'text' => 'compilation-attention-text',

        'position' => 'compilation-attention-position',

        'type' => 'compilation-attention-type',
    ];

    public static function get_settings( $id )
    {
        return [
            'id' => $id,

            'date' => [
                'label' => __( BilletMain::TEXT[ 'last-updated' ], ToolLoco::TEXTDOMAIN ),

                'value' => self::get_date( $id ),
            ],

            'title' => [
                    'image' => get_field( self::COMPILATION[ 'title-image' ], $id ),

                    'class' => ( !empty( get_field( self::COMPILATION[ 'title-image' ], $id ) ) ? 'legal-image' : '' ),

                    'text' => get_field( self::COMPILATION[ 'title-text' ], $id ),
            ],

            'attention' => [
                'text' => get_field( self::ATTENTION[ 'text' ], $id ),

                'position' => get_field( self::ATTENTION[ 'position' ], $id ),

                'type' => get_field( self::ATTENTION[ 'type' ], $id ),
            ],
        ];
    }

    public static function check_id( $id = 0 ) {
        if ( $id == 0 )
        {
            $post = get_post();
    
            if ( $post )
            {
                return $post->ID;
            }
        }

        return $id;
    }

    const COMPILATION = [
        'title-image' => 'compilation-title-image',

        'title-text' => 'compilation-title-text',

        'type' => 'compilation-type',

        'filter' => 'compilation-filter',

        'locale' => 'compilation-locale',

        'operator' => 'compilation-operator',

        'lang' => 'compilation-lang',

        'review-label' => 'compilation-review-label',

        'review-type' => 'compilation-review-type',

        'play-label' => 'compilation-play-label',
    ];

    const BILLET = [
        'order-type' => 'billet-order-type',

        'rating-enabled' => 'billet-rating-enabled',

        'achievement-type' => 'billet-achievement-type',

        'bonus-enabled' => 'billet-bonus-enabled',

        'mobile-enabled' => 'billet-mobile-enabled',

        'profit-enabled' => 'billet-profit-enabled',

        'spoiler-enabled' => 'billet-spoiler-enabled',

        'description-enabled' => 'billet-description-enabled',

        'no-license-enabled' => 'billet-no-license-enabled',
    ];

    public static function get_filter( $id )
    {
        return [
            'review' => [
                'label' => get_field( self::COMPILATION[ 'review-label' ], $id ),

                'type' => get_field( self::COMPILATION[ 'review-type' ], $id ),
            ],

            'play' => [
                'label' => get_field( self::COMPILATION[ 'play-label' ], $id ),
            ],

            'features' => get_field( self::COMPILATION[ 'filter' ], $id ),

            'order' => get_field( self::BILLET[ 'order-type' ], $id ),

            'rating' => get_field( self::BILLET[ 'rating-enabled' ], $id ),

            'achievement' => get_field( self::BILLET[ 'achievement-type' ], $id ),

            'bonus' => get_field( self::BILLET[ 'bonus-enabled' ], $id ),

            'mobile' => get_field( self::BILLET[ 'mobile-enabled' ], $id ),

            'profit' => get_field( self::BILLET[ 'profit-enabled' ], $id ),

            'spoiler' => get_field( self::BILLET[ 'spoiler-enabled' ], $id ),

            'description' => get_field( self::BILLET[ 'description-enabled' ], $id ),

            'no-license' => get_field( self::BILLET[ 'no-license-enabled' ], $id ),
        ];
    }

    const FIELD = [
        'about' => 'review-about',
    ];

    const ABOUT = [
        'rating' => 'about-rating',
    ];

    const META_KEY = [
        'rating' => 'billet-title-rating',

        'profit' => 'billet-profit-items',
    ];

    const PROFIT_ITEM = [
        'feature' => 'profit-item-feature',

        'value' => 'profit-item-value',

        'pair' => 'profit-item-pair',
    ];

    public static function compilation_posts_where( $where )
    {
        if ( strpos( $where, self::META_KEY[ 'profit' ] . '_$' ) )
        {
            $where = str_replace("meta_key = '" . self::META_KEY[ 'profit' ] . "_$", "meta_key LIKE '" . self::META_KEY[ 'profit' ] . "_%", $where);
        }
    
        return $where;
    }

    const DATE_EXCEPTION = [ 'kz', 'by', 'es', 'uk', 'za', 'br', 'ng', 'ie', 'pt' ];

    public static function calculate_date( $id )
    {
        $post_modified = '';

        $posts = get_posts( self::get_args_date( $id ) );

        if ( !empty( $posts ) )
        {
            $post_modified = array_shift( $posts )->post_modified;
        }

        return $post_modified;
    }

    const FORMAT = [
        'updated' => 'd.m.Y',
    ];

    public static function get_billets_id( $id )
    {
        // LegalDebug::debug( [
        //     'CompilationMain' => 'get_billets_id',

        //     // 'id' => $id,

        //     // 'get' => self::get( $id ),

        //     // 'billets' => self::get( $id )[ 'billets' ],

        //     'array_column' => array_column( self::get( $id )[ 'billets' ], 'id' )
        // ] );

        return array_column( self::get( $id )[ 'billets' ], 'id' );
    }

    public static function get_date( $id )
    {
        $date = '';

        if ( empty( get_field( 'compilation-updated', $id ) ) )
        {
            $locale = WPMLMain::current_language();
    
            if ( in_array( $locale, self::DATE_EXCEPTION ) )
            {
                $modified = new DateTime( self::calculate_date( $id ) );
    
                $date = $modified->format( self::FORMAT[ 'updated' ] );
            } else
            {
                $current = new DateTime();
                
                $start = new DateTime('first day of this month');
    
                $middle = new DateTime( 'last day of previous month' );
    
                $middle->modify('+15 day');
    
                $date = $start->format( self::FORMAT[ 'updated' ] );
    
                if ( $current > $middle )
                {
                    $date = $middle->format( self::FORMAT[ 'updated' ] );
                }
            }
        }

        return $date;
    }

    public static function get_args_date( $id )
    {
        $args = self::get_args( $id );

        $args[ 'orderby' ] = [ 'modified' => 'DESC' ];

        return $args;
    }

    public static function get_args( $id, $limit = -1 )
    {
        $meta_query = [];

        $orderby = [
            'menu_order' => 'ASC',
        ];

        $rating_enabled = get_field( self::BILLET[ 'rating-enabled' ], $id );

        if ( $rating_enabled )
        {
            $meta_query = [

                'relation' => 'AND',
    
                'legal_rating' =>
                [
                    'key' => self::FIELD[ 'about' ] . '_' . self::ABOUT[ 'rating' ],

                    'value'   => [ '' ],
        			
					'compare' => 'NOT IN',
                ],
            ];

            $orderby = [ 'legal_rating' => 'DESC' ] + $orderby;
        }

        $profit_enabled = get_field( self::BILLET[ 'profit-enabled' ], $id );

        if ( $profit_enabled )
        {
            $filter = get_field( self::COMPILATION[ 'filter' ], $id );

            $feature = array_shift( $filter );

            $meta_query = [

                'relation' => 'AND',

                'legal_profit' => [

                    'key' => self::META_KEY[ 'profit' ] . '_$_' . self::PROFIT_ITEM[ 'pair' ],

                    'compare' => 'LIKE',

                    'value' => 'pair-order-' . $feature,
                ],
            ];

            $orderby = [ 'legal_profit' => 'ASC' ] + $orderby;
        }

        $terms = get_field( self::COMPILATION[ 'filter' ], $id );

        $terms = $terms ? $terms : [];

        $args = [

            'numberposts' => $limit,

            'post_type' => 'legal_billet',

            'suppress_filters' => get_field( self::COMPILATION[ 'locale' ], $id ),

            'tax_query' => [

                'relation' => 'AND',

                [
                    'taxonomy' => 'billet_feature',

                    'field' => 'term_id',
                    
                    'terms' => $terms,

                    'operator' => get_field( self::COMPILATION[ 'operator' ], $id ),
                ],

                [
                    'taxonomy' => 'billet_type',

                    'field' => 'term_id',

                    'terms' => get_field( self::COMPILATION[ 'type' ], $id ),
                ]

            ],

            'meta_query' => $meta_query,

            'orderby' => $orderby,
        ];

        return $args;
    }

    public static function get_posts( $id )
    {
        $new_lang = get_field( self::COMPILATION[ 'lang' ], $id );

        $switch_lang = ( !empty( $new_lang ) );

        if ( $switch_lang ) {
            global $sitepress;

            $current_lang = $sitepress->get_current_language();

            $sitepress->switch_lang( $new_lang );
        }

        $posts = get_posts( self::get_args( $id ) );

        if ( $switch_lang ) {
            $sitepress->switch_lang( $current_lang );
        }

        return $posts;
    }

    public static function get( $id )
    {
        $id = self::check_id( $id );

        $posts = self::get_posts( $id );

        return [
            'billets' => self::get_billets( $posts, self::get_filter( $id ) ),

            'settings' => self::get_settings( $id ),
        ];
    }

    const SHORTCODES = [
        'tabs' => 'legal-tabs',

        'compilation' => 'legal-compilation',
    ];

    const PAIRS = [
        'compilation' => [
            'id' => 0,
        ],
	];

    const TEMPLATE = [
        'compilation-main' => LegalMain::LEGAL_PATH . '/template-parts/compilation/part-compilation-main.php',

        self::HANDLE[ 'style' ] => LegalMain::LEGAL_PATH . '/template-parts/compilation/part-compilation-style.php',
        
        'compilation-attention' => LegalMain::LEGAL_PATH . '/template-parts/compilation/part-compilation-attention.php',

        'attention-tooltip' => LegalMain::LEGAL_PATH . '/template-parts/compilation/part-compilation-attention-tooltip.php',
    ];

    public static function prepare_compilation( $atts )
    {
		$atts = shortcode_atts( self::PAIRS[ 'compilation' ], $atts, self::SHORTCODES[ 'compilation' ] );

        $handler = new self();

        // ToolEnqueue::enqueue_inline_style( self::HANDLE[ 'style' ], self::render_style( $atts[ 'id' ] ) );
		
        return self::render_compilation( $atts[ 'id' ] );
	}

    public static function render_style( $id = 0 )
    {
        return LegalComponents::render_main( self::TEMPLATE[ self::HANDLE[ 'style' ] ], self::get( $id ) );
    }

    public static function render_compilation(  $id = 0  )
    {
        return LegalComponents::render_main( self::TEMPLATE[ self::HANDLE[ 'main' ] ], self::get( $id ) );
    }

    // public static function render_main( $template, $args )
    // {
    //     ob_start();

    //     load_template( $template, false, $args );

    //     $output = ob_get_clean();

    //     return $output;
    // }
    
    const POSITION = [
        'above' => 'legal-above-title',

        'below' => 'legal-below-title',

        'bottom' => 'legal-below',
    ];

    public static function render_attention( $attention, $position )
    {
        if ( !empty( $attention[ 'text' ] ) )
        {
            if ( $position == $attention[ 'position' ] )
            {
                return LegalComponents::render_main( self::TEMPLATE[ self::HANDLE[ 'attention' ] ], $attention );
            }
        }
    }

    public static function get_tooltip()
    {
        return [
            'label' => __( BilletMain::TEXT[ 'how-do-we-evaluate' ], ToolLoco::TEXTDOMAIN ),
        ];
    }

    // $choices[ 'legal-default' ] = 'Текст';

    // $choices[ 'legal-attention' ] = 'Блок Внимание';

    // $choices[ 'legal-tooltip' ] = 'Блок Подсказка';

    const TYPE = [
        'default' => 'legal-default',

        'attention' => 'legal-attention',

        'tooltip' => 'legal-tooltip',
    ];

    public static function render_attention_tooltip( $attention )
    {
        if ( $attention[ 'type' ] != self::TYPE[ 'tooltip' ] )
        {
            return '';
        }

        return LegalComponents::render_main( self::TEMPLATE[ 'attention-tooltip' ], self::get_tooltip() );
    }
}

?>