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

	public static function register()
    {
        if ( self::check_contains_forecast_vote() )
        {
            $handler = new self();
    
            add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
        }
    }

    public static function check_contains_forecast_vote()
    {
        return LegalComponents::check_shortcode( self::CLASSES[ 'poll' ] );
    }

    const SHORTCODES = [
        'poll' => 'poll',
    ];
}

?>