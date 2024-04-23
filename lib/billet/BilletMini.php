<?php

class BilletMini
{
	public static function cut_numeric( $value, $precision = 2 )
    {
        $integerPart = floor( $value );

        $decimalPart = str_replace( $integerPart, '', $value );

        $trimmedDecimal = substr( $decimalPart, 0, $precision + 1 );

        return $integerPart . $trimmedDecimal;
    }

    public static function get_average( $id )
    {
        $items = get_field( BilletProfit::PROFIT_ITEMS, $id );
    
        if ( $items )
        {
            $value = 0;

            foreach ( $items as $item )
            {
                $value += $item[ BilletProfit::PROFIT_ITEM_VALUE ];
            }

            $value = $value / count( $items );

            return self::cut_numeric( $value );
        }

        return 0;
    }

	private static function get_bonus_title( $id )
    {
        $group = get_field( BilletMain::FIELD[ 'about' ], $id );

        if ( $group )
        {
            return $group[ BilletMain::ABOUT[ 'bonus-title' ] ];
        }

        return '';
    }

	public static function get_mini( $id, $profit = false, $filter = [] )
    {
        $href = BilletMain::get_url( $id, $filter )[ 'play' ];
        
        return [
            'id' => $id,

            'logo' => [
                'href' => $href,

                'url' => self::get_logo( $id ),
            ],

            'bonus' => !$profit ? self::get_bonus_title( $id ) : '',

            'profit' => $profit ? self::get_average( $id ) : 0,

            'button' => [
                'href' => $href,

                'label' => __( BilletMain::TEXT[ 'bet-now' ], ToolLoco::TEXTDOMAIN ),
            ],   
        ];
    }

    const FIELD = [
        'image' => 'tabs-mini-image',
    ];

    const SIZE = [
        'logo-mini' => 'tabs-logo-mini',
    ];

    public static function get_logo( $id, $size = self::SIZE[ 'logo-mini' ] )
	{
        $logo = BrandMain::get_logo_tabs_mini( $id );

        LegalDebug::debug( [
            'BilletMini' => 'get_logo',

            'logo' => $logo,
        ] );

        if ( empty( $logo ) )
		{
            $logo = get_field( BilletLogo::FIELD[ 'about' ] . '_' . BilletLogo::ABOUT[ 'mega' ], $id, false );

            LegalDebug::debug( [
                'BilletMini' => 'get_logo',
    
                'logo' => $logo,
            ] );
        }
        
        if ( empty( $logo ) )
        {
            $logo = get_field( BilletLogo::FIELD[ 'about' ] . '_' . BilletLogo::ABOUT[ 'logo' ], $id, false );

            LegalDebug::debug( [
                'BilletMini' => 'get_logo',
    
                'logo' => $logo,
            ] );
        }

        if ( !empty( $logo ) )
        {
            $details = wp_get_attachment_image_src( $logo, $size );

            LegalDebug::debug( [
                'BilletMini' => 'get_logo',
    
                'details' => $details,
            ] );

            if ( $details )
            {
                return $details[ 0 ];
            }
        }

        return LegalMain::LEGAL_URL . '/assets/img/compilation/mini-mc.webp';
	}
}

?>