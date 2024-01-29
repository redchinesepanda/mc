SELECT `element_id` 
FROM `wp_icl_translations` 
WHERE 
`element_type` = 'post_attachment'
AND 
`source_language_code` IS NOT NULL;

SELECT `mc_posts`.`ID`,
`mc_posts`.`guid`,
`mc_icl_translations`.`element_id`,
`mc_icl_translations`.`source_language_code`
FROM `mc_posts` AS `mc_posts`
INNER JOIN `wp_icl_translations` AS `mc_icl_translations` ON `mc_posts`.`ID` = `mc_icl_translations`.`element_id`;