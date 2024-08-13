<?php

class YoastVerification
{
	const GOOGLE_VERIFICATION = [
		'old-au.match.center' => '2dAywc7Sx2HoaFUblkGSpagh3bqZc4-BBhS6tQ2WB40',

		'match-center-au.com' => '2dAywc7Sx2HoaFUblkGSpagh3bqZc4-BBhS6tQ2WB40',

		'match-center.at' => '5DLHAOxxRfrKYK3wIUaq0xciDnh6pb9Lv9MJQLhAV2E',

		'match-center.mt' => 'KmZVf5Emmz8s9HLvmrqcExlPZwHfYZrdAF0KMD1D2RY',

		'match-center.nl' => 'CrvtIqKDtaSvdPanDaB0sgmPewuoJIqFrZ5QDPhostw',

		'match-center.nz' => 'fcqNvu0qA7WE-eyxfNul5kC9y_c1lWQvGzDc5b06uQg',

		'match-center.ro' => 'ENyrRmbmfl3ahc_MEpiV_hGL1RaiTnppypL6xaxk2_c',

		'match-center.cz' => 'mEkrJzr2kWNt0bwY4KBe-esDddNfY6LHIHoQwqgXUAA',

		'match-center.pl' => 'cHXNqzAYzXW9xQcJ_3XkMxaOlOY2RjHWtYOzqq7-mX0',

		'match-center-de.com' => 'uL_MOpGHjVJdTC0wYE5IpCP_DVbLdMZNH9QnAjaOdes',

		'match-center-ua.com' => 'xsV_rhcHpVkCE0BOHIGgCEeHPDJ2yBVtlNkOBjaSpxU',

		'match-center.ar' => 'Y2Opq8gGQS9XXahYuxOsrMaQ3UoJTQFjarZttw-zaTs',

		'match-center-kz.com' => 'HMUEHcjh7O4qA20TiXyX9X3zrktuScU96hOjIXbVfmE',
	];

	public static function get_google_verification()
	{
		$domain = MultisiteBlog::get_domain();

		LegalDebug::debug( [
			'YoastVerification' => 'get_google_verification',

			'domain' => $domain,
		] );

		if ( array_key_exists( $domain, self::GOOGLE_VERIFICATION ) )
		{
			return [
				'name' => 'google-site-verification',

				'content' => self::GOOGLE_VERIFICATION[ $domain ],
			];
		}

		return [];
	}

	public static function get_verification()
	{
		$verification = [];

		$google = self::get_google_verification();

		if ( ! empty( $google ) )
		{
			$verification[ 'google' ] = $google;
		}
	}

	const TEMPLATE = [
        'yoast-verification' => LegalMain::LEGAL_PATH . '/template-parts/yoast/part-yoast-verification.php',
    ];

    public static function render()
    {
		return LegalComponents::render_main( self::TEMPLATE[ 'yoast-verification' ], self::get_verification() );
    }
}

?>