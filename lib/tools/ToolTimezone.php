<?php

class ToolTimezone
{
	public static function get_now_timezone( $country_code = '' )
	{
		return new DateTime(
			'now', 

			new DateTimeZone(
				ToolTimezone::get_timezone( $country_code )
			)
		);
	}

	public static function get_timezone( $country_code = '' )
	{
		if ( empty( $country_code ) )
		{
			$country_code = strtoupper( WPMLMain::current_language() );
		}

		if ( empty( $country_code ) )
		{
			return false;
		}

		$timezone = \DateTimeZone::listIdentifiers( \DateTimeZone::PER_COUNTRY, $country_code );

		if ( !empty( $timezone ) )
		{
			return array_shift( $timezone );
		}

		return false;

		// return array_shift( $timezone );
	}
}

?>