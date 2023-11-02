<?php

require_once( 'ForecastPreview.php' );

require_once( 'ForecastVote.php' );

class ForecastMain
{
	public static function register()
    {
        ForecastPreview::register();

        ForecastVote::register();
    }
}

?>