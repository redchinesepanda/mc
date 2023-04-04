<?php

class OopsMain
{
    public static function check_oops()
    {
        $args = [
            'numberposts' => -1,

            'post_type' => 'legal_billet',

            'suppress_filters' => 0,

            'meta_query' => [
                [
                    'key' => 'billet-referal',

                    'value' => '',

                    'meta_compare' => '!=',
                ],
            ]
        ];

        $posts = new WP_Query( $args );
        
        return $posts->found_posts;
    }
}

?>