<?php

class ACFBrand
{
	const POST_TYPE = [
		'billet' => 'legal_billet',

		'brand' => 'legal_brand',

		'page' => 'page',
	];
	const FIELDS_GROUPS = [
		'about' => 'review-about',
	];

	const FIELDS_SIMPLE = [
		'brand' => 'billet-brand',
	];

	public static function register()
    {
        $handler = new self();
        
        add_filter( 'edit_post_' . self::POST_TYPE[ 'billet' ], [ $handler, 'set_brand' ], 10, 2 );
        
        add_filter( 'edit_post_' . self::POST_TYPE[ 'page' ], [ $handler, 'set_brand' ], 10, 2 );
    }
	
	public static function brand_args( $title )
    {
        return [
            'numberposts' => 1,

            'fields' => 'ids',

            'suppress_filters' => 1,

            'post_type' => self::POST_TYPE[ 'brand' ],

            's' => $title,
        ];
    }

	public static function get_brand( $title )
    {
        return get_posts( self::brand_args( $title ) );
    }

    public static function set_brand( $post_id, $post )
    {
        $about = get_field( self::FIELDS_GROUPS[ 'about' ], $post_id );

        // LegalDebug::debug( [
        //     'ACFBillet' => 'set_brand',

        //     'about' => $about,
        // ] );

        if ( $about )
        {
            $brand_id = get_field( self::FIELDS_SIMPLE[ 'brand' ], $post_id );

            if ( empty( $brand_id ) )
            {
                // $brand_id_found = 0;
            
                if ( $title = $about[ BilletTitle::ABOUT[ 'title' ] ] )
                {
                    $brands = self::get_brand( $title );
    
                    // LegalDebug::debug( [
                    //     'ACFBillet' => 'set_brand',
    
                    //     'brands' => $brands,
                    // ] );
    
                    $brand_id = array_shift( $brands );
                }
    
                // LegalDebug::die( [
                //     'ACFBillet' => 'set_brand',
        
                //     'brand_id_found' => $brand_id_found,
                // ] );
        
                if ( !empty( $brand_id ) )
                {
                    update_field( self::FIELDS_SIMPLE[ 'brand' ], $brand_id, $post_id );
                }
            }

            // LegalDebug::die( [
            //     'ACFBillet' => 'set_brand',
    
            //     'brand_id' => $brand_id,
            // ] );
        }
    }
}

?>