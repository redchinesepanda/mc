<?php

require_once( 'BilletMega.php' );

require_once( 'BilletLogo.php' );

require_once( 'BilletSpoiler.php' );

require_once( 'BilletMini.php' );

require_once( 'center/BilletTitle.php' );

require_once( 'center/BilletDescription.php' );

require_once( 'center/BilletList.php' );

require_once( 'center/BilletAchievement.php' );

require_once( 'right/BilletRight.php' );

class BilletMain
{
	const TEXT = [
		'bet-here' => 'Bet here',

		'bet-now' => 'Bet now',

		'close-details' => 'Close Details',

		'get-in-touch' => 'Get in touch',

		'last-updated' => 'Last updated',

		'margin' => 'Margin',

		'more-details' => 'More Details',

		'read-more-about' => 'Read more about',

		'review' => 'Review',

        'there-are-no-tabs' => 'There are no tabs added yet',
	];
    
    const DEFAULT_COLOR = 'rgb(0,46,90)';

    const CSS = [
        'billet-main' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/billet/billet-main.css',

            'ver' => '1.0.5',
        ],

        'billet-spoiler' => LegalMain::LEGAL_URL . '/assets/css/billet/billet-spoiler.css',
    ];

    const JS = [
        'billet-spoiler' => LegalMain::LEGAL_URL . '/assets/js/billet/billet-spoiler.js'
    ];

    public static function print()
    {
        ToolPrint::print_style( self::CSS );

        ToolPrint::print_script( self::JS );
    }

    public static function register_script( $scripts = [] )
    {
        if ( self::check() ) {
            if ( empty( $scripts ) ) {
                $scripts = self::JS;
            }

            ToolEnqueue::register_script( $scripts );
        }
    }

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

    const FIELD = [
        'about' => 'review-about',
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

    public static function register()
    {
        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );

        BilletMega::register();
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

        LegalDebug::debug( [
            'function' => 'BilletMain::get_bonus_url',

            'feature_bonus_item' => $feature_bonus_item,

            'bonus_url' => $bonus_url,

            'id' => $id,

            'filter' => $filter,
        ] );
        
        return $bonus_url;
    }

    public static function get_url( $id, $filter = [] )
    {
        $referal_url = '';

        $card_url = '';

        $bonus_url = '';

        $group = get_field( self::FIELD[ 'about' ], $id );

        if ( $group )
        {
            $referal_url = $group[ self::ABOUT[ 'afillate' ] ];

            $card_url = $group[ self::ABOUT[ 'review' ] ];

            // $bonus_url = $group[ self::ABOUT[ 'bonus-id' ] ];

            $bonus_url = self::get_bonus_url( $id, $filter );
        }

        // Партнерская БК или ''

        // $referal_url = get_field( self::SETTINGS[ 'referal' ], $id );

        // Карточка БК или ''

        // $card_url = get_field( self::SETTINGS[ 'card' ], $id );

        // Бонус или ''

        // $bonus_url = self::get_post_url( $id, self::SETTINGS[ 'bonus' ], '' );

        // Текущая локаль

        // $locale = ( apply_filters( 'wpml_post_language_details', NULL, $id ) )[ 'locale' ];

        $locale = 'en';

        $details = WPMLMain::get_post_language_details( $id );

        if ( !empty( $details ) && !is_wp_error( $details ) )
        {
            $locale = $details[ 'locale' ];
        }

        // Oops если есть

        $oops = ( OopsMain::check_oops() > 0 ? '#' : '' );

        return [
            // Логотип

            'logo' => ( !empty( $referal_url ) ? $referal_url : $card_url ),

            // Кнопка обзор учитывая тип Бонус

            'review' => ( !empty( $filter['review']['type'] ) && !empty( $bonus_url ) ? $bonus_url : $card_url ),

            // Название БК

            'title' => ( !empty( $card_url ) ? $card_url : $referal_url ),

            // Заголовок бонуса учитывая локаль Казахстан
        
            'bonus' => ( $locale == 'ru_KZ' ? $bonus_url : ( !empty( $referal_url ) ? $referal_url : $oops ) ),

            // Кнопка играть

            'play' =>  ( !empty( $referal_url ) ? $referal_url : $oops ),
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

    private static function get_bonus( $id )
    {
        $args = [];

        $bonus_id = 0;

        $title = '';

        $description = '';

        $group = get_field( self::FIELD[ 'about' ], $id );

        if ( $group )
        {
            $bonus_id = $group[ self::ABOUT[ 'bonus-id' ] ];

            $title = $group[ self::ABOUT[ 'bonus-title' ] ];

            $description = $group[ self::ABOUT[ 'bonus-description' ] ];
        }

        if ( $bonus_id )
        {
            $title = get_field( self::BONUS[ 'title' ], $bonus_id );

            $description = get_field( self::BONUS[ 'description' ], $bonus_id );
        }

        return [
            'title' => $title,

            'description' => $description,
        ];
    }

    public static function get( $args )
    {
        $id = ( !empty( $args['id'] ) ? $args['id'] : ( get_post() )->ID );

        $filter = ( !empty( $args[ 'filter' ] ) ? $args[ 'filter' ] : [] );

        $description = '';

        $group = get_field( self::FIELD[ 'about' ], $id );

        if ( $group )
        {
            $filter_description = ( !empty( $args[ 'filter' ] ) ? $args[ 'filter' ][ 'description' ] : true );

            if ( $filter_description )
            {
                $description = $group[ self::ABOUT[ 'description' ] ];
            }
        }

        return [
            'index' => ( !empty( $args['index'] ) ? $args['index'] : 1 ),

            'id' => $id,
        
            'url' => self::get_url( $id, $filter ),

            'bonus' => self::get_bonus( $id ),

            'selector' => 'billet-' . $id,

            'color' => self::get_color( $id ),

            'description' => $description,

            'filter' => $filter,
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
        'billet-main' => LegalMain::LEGAL_PATH . '/template-parts/billet/part-billet-main.php',

        'billet-bonus' => LegalMain::LEGAL_PATH . '/template-parts/billet/part-billet-item-bonus.php',
    ];

    public static function render( $args = [] )
    { 
        load_template( self::TEMPLATE[ 'billet-main' ], false, self::get( $args ) );
    }

    public static function render_bonus( $args = [] )
    {
		ob_start();

        load_template( self::TEMPLATE[ 'billet-bonus' ], false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>