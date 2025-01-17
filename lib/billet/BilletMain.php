<?php

require_once( 'BilletMega.php' );

require_once( 'BilletLogo.php' );

require_once( 'BilletSpoiler.php' );

require_once( 'BilletMini.php' );

require_once( 'center/BilletTitle.php' );

require_once( 'center/BilletDescription.php' );

require_once( 'center/BilletList.php' );

require_once( 'center/BilletAchievement.php' );

// require_once( 'center/BilletDescriptionAjax.php' );

// require_once( 'center/BilletDescriptionRESTAPI.php' );

require_once( 'right/BilletRight.php' );

class BilletMain
{
    const HANDLE = [
        'main' => 'billet-main',

        'new' => 'billet-main-new',

        'style' => 'billet-style',

        'spoiler' => 'billet-spoiler',

        'bonus' => 'billet-bonus',

        'bonus-new' => 'billet-bonus-new',
    ];

	const TEXT = [
		'bet-here' => 'Bet here',

		'bet-now' => 'Bet now',

		'close-details' => 'Close Details',

        'full-tnc' => 'Full T&Cs apply',

		'get-in-touch' => 'Get in touch',

        'hide-tnc' => 'Hide T&C',

        'hide' => 'Hide',

        'how-do-we-evaluate' => 'How do we evaluate bookmakers?',

		'last-updated' => 'Last updated',

		'margin' => 'Margin',

		'more-details' => 'More Details',

		'no-license' => 'No license in UK',

		'play-responsibly' => 'Play responsibly',

		'read-more-about' => 'Read more about',

		'read-more' => 'Read more',

		'review' => 'Review',
        
        'show-tnc' => 'Show T&C',

        'there-are-no-tabs' => 'There are no tabs added yet',
	];
    
    const DEFAULT_COLOR = 'rgb(0,46,90)';

    const CSS = [
        self::HANDLE[ 'main' ] => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/billet/billet-main.css',

            'ver' => '1.0.7',
        ],

        self::HANDLE[ 'spoiler' ] => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/billet/billet-spoiler.css',

            'ver' => '1.0.0',
        ],
    ];

    const CSS_NEW = [
        self::HANDLE[ 'main' ] => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/billet/billet-main-new.css',

            'ver' => '1.0.0',
        ],
    ];

    // public static function print()
    // {
    //     ToolPrint::print_style( self::CSS );

    //     ToolPrint::print_script( self::JS );
    // }

	public static function register_style( $styles = [] )
    {
        // if ( self::check() )

        if ( CompilationTabs::check_contains_tabs() )
        {
            
            if ( empty( $styles ) )
            {
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

    const JS = [
        self::HANDLE[ 'spoiler' ] => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/billet/billet-spoiler.js',

            'ver' => '1.0.0',
        ],
    ];

    const JS_NEW = [
        self::HANDLE[ 'spoiler' ] => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/billet/billet-spoiler.js',

            'ver' => '1.0.0',
        ],

        'billet-footer' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/billet/billet-footer.js',

            'ver' => '1.0.0',
        ],
    ];

    public static function register_script( $scripts = [] )
    {
        // if ( self::check() )

        if ( CompilationTabs::check_contains_tabs() )
        {
            if ( empty( $scripts ) )
            {
                if ( TemplateMain::check_new() )
                {
                    $scripts = self::JS_NEW;    
                }
                else
                {
                    $scripts = self::JS;
                }
            }

            ToolEnqueue::register_script( $scripts );
        }
    }

    private static function get_footer_tnc()
    {
        return [
            'button' => __( BilletMain::TEXT[ 'read-more' ], ToolLoco::TEXTDOMAIN ),

            // 'active' => __( BilletMain::TEXT[ 'hide-tnc' ], ToolLoco::TEXTDOMAIN ),
            'link' => __( BilletMain::TEXT[ 'full-tnc' ], ToolLoco::TEXTDOMAIN ),
        ];
    }

	public static function check()
    {
        return LegalComponents::check();
    }

    const FIELD = [
        'about' => 'review-about',

        'main-description' => 'billet-feture-main-description',
    ];

    const ABOUT = [
        'afillate' => 'about-afillate',

        'review' => 'about-review',

        'bonus-id' => 'about-bonus-id',

        'bonus-title' => 'about-bonus',

        'bonus-description' => 'about-description',

        'background' => 'about-background',

        'description' => 'about-main-description',
    ];
    
    public static function register_functions()
	{
		BilletMega::register_functions();

        // BilletDescriptionAjax::register_functions();

        // BilletDescriptionRESTAPI::register_functions();
	}

    public static function register()
    {
        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );

        BilletMega::register();

        // BilletDescriptionAjax::register();
    }

    public static function get_bonus_url( $id, $filter = [] )
    {
        $bonus_url = '';

        $feature_bonus_item = BilletBonus::get_feture_bonus( $id, $filter );

        if ( !empty( $feature_bonus_item ) )
        {
            $bonus_id = $feature_bonus_item[ BilletBonus::FETURE_BONUS[ 'bonus-id' ] ];

            if ( $bonus_id )
            {
                $bonus_url = get_post_permalink( $bonus_id );
            }
        }

        if ( empty( $bonus_url ) )
        {
            $group = get_field( self::FIELD[ 'about' ], $id );

            if ( $group )
            {
                $bonus_id = $group[ self::ABOUT[ 'bonus-id' ] ];
                
                if ( $bonus_id )
                {
                    $bonus_url = get_post_permalink( $bonus_id );
                }
            }
        }
        
        return $bonus_url;
    }

    public static function get_nofollow( $url )
    {
        return str_contains( $url, '/go/' );
    }

    public static function get_url( $id, $filter = [] )
    {
        $referal_url = '';

        $card_url = '';

        // $bonus_url = '';

        $group = get_field( self::FIELD[ 'about' ], $id );

        if ( $group )
        {
            $referal_url = $group[ self::ABOUT[ 'afillate' ] ];

            $card_url = $group[ self::ABOUT[ 'review' ] ];

            // $bonus_url = $group[ self::ABOUT[ 'bonus-id' ] ];

            // $bonus_url = self::get_bonus_url( $id, $filter );
        }

        // LegalDebug::debug( [
        //     'function' => 'BilletMainget_url',

        //     'card_url' => $card_url,

        //     'bonus_url' => $bonus_url,

        //     'referal_url' => $referal_url,
        // ] );

        // Партнерская БК или ''

        // $referal_url = get_field( self::SETTINGS[ 'referal' ], $id );

        // Карточка БК или ''

        // $card_url = get_field( self::SETTINGS[ 'card' ], $id );

        // Бонус или ''

        // $bonus_url = self::get_post_url( $id, self::SETTINGS[ 'bonus' ], '' );

        // Текущая локаль

        // $locale = ( apply_filters( 'wpml_post_language_details', NULL, $id ) )[ 'locale' ];

        // $locale = WPMLMain::get_locale();
        
        // $locale = 'en';

        // $details = WPMLMain::get_post_language_details( $id );

        // if ( !empty( $details ) && !is_wp_error( $details ) )
        // {
        //     $locale = $details[ 'locale' ];
        // }

        // Oops если есть

        $oops = ( OopsMain::check_oops() > 0 ? '#' : '' );

        // Логотип

        // $logo_href = !empty( $referal_url ) ? $referal_url : $card_url;
        
        $logo_href = !empty( $referal_url ) ? $referal_url : ( !empty( $card_url ) ? $card_url : $oops );

        // Кнопка обзор учитывая тип Бонус

        $review_href = !empty( $filter['review']['type'] ) && !empty( $bonus_url ) ? $bonus_url : $card_url;

        // Название БК

        // $title_href = !empty( $card_url ) ? $card_url : $referal_url;
        
        $title_href = !empty( $card_url ) ? $card_url : ( !empty( $referal_url ) ? $referal_url : $oops );

        // Заголовок бонуса учитывая локаль Казахстан

        // $bonus_href = '';

        // if ( in_array( $locale, self::LOCALE_BONUS ) )
        // {
        //     if ( !empty ( $bonus_url ) )
        //     {
        //         $bonus_href = $bonus_url;
        //     }
        // }

        // if ( empty( $bonus_href ) )
        // {
        //     $bonus_href = !empty( $referal_url ) ? $referal_url : $oops;
        // }

        // Кнопка играть

        $play_href = !empty( $referal_url ) ? $referal_url : $oops;

        return [

            'logo' => $logo_href,

            'logo-nofollow' => self::get_nofollow( $logo_href ),

            'review' => $review_href,

            'title' => $title_href,

            'title-nofollow' => self::get_nofollow( $title_href ),
        
            // 'bonus' => $bonus_href,

            // 'bonus-nofollow' => self::get_nofollow( $bonus_href ),

            'play' => $play_href,

            'play-nofollow' => self::get_nofollow( $play_href ),

            'referal' => $referal_url,

            'oops' => $oops,

        ];
    }

    private static function get_post_url( $id, $field, $value )
    {
        $result = get_field( $field, $id );

        if ( !empty( $result ) ) {
            return get_post_permalink( $result );
        }

        return $value;
    }

    private static function get_field_default( $id, $field, $value )
    {
        $result = get_field( $field, $id );

        if ( !empty( $result ) ) {
            return $result;
        }

        return $value;
    }

    const SETTINGS = [
        'referal' => 'billet-referal',

        'card' => 'billet-card',

        'bonus' => 'billet-bonus',

        'bonus-title' => 'billet-bonus-title',

        'bonus-description' => 'billet-bonus-description',
    ];

    const BONUS = [
        'title' => 'billet-bonus-title',

        'description' => 'billet-bonus-description',
    ];

    private static function get_logo( $id, $index, $url, $filter )
    {
        return BilletLogo::get_logo( $id, $index, $url, $filter ); 
    }

    private static function get_title( $id, $index, $url, $filter )
    {
        return BilletTitle::get_title( $id, $index, $url, $filter ); 
    } 

    private static function get_bonus( $id, $url, $filter )
    {
        return BilletBonus::get_bonus( $id, $url, $filter );
    }

    private static function get_achievement( $id, $filter )
    {
        return BilletAchievement::get_achievement( $id, $filter );
    }

    private static function get_mobile( $id, $filter )
    {
        return BilletMobile::get_mobile( $id, $filter );
    }

    const FETURE_MAIN_DESCRIPTION = [
        'id' => 'billet-feture-id',

        'description' => 'billet-main-description'
    ];

    public static function get_main_description( $id, $filter = [] )
    {
        $main_description = '';

        $permission_main_description = ( !empty( $filter ) ? $filter[ 'description' ] : true );

        if ( $permission_main_description )
        {
            $feature_main_description = get_field( self::FIELD[ 'main-description' ], $id );

            // LegalDebug::debug( [
            //     'BilletMain' => 'get_main_description',
    
            //     'feature_main_description' => $feature_main_description,
            // ] );

            if ( $feature_main_description )
            {
                foreach ( $feature_main_description as $feature_main_description_item )
                {
                    if ( in_array( $feature_main_description_item[ self::FETURE_MAIN_DESCRIPTION[ 'id' ] ], $filter[ 'features' ] ) )
                    {
                        $main_description = $feature_main_description_item[ self::FETURE_MAIN_DESCRIPTION[ 'description' ] ];
                    }
                }
            }

            if ( empty( $main_description ) )
            {
                $group = get_field( self::FIELD[ 'about' ], $id );

                if ( $group )
                {
                    $main_description = $group[ self::ABOUT[ 'description' ] ];
                }
            } 
        }

        return wpautop( $main_description );
    }

    public static function get( $args )
    {
        $id = !empty( $args['id'] ) ? $args['id'] : ( get_post() )->ID;

        $filter = ( !empty( $args[ 'filter' ] ) ? $args[ 'filter' ] : [] );

        $url = self::get_url( $id, $filter );

        $index = !empty( $args['index'] ) ? $args['index'] : 1;
        
        $logo = self::get_logo( $id, $index, $url, $filter );

        $title = self::get_title( $id, $index, $url, $filter );

        $bonus = self::get_bonus( $id, $url, $filter );

        $achievement = self::get_achievement( $id, $filter );

        $mobile = self::get_mobile( $id, $filter );

        // $description = self::get_main_description( $args['id'], $args[ 'filter' ] );

        // LegalDebug::debug( [
        //     'function' => 'BilletMain::get',

        //     'bonus' =>  $bonus,
        // ] );

        return [
            'index' => $index,

            'id' => $id,
        
            // 'url' => self::get_url( $id, $filter ),
            
            'url' => $url,

            // 'bonus' => self::get_bonus( $id ),
            
            'logo' => $logo,

            'title' => $title,

            'bonus' => $bonus,

            'achievement' => $achievement,

            'mobile' => $mobile,

            'selector' => 'billet-' . $id,

            'color' => self::get_color( $id ),

            // 'description' => $description,

            'filter' => $filter,

            'footer-tnc' => self::get_footer_tnc(),
        ];
    }

    private static function get_color( $id )
    {
        $color = self::DEFAULT_COLOR;

        $group = get_field( self::FIELD[ 'about' ], $id );

        if ( $group )
        {
            $color = $group[ self::ABOUT[ 'background' ] ];
        }

        return $color;
    }

    public static function disabled( $url )
    {
        return ( $url == '' ? 'legal-disabled' : '' );
    }

    public static function href( $url )
    {
        $args['href'] = $url;

        $args['class'] = self::disabled( $url );

        return $args;
    }

    const TEMPLATE = [
        self::HANDLE[ 'main' ] => LegalMain::LEGAL_PATH . '/template-parts/billet/part-billet-main.php',

        self::HANDLE[ 'new' ] => LegalMain::LEGAL_PATH . '/template-parts/billet/part-billet-main-new.php',

        self::HANDLE[ 'style' ] => LegalMain::LEGAL_PATH . '/template-parts/billet/part-billet-style.php',

        self::HANDLE[ 'bonus' ] => LegalMain::LEGAL_PATH . '/template-parts/billet/part-billet-item-bonus.php',

        self::HANDLE[ 'bonus-new' ] => LegalMain::LEGAL_PATH . '/template-parts/billet/part-billet-item-bonus-new.php',
    ];

    public static function render_billet( $args = [] )
    { 
        if ( TemplateMain::check_new() )
        {
            return self::render_main( self::TEMPLATE[ self::HANDLE[ 'new' ] ], self::get( $args ) );
        }

        return self::render_main( self::TEMPLATE[ self::HANDLE[ 'main' ] ], self::get( $args ) );
    }

    public static function render_style( $args = [] )
    { 
        return self::render_main( self::TEMPLATE[ self::HANDLE[ 'style' ] ], self::get( $args ) );
    }

    public static function render_bonus( $args = [] )
    {
        if ( TemplateMain::check_new() )
        {
            return self::render_main( self::TEMPLATE[ self::HANDLE[ 'bonus-new' ] ], $args );
        }
		
        return self::render_main( self::TEMPLATE[ self::HANDLE[ 'bonus' ] ], $args );
    }

    public static function render_main( $template, $args )
    {
		ob_start();

        load_template( $template, false, $args );

        $output = ob_get_clean();

        return $output;
    }

    public static function render_nofollow( $permission )
    {
        // LegalDebug::debug( [
        //     'function' => 'BillletMain::render_nofollow',

        //     'permission' => $permission,
        // ] );

		if ( $permission )
        {
            return 'rel="nofollow"';
        }

        return '';
    }
}

?>