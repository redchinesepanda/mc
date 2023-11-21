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
        BonusMain::register_style( self::CSS );
    }

	public static function register_functions()
    {
        // self::date_migrate();
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

	// public static function date_migrate_args()
    // {
    //     return [
    //         'numberposts' => -1,

	// 		'suppress_filters' => 1,

	// 		// 'p' => 250736,

    //         'post_type' => 'post',

    //         [
    //             [
    //                 'taxonomy' => self::TAXONOMY[ 'category' ],

    //                 'field' => 'slug',

    //                 'terms' => self::CATEGORY,

	// 				'operator' => 'IN',
	// 			],
    //         ],
    //     ];
    // }

	public static function date_get( $id )
    {
        $bonus_date = get_field( self::FIELD[ 'bonus-duration' ], $id );

        if ( !empty( $bonus_date ) && $bonus_date != '-' )
        {
            // return $bonus_date;

			$date_match = '';
				
			$result = preg_match( "/(\d{2}\/\d{2}\/\d{4})/", $bonus_date, $date_match );

			// LegalDebug::debug( [
			// 	'function' => 'BonusAbout::date_get',

			// 	'bonus_date' => $bonus_date,

			// 	'result' => $result,

			// 	'date_match' => $date_match,
			// ] );

			if ( $result == 1 )
			{
				return array_shift( $date_match );
			}
        }
        
        return '';
    }

	// public static function date_migrate()
    // {
    //     $posts = get_posts( self::date_migrate_args() );

    //     foreach ( $posts as $post )
    //     {
    //         $date = self::date_get( $post->ID );

	// 		if ( $date )
	// 		{
	// 			$date_time = DateTime::createFromFormat('d/m/Y', $date);

	// 			$current = get_post_meta( $post->ID, self::FIELD[ 'bonus-expire' ], true );

	// 			$date_time->setTime( 23, 59, 59 );
				
	// 			$value = $date_time->format( "Y-m-d H:i:s" );
	
	// 			update_field( self::FIELD[ 'bonus-expire' ], $value, $post->ID );

	// 			LegalDebug::debug( [
	// 			    'function' => 'BonusAbout::affiliate_migrate',

	// 				'ID' => $post->ID,

	// 			    'date' => $date,

	// 			    'current' => $current,

	// 			    'date_time' => $date_time,

	// 			    'value' => $value,
	// 			] );
	// 		}

	// 		// LegalDebug::debug( [
	// 		// 	'function' => 'BonusAbout::affiliate_migrate',

	// 		// 	'ID' => $post->ID,
	// 		// ] );

	// 		// delete_field( self::FIELD[ 'bonus-expire' ], $post->ID );
    //     }
    // }

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

		// LegalDebug::debug( [
		// 	'function' => 'BonusDuration::get_duration',

		// 	'get_field' => get_field( self::FIELD[ 'bonus-expire' ], $id, false ),

		// 	'get_post_meta' => get_post_meta( $id, self::FIELD[ 'bonus-expire' ], true ),
		// ] );

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

			// 'duration' => get_field( self::FIELD[ 'bonus-duration' ], $id ),
			
			// 'duration' => get_field( self::FIELD[ 'bonus-expire' ], $id ),
			
			// 'duration' => $duration->format( self::FORMAT[ 'bonus' ] ),
			
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

		// $bonus_duration = get_field( self::FIELD[ 'bonus-duration' ], $id );
		
		$bonus_duration = get_field( self::FIELD[ 'bonus-expire' ], $id );

		if ( $bonus_duration )
		{
			// $bonus = DateTime::createFromFormat( self::FORMAT[ 'bonus' ], $bonus_duration );
			
			$bonus = DateTime::createFromFormat( self::FORMAT[ 'expire' ], $bonus_duration );

			if ( $bonus )
			{
				// $current = new DateTime();

				// $timezone = ToolTimezone::get_timezone();
				
				// $current = new DateTime( 'now', new DateTimeZone( $timezone ) );
				
				$current = ToolTimezone::get_now_timezone();
	
				// $result = $bonus->format( self::FORMAT[ 'compare' ] ) < $current->format( self::FORMAT[ 'compare' ] );
				
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

        ob_start();

        load_template( self::TEMPLATE[ 'bonus-duration' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>