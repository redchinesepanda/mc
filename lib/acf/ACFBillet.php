<?php

class ACFBillet
{
	const FIELD = [
        'icon' => 'billet-list-part-icon',

        'direction' => 'billet-list-part-direction',
    ];

    public static function register()
    {
        $handler = new self();

        add_filter( 'acf/load_field/name=' . self::FIELD[ 'icon' ], [ $handler, 'choices_icon' ] );

        add_filter( 'acf/load_field/name=' . self::FIELD[ 'direction' ], [ $handler, 'choices_direction' ] );
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

    function choices_icon( $field )
    {
        $choices[ 'legal-row' ] = 'Строка';

        $choices[ 'legal-column' ] = 'Столбец';

        $field[ 'choices' ] = $choices;

        return $field;
    }
}

?>