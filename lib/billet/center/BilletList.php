<?php

class BilletList
{
    const FIELD = [
        'lists' => 'billet-list-parts',
    ];
    
    const ICON_OTHER = [
        // Без маркера

        'legal-default',
    ];

    const ICON_PROS = [
        // Галка

        'legal-check',

        // Галка в круге

        'legal-check-round',

        // Плюс

        'legal-plus',
    ];

    const ICON_ALLOWED = [
        ...self::ICON_OTHER,

        ...self::ICON_PROS,
    ];

    const ICON_CONS = [
        // Крест

        'legal-close',

        // Минус

        'legal-minus',

        // Треугольник

        'legal-triangle',
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

    public static function check_list_feature_has( $list, $feature )
	{
		return strpos( $list[ 'default_locale' ], $value ) !== false;
	}

    public static function filter_lists_feature_has( $lists, $features )
    {
        // LegalDebug::debug( [
        //     'function' => 'filter_lists_feature_has',

        //     'lists' => $lists,

        //     'features' => $features,
        // ] );

        if ( empty( $lists ) )
        {
            return [];
        }

        return array_filter( $lists, function( $list ) use ( $features )
        {
            if ( empty( $list[ self::LIST[ 'feature' ] ] ) )
            {
                // return false;
                
                return [];
            }

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

    public static function filter_lists_feature_empty( $lists )
    {
        if ( empty( $lists ) )
        {
            return [];
        }

        $handler = new self();

        return array_filter( $lists, [ $handler, 'check_feature_empty' ] );
    }

    public static function check_icon_allowed( $list )
    {
        return in_array( $list[ self::LIST[ 'icon' ] ], self::ICON_ALLOWED );
        
        // return in_array( $list[ self::LIST[ 'icon' ] ], self::ICON_CONS );
    }

    public static function filter_lists_icon_allowed( $lists )
    {
        if ( empty( $lists ) )
        {
            return [];
        }

        $handler = new self();

        return array_filter( $lists, [ $handler, 'check_icon_allowed' ] );
    }

    public static function parse_items( $items )
    {
        if ( empty( $items ) )
        {
            return [];
        }

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

    public static function get( $billet )
    {
        $lists = get_field( self::FIELD[ 'lists' ], $billet[ 'id' ] );

        $features = self::get_features( $billet );

        $result = [];

        if ( !empty( $features ) )
        {
            $result = self::filter_lists_feature_has( $lists, $features );
        }

        if ( empty( $result ) )
        {
            // $result = self::filter_lists_feature_empty( $lists );

            $term = get_term_by( 'slug', 'legal-default', 'billet_feature' );

            if ( $term )
            {
                $result = self::filter_lists_feature_has( $lists, [ $term->term_id ] );
            }
        }

        $result = array_merge( $result, self::filter_lists_feature_empty( $lists ) );

        if ( TemplateMain::check_new() )
        {
            $result = self::filter_lists_icon_allowed( $result );
        }
        
        return self::parse_lists( $result );
    }

    const TEMPLATE = [
        'lists' => LegalMain::LEGAL_PATH . '/template-parts/billet/center/part-billet-list.php',
    ];

    public static function render( $billet )
    { 
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