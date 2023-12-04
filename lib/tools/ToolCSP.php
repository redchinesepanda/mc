<?php

class ToolCSP
{
	public static function register()
    {
        $handler = new self();

		add_action( 'wp_head', [ $handler, 'prepare' ] );
    }

	const TEMPLATE = [
        'legal-tool-csp' => LegalMain::LEGAL_PATH . '/template-parts/tools/part-tool-csp.php',
    ];

	const NAME = [
		'csp' => 'Content-Security-Policy',
	];

	const DIRECTIVES = [
		'base-uri' => [
			'\'self\'',
		],
		
		'default-src' => [
			'\'none\'',
		],

		'connect-src' => [
			'\'self\'',
		],

		'font-src' => [
			'\'self\'',

			'fonts.googleapis.com',
		],

		'img-src' => [
			'\'self\'',
		],

		'script-src' => [
			'\'self\'',

			'mc.yandex.ru',

			'www.googletagmanager.com',
		],

		'style-src' => [
			'\'self\'',

			'\'unsafe-inline\'',
		],
	];

	public static function prepare_directive ( $directive, $key )
	{
		return $key . ' ' . implode( ' ', $directive );
	}

    public static function prepare()
	{
		$handler = new self();

		$content = implode(
			'; ',

			array_map(
				[ $handler, 'prepare_directive' ],
				self::DIRECTIVES, array_keys( self::DIRECTIVES )
			)
		);

		$args = [
			'name' => self::NAME[ 'csp' ],

			'content' => $content,
		];

		self::render_csp( $args );
	}

    public static function render_csp( $args = [] )
	{
		echo self::render( self::TEMPLATE[ 'legal-tool-csp' ], $args );
	}

    public static function render( $template, $args = [] )
    {
        ob_start();

        load_template( $template, false, $args );

        $output = ob_get_clean();

        return $output;
    }
}

?>