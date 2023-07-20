<?php

class ACFBillet
{
    const PROFIT = [
        'feature' => 'profit-item-feature',

        'value' => 'profit-item-value',

        'pair' => 'profit-item-pair',
    ];

    public static function register()
    {
        $handler = new self();

        add_filter( 'acf/load_field/name=' . self::FIELD[ 'icon' ], [ $handler, 'choices_icon' ] );

        add_filter( 'acf/load_field/name=' . self::FIELD[ 'direction' ], [ $handler, 'choices_direction' ] );

        add_filter( 'acf/load_field/name=' . self::FIELD[ 'font' ], [ $handler, 'choices_font' ] );

        add_action( 'acf/save_post', [ $handler, 'my_acf_save_post' ] );

        add_filter( 'acf/prepare_field/name=' . self::PROFIT[ 'pair' ], [ $handler, 'legal_hidden' ] );

        add_action( 'acf/save_post', [ $handler, 'billet_to_review' ] );
    }

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
    ];

    public static function billet_to_review( $post_id )
    {
        $group = get_field( BilletMain::FIELD[ 'about' ], $post_id );

        if ( $group )
        {
            // LegalDebug::debug( [
            //     'post_id' => $post_id,

            //     'group' => $group,
            // ] );

            $title = get_field( self::FIELD[ 'title-text' ], $post_id );

            if ( $title )
            {
                $group[ BilletTitle::ABOUT[ 'title' ] ] = $title;
            }

            $rating = get_field( self::FIELD[ 'title-rating' ], $post_id );

            if ( $rating )
            {
                $group[ BilletTitle::ABOUT[ 'rating' ] ] = $rating;
            }

            $logo = get_field( self::FIELD[ 'logo' ], $post_id );

            if ( $logo )
            {
                $group[ BilletLogo::ABOUT[ 'logo' ] ] = $logo;
            }

            $font = get_field( self::FIELD[ 'font' ], $post_id );

            if ( $font )
            {
                $group[ BilletLogo::ABOUT[ 'font' ] ] = $font;
            }

            $afillate = get_field( self::FIELD[ 'referal' ], $post_id, false );

            if ( $afillate )
            {
                $group[ BilletMain::ABOUT[ 'afillate' ] ] = $afillate;
            }

            // LegalDebug::debug( [
            //     'afillate_meta' => get_post_meta( $post_id, BilletMain::FIELD[ 'about' ]. '_' . BilletMain::ABOUT[ 'afillate' ] , true ),

            //     'afillate-get_field' => get_field( self::FIELD[ 'referal' ], $post_id, false )
            // ] );

            $review = get_field( self::FIELD[ 'card' ], $post_id );

            if ( $review )
            {
                $group[ BilletMain::ABOUT[ 'review' ] ] = $review;
            }

            $bonus_id = get_field( self::FIELD[ 'bonus-id' ], $post_id );

            if ( $bonus_id )
            {
                $group[ BilletMain::ABOUT[ 'bonus-id' ] ] = $bonus_id;
            }

            $bonus_title = get_field( self::FIELD[ 'bonus-title' ], $post_id );

            if ( $bonus_title )
            {
                $group[ BilletMain::ABOUT[ 'bonus-title' ] ] = $bonus_title;
            }

            $bonus_description = get_field( self::FIELD[ 'bonus-description' ], $post_id );

            if ( $bonus_description )
            {
                $group[ BilletMain::ABOUT[ 'bonus-description' ] ] = $bonus_description;
            }

            $background = get_field( self::FIELD[ 'color' ], $post_id );

            if ( $background )
            {
                $group[ BilletMain::ABOUT[ 'background' ] ] = $background;
            }

            // LegalDebug::die( [
            //     'group' => $group,
            // ] );

            update_field( BilletMain::FIELD[ 'about' ], $group, $post_id );
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