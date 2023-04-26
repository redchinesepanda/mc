<?php

class ReviewBonus
{
	public static function register()
	{
		$handler = new self();

		add_filter( 'the_content', [ $handler, 'get' ] );	
	}

	const BONUS_CLASS = 'legal-bonus';

	public static function get( $content )
	{
		$dom = new DomDocument();

		$dom->load( $content );

		$finder = new DomXPath( $dom );

		$nodes = $finder->query( '//*[contains(@class, ' . self::BONUS_CLASS . ')]' );

		LegalDebug::debug( [
			'$nodes' => $nodes,
		] );

		return $content;
	}
}

?>