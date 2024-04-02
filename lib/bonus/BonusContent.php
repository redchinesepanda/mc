<?php

class BonusContent
{
	const CSS = [
        'bonus-content' => [
            'path' => LegalMain::LEGAL_URL . '/assets/css/bonus/legal-bonus-content.css',

            'ver'=> '1.0.1',
        ],
    ];

    public static function register_style()
    {
        BonusMain::register_style( self::CSS );
    }

	public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );
    }

	const FIELD = [
		'bonus-content' => 'text-bonus',
	];

    const ALLOWED = [
        'a',

        'h2',

        'h3',

        'h4',

        'p',

        'div',

        'ul',

        'ol',

        'li',

        'table',

        'thead',

        'tbody',

        'th',

        'tr',

        'td',

        'strong',

        'b',

        'img', 
    ];

	public static function modify_content( $content )
    {
        $content = strip_tags( $content, self::ALLOWED );

        $content = preg_replace( '/\s?<p>(\s|&nbsp;)*<\/p>/', '', $content );

        $content = str_replace( '&nbsp;', '', $content );

        return $content;
    }

	public static function get()
    {
        // $id = BonusMain::get_id();

        $post = BonusMain::get_post();
        
		if ( empty( $post ) )
		{
			return [];
        }

        $content = '';

        if ( !empty( $post->post_content ) )
        {
            $content = $post->post_content;
        }
        else
        {
            $content = get_field( self::FIELD[ 'bonus-content' ], $post->ID );
        }

        if ( !empty( $content ) )
        {
            $content = self::modify_content( $content );
        }

        // $content = strip_tags( $content, self::ALLOWED );

        // $content = preg_replace( '/\s?<p>(\s|&nbsp;)*<\/p>/', '', $content );

        // $content = str_replace( '&nbsp;', '', $content );

        // global $wp_filter;

        // LegalDebug::debug( [
        //     'function' => 'ConusContent::get',

        //     'wp_filter' => $wp_filter[ 'the_content' ],
        // ] );

		return [
			// 'content' => $content,
			
            'content' => apply_filters( 'the_content', $content ),
		];
    }

	const TEMPLATE = [
        'bonus-content' => LegalMain::LEGAL_PATH . '/template-parts/bonus/part-legal-bonus-content.php',
    ];

    public static function render()
    {
		if ( !BonusMain::check() )
        {
            return '';
        }

        ob_start();

        load_template( self::TEMPLATE[ 'bonus-content' ], false, self::get() );

        $output = ob_get_clean();

        return $output;
    }
}

?>