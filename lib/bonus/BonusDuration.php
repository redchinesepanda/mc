<?php

class BonusDuration
{
	const CSS = [
        'bonus-duration' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-duration.css',

            'ver'=> '1.0.0',
        ],
    ];

	const CSS_NEW = [
        'bonus-duration-new' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-duration-new.css',

			'ver' => '1.0.0',
		],
    ];

	public static function register_style()
    {
		if ( TemplateMain::check_code() )
		{
			BonusMain::register_style( self::CSS_NEW );
		}
		else
		{
			BonusMain::register_style( self::CSS );
		}
    }

	public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	const TAXONOMY = [
		'category' => 'category',
	];

    const CATEGORY = [
		'bonusy-kz',
        
        'bonusy-by',
	];

	public static function date_get( $id )
    {
        $bonus_date = get_field( self::FIELD[ 'bonus-duration' ], $id );

        if ( !empty( $bonus_date ) && $bonus_date != '-' )
        {
            $date_match = '';
				
			$result = preg_match( "/(\d{2}\/\d{2}\/\d{4})/", $bonus_date, $date_match );

			if ( $result == 1 )
			{
				return array_shift( $date_match );
			}
        }
        
        return '';
    }

	const TEMPLATE = [
        'bonus-duration' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus-duration.php',
    ];

	const FIELD = [
		'bonus-duration' => 'data-okonchaniya',

		'bonus-expire' => 'bonus-expire',
	];

	public static function get_expired()
	{
		return [
			'title' => __( BonusMain::TEXT[ 'promotion-expired' ], ToolLoco::TEXTDOMAIN ),

			'class' => 'legal-bonus-duration-expired',
		];
	}

	public static function get_duration( $id )
    {
		$duration = __( BonusMain::TEXT[ 'indefinitely' ], ToolLoco::TEXTDOMAIN );

		$prefix = '';

		if ( $bonus_expire = get_field( self::FIELD[ 'bonus-expire' ], $id ) )
		{
			$duration = (
				DateTime::createFromFormat( self::FORMAT[ 'expire' ], $bonus_expire )
			)->format( self::FORMAT[ 'bonus' ] );

			$prefix = __( BonusMain::TEXT[ 'till' ], ToolLoco::TEXTDOMAIN );
		}
		
		return [
			'title' => __( BonusMain::TEXT[ 'promotion-period' ], ToolLoco::TEXTDOMAIN ) . ':',
			
			'prefix' => $prefix,
			
			'duration' => $duration,

			'class' => 'legal-bonus-duration-default',
		];
    }

	const FORMAT = [
		'bonus' => 'd/m/Y',

		'expire' => "Y-m-d H:i:s",

		'compare' => 'Y-m-d',
	];

	public static function check_expired( $id )
	{
		$result = false;
		
		$bonus_duration = get_field( self::FIELD[ 'bonus-expire' ], $id );

		if ( $bonus_duration )
		{
			$bonus = DateTime::createFromFormat( self::FORMAT[ 'expire' ], $bonus_duration );

			if ( $bonus )
			{
				$current = ToolTimezone::get_now_timezone();
				
				$result = $bonus->format( self::FORMAT[ 'expire' ] ) < $current->format( self::FORMAT[ 'expire' ] );
			}
		}

		return $result;
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

        // ob_start();

        // load_template( self::TEMPLATE[ 'bonus-duration' ], false, self::get() );

        // $output = ob_get_clean();

        // return $output;

		return LegalComponents::render_main( self::TEMPLATE[ 'bonus-duration' ], self::get() );
    }
}

?>