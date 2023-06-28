<?php

class ACFCompilation
{
    const FIELD = [
        'lang' => 'compilation-lang',

        // 'profit' => 'billet-profit-items',
    ];

    public static function register()
    {
        $handler = new self();

        add_filter( 'acf/load_field/name=' . self::FIELD[ 'lang' ], [ $handler, 'choices' ] );

        // add_action('acf/save_post', [ $handler, 'my_acf_save_post' ]);
    }

    // public static function my_acf_save_post( $post_id ) {

	// 	// Get newly saved values.
	// 	$values = get_fields( $post_id );

	// 	// Check the new value of a specific field.
	// 	$hero_image = get_field( 'hero_image' , $post_id );
	// 	if ( $hero_image )
    //     {
	// 		// Do something...
	// 	}
	// }

    public static function choices( $field )
    {
        $languages = WPMLLangSwitcher::choises();

        foreach( $languages as $language )
        {
            $field[ 'choices' ][ $language[ 'language_code' ] ] = $language[ 'native_name' ] . ' [' . $language[ 'language_code' ] . ']';
        }

        return $field;
    }
}

?>