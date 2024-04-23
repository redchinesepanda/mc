<?php

class ACFBillet
{
    const PROFIT = [
        'feature' => 'profit-item-feature',

        'value' => 'profit-item-value',

        'pair' => 'profit-item-pair',
    ];

    const GROUP = [
        'about' => 'review-about',

        'brand' => 'billet-brand',
    ];

	const FIELD = [
        'icon' => 'billet-list-part-icon',

        'direction' => 'billet-list-part-direction',

        'profit' => 'billet-profit-items',

        'font' => 'billet-font',

        'title-text' => 'billet-title-text',

        'title-rating' => 'billet-title-rating',

        'logo' => 'billet-logo-url',

        'font' => 'billet-font',

        'referal' => 'billet-referal',

        'card' => 'billet-card',

        'bonus-id' => 'billet-bonus',

        'bonus-title' => 'billet-bonus-title',

        'bonus-description' => 'billet-bonus-description',

        'color' => 'billet-color',

        'description' => 'billet-description',
    ];

    const POST_TYPE = [
        'billet' => 'legal_billet',

        'brand' => 'legal_brand',

        'page' => 'page',
    ];

    public static function register()
    {
        $handler = new self();

        add_filter( 'acf/load_field/name=' . self::FIELD[ 'icon' ], [ $handler, 'choices_icon' ] );

        add_filter( 'acf/load_field/name=' . self::FIELD[ 'direction' ], [ $handler, 'choices_direction' ] );

        add_filter( 'acf/load_field/name=' . self::FIELD[ 'font' ], [ $handler, 'choices_font' ] );

        add_action( 'acf/save_post', [ $handler, 'my_acf_save_post' ] );

        add_filter( 'acf/prepare_field/name=' . self::PROFIT[ 'pair' ], [ $handler, 'legal_hidden' ] );

        // add_filter( 'save_post', [ $handler, 'billet_to_review' ], 10, 2 );
        
        // add_filter( 'save_post', [ $handler, 'billet_set_brand' ], 10, 2 );
        
        add_filter( 'save_post_' . self::POST_TYPE[ 'billet' ], [ $handler, 'billet_set_brand' ], 10, 2 );
        
        add_filter( 'save_post_' . self::POST_TYPE[ 'page' ], [ $handler, 'billet_set_brand' ], 10, 2 );
    }

    public static function brand_args( $title )
    {
        return [
            'numberposts' => 1,

            'fields' => 'ids',

            'suppress_filters' => 1,

            'post_type' => self::POST_TYPE[ 'brand' ],

            's' => $title,
        ];
    }

    public static function get_brand( $title )
    {
        return get_posts( self::brand_args( $title ) );
    }

    public static function billet_set_brand( $post_id, $post )
    {
        // if ( self::POST_TYPE[ 'billet' ] == $post->post_type )
        // {
            $args = 0;

            $about = get_field( self::GROUP[ 'about' ], $post_id );

            if ( $about )
            {
                if ( $title = $about[ BilletTitle::ABOUT[ 'title' ] ] )
                {
                    $brands = self::get_brand( $title );

                    // LegalDebug::die( [
                    //     'ACFBillet' => 'billet_set_brand',

                    //     'brands' => $brands,
                    // ] );

                    $args = array_shift( $brands );
                }
            }

            // LegalDebug::die( [
            //     'ACFBillet' => 'billet_set_brand',

            //     'args' => $args,
            // ] );

            if ( !empty( $args ) && empty( get_field( self::GROUP[ 'brand' ], $post_id ) ) )
            {
                update_field( self::GROUP[ 'brand' ], $args, $post_id );
            }
        // }
    }
    
    public static function billet_to_review( $post_id, $post )
    {
        if ( self::POST_TYPE[ 'billet' ] == $post->post_type ) {
            // $group = get_field( BilletMain::FIELD[ 'about' ], $post_id );
    
            // if ( !$group )
            // {
            //     $group = [];
            // }

            $args = [];

            $title = get_field( self::FIELD[ 'title-text' ], $post_id );

            if ( $title )
            {
                $args[ BilletTitle::ABOUT[ 'title' ] ] = $title;

                delete_field( self::FIELD[ 'title-text' ], $post_id );
            }

            $rating = get_field( self::FIELD[ 'title-rating' ], $post_id );

            if ( $rating )
            {
                $args[ BilletTitle::ABOUT[ 'rating' ] ] = $rating;

                delete_field( self::FIELD[ 'title-rating' ], $post_id );
            }

            $logo = get_field( self::FIELD[ 'logo' ], $post_id, false );

            if ( $logo )
            {
                $args[ BilletLogo::ABOUT[ 'logo' ] ] = $logo;

                delete_field( self::FIELD[ 'logo' ], $post_id );
            }

            $font = get_field( self::FIELD[ 'font' ], $post_id );

            if ( $font )
            {
                $args[ BilletLogo::ABOUT[ 'font' ] ] = $font;

                delete_field( self::FIELD[ 'font' ], $post_id );
            }

            $description = get_field( self::FIELD[ 'description' ], $post_id );

            if ( $description )
            {
                $args[ BilletMain::ABOUT[ 'description' ] ] = $description;

                delete_field( self::FIELD[ 'description' ], $post_id );
            }

            $afillate = get_field( self::FIELD[ 'referal' ], $post_id, false );

            if ( $afillate )
            {
                $args[ BilletMain::ABOUT[ 'afillate' ] ] = $afillate;

                delete_field( self::FIELD[ 'referal' ], $post_id );
            }

            $review = get_field( self::FIELD[ 'card' ], $post_id, false );

            if ( $review )
            {
                $args[ BilletMain::ABOUT[ 'review' ] ] = $review;

                delete_field( self::FIELD[ 'card' ], $post_id );
            }

            $bonus_id = get_field( self::FIELD[ 'bonus-id' ], $post_id );

            if ( $bonus_id )
            {
                $args[ BilletMain::ABOUT[ 'bonus-id' ] ] = $bonus_id;

                delete_field( self::FIELD[ 'bonus-id' ], $post_id );
            }

            $bonus_title = get_field( self::FIELD[ 'bonus-title' ], $post_id );

            if ( $bonus_title )
            {
                $args[ BilletMain::ABOUT[ 'bonus-title' ] ] = $bonus_title;

                delete_field( self::FIELD[ 'bonus-title' ], $post_id );
            }

            $bonus_description = get_field( self::FIELD[ 'bonus-description' ], $post_id );

            if ( $bonus_description )
            {
                $args[ BilletMain::ABOUT[ 'bonus-description' ] ] = $bonus_description;

                delete_field( self::FIELD[ 'bonus-description' ], $post_id );
            }

            $background = get_field( self::FIELD[ 'color' ], $post_id );

            if ( $background )
            {
                $args[ BilletMain::ABOUT[ 'background' ] ] = $background;

                delete_field( self::FIELD[ 'color' ], $post_id );
            }

            if ( !empty( $args ) )
            {
                update_field( BilletMain::FIELD[ 'about' ], $args, $post_id );
            }

        }
    }

    public static function legal_hidden( $field )
    {
        return false;
    }

    public static function my_acf_save_post( $post_id )
    {
		$profit = get_field( self::FIELD[ 'profit' ] , $post_id );

		if ( $profit )
        {
            foreach ( $profit as $id => $row )
            {
                $value = [
                    self::PROFIT[ 'feature' ] => $row[ self::PROFIT[ 'feature' ] ],

                    self::PROFIT[ 'value' ] => $row[ self::PROFIT[ 'value' ] ],

                    self::PROFIT[ 'pair' ] => 'pair-order-' . $row[ self::PROFIT[ 'feature' ] ] . '-' . $row[ self::PROFIT[ 'value' ] ],
                ];

                update_row( self::FIELD[ 'profit' ], $id + 1, $value, $post_id );
            }

            $profit = get_field( self::FIELD[ 'profit' ] , $post_id );
		}
	}

    function choices_icon( $field )
    {
        $choices[ 'legal-default' ] = 'Без маркера';

        $choices[ 'legal-check' ] = 'Галка';

        $choices[ 'legal-check-round' ] = 'Галска в круге';

        $choices[ 'legal-close' ] = 'Крест';

        $choices[ 'legal-plus' ] = 'Плюс';

        $choices[ 'legal-minus' ] = 'Минус';

        $choices[ 'legal-triangle' ] = 'Треугольник';

        $field[ 'choices' ] = $choices;

        return $field;
    }

    function choices_direction( $field )
    {
        $choices[ 'legal-row' ] = 'Строка';

        $choices[ 'legal-column' ] = 'Столбец';

        $field[ 'choices' ] = $choices;

        return $field;
    }

    function choices_font( $field )
    {
        $choices[ 'legal-default' ] = 'Белый';

        $choices[ 'legal-black' ] = 'Черный';

        $field[ 'choices' ] = $choices;

        $field[ 'default_value' ] = 'legal-default';

        return $field;
    }
}

?>