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

    const LOCALE_BONUS = [
        // 'ru_KZ',
    ];
    
    public static function get_bonus_href( $bonus_url, $referal_url, $oops )
    {
        $bonus_href = '';

        if ( !empty( $bonus_url ) && in_array( WPMLMain::get_locale(), self::LOCALE_BONUS )  )
        {
            $bonus_href = $bonus_url;
        }

        if ( empty( $bonus_href ) )
        {
            $bonus_href = !empty( $referal_url ) ? $referal_url : $oops;
        }

        LegalDebug::debug( [
            'function' => 'get_bonus_href',

            'bonus_url' => $bonus_url,

            'referal_url' => $referal_url,

            'oops' => $oops,

            'bonus_href' => $bonus_href,

            'href' => array_merge(
                BilletMain::href( $bonus_href ),
    
                [ 'nofollow' => BilletMain::get_nofollow( $bonus_href ) ]
            ),
        ] );

        return array_merge(
            BilletMain::href( $bonus_href ),

            [ 'nofollow' => BilletMain::get_nofollow( $bonus_href ) ]
        );
    }

    public static function get_bonus( $id, $url, $filter )
    {
        $enabled = true;

        if ( !empty( $filter[ 'bonus' ] ) )
        {
            $enabled = $filter[ 'bonus' ];
        }

        if ( !$enabled )
        {
            return null;
        }

        $bonus_data = self::get_bonus_data( $id, $filter );

        LegalDebug::debug( [
            'function' => 'BilletBonus::get_bonus',

            'data' => array_merge(
                self::get_bonus_href( $bonus_data[ 'href' ], $url[ 'referal' ], $url[ 'oops' ] ),
    
                $bonus_data
            ),
        ] );

        return array_merge(
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
    }

    public static function get( $billet )
    {
        return self::get_bonus( $billet[ 'id' ], $billet[ 'url' ], $billet[ 'filter' ] );
    }

    const TEMPLATE = [
        'bonus' => LegalMain::LEGAL_PATH . '/template-parts/billet/right/part-billet-bonus.php',
    ];

    public static function render( $args )
    {
        if ( empty( $args ) )
        {
            return '';
        }
        
        return self::render_main( self::TEMPLATE[ 'bonus' ], $args );
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