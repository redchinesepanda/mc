<?php

class CompilationMini
{
	public static function get_ids( $id, $limit )
    {
        if ( $limit == 0 )
        {
            return [];
        }

        $id = self::check_id( $id );

        $posts = get_posts( self::get_args( $id, $limit ) );

        return self::get_billets_ids( $posts );
    }

	public static function get_filter_profit( $id )
    {
        return get_field( self::BILLET[ 'profit-enabled' ], $id );
    }
}

?>