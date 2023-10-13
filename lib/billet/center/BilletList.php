<?php

class BilletList
{
    const FIELD = [
        'parts' => 'billet-list-parts',
    ];

    const PART = [
        'icon' => 'billet-list-part-icon',

        'direction' => 'billet-list-part-direction',

        'feature' => 'billet-list-part-feature',

        'items' => 'billet-list-part-items',
    ];

    const ITEM = [
        'title' => 'billet-list-part-item-title',
    ];

    public static function check_list( $billet, $part )
    {
        $display = true;

        // LegalDebug::debug( [
        //     'function' => 'check_list',
        // ] );

        if ( !empty( $billet[ 'filter' ] ) ) {
            $permission_filter = false;

            $permission_empty = ( empty( $part[ self::PART[ 'feature' ] ] ) );

            // LegalDebug::debug( [
            //     'part' => $part[ self::PART[ 'feature' ] ],
            // ] );

            if ( !$permission_empty ) {
                // $permission_filter = in_array( $part[ self::PART[ 'feature' ] ], $billet[ 'filter' ][ 'features' ] );
                
                $permission_filter = !empty( array_intersect( $part[ self::PART[ 'feature' ] ], $billet[ 'filter' ][ 'features' ] ) );

                // LegalDebug::debug( [
                //     'billet' => $billet[ 'filter' ][ 'features' ],

                //     'array_intersect' => array_intersect( $part[ self::PART[ 'feature' ] ], $billet[ 'filter' ][ 'features' ] )
                // ] );
            }

            $display = ( $permission_filter || $permission_empty );
        }

        return $display;
    }

    public static function get( $billet )
    {
        $args = [];

        $parts = get_field( self::FIELD[ 'parts' ], $billet[ 'id' ] );

        if ( $parts ) {
            foreach ( $parts as $key => $part ) {
                $display = self::check_list( $billet, $part );

                if ( $display ) {
                    $args[ $key ][ 'part-icon' ] = $part[ self::PART[ 'icon' ] ];
    
                    $args[ $key ]['part-direction' ] = $part[ self::PART[ 'direction' ] ];
    
                    $items = $part[ self::PART[ 'items' ] ];
    
                    if ( $items ) {
                        foreach ( $items as $item ) {
                            $args[ $key ][ 'part-items' ][] = $item[ self::ITEM[ 'title' ] ];
                        }
                    }
                }
            }
        }

        return $args;
    }

    const TEMPLATE = [
        'list' => LegalMain::LEGAL_PATH . '/template-parts/billet/center/part-billet-list.php',
    ];

    public static function render( $billet )
    { 
        load_template( self::TEMPLATE[ 'list' ], false, self::get( $billet ) );
    }
}

?>