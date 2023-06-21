<?php

class ACFBillet
{
	const FIELD = [
        'icon' => 'billet-list-part-icon',
    ];

    public static function register()
    {
        $handler = new self();

        add_filter( 'acf/load_field/name=' . self::FIELD[ 'icon' ], [ $handler, 'choices' ] );
    }

    function choices( $field )
    {
        $field[ 'choices' ][ 'legal-check' ] = 'Галка';

        $field[ 'choices' ][ 'legal-check-round' ] = 'Галска в круге';

        $field[ 'choices' ][ 'legal-close' ] = 'Крест';

        $field[ 'choices' ][ 'legal-plus' ] = 'Плюс';

        $field[ 'choices' ][ 'legal-minus' ] = 'Минус';

        $field[ 'choices' ][ 'legal-triangle' ] = 'Треугольник';

        return $field;
    }
}

?>