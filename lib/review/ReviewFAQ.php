<?php

class ReviewFAQ
{
    const CSS = [
        'review-faq' => LegalMain::LEGAL_URL . '/assets/css/review/review-faq.css',
    ];

    public static function register_style()
    {
        foreach ( self::CSS as $name => $path ) {
            wp_enqueue_style( $name, $path );
        }
    }

    const JS = [
        'review-faq' => LegalMain::LEGAL_URL . '/assets/js/review/review-faq.js',
    ];

    public static function register_script()
    {
        foreach ( self::JS as $name => $path ) {
            wp_register_script( $name, $path, [], false, true );

            wp_enqueue_script( $name );
        }
    }

    public static function register()
    {
        $handler = new self();

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_style' ] );

        add_action( 'wp_enqueue_scripts', [ $handler, 'register_script' ] );

		add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_faq' ] );
    }

    public static function schema()
    {
        return [
            "@context" => "https://schema.org",

            "@type" => "FAQPage",

            "mainEntity" => self::get_schema_data(),
        ];
    }
    
    const CSS_CLASS = [
        'base' => 'legal-faq',

        'title' => 'legal-faq-title',

        'description' => 'legal-faq-description',
    ];

	public static function get_nodes( $dom )
	{
		$xpath = new DOMXPath( $dom );

		return $xpath->query( './/*[contains(@class, \'' . self::CSS_CLASS[ 'base' ] . '\')]' );
	}

	public static function clean( &$node )
    {
        if ( $node->hasChildNodes() ) {
            foreach ( $node->childNodes as $child ) {
                self::clean( $child );
            }
        } else {
            $node->textContent = preg_replace( '/\s+/', ' ', $node->textContent );
        }
    }

    public static function get_schema_data()
	{
        if ( !ReviewMain::is_front() ) {
			return [];
		}

        $post = get_post();

        if ( empty( $post ) ) {
            return [];
        }

		$dom = LegalDOM::get_dom( $post->post_content );

        $nodes = self::get_nodes( $dom );

		if ( $nodes->length == 0 ) {
			return $post->post_content;
		}

		$items = [];

		$last = $nodes->length - 1;

		foreach ( $nodes as $id => $node ) {
            $class = explode( ' ', $node->getAttribute( 'class' ) );

			$permission_title = ( in_array( self::CSS_CLASS[ 'title' ], $class ) );

			$permission_description = ( in_array( self::CSS_CLASS[ 'description' ], $class ) );

			$permission_last = ( $id == $last );

			if ( !empty( $item ) && $permission_description ) {
                $node->removeAttribute( 'class' );

                self::clean( $node );

                $item[ 'acceptedAnswer' ][ 'text' ] .= ToolEncode::encode( $dom->saveHTML( $node ) );
			}

			if ( !empty( $item ) && ( $permission_title || $permission_last ) ) {
                $items[] = $item;

                $item = null;
			}

			if ( $permission_title ) {
                $item = [
                    '@type' => 'Question',

                    'name' => ToolEncode::encode( $node->textContent ),

                    'acceptedAnswer' => [
                        '@type' => 'Answer',

                        'text' => '',
                    ]
                ];
			}
		}

		return $items;
	}

	public static function style_formats_faq( $settings )
	{
		return ToolTinyMCE::style_formats_check( $settings, [
			[
				'title' => 'FAQ',

				'items' => [
					[
						'title' => 'FAQ Title',
						
						'selector' => 'h3',

						'classes' => self::CSS_CLASS[ 'title' ],
					],

					[
						'title' => 'FAQ Description',
						
						'selector' => 'p,ul,ol',

						'classes' => self::CSS_CLASS[ 'description' ],
					],
				],
			],
		] );
	}
}

?>