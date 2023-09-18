<?php

class BonusDuration
{
	const CSS = [
        'bonus-duration' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-duration.css',

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

	const TEMPLATE = [
        'bonus-duration' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus-duration.php',
    ];

	const FIELD = [
		'bonus-duration' => 'data-okonchaniya',
	];

	public static function get_expired()
	{
		return [
			'title' => __( BonusMain::TEXT[ 'promotion-period' ], ToolLoco::TEXTDOMAIN ),

			'class' => 'legal-bonus-expired',
		];
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

	public static function get_till()
    {
        $id = self::get_id();
        
		if ( empty( $id ) )
		{
			return [];
        }

		return [
			'title' => __( BonusMain::TEXT[ 'promotion-period' ], ToolLoco::TEXTDOMAIN ),
			
			'prefix' => __( BonusMain::TEXT[ 'till' ], ToolLoco::TEXTDOMAIN ),

			'duration' => get_field( self::FIELD[ 'bonus-duration' ], $id ),

			'class' => 'legal-bonus-default',
		];
    }

	public static function get()
	{
		$id = self::get_id();
        
		if ( empty( $id ) )
		{
			return [];
        }

		$bonus_duration = get_field( self::FIELD[ 'bonus-duration' ], $id );

		// $bonus = new DateTime( $bonus_duration );
		$bonus = new DateTime();

		$bonus->createFromFormat( 'dd/mm/YY', $bonus_duration );
		
		// $current = new DateTime( '2008-01-03 11:11:10' );
		
		$current = new DateTime();
		
		// $current = new date( 'Y-m-d' );

		LegalDebug::debug( [
			'function' => 'BonusDuration::get',

			'bonus' => $bonus,

			'current' => $current,

			'eq' => $bonus == $current ? 'true' : 'false',
	
			'bonus_lager' => $bonus > $current ? 'true' : 'false',

			'bonus_smaller' => $bonus < $current ? 'true' : 'false',
		] );
	}

    public static function render()
    {
		if ( !BonusMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'bonus-duration' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>