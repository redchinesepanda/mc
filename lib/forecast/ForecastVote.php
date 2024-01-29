<?php

class ForecastVote
{
	const CSS = [
        'legal-forecast-vote' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/forecast/legal-forecast-vote.css',

            'ver'=> '1.0.1',
        ],
    ];

	public static function register_style()
    {
		ToolEnqueue::register_style( self::CSS );
    }

    const DEQUEUE_CSS = [
        'wp-polls',
    ];

    const DEQUEUE_JS = [
        'wp-polls',
    ];

    const DEQUEUE = [
        ...self::DEQUEUE_CSS,
        
        ...self::DEQUEUE_JS,
    ];

    public static function dequeue_style()
    {
        if ( TemplateMain::check_new() ) 
        {
            ToolEnqueue::dequeue_style( TemplateMain::DEQUEUE );
        }
    }

	public static function register()
    {
        $handler = new self();

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