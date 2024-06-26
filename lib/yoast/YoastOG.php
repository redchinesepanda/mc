<?php

class YoastOG
{
	const VALID_OG_LOCALE = [
		'en_US', 'ca_ES', 'cs_CZ', 'cx_PH', 'cy_GB', 'da_DK', 'de_DE', 'eu_ES', 'en_PI', 'en_UD', 'ck_US', 'es_LA', 'es_ES', 'es_MX', 'gn_PY', 'fi_FI', 'fr_FR', 'gl_ES', 'ht_HT', 'hu_HU', 'it_IT', 'ja_JP', 'ko_KR', 'nb_NO', 'nn_NO', 'nl_NL', 'fy_NL', 'pl_PL', 'pt_BR', 'pt_PT', 'ro_RO', 'ru_RU', 'sk_SK', 'sl_SI', 'sv_SE', 'th_TH', 'tr_TR', 'ku_TR', 'zh_CN', 'zh_HK', 'zh_TW', 'fb_LT', 'af_ZA', 'sq_AL', 'hy_AM', 'az_AZ', 'be_BY', 'bn_IN', 'bs_BA', 'bg_BG', 'hr_HR', 'nl_BE', 'en_GB', 'eo_EO', 'et_EE', 'fo_FO', 'fr_CA', 'ka_GE', 'el_GR', 'gu_IN', 'hi_IN', 'is_IS', 'id_ID', 'ga_IE', 'jv_ID', 'kn_IN', 'kk_KZ', 'ky_KG', 'la_VA', 'lv_LV', 'li_NL', 'lt_LT', 'mi_NZ', 'mk_MK', 'mg_MG', 'ms_MY', 'mt_MT', 'mr_IN', 'mn_MN', 'ne_NP', 'pa_IN', 'rm_CH', 'sa_IN', 'sr_RS', 'so_SO', 'sw_KE', 'tl_PH', 'ta_IN', 'tt_RU', 'te_IN', 'ml_IN', 'uk_UA', 'uz_UZ', 'vi_VN', 'xh_ZA', 'zu_ZA', 'km_KH', 'tg_TJ', 'ar_AR', 'he_IL', 'ur_PK', 'fa_IR', 'sy_SY', 'yi_DE', 'qc_GT', 'qu_PE', 'ay_BO', 'se_NO', 'ps_AF', 'tl_ST', 'gx_GR', 'my_MM', 'qz_MM', 'or_IN', 'si_LK', 'rw_RW', 'ak_GH', 'nd_ZW', 'sn_ZW', 'cb_IQ', 'ha_NG', 'yo_NG', 'ja_KS', 'lg_UG', 'br_FR', 'zz_TR', 'tz_MA', 'co_FR', 'ig_NG', 'as_IN', 'am_ET', 'lo_LA', 'ny_MW', 'wo_SN', 'ff_NG', 'sc_IT', 'ln_CD', 'tk_TM', 'sz_PL', 'bp_IN', 'ns_ZA', 'tn_BW', 'st_ZA', 'ts_ZA', 'ss_SZ', 'ks_IN', 've_ZA', 'nr_ZA', 'ik_US', 'su_ID', 'om_ET', 'em_ZM', 'qr_GR', 'iu_CA',
	];

	const TAXONOMY = [
		'media' => 'media_type',
	];

	const MEDIA_TYPE = [
		'og' => 'legal-og-image',
	];

	public static function register_functions()
    {
        $handler = new self();

		add_action( 'wpseo_add_opengraph_images', [ $handler, 'add_og_images' ] );

		add_filter( 'wpseo_opengraph_image', [ $handler, 'default_og_image' ] );

		add_filter( 'wpseo_twitter_image', [ $handler, 'default_twitter_image' ] );
	
		add_action( 'wpseo_frontend_presenters', [ $handler, 'remove_og_locale' ] );

		add_action( 'wp_head', [ $handler, 'add_og_meta_tags' ]);
    }

	const TEMPLATE = [
        'og' => LegalMain::LEGAL_PATH . '/template-parts/yoast/part-yoast-og.php',
    ];

    public static function get_og_meta_tags()
	{
		return [
			'og-image' => [
				'content' => LegalMain::LEGAL_URL . '/assets/img/yoast/mc-favicon.svg',
			],
		];
	}

    public static function add_og_meta_tags()
    {
        echo LegalComponents::render_main( self::TEMPLATE[ 'og' ], self::get_og_meta_tags() );
    }

	public static function remove_locale_presenter( $presenter )
	{
		if ( ! $presenter instanceof Yoast\WP\SEO\Presenters\Open_Graph\Locale_Presenter )
		{
			return $presenter;
		}
	}

	public static function check_locale_not_valid()
	{
		return ! self::check_locale_valid();
	}

	public static function check_locale_valid()
	{
		$locale = WPMLMain::get_locale();

		// LegalDebug::debug( [
		// 	'YoastOG' =>'check_locale_valid',

		// 	'locale' => $locale,

		// 	'in_array' => in_array( $locale, self::VALID_OG_LOCALE ),
		// ] );

		if ( in_array( $locale, self::VALID_OG_LOCALE ) )
		{
			return true;
		}

		return false;
	}

	public static function remove_og_locale( $presenters )
	{
		// return array_map( function( $presenter )
		// {
		// 	if ( ! $presenter instanceof Yoast\WP\SEO\Presenters\Open_Graph\Locale_Presenter ) {
		// 		return $presenter;
		// 	}
		// }, $presenters );

		if ( self::check_locale_not_valid() )
		{
			$handler = new self();
	
			return array_map( [ $handler, 'remove_locale_presenter' ], $presenters );
		}
	}

	public static function add_og_images( $image_container )
	{
		$thumbnail_id = get_post_thumbnail_id();

		// LegalDebug::debug( [
		// 	'YoastOG' => 'add_og_images',

		// 	// 'image_container' => $image_container,

		// 	// 'has_post_thumbnail' => has_post_thumbnail(),

		// 	'thumbnail_id' => $thumbnail_id,

		// 	// 'post_exists' => post_exists( $thumbnail_id ),

		// 	'wp_get_attachment_url' => wp_get_attachment_url( $thumbnail_id ),

		// 	'get_images' => $image_container->get_images(),

		// 	'has_images' => $image_container->has_images(),
		// ] );

		// if ( ! $image_container->has_images() )
		
		// if ( ! has_post_thumbnail() )
		
		if ( empty( wp_get_attachment_url( $thumbnail_id ) ) )
		{
			// $og_attachments = self::get_og_attachments();
			
			$og_attachment = self::get_og_attachment();
	
			// LegalDebug::debug([
			// 	'YoastOG' => 'add_default_opengraph',
	
			// 	'og_attachments' => $og_attachments,
			// ]);
	
			// if ( !empty( $og_attachments ) )
			
			if ( !empty( $og_attachment ) )
			{
				// foreach ( $og_attachments as $og_attachment )
				// {
				// 	$image_container->add_image_by_id( $og_attachment );
				// }

				$image_container->add_image_by_id( $og_attachment );
			}
			else
			{
				$image_container->add_image( self::get_default_image() );
			}
		}
	}

	public static function default_twitter_image( $image )
	{
		// LegalDebug::debug( [
		// 	'YoastOG' => 'default_twitter_image',
		// ] );

		// return self::get_default_image();

		return self::get_og_attachment_url();
	}

	public static function default_og_image( $image )
	{
		// LegalDebug::debug( [
		// 	'YoastOG' => 'default_og_image',
		// ] );

		// return self::get_default_image();

		return self::get_og_attachment_url();
	}

	public static function get_default_image()
	{
		return LegalMain::LEGAL_URL . '/assets/img/yoast/preview-default.webp';
	}

	public static function get_og_attachment_query()
	{
		return [
			'posts_per_page' => -1,
			
			'post_type' => 'attachment',

			'tax_query' => [
				[
					'taxonomy' => self::TAXONOMY[ 'media' ],
					
					'terms' => self::MEDIA_TYPE,

					'field' => 'slug',

					'operator' => 'IN',
				],
			],

			'fields' => 'ids',
		];
	}

	public static function get_og_attachments()
	{
		return get_posts( self::get_og_attachment_query() );
	}

	public static function get_og_attachment()
	{
		$attachments = self::get_og_attachments();

		if ( ! empty( $attachments ) )
		{
			return array_shift( $attachments );
		}

		return null;
	}

	public static function get_og_attachment_url()
	{
		$attachment = self::get_og_attachment();

		if ( ! empty( $attachment ) )
		{
			if ( $attachment_url = wp_get_attachment_url( $attachment ) )
			{
				return $attachment_url;
			}
		}

		return self::get_default_image();
	}
}

?>