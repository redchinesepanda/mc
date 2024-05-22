<?php

class BrandMain
{
	const FIELD = [
        'about' => 'review-about',

		'brand' => 'billet-brand',
    ];

	const ABOUT = [
        'font' => 'about-font',

        'background' => 'about-background',

        'logo' => 'about-logo',

        'mega' => 'about-logo-mega',

        'square' => 'about-logo-square',
    ];

	public static function get_logo_tabs_mini( $billet_id )
	{
		return self::get_logo_billet( $billet_id );
	}

	public static function get_logo_review_counter( $billet_id )
	{
		return self::get_logo_billet( $billet_id );
	}

	public static function get_logo_review( $billet_id )
	{
		return self::get_logo_billet( $billet_id );
	}

	public static function get_logo_bonus( $id )
	{
		return self::get_logo_billet( $id );
	}

	public static function get_logo_billet( $billet_id )
	{
		$brand_id = get_field( self::FIELD[ 'brand' ], $billet_id );

		if ( $brand_id )
        {
			$about = get_field( self::FIELD[ 'about' ], $brand_id );

			if ( $about )
        	{
				if ( TemplateMain::check_new() )
                {
					if ( $about[ self::ABOUT[ 'square' ] ] )
					{
						return $about[ self::ABOUT[ 'square' ] ];
					}
				}
				else
				{
					if ( $about[ self::ABOUT[ 'logo' ] ] )
					{
						return $about[ self::ABOUT[ 'logo' ] ];
					}
				}
			}
		}

		return '';
	}

	public static function get_logo_review_bonus( $billet_id, $large )
	{
		$brand_id = get_field( self::FIELD[ 'brand' ], $billet_id );

		if ( $brand_id )
        {
			$about = get_field( self::FIELD[ 'about' ], $brand_id );

			if ( $about )
        	{
				if ( TemplateMain::check_new() )
                {
					if ( $about[ self::ABOUT[ 'square' ] ] )
					{
						return $about[ self::ABOUT[ 'square' ] ];
					}
				}
				else
				{
					if ( $large )
					{
						if ( $about[ self::ABOUT[ 'mega' ] ] )
						{
							return $about[ self::ABOUT[ 'mega' ] ];
						}

						if ( $about[ self::ABOUT[ 'logo' ] ] )
						{
							return $about[ self::ABOUT[ 'logo' ] ];
						}
					}
					else
					{
						if ( $about[ self::ABOUT[ 'square' ] ] )
						{
							return $about[ self::ABOUT[ 'square' ] ];
						}
					}
				}
			}
		}

		return '';
	}

	public static function get_logo_review_billet( $billet_id )
	{
		$brand_id = get_field( self::FIELD[ 'brand' ], $billet_id );

		if ( $brand_id )
        {
			$about = get_field( self::FIELD[ 'about' ], $brand_id );

			if ( $about )
        	{
				if ( TemplateMain::check_new() )
                {
					if ( $about[ self::ABOUT[ 'square' ] ] )
					{
						return $about[ self::ABOUT[ 'square' ] ];
					}
				}
				else
				{
					if ( !empty( $about[ self::ABOUT[ 'logo' ] ] ) )
					{
						return $about[ self::ABOUT[ 'logo' ] ];
					}
				}
			}
		}

		return '';
	}

	public static function get_logo_bonus_preview( $bonus_id )
	{
		return self::get_logo_megabillet( $bonus_id );
	}

	public static function get_logo_megabillet( $billet_id )
	{
		$brand_id = get_field( self::FIELD[ 'brand' ], $billet_id );

		if ( $brand_id )
        {
			$about = get_field( self::FIELD[ 'about' ], $brand_id );

			if ( $about )
        	{
				if ( TemplateMain::check_new() )
                {
					if ( $about[ self::ABOUT[ 'square' ] ] )
					{
						return $about[ self::ABOUT[ 'square' ] ];
					}
				}
				else
				{
					if ( $about[ self::ABOUT[ 'square' ] ] )
					{
						return $about[ self::ABOUT[ 'square' ] ];
					}

					if ( $about[ self::ABOUT[ 'logo' ] ] )
					{
						return $about[ self::ABOUT[ 'logo' ] ];
					}
				}
			}
		}

		return '';
	}
}

?>