<?php

class BonusDuration
{
	const CSS = [
        'bonus-duration' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-duration.css',

            'ver'=> '1.0.0',
        ],
    ];

    // public static function register_style()
    // {
    //     if ( BonusMain::check() ) {
    //         ToolEnqueue::register_style( self::CSS );
    //     }
    // }

	public static function register_style()
    {
        BonusMain::register_style( self::CSS );
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

	// public static function get_id()
    // {
	// 	$post = get_post();

    //     if ( !empty( $post ) )
    //     {
    //         return $post->ID;
    //     }

    //     return 0;
    // }

	public static function get_expired()
	{
		return [
			'title' => __( BonusMain::TEXT[ 'promotion-expired' ], ToolLoco::TEXTDOMAIN ),

			'class' => 'legal-bonus-duration-expired',
		];
	}

	public static function get_duration( $id )
    {
        return [
			'title' => __( BonusMain::TEXT[ 'promotion-period' ], ToolLoco::TEXTDOMAIN ) . ':',
			
			'prefix' => __( BonusMain::TEXT[ 'till' ], ToolLoco::TEXTDOMAIN ),

			'duration' => get_field( self::FIELD[ 'bonus-duration' ], $id ),

			'class' => 'legal-bonus-duration-default',
		];
    }

	const FORMAT = [
		'bonus' => 'd/m/Y',

		'compare' => 'Y-m-d',
	];

	public static function check_expired( $id )
	{
		$bonus_duration = get_field( self::FIELD[ 'bonus-duration' ], $id );

		$bonus = DateTime::createFromFormat( self::FORMAT[ 'bonus' ], $bonus_duration );
		
		$current = new DateTime();

		return $bonus->format( self::FORMAT[ 'compare' ] ) < $current->format( self::FORMAT[ 'compare' ] );
	}

	public static function get()
	{
		$id = BonusMain::get_id();
        
		if ( empty( $id ) )
		{
			return [];
        }

		if ( self::check_expired( $id ) )
		{
			return self::get_expired();
		}
		else
		{
			return self::get_duration( $id );
		}
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