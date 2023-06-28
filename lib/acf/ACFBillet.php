<?php

class ACFBillet
{
	const FIELD = [
        'icon' => 'billet-list-part-icon',

        'direction' => 'billet-list-part-direction',

        'profit' => 'billet-profit-items',
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

        add_action('acf/save_post', [ $handler, 'my_acf_save_post' ]);
    }

    public static function my_acf_save_post( $post_id ) {

		// Get newly saved values.
		// $values = get_fields( $post_id );

		// Check the new value of a specific field.
		$profit = get_field( self::FIELD[ 'profit' ] , $post_id );

		if ( $profit )
        {
			// LegalDebug::debug( [
            //     // 'values' => $values,

            //     'profit' => $profit,
            // ] );

            foreach ( $profit as $id => $row )
            {
                $value = [
                    self::PROFIT[ 'feature' ] => $row[ self::PROFIT[ 'feature' ] ],

                    self::PROFIT[ 'value' ] => $row[ self::PROFIT[ 'value' ] ],

                    self::PROFIT[ 'pair' ] => 'pair-order' . $row[ self::PROFIT[ 'feature' ] ] . '-' . $row[ self::PROFIT[ 'value' ] ],
                ];

                update_row( self::FIELD[ 'profit' ], $id, $value, [ $post_id ] )
            }
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
}

?>