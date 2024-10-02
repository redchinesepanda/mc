<?php

class ACFReview
{
	const FIELD = [
        'link' => 'author-link-items',

        'about' => 'review-about',

        'post-type' => 'legal_post_type',

        'post-type-wiki' => 'legal_post_type_wiki',
	];

	const LINK = [
        'image' => 'link-item-image',
	];

	const ABOUT = [
        'afillate' => 'about-afillate',
	];

    public static function register_functions()
    {
        $handler = new self();

        // add_filter('acf/format_value/name=' . self::ABOUT[ 'afillate' ], [ $handler, 'format_afillate' ], 10, 3 );

        add_filter( 'post_type_link', [ $handler, 'afillate_link_filter_locale' ], 10, 4 );
    }

    public static function register()
    {
        $handler = new self();

        add_filter( 'acf/load_field/name=' . ReviewAnchors::FIELD[ 'anchors' ], [ $handler, 'supply_field' ] );

		add_filter( 'acf/load_field/name=' . ReviewAuthor::LINK_ITEM[ 'image' ], [ $handler, 'choices_image' ] );

		add_filter( 'acf/load_field/name=' . self::FIELD[ 'post-type' ], [ $handler, 'choices_post_type' ] );

		add_filter( 'acf/load_field/name=' . self::FIELD[ 'post-type-wiki' ], [ $handler, 'choices_post_type_wiki' ] );

        add_action( 'acf/save_post', [ $handler, 'change_post_type' ] );
    }

    public static function change_post_type( $post_id )
    {
		$post_type = get_field( self::FIELD[ 'post-type' ], $post_id );

		if ( !$post_type )
        {
            $post_type = get_field( self::FIELD[ 'post-type-wiki' ], $post_id );
        }

		if ( $post_type )
        {
            $post = get_post( $post_id );

            if ( $post_type != $post->post_type )
            {
                set_post_type( $post_id, $post_type );
            }
		}
	}

    public static function format_afillate( $value, $post_id = 0, $field = '' )
    {
        $lang = WPMLMain::current_language();

        return str_replace(  '/' . $lang . '/', '/', $value );
    }

    const POST_TYPE = [
        'affiliate-links' => 'affiliate-links',
    ];

    public static function afillate_link_filter_locale( $post_link, $post, $leavename, $sample )
    {
        if ( $post->post_type == self::POST_TYPE[ 'affiliate-links' ] )
        {
            return self::format_afillate( $post_link );
        }

        return $post_link;
    }

	public static function choices_post_type( $field )
    {
        $choices[ 'page' ] = 'Страница';

        $choices[ 'legal_bk_review' ] = 'Обзор БК';

        $field[ 'choices' ] = $choices;

        if ( $post = get_post() )
        {
            $field[ 'value' ] = $post->post_type;
        }

        return $field;
    }

	public static function choices_post_type_wiki( $field )
    {
        $choices[ 'post' ] = 'Пост';

        $choices[ 'legal_wiki' ] = 'Пост Вики';

        $field[ 'choices' ] = $choices;

        if ( $post = get_post() )
        {
            $field[ 'value' ] = $post->post_type;
        }

        return $field;
    }

	public static function choices_image( $field )
    {
        $choices[ 'link-linkedin' ] = 'Linkedin';

        $choices[ 'link-twitter' ] = 'Twitter';

        $choices[ 'link-facebook' ] = 'Facebook';

        $field[ 'choices' ] = $choices;

        return $field;
    }

    public static function supply_field( $field )
    {
		$field[ 'instructions' ] = implode( '<br />', self::get() );

        return $field;
    }

	public static function get()
	{
		$anchors = ReviewAnchors::get_labels();

		$args = [];
		
		foreach( $anchors as $id => $label ) {
			$args[] = $id . ' ( ' . $label . ' )';
		}

		return $args;
	}
}

?>