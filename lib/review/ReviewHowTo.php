<?php

class ReviewHowTo
{
	public static function schema()
    {
        return [
			"@context" => "https://schema.org",

			"@type" => "HowTo",
			
			"name" => "How to claim the Betfred new customer bonus:",

			"step" => [
				[
					"@type" => "HowToSection",
					"name" => "Preparation",
					"position" => "1",
					"itemListElement" => [
						[
							"@type" => "HowToStep",
							"position" => "1",
							"itemListElement" => [
								[
									"@type" => "HowToDirection",
									"position" => "1",
									"text" => "Before placing your first bet, make a minimum deposit of £10 within 7 days of registering, using a debit card. Note: payment restrictions apply. "
								],
								[
									"@type" => "HowToDirection",
									"position" => "2",
									"text" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris pulvinar nibh id nibh molestie, scelerisque interdum metus venenatis."
								],
								[
									"@type" => "HowToTip",
									"position" => "3",
									"text" => "Nam pellentesque eu nisl id congue."
								],
								[
									"@type" => "HowToTip",
									"position" => "4",
									"text" => "Maecenas in vulputate ipsum.",
								],
							],
						],
						[
							"@type" => "HowToStep",
							"position" => "2",
							"itemListElement" => [
								[
									"@type" => "HowToDirection",
									"position" => "1",
									"text" => "Place your first bet. The first bet must be £10 or more on any qualifying sportsbook markets at odds of evens or greater.",
								],
								// [
								// 	"@type" => "HowToTip",
								// 	"position" => "2",
								// 	"text" => "You don't want the car to move while you're working on it.",
								// ],
							],
						],
					]
				],
			],

			"totalTime" => "P2D",
        ];
    }
}

?>