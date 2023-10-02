<?php

class BilletTitle extends LegalDebug
{
    const FIELD = [
        'about' => 'review-about',
    ];

    const ABOUT = [
        'title' => 'about-title',

        'rating' => 'about-rating',
    ];

    const ORDER_TYPE = 'legal-title';

    public static function get( $billet )
    {
        $rating = 0;

        $label = '';

        $group = get_field( self::FIELD[ 'about' ], $billet['id'] );

        if ( $group )
        {
            if ( !empty( $billet['filter']['rating'] ) )
            {
                $rating = $group[ self::ABOUT[ 'rating' ] ];
            }

            $label = $group[ self::ABOUT[ 'title' ] ];
        }

        $args = BilletMain::href( $billet['url']['title'] );

        $args['id'] = $billet['id'];

        $args['index'] = $billet['index'];

        $args['order'] = !empty( $billet['filter']['order'] ) ? $billet['filter']['order'] : self::ORDER_TYPE;

        $args['achievement'] = !empty( $billet['filter']['achievement'] ) ? $billet['filter']['achievement'] : BilletAchievement::TYPE_IMAGE;

        // $args['rating'] = ( !empty( $billet['filter']['rating'] ) ? get_field( 'billet-title-rating', $billet['id'] ) : 0 );

        // $args['label'] = get_field( 'billet-title-text', $billet['id'] );

        $args['rating'] = $rating;

        $args['label'] = $label;

        $args[ 'filter' ] = $billet['filter'];

        return $args;
    }

    const TEMPLATE = [
        'title' => LegalMain::LEGAL_PATH . '/template-parts/billet/center/part-billet-title.php',
    ];

    public static function render( $billet )
    {
        load_template( self::TEMPLATE[ 'title' ], false, self::get( $billet ) );
    }
}

?>