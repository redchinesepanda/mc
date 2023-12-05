<?php

class BilletBonus
{
    const FIELD = [
        'about' => 'review-about',

        'feture-bonus' => 'billet-feture-bonus',
    ];

    const FETURE_BONUS = [
        'feture-id' => 'billet-feture-id',

        'bonus-id' => 'billet-bonus-id',

        'bonus-title' => 'billet-bonus-title',

        'bonus-description' => 'billet-bonus-description',

        'bonus-description-full' => 'billet-bonus-description-full',
    ];

    const ABOUT = [
        'bonus-id' => 'about-bonus-id',

        'bonus-title' => 'about-bonus',

        'bonus-description' => 'about-description',

        'description' => 'about-main-description',
    ];

    // public static function get_feture_bonus( $id, $filter = [] )
    // {
    //     $result = null;

    //     $feature_bonus_item = null;

    //     $feature_bonus = get_field( self::FIELD[ 'feture-bonus' ], $id );

    //     if ( $feature_bonus )
    //     {
    //         foreach ( $feature_bonus as $feature_bonus_item )
    //         {
    //             if (
    //                 !empty( $filter[ 'features' ] )

    //                 && in_array(
    //                     $feature_bonus_item[ self::FETURE_BONUS[ 'feture-id' ] ],
                        
    //                     $filter[ 'features' ]
    //                 )
    //             )
    //             {
    //                 $result = $feature_bonus_item;
    //             }
    //         }
    //     }

    //     // LegalDebug::debug( [
    //     //     'function' => 'BilletBonus::get_feture_bonus',

    //     //     'feature_bonus_item' => $feature_bonus_item,

    //     //     'result' => $result,

    //     //     'id' => $id,

    //     //     'filter' => $filter,
    //     // ] );

    //     return $result;
    // }
    
    public static function get_bonus_repeater( $id = 0, $filter = [] )
    {
        if ( !empty( $filter[ 'features' ] ) )
        {
            $items = get_field( self::FIELD[ 'feture-bonus' ], $id );

            if ( $items )
            {
                foreach ( $items as $item )
                {
                    if ( in_array( $item[ self::FETURE_BONUS[ 'feture-id' ] ], $filter[ 'features' ] ) )
                    {
                        // LegalDebug::debug( [
                        //     'function' => 'BilletBonus::get_feture_bonus',

                        //     'feature_bonus_item' => $feature_bonus_item,

                        //     'result' => $result,

                        //     'id' => $id,

                        //     'filter' => $filter,
                        // ] );
                        
                        // return $item;

                        $bonus_href = '';

                        if ( $bonus_id = $item[ self::FETURE_BONUS[ 'bonus-id' ] ] )
                        {
                            $bonus_href = get_post_permalink( $bonus_id );
                        }

                        return [
                            'href' => $bonus_href,

                            'title' => $item[ self::FETURE_BONUS[ 'bonus-title' ] ],
                
                            'description' => $item[ self::FETURE_BONUS[ 'bonus-description' ] ],
                
                            'description-full' => $item[ self::FETURE_BONUS[ 'bonus-description-full' ] ],
                        ];
                    }
                }
            }
        }

        return null;
    }

    public static function get_bonus_default( $id )
    {
        return [
            'href' => '',

            'title' => '',

            'description' => '',

            'description-full' => '',
        ];
    }

    public static function get_bonus_group( $id )
    {
        $group = get_field( self::FIELD[ 'about' ], $id );

        if ( $group )
        {
            // $title = $group[ self::ABOUT[ 'bonus-title' ] ];

            // $description = $group[ self::ABOUT[ 'bonus-description' ] ];
            
            // $description_full = $group[ self::ABOUT[ 'bonus-description-full' ] ];

            $bonus_href = '';
                
            if ( $bonus_id = $group[ self::ABOUT[ 'bonus-id' ] ] )
            {
                $bonus_href = get_post_permalink( $bonus_id );
            }

            return [
                'href' => $bonus_href,
                
                'title' => $group[ self::ABOUT[ 'bonus-title' ] ],
    
                'description' => $group[ self::ABOUT[ 'bonus-description' ] ],
    
                'description-full' => $group[ self::ABOUT[ 'description' ] ],
            ];
        }

        return null;
    }

    // public static function get_bonus_href( $bonus_url, $referal_url, $oops )
    // {
    //     if ( !empty( $bonus_url ) && in_array( $locale, self::LOCALE_BONUS )  )
    //     {
    //         return $bonus_url;
    //     }

    //     return !empty( $referal_url ) ? $referal_url : $oops;
    // }
    
    public static function get_bonus_href( $bonus_url, $referal_url, $oops )
    {
        $bonus_href = '';

        if ( !empty( $bonus_url ) && in_array( $locale, self::LOCALE_BONUS )  )
        {
            $bonus_href = $bonus_url;
        }

        if ( empty( $bonus_href ) )
        {
            $bonus_href = !empty( $referal_url ) ? $referal_url : $oops;
        }

        return array_merge(
            BilletMain::href( $bonus_href ),

            [ 'nofollow' => BilletMain::get_nofollow( $bonus_href ) ]
        );
    }

    public static function get_bonus( $id, $url, $filter )
    {
        $bonus_data = self::get_bonus_data( $id, $filter );

        return array_merge(
            // BilletMain::href( $url[ 'bonus' ] ),

            // [ 'nofollow' => $url[ 'bonus-nofollow' ] ],

            self::get_bonus_href( $bonus_data[ 'href' ], $url[ 'referal' ], $url[ 'oops' ] ),

            $bonus_data
        );
    }

    public static function get_bonus_data( $id, $filter )
    {
        if ( $bonus = self::get_bonus_repeater( $id, $filter ) )
        {
            return $bonus;
        }

        if ( $bonus = self::get_bonus_group( $id ) )
        {
            return $bonus;
        }

        return self::get_bonus_default();

        // $args = [];

        // $title = '';

        // $description = '';

        // $description_full = '';

        // $feature_bonus_item = self::get_feture_bonus( $billet[ 'id' ], $billet[ 'filter' ] );
        
        // $feature_bonus_item = self::get_feture_bonus( $id, $filter );

        // if ( !empty( $feature_bonus_item ) )
        // {
        //     // $args = BilletMain::href( $billet[ 'url' ][ 'bonus' ] );

        //     // $args[ 'nofollow' ] = $billet[ 'url' ][ 'bonus-nofollow' ];

        //     // $args[ 'title' ] = $feature_bonus_item[ self::FETURE_BONUS[ 'bonus-title' ] ];
            
        //     $title = $feature_bonus_item[ self::FETURE_BONUS[ 'bonus-title' ] ];

        //     // $args[ 'description' ] = $feature_bonus_item[ self::FETURE_BONUS[ 'bonus-description' ] ];
            
        //     $description = $feature_bonus_item[ self::FETURE_BONUS[ 'bonus-description' ] ];

        //     // $args[ 'description-full' ] = $feature_bonus_item[ self::FETURE_BONUS[ 'bonus-description-full' ] ];
            
        //     $description_full = $feature_bonus_item[ self::FETURE_BONUS[ 'bonus-description-full' ] ];
        // }
        // else

        // // if ( empty( $args ) )
        // {
        //     // if ( !empty( $billet[ 'bonus' ] ) )
        //     // {
        //         // $args = BilletMain::href( $billet[ 'url' ][ 'bonus' ] );

        //         // $args[ 'nofollow' ] = $billet[ 'url' ][ 'bonus-nofollow' ];

        //         // $args[ 'title' ] = $billet[ 'bonus' ][ 'title' ];

        //         // $args[ 'description' ] = $billet[ 'bonus' ][ 'description' ];

        //         // $args[ 'description-full' ] = $billet[ 'bonus' ][ 'description-full' ];
                
        //     // }

        //     $group = get_field( self::FIELD[ 'about' ], $id );

        //     if ( $group )
        //     {
        //         // $bonus_id = $group[ self::ABOUT[ 'bonus-id' ] ];

        //         $title = $group[ self::ABOUT[ 'bonus-title' ] ];

        //         $description = $group[ self::ABOUT[ 'bonus-description' ] ];
                
        //         $description_full = $group[ self::ABOUT[ 'bonus-description-full' ] ];
        //     }
        // }
        
        // // LegalDebug::debug( [
        // //     'function' => 'BilletBonus::get_bonus',

        // //     'billet' => $billet,

        // //     'feature_bonus_item' => $feature_bonus_item,

        // //     'args' => $args,
        // // ] );

        // // return $args;
        
        // return [
        //     'title' => $title,

        //     'description' => $description,

        //     'description-full' => $description_full,
        // ];
    }

    // public static function get_bonus( $billet )
    // {
    //     $args = [];

    //     $feature_bonus_item = self::get_feture_bonus( $billet[ 'id' ], $billet[ 'filter' ] );

    //     if ( !empty( $feature_bonus_item ) )
    //     {
    //         $args = BilletMain::href( $billet[ 'url' ][ 'bonus' ] );

    //         $args[ 'nofollow' ] = $billet[ 'url' ][ 'bonus-nofollow' ];

    //         $args[ 'title' ] = $feature_bonus_item[ self::FETURE_BONUS[ 'bonus-title' ] ];

    //         $args[ 'description' ] = $feature_bonus_item[ self::FETURE_BONUS[ 'bonus-description' ] ];

    //         $args[ 'description-full' ] = $feature_bonus_item[ self::FETURE_BONUS[ 'bonus-description-full' ] ];
    //     }

    //     if ( empty( $args ) )
    //     {
    //         if ( !empty( $billet[ 'bonus' ] ) )
    //         {
    //             $args = BilletMain::href( $billet[ 'url' ][ 'bonus' ] );

    //             $args[ 'nofollow' ] = $billet[ 'url' ][ 'bonus-nofollow' ];

    //             $args[ 'title' ] = $billet[ 'bonus' ][ 'title' ];

    //             $args[ 'description' ] = $billet[ 'bonus' ][ 'description' ];

    //             $args[ 'description-full' ] = $billet[ 'bonus' ][ 'description-full' ];
    //         }
    //     }
        
    //     // LegalDebug::debug( [
    //     //     'function' => 'BilletBonus::get_bonus',

    //     //     'billet' => $billet,

    //     //     'feature_bonus_item' => $feature_bonus_item,

    //     //     'args' => $args,
    //     // ] );

    //     return $args;
    // }

    public static function get( $billet )
    {
        // LegalDebug::debug( [
        //     'function' => 'BilletBonus::get',

        //     'billet' => $billet,
        // ] );

        $enabled = true;

        if ( !empty( $billet[ 'filter' ] ) ) {
            $enabled = $billet[ 'filter' ][ 'bonus' ];
        }

        if ( $enabled ) {
            return self::get_bonus( $billet[ 'id' ], $billet[ 'url' ], $billet[ 'filter' ] );
        }

        return [];
    }

    const TEMPLATE = [
        'bonus' => LegalMain::LEGAL_PATH . '/template-parts/billet/right/part-billet-bonus.php',
    ];

    public static function render( $billet )
    {
        $args = self::get( $billet );

        if ( !empty( $args ) ) {
            load_template( self::TEMPLATE[ 'bonus' ], false, $args );
        }
    }
}

?>