<?php

class BonusContent
{
	const CSS = [
        'bonus-content' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-content.css',

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

	const FIELD = [
		'bonus-content' => 'text-bonus',
	];

	public static function get()
    {
        $id = BonusMain::get_id();
        
		if ( empty( $id ) )
		{
			return [];
        }

		return [
			'content' => get_field( self::FIELD[ 'bonus-content' ], $id ),
		];
    }

	const TEMPLATE = [
        'bonus-content' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus-content.php',
    ];

    public static function render()
    {
		if ( !BonusMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'bonus-content' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>