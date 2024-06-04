<?php

class ReviewAbout
{
    const CSS = [
        'review-about' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-about.css',

            'ver'=> '1.2.1',
        ],
    ];

    const CSS_NEW = [
        'review-about-new' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/review/review-about-new.css',

			'ver' => '1.0.0',
		],
    ];

/*     public static function register_style()
    {
        if ( self::check() ) {
            ToolEnqueue::register_style( self::CSS );
        }
    } */

    public static function register_style()
    {
		if ( TemplateMain::check_new() )
		{
			ToolEnqueue::register_style( self::CSS_NEW );
		}
		else
		{
			ToolEnqueue::register_style( self::CSS );
		}
    }

    public static function register_inline_style()
    {
        if ( self::check() )
        {
            ToolEnqueue::register_inline_style( 'review-about', self::inline_style_about() );

            ToolEnqueue::register_inline_style( 'review-highlight', self::inline_style_highlight() );
        }
    }

    const JS_NEW = [
        'review-about' => [
			'path' => LegalMain::LEGAL_URL . '/assets/js/review/review-about.js',

			'ver' => '1.0.0',
		],

        'review-about-tooltip' => [
			'path' => LegalMain::LEGAL_URL . '/assets/js/review/review-about-tooltip.js',

			'ver' => '1.0.0',
		], 
    ];

    public static function register_script()
    {
		if ( TemplateMain::check_new() )
		{
			ToolEnqueue::register_script( self::JS_NEW );
		}
    }

    public static function check()
    {
        return ReviewMain::check() && TemplatePage::check_review();
    }

    public static function register()
    {
        if ( self::check() )
        {
            $handler = new self();
    
            // [legal-about]
    
            // [legal-about mode="footer"]
    
            // [legal-about mode="mini"]
    
            // add_shortcode( 'legal-about', [ $handler, 'render' ] );
            
            add_shortcode( self::SHPRTCODE[ 'about' ], [ $handler, 'prepare_about' ] );
    
            // [legal-button suffix="ios" label="costom button label"]
    
            add_shortcode( 'legal-button', [ $handler, 'render_button' ] );
    
            add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    
            add_action( 'wp_enqueue_scripts', [ $handler, 'register_inline_style' ] );

            add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
        }
    }

    public static function inline_style_highlight()
    {
        if ( TemplateMain::check_new() )
        {
            return '';
        }

        if ( !self::check() ) {
            return '';
        }

        $style = [];

		$style_item = self::get( [] );

        if ( !empty( $style_item[ 'background' ] ) )
        {
            $style[] = '.legal-highlight { background-color: ' . $style_item[ 'background' ] .'; }';
        }

        return implode( ' ', $style ); 
    }

    public static function inline_style_about()
    {
        if ( !self::check() ) {
            return '';
        }

		$style = [];

		$style_item = self::get( [] );

        if ( !TemplateMain::check_new() )
        {
            if ( !empty( $style_item[ 'background' ] ) )
            {
                $style[] = '.review-about-wrapper:not( .legal-mode-mini ), .review-about.legal-mode-mini { background-color: ' . $style_item[ 'background' ] .'; }';
            }
        }

        if ( !empty( $style_item[ 'logo' ] ) )
        {
            $style[] = '.review-about .about-logo { background-image: url( \'' . $style_item[ 'logo' ] .'\' ); }';
        }

		return implode( ' ', $style );
	}

    public static function check_href_afillate( $id )
	{
        $group = get_field( ReviewAbout::FIELD, $id );
        
        if( $group ) {
			if ( !empty( $group[ 'about-afillate' ] ) )
            {
                return $group[ 'about-afillate' ];
			}
		}

		return ( OopsMain::check_oops() ? '#' : '' );
	}

    const FIELD = 'review-about';

    const ABOUT = [
        'background' => 'about-background',

        'logo' => 'about-logo',

        'font' => 'about-font',
    ];

    const BONUS_EXCEPTION = [
        'dk',

        'es',

        'ie',

        'mx',

        'pt',

        'se',
    ];

    public static function check_bonus_exception()
    {
        return in_array( WPMLMain::current_language(), self::BONUS_EXCEPTION );
    }

    public static function get_achievement( $id )
    {
        // LegalDebug::debug( [
        //     'ReviewAbout' => 'get_achievement',

        //     'id' => $id,

        //     'get' => BilletAchievement::get( [
        //         'id' => $id,
    
        //         // 'achievement' => BilletAchievement::TYPE[ 'about' ],
    
        //         'filter' => [],
        //     ] ),
        // ] );

        // return BilletAchievement::get( [
        //     'id' => $id,

        //     'achievement' => BilletAchievement::TYPE[ 'about' ],

        //     'filter' => [],
        // ] );

        return BilletAchievement::get_achievement( $id, [] );
    }

    public static function get_title()
    {
        $group = get_field( self::FIELD );

        if ( $group )
        {
            return $group[ 'about-title' ];
        }

        return '';
    }

    public static function get_font()
    {
        $group = get_field( self::FIELD );

        if ( $group )
        {
            return $group[ self::ABOUT[ 'font' ] ];
        }

        return '';
    }

    public static function get_name( $group, $mode, $bonus_exception )
    {
        // заккоментил Калабин. Проверка вывода названия бонуса в сайдбаре 
        // if ( $mode == 'mini' || $bonus_exception )
        if ( $mode == 'mini' && $bonus_exception )
        {
            return $group[ 'about-title' ];
        }

        return $group[ 'about-bonus' ];
    }

    public static function get_afillate_description( $mode )
    {
        // $afillate_description = '';

        // if ( in_array( $locale, self::BONUS_EXCEPTION ) && empty( $mode ) )
        
        if ( empty( $mode ) && self::check_bonus_exception() )
        {
            // $afillate_description = 'Publicidad | Juego Responsable | +18';
            
            return ToolLoco::translate( ReviewMain::TEXT[ 'advertising' ] );
        }

        return '';
    }

    public static function get_about_mode( $args )
    {
        if ( !empty( $args[ 'mode' ] ) )
        {
            if ( in_array( $args[ 'mode' ], self::MODE ) )
            {
                return $args[ 'mode' ];
            }
        }

        return self::MODE[ 'default' ];
    }

    public static function get_about_logo_items()
	{
        if ( TemplateMain::check_new() && self::check_bonus_exception() )
        {
            $terms = [ 'header', 'header-' . WPMLMain::current_language() ];

            // return array_slice( BaseFooter::get_logo_items(), 1 );
            
            return BaseFooter::get_logo_items( $terms );
        }

        return [];
    }

    public static function get_about_achievement( $id, $group )
	{
        $achievement_item = self::get_achievement( $id );

        // LegalDebug::debug( [
        //     'ReviewAbout' => 'get_about_achievement',

        //     'achievement_item' => $achievement_item,
        // ] );

        if ( !empty( $achievement_item ) )
        {
            return [
                'bonus' => $group[ 'about-bonus' ],

                'name' => $achievement_item[ 'name' ],

                'app' => __( ReviewMain::TEXT[ 'app' ], ToolLoco::TEXTDOMAIN ),

                'href' => self::check_href_afillate( $id ),

                'image' => $achievement_item[ 'image' ],

                'tooltip' => $achievement_item[ 'tooltip' ],
            ];
        }

        return [];
    }

    public static function get_about_rating( $group )
	{
        if ( !empty( $group[ 'about-rating' ] ) )
        {
            return [
                'label' => __( ReviewMain::TEXT[ 'rating' ], ToolLoco::TEXTDOMAIN ),
    
                'value' => $group[ 'about-rating' ],
            ];
        }

        return [];
    }

    public static function get_about_title( $group )
	{
        return ReviewTitle::replace_placeholder( implode( ' ', [
            $group[ 'about-prefix' ],

            $group[ 'about-title' ],

            $group[ 'about-suffix' ],
        ] ) );
    }

    public static function get_about_bonus( $group, $mode )
	{
        return [
            'name' => self::get_name( $group, $mode, self::check_bonus_exception() ),

            'description' => $group[ 'about-description' ],
        ];
    }

    public static function get_about_logo( $id, $group )
	{
        $logo = BrandMain::get_logo_review( $id );

        if ( !empty( $logo ) )
        {
            return $logo;
        }

        return $group[ self::ABOUT[ 'logo' ] ];

        // return '';
    }

    public static function get( $args )
    {
        $id = BonusMain::get_id();

        $mode = self::get_about_mode( $args );

        $group = get_field( self::FIELD, $id );

        if ( $group )
        {
            $bonus = self::get_about_bonus( $group, $mode );

            // $bonus_exception = self::check_bonus_exception();

            // $bonus = [
            //     'name' => self::get_name( $group, $mode, $bonus_exception ),

            //     'description' => $group[ 'about-description' ],
            // ];

            $achievement = self::get_about_achievement( $id, $group );

            $rating = self::get_about_rating( $group );

            // $rating = [];
            
            // $achievement = [];

            // $term = self::get_achievement( $id );

            // if ( !empty( $term ) )
            // {
            //     $achievement = [
            //         'bonus' => $group[ 'about-bonus' ],

            //         'term' => $term[ 'name' ],

            //         'app' => __( ReviewMain::TEXT[ 'app' ], ToolLoco::TEXTDOMAIN ),

            //         'href' => self::check_href_afillate( $id ),
            //     ];
            // }
            // else 
            // {
            //     $rating = [
            //         'label' => __( ReviewMain::TEXT[ 'rating' ], ToolLoco::TEXTDOMAIN ),

            //         'value' => $group[ 'about-rating' ],
            //     ];
            // }

            $title = self::get_about_title( $group );

            // $title = ReviewTitle::replace_placeholder( $group[ 'about-prefix' ] . ' ' . $group[ 'about-title' ] . ' ' . $group[ 'about-suffix' ] );

            $logo = self::get_about_logo( $id, $group );

            // $logo = BrandMain::get_logo_review( $id );

            // if ( empty( $logo ) )
            // {
            //     $logo = $group[ self::ABOUT[ 'logo' ] ];
            // }

            $logo_items = self::get_about_logo_items();

            return [
                'text' => [
                    // 'head' => __( ReviewMain::TEXT[ 'bonus' ], ToolLoco::TEXTDOMAIN ),
    
                    // 'show' => __( ReviewMain::TEXT[ 'show-tnc' ], ToolLoco::TEXTDOMAIN ),
    
                    // 'hide' => __( ReviewMain::TEXT[ 'hide-tnc' ], ToolLoco::TEXTDOMAIN ),
                    
                    'head' => ToolLoco::translate( ReviewMain::TEXT[ 'bonus' ] ),
    
                    'show' => ToolLoco::translate( ReviewMain::TEXT[ 'show-tnc' ] ),
    
                    'hide' => ToolLoco::translate( ReviewMain::TEXT[ 'hide-tnc' ] ),
                ],

                'title' => $title,
                
                'bonus' => $bonus,
                
                'logo' => $logo,

                'background' => $group[ self::ABOUT[ 'background' ] ],

                'font' => $group[ self::ABOUT[ 'font' ] ],
                
                'rating' => $rating,

                'afillate' => [
                    'href' => self::check_href_afillate( $id ),

                    'text' => self::get_text(),

                    // 'description' => self::get_afillate_description( $mode, $bonus_exception ), 
                    
                    'description' => self::get_afillate_description( $mode ), 
                ],

                'mode' => $mode,

                'class' => ( !empty( $mode ) ? 'legal-mode-' . $mode : 'legal-mode-default' ),

                'achievement' => $achievement,

                'logo-items' => $logo_items,
            ];
        }

        return [];
    }

    const TEMPLATE = [
        'review-about' => LegalMain::LEGAL_PATH . '/template-parts/review/review-about.php',

        'review-about-new' => LegalMain::LEGAL_PATH . '/template-parts/review/review-about-new.php',
        
        'review-about-bonus' => LegalMain::LEGAL_PATH . '/template-parts/review/review-about-bonus.php',

        'review-button' => LegalMain::LEGAL_PATH . '/template-parts/review/review-button.php',
    ];

    const SHPRTCODE = [
        'about' => 'legal-about',
    ];

    const PAIRS_ABOUT = [
        // 'mode' => '',
        
        'mode' => self::MODE[ 'default' ],
    ];

    public static function prepare_about( $atts = [] )
    {
        $atts = shortcode_atts( self::PAIRS_ABOUT, $atts, self::SHPRTCODE[ 'about' ] );

        return self::render_about( $atts );
    }

    public static function render_about( $atts = [] )
    {
        return self::render( self::get( $atts ) );
    }
    
    public static function render( $args )
    {
        if ( !ReviewMain::check() )
        {
            return '';
        }

        if ( TemplateMain::check_new() )
        {
            return LegalComponents::render_main( self::TEMPLATE[ 'review-about-new' ], $args );
        }

        return LegalComponents::render_main( self::TEMPLATE[ 'review-about' ], $args );
    }

    public static function render_bonus( $atts = [] )
    {
        if ( !ReviewMain::check() )
        {
            return '';
        }

        if ( TemplateMain::check_new() )
        {
            return LegalComponents::render_main( self::TEMPLATE[ 'review-about-bonus' ], self::get( $atts ) );
        }

        return '';
    }

    const MODE = [
        'default' => '',

        'footer' => 'footer',

        'mini' => 'mini',
    ];
    
    public static function render_about_bottom()
    {
        return self::render( self::get( [
            'mode' => self::MODE[ 'footer' ],
        ] ) );
    }

    public static function get_text( $suffix = '' )
    {
        $group = get_field( self::FIELD, BonusMain::get_id() );

        $text = [
            __( ReviewMain::TEXT[ 'bet-here' ], ToolLoco::TEXTDOMAIN )
        ];

        if ( $suffix )
        {
            $text[] = $suffix;
        }

        if( $group )
        {
            if ( has_term( 'app', 'page_type' ) )
            {
                $text = [
                    __( ReviewMain::TEXT[ 'download' ], ToolLoco::TEXTDOMAIN ),

                    $group[ 'about-title' ],

                    $suffix,

                    __( ReviewMain::TEXT[ 'app' ], ToolLoco::TEXTDOMAIN ),
                ];
            }
        }

        return implode( ' ', $text );
    }

    const PAIRS_BUTTON = [
        'suffix' => '',

        'label' => '',
    ];
    
    public static function get_button( $args = [] )
    {
        $atts = shortcode_atts( self::PAIRS_BUTTON, $args, 'legal-button' );

        $id = BonusMain::get_id();

        $group = get_field( self::FIELD, $id );

        if( $group )
        {
            $text = $atts[ 'label' ];

            if ( !$text )
            {
                $text = self::get_text( $atts[ 'suffix' ] );
            }

            return [
                'href' => self::check_href_afillate( $id ),

                'text' => $text,
            ];
        }

        return [];
    }

    public static function render_button( $args )
    {
        if ( !ReviewMain::check() )
        {
            return '';
        }

        return LegalComponents::render_main( self::TEMPLATE[ 'review-button' ], self::get_button( $args ) );
    }
}

?>