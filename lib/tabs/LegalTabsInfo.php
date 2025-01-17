<?php

class LegalTabsInfo
{
    const CSS = [
        'legal-tabs-info' => [
			'path' => LegalMain::LEGAL_URL . '/assets/css/tabs/legal-tabs-info.css',

			'ver' => '1.0.1',
		],
    ];

	public static function register_style()
    {
		ToolEnqueue::register_style( self::CSS );
    }

    const JS = [
        'legal-tabs-info' => [
            'path' => LegalMain::LEGAL_URL . '/assets/js/tabs/legal-tabs-info.js',

            'ver' => '1.0.3',
        ],
    ];

    public static function register_script()
    {
        ReviewMain::register_script( self::JS );
    }

	const SHORTCODE = [
		'info' => 'legal-tabs-info',
	];

	public static function register()
    {
        $handler = new self();

		// [legal-tabs-info]

        add_shortcode( self::SHORTCODE[ 'info' ], [ $handler, 'render' ] );

        if ( self::check_contains_tabs_info() )
        {
            add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

            add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );
        }
    }

    public static function get_tabs_info()
    {
		return [
            'title' => ToolLoco::translate( BaseMain::TEXT[ 'what-is' ] ),

            'items' => [
                [
                    'title' => ToolLoco::translate( BaseMain::TEXT[ 'relevance' ] ),

                    'content' => ToolLoco::translate( BaseMain::TEXT[ 'we-focus-on' ] ),

                    'class' => 'legal-active',
                ],

                [
                    'title' => ToolLoco::translate( BaseMain::TEXT[ 'expertise' ] ),

                    'content' => ToolLoco::translate( BaseMain::TEXT[ 'our-team-of' ] ),

                    'class' => '',
                ],
                
                [
                    'title' => ToolLoco::translate( BaseMain::TEXT[ 'transparency' ] ),

                    'content' => ToolLoco::translate( BaseMain::TEXT[ 'we-thoroughly' ] ),

                    'class' => '',
                ],
                
                [
                    'title' => ToolLoco::translate( BaseMain::TEXT[ 'fairness' ] ),

                    'content' => ToolLoco::translate( BaseMain::TEXT[ 'fairness-is' ] ),

                    'class' => '',
                ],

               
            ],
        ];
    }

	const TEMPLATE = [
        'main' => LegalMain::LEGAL_PATH . '/template-parts/tabs/legal-tabs-info.php',
    ];

	public static function render()
    {
        return LegalComponents::render_main( self::TEMPLATE[ 'main' ], self::get_tabs_info() );
    }

    public static function check_contains_tabs_info()
    {
        return LegalComponents::check_shortcode( self::SHORTCODE[ 'info' ] );
    } 
}

?>