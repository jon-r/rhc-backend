DELIMITER $$
DROP PROCEDURE IF EXISTS rhc_split_extras$$

CREATE PROCEDURE rhc_split_extras()
BEGIN
  DECLARE done int DEFAULT FALSE;
  DECLARE i, j, id INT;
  DECLARE name, value, string varchar(255);
  DECLARE cur1 CURSOR FOR
    SELECT `rhc_products`.id as id, `networked db`.ExtraMeasurements as input
      FROM `networked db`,`rhc_products`
      WHERE `networked db`.RHC = `rhc_products`.rhc_ref
      AND `networked db`.ExtraMeasurements<>'0'
      AND `networked db`.ExtraMeasurements<>'';
  DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

  CREATE TEMPORARY TABLE tmp (`product_id` mediumint, `name` varchar(255), `value` varchar(255)) engine=memory;

  OPEN cur1;

  read_loop: LOOP
    FETCH cur1 INTO id, string;
    IF done THEN
      LEAVE read_loop;
    END IF;

    CALL str_split(id, string);
  END LOOP;

  CLOSE cur1;

  SELECT * FROM tmp;
  DROP TEMPORARY TABLE IF EXISTS tmp;
END$$

DELIMITER ;

CALL rhc_split_extras();



-- DELIMITER $$
-- DROP PROCEDURE IF EXISTS rhc_split_extras$$
-- CREATE PROCEDURE rhc_split_extras()
-- BEGIN
--
--   DECLARE inputLength, jdx, product_id, idx mediumint;
--   DECLARE string, val varchar(255);
--   DECLARE name varchar(64);
--
--   CREATE TEMPORARY TABLE tmp (`product_id` mediumint, `name` varchar(64), `value` varchar(255)) engine=memory;
--
--   CREATE TEMPORARY TABLE inputTbl (`id` mediumint, `string` varchar(255)) engine=memory;
--   INSERT INTO inputTbl (`id`,`string`)
--   SELECT `rhc_products`.id as id, `networked db`.ExtraMeasurements as string
--   FROM `networked db`,`rhc_products`
--   WHERE `networked db`.RHC = `rhc_products`.rhc_ref
--   AND `networked db`.ExtraMeasurements<>'0'
--   AND `networked db`.ExtraMeasurements<>'';
--
--
--   SET inputLength = (SELECT count(id) from inputTbl);
--   SET jdx = 0;
--
--   WHILE jdx < inputLength DO
--
--     SET idx = 1;
--
--     WHILE CHAR_LENGTH(string)>1 && idx!= 0 DO
--       SELECT (string := `inputTbl`.string),(product_id:= `inputTbl`.id) LIMIT jdx,1;
--
--       SET idx = LOCATE(':',string);
--
--       IF idx!=0 THEN
--         SET name = LEFT(string,idx - 1);
--         SET string = RIGHT(string,CHAR_LENGTH(string) - idx);
--         SET idx = LOCATE(';',string);
--
--         IF idx!=0 THEN
--           SET val = LEFT(string, idx - 1);
--         ELSE
--           SET val = string;
--         END IF;
--       ELSE
--         SET name = string;
--         SET val = '';
--       END IF;
--
--       IF CHAR_LENGTH(name>0) THEN
--         INSERT INTO tmp (`product_id`,`name`,`value`) VALUES (product_id,name,val);
--       END IF;
--
--       SET string = RIGHT(string,CHAR_LENGTH(string) - idx);
--
--     END WHILE;
--
--     SET jdx = jxd + 1;
--
--   END WHILE;
--
--   SELECT * FROM tmp;
--
--   DROP TEMPORARY TABLE IF EXISTS inputTbl;
--   DROP TEMPORARY TABLE IF EXISTS tmp;
-- END$$
-- DELIMITER ;
--
-- call rhc_split_extras();
