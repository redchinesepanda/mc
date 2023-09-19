<?php

class BonusCategories
{
	const CSS = [
        'bonus-categories' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-categories.css',

            'ver'=> '1.0.0',
        ],
    ];

    public static function register_style()
    {
        if ( BonusMain::check() ) {
            ToolEnqueue::register_style( self::CSS );
        }
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

            [ 'fields' => 'ids,names' ]
        );
    }

    public static function get_items( $categories )
    {
        $items = 0;

        LegalDebug::debug( [
            'function' => 'BonusCategories::get_items',

            'categories' => $categories,
        ] );

        if ( !empty( $categories ) )
        {
            foreach ( $categories as $category )
            {
                $items[] = [
                    'id' => $category->term_id,

                    'href' => get_category_link( $category->term_id ),
    
                    'label' => $category->name,
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