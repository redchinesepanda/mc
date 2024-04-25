<?php

class BilletDescription
{
	const FIELD = [
        'description-full' => 'billet-description-full',
    ];

    const ALLOWED = [
        'a',

        'b',

        'p',
    ];

	public static function get( $billet )
    {
		$args = [];

        $description_full = get_field( self::FIELD[ 'description-full' ], $billet['id'] );

        LegalDebug::debug( [
            'BilletDescription' => 'get',

            'description_full' => $description_full,
        ] );

        if ( $description_full )
        {
            // $args[ 'description-full' ] = $description_full;

            LegalDebug::debug( [
                'BilletDescription' => 'get',

                'description_full' => $description_full,
            ] );
            
            $args[ 'description-full' ] = strip_tags( $description_full, self::ALLOWED );
        }

        return $args;
    }

	const TEMPLATE = [
        'description-full' => LegalMain::LEGAL_PATH . '/template-parts/billet/center/part-billet-description-full.php',
    ];

    public static function render( $billet )
    {
        ob_start();

        load_template( self::TEMPLATE[ 'description-full' ], false, self::get( $billet ) );

        $output = ob_get_clean();

        return $output;
    }
}

?>