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
				// [
				// 	"@type" => "HowToStep",

				// 	"position" => "1",

				// 	"itemListElement" => [
				// 		[
				// 			"@type" => "HowToDirection",

				// 			"text" => "Register for an account with the betting provider",
				// 		],
				// 	],
				// ],

				// [
				// 	"@type" => "HowToStep",

				// 	"position" => "2",

				// 	"itemListElement" => [
				// 		[
				// 			"@type" => "HowToDirection",

				// 			"position" => "1",

				// 			"text" => "Successfully verify your account with the provider",
				// 		],
				// 	],
				// ],

				// [
				// 	"@type" => "HowToStep",

				// 	"name" => "Before placing your first bet, make a minimum deposit of £10 within 7 days of registering, using a debit card. Note: payment restrictions apply. ",

				// 	"position" => "3",

				// 	"itemListElement" => [
				// 		[
				// 			"@type" => "HowToDirection",

				// 			"position" => "1",

				// 			"text" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris pulvinar nibh id nibh molestie, scelerisque interdum metus venenatis.",
				// 		],
				// 	],

				// 	"itemListElement" => [
				// 		[
				// 			"@type" => "HowToDirection",

				// 			"position" => "2",

				// 			"text" => "Nam pellentesque eu nisl id congue.",
				// 		],
				// 	],
				// ],

				[
					"@type" => "HowToSection",

					"name" => "Successfully verify your account with the provider",

					"position" => "3",

					"itemListElement" => [
					],
				],

				[
					"@type" => "HowToSection",

					"name" => "Before placing your first bet, make a minimum deposit of £10 within 7 days of registering, using a debit card. Note: payment restrictions apply. ",

					"position" => "3",

					"itemListElement" => [
					  	[
							"@type" => "HowToStep",

							"position" => "1",

							"itemListElement" => [
								[
									"@type" => "HowToDirection",

									"text" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris pulvinar nibh id nibh molestie, scelerisque interdum metus venenatis"
								],
							]
						],

						[
							"@type" => "HowToStep",

							"position" => "2",

							"itemListElement" => [
								[
									"@type" => "HowToDirection",

									"text" => "Nam pellentesque eu nisl id congue."
								],
							]
						],

						[
							"@type" => "HowToStep",

							"position" => "3",

							"text" => "Maecenas in vulputate ipsum.",

							// "itemListElement" => [
							// 	[
							// 		"@type" => "HowToDirection",

							// 		"text" => "Maecenas in vulputate ipsum."
							// 	]
							// ]
						],
					]
				],

			// 	[
			// 		"@type" => "HowToStep",

			// 		"position" => "4",

			// 		"itemListElement" => [
			// 			[
			// 				"@type" => "HowToDirection",

			// 				"text" => "Place your first bet. The first bet must be £10 or more on any qualifying sportsbook markets at odds of evens or greater.",
			// 			],
			// 		],
			// 	],
			],

			"totalTime" => "P2D",
        ];
    }
}

?>