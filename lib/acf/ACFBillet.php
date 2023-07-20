<?php

class ACFBillet
{
	const FIELD = [
        'icon' => 'billet-list-part-icon',

        'direction' => 'billet-list-part-direction',

        'profit' => 'billet-profit-items',

        'font' => 'billet-font',

        'title-text' => 'billet-title-text',
    ];

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

    public static function billet_to_review( $post_id )
    {
        $group = get_field( BilletMain::FIELD[ 'about' ], $post_id );

        if ( $group )
        {
            $title = get_field( self::FIELD[ 'title-text' ], $post_id );

            LegalDebug::debug( [
                    'post_id' => $post_id,

                'group' => $group,

                'title' => $title,
            ] );

            if ( $title )
            {
                $group[ BilletTitle::ABOUT[ 'title' ] ] = $title;

                update_field( BilletMain::FIELD[ 'about' ], $group, $post_id );
            }

            LegalDebug::die( [
                'group' => $group,
            ] );

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