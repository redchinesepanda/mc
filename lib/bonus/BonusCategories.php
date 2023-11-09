<?php

class BonusCategories
{
	const CSS = [
        'bonus-categories' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-categories.css',

            'ver'=> '1.0.1',
        ],
    ];

    public static function register_style()
    {
        BonusMain::register_style( self::CSS );
    }

	public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

    public static function get_categories( $id )
    {
        return wp_get_post_categories(
            $id,
            
            [ 'fields' => 'id=>name' ]
        );
    }

    const META_KEY = [
        'redirect' => 'page_redirect',
    ];

    public static function get_items( $categories )
    {
        $items = [];

        if ( !empty( $categories ) )
        {
            foreach ( $categories as $id => $name )
            {
                $tag = !empty( get_term_meta( $id, self::META_KEY[ 'redirect' ], true ) ) ? 'a' : 'span';

                $items[] = [
                    'id' => $id,

                    'href' => get_category_link( $id ),
    
                    'label' => $name,

                    'tag' => $tag,
                ];
            }
        }

        return $items;
    }

    public static function get()
    {
        $id = BonusMain::get_id();
        
		if ( empty( $id ) )
		{
			return [];
        }

		return [
			'items' => self::get_items( self::get_categories( $id ) ),
		];
    }

    const TEMPLATE = [
        'bonus-categories' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus-categories.php',
    ];

    public static function render()
    {
		if ( !BonusMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'bonus-categories' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>