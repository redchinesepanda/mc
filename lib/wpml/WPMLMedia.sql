--  all the translated/duplicated attachments start
SELECT *
FROM `wp_icl_translations` 
WHERE 
`element_type` = 'post_attachment';
--  end

--  post ID of all the translated/duplicated attachments start
SELECT *
FROM `wp_icl_translations` 
WHERE 
`element_type` = 'post_attachment'
AND 
`source_language_code` IS NOT NULL;
--  post ID of all the translated/duplicated attachments end

-- wp_posts inner join wp_icl_translations start
SELECT `mc_posts`.`ID`,
`mc_posts`.`guid`,
`mc_icl_translations`.`element_id`,
`mc_icl_translations`.`source_language_code`
FROM `wp_posts` AS `mc_posts`
INNER JOIN `wp_icl_translations` AS `mc_icl_translations` ON `mc_posts`.`ID` = `mc_icl_translations`.`element_id`;
-- wp_posts inner join wp_icl_translations end

-- count wp_posts inner join wp_icl_translations start
-- 971836
SELECT COUNT(`mc_posts`.`ID`),
`mc_posts`.`ID`,
`mc_posts`.`guid`,
`mc_icl_translations`.`element_id`,
`mc_icl_translations`.`source_language_code`
FROM `wp_posts` AS `mc_posts`
INNER JOIN `wp_icl_translations` AS `mc_icl_translations` ON `mc_posts`.`ID` = `mc_icl_translations`.`element_id`;
-- count wp_posts inner join wp_icl_translations end

-- wp_posts inner join wp_icl_translations duplicated start
SELECT `mc_posts`.`ID`,
`mc_posts`.`guid`,
`mc_icl_translations`.`element_id`,
`mc_icl_translations`.`source_language_code`
FROM `wp_posts` AS `mc_posts`
INNER JOIN `wp_icl_translations` AS `mc_icl_translations` ON `mc_posts`.`ID` = `mc_icl_translations`.`element_id`
WHERE 
`mc_icl_translations`.`element_type` = 'post_attachment'
AND 
`mc_icl_translations`.`source_language_code` IS NOT NULL;
-- wp_posts inner join wp_icl_translations duplicated end

-- count wp_posts inner join wp_icl_translations duplicated start
-- 933281
SELECT COUNT(`mc_posts`.`ID`),
`mc_posts`.`ID`,
`mc_posts`.`guid`,
`mc_icl_translations`.`element_id`,
`mc_icl_translations`.`source_language_code`
FROM `wp_posts` AS `mc_posts`
INNER JOIN `wp_icl_translations` AS `mc_icl_translations` ON `mc_posts`.`ID` = `mc_icl_translations`.`element_id`
WHERE 
`mc_icl_translations`.`element_type` = 'post_attachment'
AND 
`mc_icl_translations`.`source_language_code` IS NOT NULL;
-- count wp_posts inner join wp_icl_translations duplicated start

-- delete duplicated start
DELETE `mc_posts`,
`mc_icl_translations`
FROM `wp_posts` AS `mc_posts`
INNER JOIN `wp_icl_translations` AS `mc_icl_translations` ON `mc_posts`.`ID` = `mc_icl_translations`.`element_id`
WHERE 
`mc_icl_translations`.`element_type` = 'post_attachment'
AND 
`mc_icl_translations`.`source_language_code` IS NOT NULL;
-- end

-- select unattached start
SELECT *
FROM `wp_posts` AS `mc_posts`
WHERE
`mc_posts`.`post_type` = 'attachment'
AND `mc_posts`.`post_parent` IS NULL;
-- end

-- count unattached start
SELECT COUNT(`mc_posts`.`ID`)
FROM `wp_posts` AS `mc_posts`
WHERE
`mc_posts`.`post_type` = 'attachment'
AND `mc_posts`.`post_parent` = 0
LIMIT 0, 1000;
-- end

-- delete unattached start
DELETE FROM `wp_posts` AS `mc_posts`
WHERE
`mc_posts`.`post_type` = 'attachment'
AND `mc_posts`.`post_parent` = 0
LIMIT 10000;
-- end

-- procedure start
DROP PROCEDURE IF EXISTS GeekLoop();

DELIMITER $$ 

CREATE PROCEDURE GeekLoop()
BEGIN
	DECLARE no INT;

	SET no = 0;

	loop: LOOP
		SET no = no +1;

		select no ;

		IF no =5 THEN
			LEAVE loop;
		END IF;
	END LOOP loop;

	SELECT no;

END $$

DELIMITER ;
-- end