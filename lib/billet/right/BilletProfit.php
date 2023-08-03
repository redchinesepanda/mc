<?php

class BilletProfit extends LegalDebug
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/right/part-billet-profit.php';

    const PROFIT_ITEMS = 'billet-profit-items';

    const PROFIT_ITEM_FEATURE = 'profit-item-feature';

    const PROFIT_ITEM_VALUE = 'profit-item-value';

    // public static function truncate_number( $number, $precision = 2) {
    //     // Zero causes issues, and no need to truncate
    //     if ( 0 == (int)$number ) {
    //         return $number;
    //     }
    //     // Are we negative?
    //     $negative = $number / abs($number);
    //     // Cast the number to a positive to solve rounding
    //     $number = abs($number);
    //     // Calculate precision number for dividing / multiplying
    //     $precision = pow(10, $precision);
    //     // Run the math, re-applying the negative value to ensure returns correctly negative / positive
    //     return floor( $number * $precision ) / $precision * $negative;
    // }

    public static function cut_numeric( $value, $precision = 2 )
    {
        $integerPart = floor( $value );

        $decimalPart = str_replace( $integerPart, '', $value );

        $trimmedDecimal = substr( $decimalPart, 0, $precision + 1 );

        return $integerPart . $trimmedDecimal;
    }

    public static function get_average( $id )
    {
        $items = get_field( self::PROFIT_ITEMS, $id );
    
        if ( $items )
        {
            $value = 0;

            foreach ( $items as $item )
            {
                $value += $item[ self::PROFIT_ITEM_VALUE ];
            }

            $value = $value / count( $items );

            LegalDebug::debug( [
               'value' => $value,

               'float' => ( float ) $value,

            //    'number_format' => number_format( $value, 2, '.', ''),

            //    'number_format-float-value' => number_format( ( float ) $value, 2, '.', ''),

            //    'number_format-float-all' => ( float ) number_format( $value, 2, '.', ''),

            //    'floor' => floor( $value * 100 ) / 100,

            //    'intval' => intval(($value*100))/100,

            //    'truncate_number' => self::truncate_number( $value ),

                'cut_numeric' => self::cut_numeric( $value ),
            ] );

            return ( float ) number_format( $value / count( $items ), 2, '.', '');
        }

        return 0;
    }

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