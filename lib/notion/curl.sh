curl -X POST 'https://api.notion.com/v1/databases/64ac3b27d4a549ea9efc2d23786b6ce4/query' \
  -H 'Authorization: Bearer '"secret_STtcyJjP96m64iRq5TICvLIUcFnkPVGsUiEVcixU9rZ"'' \
  -H 'Notion-Version: 2022-06-28' \
  -H "Content-Type: application/json" \
--data '{
	"sorts": [
		{
			"property": "Name",
			"direction": "ascending"
		}
	],
	"filter": {
		"or": [
			{
				"property": "Name",
				"rich_text": {
                    "contains": "Wplay"
                }
			}
		]
	}
}' > /c/share/sites/notion/response.json