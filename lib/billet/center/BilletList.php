<?php

class BilletList
{
    const FIELD = [
        'lists' => 'billet-list-parts',
    ];

    const LIST = [
        'icon' => 'billet-list-part-icon',

        'direction' => 'billet-list-part-direction',

        'feature' => 'billet-list-part-feature',

        'items' => 'billet-list-part-items',
    ];

    const ITEM = [
        'title' => 'billet-list-part-item-title',
    ];

    public static function get_features( $billet )
    {
        if ( !empty( $billet[ 'filter' ][ 'features' ] ) )
        {
            return $billet[ 'filter' ][ 'features' ];
        }

        return [];
    }

    public static function parse_items( $items )
    {
        return array_column( $items, self::ITEM[ 'title' ] );
    }
    
    public static function parse_lists( $lists )
    {
        $result = [];

        if ( $lists )
        {
            foreach ( $lists as $list )
            {
                $result[] = [
                    'part-icon' => $list[ self::LIST[ 'icon' ] ],

                    'part-direction' => $list[ self::LIST[ 'direction' ] ],

                    'part-items' => self::parse_items( $list[ self::LIST[ 'items' ] ] ),
                ];
            }
        }

        return $result;
    }

    public static function check_list_feature_has( $list, $feature )
	{
		return strpos( $list[ 'default_locale' ], $value ) !== false;
	}

    public static function filter_lists_feature_has( $lists, $features )
    {
        LegalDebug::debug( [
            'function' => 'BilletList::filter_lists_feature_has',

            'features' => $features,
        ] );

        return array_filter( $lists, function( $list ) use ( $features )
        {
            LegalDebug::debug( [
                'function' => 'BilletList::array_filter',
    
                'list' => $list,

                'features' => $features,
            ] );

            return !empty(
                array_intersect(
                    $list[ self::LIST[ 'feature' ] ],
                    
                    $features
                )
            );
		} );
    }

    public static function check_feature_empty( $list )
    {
        return empty( $list[ self::LIST[ 'feature' ] ] );
    }

    public static function filter_lists_feature_empty( $list )
    {
        $handler = new self();

        return array_filter( $lists, [ $handler, 'check_feature_empty' ] );
    }

    public static function get( $billet )
    {
        // $args = [];

        $lists = get_field( self::FIELD[ 'lists' ], $billet[ 'id' ] );

        $features = self::get_features( $billet );

        $result = [];

        if ( !empty( $features ) )
        {
            $result = self::filter_lists_feature_has( $lists, $features );
        }

        LegalDebug::debug( [
            'function' => 'BilletList::get',

            'result' => $result,
        ] );

        if ( empty( $result ) )
        {
            $result = self::filter_lists_feature_empty( $lists );
        }

        // return self::parse_lists( $result, $billet );
        
        return self::parse_lists( $result ); 

        // if ( $lists )
        // {
        //     foreach ( $lists as $key => $list )
        //     {
        //         // LegalDebug::debug( [
        //         //     'function' => 'BilletList::get',

        //         //     'parts' => $parts,

        //         //     'parts_json_encode' => json_encode( $parts ),
        //         // ] );

        //         $display = self::check_list( $billet, $list );

        //         if ( $display )
        //         {
        //             // $args[ $key ][ 'part-icon' ] = $part[ self::PART[ 'icon' ] ];
    
        //             // $args[ $key ]['part-direction' ] = $part[ self::PART[ 'direction' ] ];
    
        //             // $items = $part[ self::PART[ 'items' ] ];
    
        //             // if ( $items ) {
        //             //     foreach ( $items as $item ) {
        //             //         $args[ $key ][ 'part-items' ][] = $item[ self::ITEM[ 'title' ] ];
        //             //     }
        //             // }

        //             $args[ $key ] = [
        //                 'part-icon' => $list[ self::LIST[ 'icon' ] ],

        //                 'part-direction' => $list[ self::LIST[ 'direction' ] ],

        //                 'part-items' => self::parse_items( $list[ self::LIST[ 'items' ] ] ),
        //             ];
        //         }
        //     }
        // }

        // return $args;
    }

    const TEMPLATE = [
        'lists' => LegalMain::LEGAL_PATH . '/template-parts/billet/center/part-billet-list.php',
    ];

    public static function render( $billet )
    { 
        // load_template( self::TEMPLATE[ 'lists' ], false, self::get( $billet ) );

        return self::render_main( self::TEMPLATE[ 'lists' ], self::get( $billet ) );
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