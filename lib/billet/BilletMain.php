<?php

require_once( 'BilletLogo.php' );

require_once( 'BilletSpoiler.php' );

require_once( 'center/BilletTitle.php' );

require_once( 'center/BilletList.php' );

require_once( 'center/BilletAchievement.php' );

require_once( 'right/BilletRight.php' );

class BilletMain
{
    const DEFAULT_COLOR = 'rgb(0,46,90)';

    const CSS = [
        'billet-main' => LegalMain::LEGAL_URL . '/assets/css/billet/billet-main.css',

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
        $permission = true;
        
        return $permission;
    }

    public static function register()
    {
        $handler = new self();

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
    }

    const SETTINGS = [
        'referal' => 'billet-referal',

        'card' => 'billet-card',

        'bonus' => 'billet-bonus',
    ];

    private static function get_url( $id, $filter )
    {
        // Партнерская БК или ''

        $referal_url = get_field( self::SETTINGS[ 'referal' ], $id );

        // Карточка БК или ''

        $card_url = get_field( self::SETTINGS[ 'card' ], $id );

        // Бонус или ''

        $bonus_url = self::get_post_url( $id, self::SETTINGS[ 'bonus' ], '' );

        // Текущая локаль

        $locale = ( apply_filters( 'wpml_post_language_details', NULL, $id ) )['locale'];

        // Oops если есть

        $oops = ( OopsMain::check_oops() > 0 ? '#oops' : '' );

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

    private static function get_bonus( $id )
    {
        $bonus_id = get_field( 'billet-bonus', $id );

        if ( !empty( $bonus_id ) ) {
            // $args['url'] = self::get_field_default( $bonus_id, 'billet-afillate-link', '/#oops' );

            $args['title'] = self::get_field_default( $bonus_id, 'billet-bonus-title', __( 'Not set', ToolLoco::TEXTDOMAIN ) );

            $args['description'] = self::get_field_default( $bonus_id, 'billet-bonus-description', __( 'Not set', ToolLoco::TEXTDOMAIN ) );

            return $args;
        }

        return [];
    }

    private static function get( $args )
    {
        $id = ( !empty( $args['id'] ) ? $args['id'] : ( get_post() )->ID );

        $filter = ( !empty( $args[ 'filter' ] ) ? $args[ 'filter' ] : [] );

        $filter_description = ( !empty( $args[ 'filter' ] ) ? $args[ 'filter' ][ 'description' ] : true );

        return [
            'index' => ( !empty( $args['index'] ) ? $args['index'] : 1 ),

            'id' => $id,
        
            'url' => self::get_url( $id, $filter ),

            'bonus' => self::get_bonus( $id ),

            'selector' => 'billet-' . $id,

            'color' => self::get_color( $id ),

            'description' => ( $filter_description ? get_field( 'billet-description', $id ) : '' ),

            'filter' => $filter,
        ];
    }

    private static function get_color( $id )
    {
        $color = get_field( 'billet-color', $id );

        if ( empty( $color ) ) {
            $color = self::DEFAULT_COLOR;
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
    ];

    public static function render( $args = [] )
    { 
        load_template( self::TEMPLATE[ 'billet-main' ], false, self::get( $args ) );
    }
}

?>