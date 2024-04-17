<?php

class ForecastVote
{
	const CSS = [
        'legal-forecast-vote' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/forecast/legal-forecast-vote.css',

            'ver'=> '1.0.1',
        ],
    ];

    const CSS_NEW = [
        'legal-forecast-vote-new' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/forecast/legal-forecast-vote-new.css',

			'ver' => '1.0.0',
		],
    ];

	/* public static function register_style()
    {
		ToolEnqueue::register_style( self::CSS );
    } */

    public static function register_style()
    {
		if ( TemplateMain::check_new() )
		{
			ToolEnqueue::register_style( self::CSS_NEW );
		}
		else
		{
			ToolEnqueue::register_style( self::CSS );
		}
    }

    const JS_NEW = [
        'legal-forecast-vote' => [
			'path' => LegalMain::LEGAL_URL . '/assets/js/forecast/legal-forecast-vote.js',

			'ver' => '1.0.0',
		],
    ];

    public static function register_script()
    {
	/* 	if ( TemplateMain::check_new() )
		{
			ToolEnqueue::register_script( self::JS_NEW );
		} */
        ToolEnqueue::register_script( self::JS_NEW );
    }

    const DEQUEUE_CSS = [
        'wp-polls',
    ];

    const DEQUEUE_JS = [
        'wp-polls',
    ];

    // const DEQUEUE = [
    //     ...self::DEQUEUE_CSS,
        
    //     ...self::DEQUEUE_JS,
    // ];

    public static function dequeue_style()
    {
        if ( TemplateMain::check_new() ) 
        {
            // ToolEnqueue::dequeue_style( TemplateMain::DEQUEUE );
            
            ToolEnqueue::dequeue_style( self::DEQUEUE_CSS );

            ToolEnqueue::dequeue_script( self::DEQUEUE_JS );
        }
    }

	public static function register()
    {
        $handler = new self();

        // LegalDebug::debug( [
        //     'check_contains_forecast_vote' => self::check_contains_forecast_vote(),
        // ] );

        if ( self::check_contains_forecast_vote() )
        {
            add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
        }
        else
        {
            add_action( 'wp_enqueue_scripts', [ $handler, 'dequeue_style' ], 99 );
        }
    }

    public static function check_contains_forecast_vote()
    {
        return LegalComponents::check_shortcode( self::SHORTCODES[ 'poll' ] );
    }

    const SHORTCODES = [
        'poll' => 'poll',
    ];
}

?>