<?php

class ToolTimezone
{
	public static function get_timezone( $country_code = '' )
	{
		if ( empty( $country_code ) )
		{
			$country_code = WPMLMain::get_locale();
		}

		return \DateTimeZone::listIdentifiers( \DateTimeZone::PER_COUNTRY, $countryCode );
	}
}

?>