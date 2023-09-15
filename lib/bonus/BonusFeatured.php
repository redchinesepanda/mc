<?php

class BonusFeatured
{
	public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

		add_image_size( self::SIZE[ 'featured' ], 700, 400, false );
    }

	public static function get_id()
    {
		$post = get_post();

        if ( !empty( $post ) )
        {
            return $post->ID;
        }

        return 0;
    }

	const SIZE = [
		'featured' => 'legal-bonus-featured',
	];

	const FIELD = [
		'bonus-affilate-primary' => 'ref-ssylka',

		'bonus-affilate-secondary' => 'ref-perelinkovka',
	];

	public static function get()
	{
		$post_id = self::get_id();

		$preview = BonusMain::get_thumbnail( $post_id, self::SIZE[ 'featured' ] );

		$preview[ 'href' ] = get_field( self::FIELD[ 'bonus-affilate-primary' ], $id );

		return [
			'preview' => $preview,
		];
	}

	const TEMPLATE = [
        'bonus-featured' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus-featured.php',
    ];

    public static function render()
    {
		if ( !BonusMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'bonus-featured' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>