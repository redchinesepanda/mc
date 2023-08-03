<?php

class CompilationMini
{
	public static function get_billets_ids( $posts )
    {
        $data = [];

        foreach ( $posts as $post )
        {
            $data[] = $post->ID;
        }

        return $data;
    }

	public static function get_ids( $id, $limit )
    {
        if ( $limit == 0 )
        {
            return [];
        }

        $id = CompilationMain::check_id( $id );

        $posts = get_posts( CompilationMain::get_args( $id, $limit ) );

        return self::get_billets_ids( $posts );
    }

	public static function get_filter_profit( $id )
    {
        return get_field( CompilationMain::BILLET[ 'profit-enabled' ], $id );
    }
}

?>