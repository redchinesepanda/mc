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

    public static function get( $billet )
    {
        $args = [];

        $parts = get_field( self::FIELD[ 'parts' ], $billet[ 'id' ] );

        if ( $parts ) {
            LegalDebug::debug( [
                'filter-features' => $billet[ 'filter' ][ 'features' ],
            ] );

            foreach ( $parts as $key => $part ) {
                $display = true;

                if ( !empty( $billet[ 'filter' ] ) ) {
                    $display = in_array( $part[ self::PART[ 'icon' ] ], $billet[ 'filter' ][ 'list' ] );
                }

                LegalDebug::debug( [
                    '$display' => $display,
                    
                    'part-feature' => $part[ self::PART[ 'feature' ] ],
                ] );

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