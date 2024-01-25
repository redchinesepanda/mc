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

    // $billet['id']

    // $billet['index']

    // $billet['url']

    // $billet['filter']

    public static function get_title( $id, $index, $url, $filter )
    {
        $rating = 0;

        $label = '';

        $group = get_field( self::FIELD[ 'about' ], $id );

        if ( $group )
        {
            if ( !empty( $filter['rating'] ) )
            {
                $rating = $group[ self::ABOUT[ 'rating' ] ];
            }

            $label = $group[ self::ABOUT[ 'title' ] ];
        }

        $args = BilletMain::href( $url['title'] );

        $args['nofollow'] = $url['title-nofollow'];

        $args['id'] = $id;

        $args['index'] = $index;

        $args['order'] = !empty( $filter['order'] ) ? $filter['order'] : self::ORDER_TYPE;

        $args['achievement'] = !empty( $filter['achievement'] ) ? $filter['achievement'] : BilletAchievement::TYPE_IMAGE;

        // $args['rating'] = ( !empty( $billet['filter']['rating'] ) ? get_field( 'billet-title-rating', $billet['id'] ) : 0 );

        // $args['label'] = get_field( 'billet-title-text', $billet['id'] );

        $args['rating'] = $rating;

        $args['label'] = $label;

        $args[ 'filter' ] = $filter;

        return $args;
    }

    public static function get( $billet )
    {
        // $rating = 0;

        // $label = '';

        // $group = get_field( self::FIELD[ 'about' ], $billet['id'] );

        // if ( $group )
        // {
        //     if ( !empty( $billet['filter']['rating'] ) )
        //     {
        //         $rating = $group[ self::ABOUT[ 'rating' ] ];
        //     }

        //     $label = $group[ self::ABOUT[ 'title' ] ];
        // }

        // $args = BilletMain::href( $billet['url']['title'] );

        // $args['nofollow'] = $billet['url']['title-nofollow'];

        // $args['id'] = $billet['id'];

        // $args['index'] = $billet['index'];

        // $args['order'] = !empty( $billet['filter']['order'] ) ? $billet['filter']['order'] : self::ORDER_TYPE;

        // $args['achievement'] = !empty( $billet['filter']['achievement'] ) ? $billet['filter']['achievement'] : BilletAchievement::TYPE_IMAGE;

        // // $args['rating'] = ( !empty( $billet['filter']['rating'] ) ? get_field( 'billet-title-rating', $billet['id'] ) : 0 );

        // // $args['label'] = get_field( 'billet-title-text', $billet['id'] );

        // $args['rating'] = $rating;

        // $args['label'] = $label;

        // $args[ 'filter' ] = $billet['filter'];

        // return $args;

        return self::get_title( $billet['id'], $billet['index'], $billet['url'], $billet['filter'] );
    }

    const TEMPLATE = [
        'title' => LegalMain::LEGAL_PATH . '/template-parts/billet/center/part-billet-title.php',

        'new' => LegalMain::LEGAL_PATH . '/template-parts/billet/center/part-billet-title-new.php',
    ];

    public static function render( $billet )
    {
        // load_template( self::TEMPLATE[ 'title' ], false, self::get( $billet ) );

        if ( TemplateMain::check_new() )
        {
            return self::render_main( self::TEMPLATE[ 'new' ], self::get( $billet ) );
        }

        return self::render_main( self::TEMPLATE[ 'title' ], self::get( $billet ) );
    }

    public static function render_main( $template, $args )
    {
		ob_start();

        load_template( $template, false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>