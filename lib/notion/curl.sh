# curl -X POST 'https://api.notion.com/v1/databases/64ac3b27d4a549ea9efc2d23786b6ce4/query' \

curl -X POST 'https://api.notion.com/v1/databases/044a9c86ed8c4574afdf70fb00d545b1/query' \
  -H 'Authorization: Bearer '"secret_STtcyJjP96m64iRq5TICvLIUcFnkPVGsUiEVcixU9rZ"'' \
  -H 'Notion-Version: 2022-06-28' \
  -H "Content-Type: application/json" \
--data '{
	"sorts": [
		{
			"property": "title",
			"direction": "ascending"
		}
	],
	"filter": {
		"and": [
			{
				"property": "title",
				"rich_text": {
                    "contains": "Betfair"
                }
			},
			{
				"property": "Locale Language Code",
				"rich_text": {
                    "contains": "cl"
                }
			}
		]
	}
}' > /c/share/sites/notion/response.json

curl -X POST 'https://api.notion.com/v1/databases/044a9c86ed8c4574afdf70fb00d545b1/query' \
  -H 'Authorization: Bearer '"secret_STtcyJjP96m64iRq5TICvLIUcFnkPVGsUiEVcixU9rZ"'' \
  -H 'Notion-Version: 2022-06-28' \
  -H "Content-Type: application/json" \
--data '{
}' > /c/share/sites/notion/response.json