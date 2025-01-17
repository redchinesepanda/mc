<?php

class BilletProfit extends LegalDebug
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/right/part-billet-profit.php';

    const PROFIT_ITEMS = 'billet-profit-items';

    const PROFIT_ITEM_FEATURE = 'profit-item-feature';

    const PROFIT_ITEM_VALUE = 'profit-item-value';

    public static function get_value( $billet )
    {
        $features = ( !empty( $billet['filter']['features'] ) ? $billet['filter']['features'] : [ '', ] );

        $items = get_field( self::PROFIT_ITEMS, $billet[ 'id' ] );
    
        if ( $items ) {
            foreach( $items as $item ) {
                if ( in_array( $item[ self::PROFIT_ITEM_FEATURE ], $features ) ) {
                    return $item[ self::PROFIT_ITEM_VALUE ];
                }
            }
        }

        return '';
    }

    public static function get_profit( $billet )
    {
        return [
            'class' => get_field( 'billet-play-profit-type', $billet[ 'id' ] ),

            'label' => __( BilletMain::TEXT[ 'margin' ], ToolLoco::TEXTDOMAIN ),
            
            'value' => self::get_value( $billet ),
        ];
    }

    public static function get( $billet )
    {
        $args = [];

        $enabled = true;

        if ( !empty( $billet[ 'filter' ] ) ) {
            $enabled = $billet['filter']['profit'];
        }

        if ( $enabled ) {
            $args['profit'] = self::get_profit( $billet );
        }

        return $args;
    }

    public static function render( $billet )
    {
        $args = self::get( $billet );

        if ( !empty( $args ) ) {
            load_template( self::TEMPLATE, false, $args );
        }
    }
}

?>