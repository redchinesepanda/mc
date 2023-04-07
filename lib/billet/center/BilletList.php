<?php

class BilletList
{
    const TEMPLATE = LegalMain::LEGAL_PATH . '/template-parts/billet/center/part-billet-list.php';

    public static function get( $billet )
    {
        $args = [];

        $parts = get_field( 'billet-list-parts', $billet['id'] );

        if( $parts ) {
            foreach( $parts as $key => $part ) {
                $display = true;

                if ( !empty( $billet['compilation'] ) ) {
                    $display = in_array( $part['billet-list-part-icon'], $billet['compilation']['list'] );
                }

                if ( $display ) {
                    $args[$key]['part-icon'] = $part['billet-list-part-icon'];
    
                    $args[$key]['part-direction'] = $part['billet-list-part-direction'];
    
                    $items = $part['billet-list-part-items'];
    
                    if( $items ) {
                        foreach( $items as $item ) {
                            $args[$key]['part-items'][] = $item['billet-list-part-item-title'];
                        }
                    }
                }
            }
        }

        return $args;
    }

    public static function render( $billet )
    { 
        load_template( self::TEMPLATE, false, self::get( $billet ) );
    }
}

?>