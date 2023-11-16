<?php

class ToolTimezone
{
	public static function get_timezone( $country_code = '' )
	{
		if ( empty( $country_code ) )
		{
			$country_code = WPMLMain::get_locale();
		}

		$timezone = \DateTimeZone::listIdentifiers( \DateTimeZone::PER_COUNTRY, $country_code );

		LegalDebug::debug( [
			'function' => 'ToolTimezone::get_timezone',

			'country_code' => $country_code,

			'timezone' => $timezone,
		] );

		return $timezone;
	}
}

?>