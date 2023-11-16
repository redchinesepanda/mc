<?php

class ToolTimezone
{
	public static function get_timezone( $country_code = '' )
	{
		if ( empty( $country_code ) )
		{
			$country_code = WPMLMain::get_locale();
		}

		return geoip_time_zone_by_country_and_region( $country_code );
	}
}

?>