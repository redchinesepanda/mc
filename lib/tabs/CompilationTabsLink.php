<?php

class CompilationTabsLink
{

	const CLASSES = [
		'link' => 'compilation-link',

		'tabs' => 'legal-tabs',
	];

	public static function register_functions()
	{
		$handler = new self();

        add_filter( 'tiny_mce_before_init', [ $handler, 'style_formats_compilation_link' ] );
	}

	public static function style_formats_compilation_link( $settings )
	{
		return ToolTinyMCE::style_formats_check( $settings, [
			[
				'title' => 'Compilation',

				'items' => [
					[
						'title' => 'Compilation Link',
						
						'selector' => 'a',

						'classes' => self::CLASSES[ 'link' ],
					],
				],
			],
		] );
	}

	public static function modify_content( $content )
	{
		$dom = LegalDOM::get_dom( $content );

		self::modify_link( $dom );

		return $dom->saveHTML( $dom );
	}

	public static function get_nodes_link( $dom )
	{
		// $query = '//div[contains(concat(" ",normalize-space(@class)," ")," ' . self::CLASSES[ 'tabs' ] . ' ")]/following-sibling::*[1]/self::ul';
		
		$query = '//div[contains(concat(" ",normalize-space(@class)," ")," legal-compilation ")]/following-sibling::*[1]/self::ul|//div[contains(concat(" ",normalize-space(@class)," ")," legal-tabs ")]/following-sibling::*[1]/self::ul';

		// LegalDebug::debug( [
		// 	'CompilationTabsLink' => 'get_nodes_link',

		// 	'query' => $query,
		// ] );

		return LegalDOM::get_nodes( $dom, $query );
	}

	public static function modify_link( $dom )
	{
		// if ( !CompilationTabs::check_contains_tabs() )
		// {
		// 	return false;
		// }

		$nodes = self::get_nodes_link( $dom );
		
		// LegalDebug::debug( [
		// 	'CompilationTabsLink' => 'modify_link',

		// 	'nodes-length' => $nodes->length,
		// ] );

		if ( $nodes->length == 0 )
		{
			return false;
		}

		foreach ( $nodes as $node )
		{
			$anchors = $node->getElementsByTagName( 'a' );

			// LegalDebug::debug( [
			// 	'CompilationTabsLink' => 'modify_link',

			// 	'nodeclass-class' => $node->getAttribute( 'class' ),

			// 	'anchors-length' => $anchors->length,
			// ] );

			if ( $anchors->length != 0 )
			{
				$anchor = $node->getElementsByTagName( 'a' )->item( 0 );

				$item = $dom->createElement( 'a' );

				$item->setAttribute( 'class', self::CLASSES[ 'link' ] );

				$item->setAttribute( 'href', $anchor->getAttribute( 'href' ) );

				$item->textContent = $anchor->textContent;

				// LegalDebug::debug( [
				// 	'CompilationTabsLink' => 'modify_link',

				// 	'item' => $item,
				// ] );

				try
				{
					$node->parentNode->replaceChild( $item, $node );
				}
				catch ( DOMException $e )
				{
					LegalDebug::debug( [
						'CompilationTabsLink' => 'modify_link',

						'node' => substr( $node->textContent, 0, 30 ),

						'message' => $e->getMessage(),
					] );
				}
			}
		}

		return true;
	}
}

?>