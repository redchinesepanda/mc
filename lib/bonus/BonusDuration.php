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
        self::date_migrate();
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

	public static function date_migrate_args()
    {
        return [
            'numberposts' => -1,

			// 'suppress_filters' => 1,

			'p' => 250736,

            'post_type' => 'post',

            [
                [
                    'taxonomy' => self::TAXONOMY[ 'category' ],

                    'field' => 'slug',

                    'terms' => self::CATEGORY,

					'operator' => 'IN',
				],
            ],
        ];
    }

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

	public static function date_migrate()
    {
        $posts = get_posts( self::date_migrate_args() );

        foreach ( $posts as $post )
        {
            // $date = self::date_get( $post->ID );

			// if ( $date )
			// {
			// 	$date_time = DateTime::createFromFormat('d/m/Y', $date);

			// 	$current = get_post_meta( $post->ID, self::FIELD[ 'bonus-expire' ], true );

			// 	// LegalDebug::debug( [
			// 	//     'function' => 'BonusAbout::affiliate_migrate',

			// 	//     'ID' => $post->ID,

			// 	//     'date' => $date,
			// 	// ] );

			// 	$date_time->setTime( 23, 59, 59 );
				
			// 	// $value = $date_time->format( "Y-m-d H:i:s" );
				
			// 	$value = $date_time->format('Ymd');
	
			// 	// update_field( self::FIELD[ 'bonus-expire' ], $value, $post->ID );

			// 	LegalDebug::debug( [
			// 	    'function' => 'BonusAbout::affiliate_migrate',

			// 		'ID' => $post->ID,

			// 	    'date' => $date,

			// 	    'current' => $current,

			// 	    'date_time' => $date_time,

			// 	    'value' => $value,
			// 	] );
			// }

			LegalDebug::debug( [
				'function' => 'BonusAbout::affiliate_migrate',

				'ID' => $post->ID,
			] );

			// delete_field( self::FIELD[ 'bonus-expire' ], $post->ID );
        }
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
		$result = false;

		$bonus_duration = get_field( self::FIELD[ 'bonus-duration' ], $id );

		if ( $bonus_duration )
		{
			$bonus = DateTime::createFromFormat( self::FORMAT[ 'bonus' ], $bonus_duration );

			if ( $bonus )
			{
				$current = new DateTime();
	
				$result = $bonus->format( self::FORMAT[ 'compare' ] ) < $current->format( self::FORMAT[ 'compare' ] );
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