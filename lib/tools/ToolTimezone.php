<?php

class ToolTimezone
{
	public static function get_timezone( $country_code = '' )
	{
		if ( empty( $country_code ) )
		{
			$country_code = WPMLMain::current_language();
		}

		// $timezone = \DateTimeZone::listIdentifiers( \DateTimeZone::PER_COUNTRY, $country_code );
		
		$timezone = \DateTimeZone::listIdentifiers( \DateTimeZone::PER_COUNTRY );

		LegalDebug::debug( [
			'function' => 'ToolTimezone::get_timezone',

			'country_code' => $country_code,

			'current_language' => WPMLMain::current_language(),

			'timezone' => $timezone,
		] );

		return $timezone;
	}
}

?>