--
-- set icons
--

DELIMITER $$
DROP FUNCTION IF EXISTS rhc_set_icon$$
CREATE FUNCTION rhc_set_icon(
  pwr varchar(20),
  cat0 varchar(64),
  cat1 varchar(64),
  cat2 varchar(64),
  cat3 varchar(64)
) RETURNS enum(
  'Single Phase','Three Phase','Natural Gas','LPG','Dual Fuel',
  'Fridge','Freezer','Fridge-Freezer','Domestic',''
)
BEGIN
  DECLARE cat varchar(255);
  SET cat = CONCAT(cat0,cat1,cat2,cat3);
  RETURN IF(cat LIKE '%Fridge%' && cat LIKE '%Freezer%', 'Fridge-Freezer',
    IF(cat LIKE '%Fridge%', 'Fridge',
      IF(cat LIKE '%Freezer%', 'Freezer',
        IF(pwr <> '0', pwr, '')
      )
    )
  );
END$$
DELIMITER ;


--
-- SET Power
--
DELIMITER $$;
DROP FUNCTION IF EXISTS rhc_set_power$$
CREATE FUNCTION rhc_set_power(watts decimal(5,0), power varchar(255))
RETURNS varchar(255)
BEGIN
RETURN CONCAT(
  IF(watts > 1500,
    CONCAT(round(watts/1000,1),'kw'),
    IF(watts > 0, CONCAT(watts,' watts'), '')
  ),
  IF (watts > 0 && power <> '0', ', ', ''),
  IF (power <> '0', power, '')
); END


--
-- STR_SPLIT
--

DELIMITER $$
DROP PROCEDURE IF EXISTS str_split$$
CREATE PROCEDURE str_split(id mediumint, str varchar(255))
BEGIN
  DECLARE name, val varchar(255);
  DECLARE i INT DEFAULT 1;

  WHILE CHAR_LENGTH(str) > 1 && i != 0 DO
      SET i = LOCATE(':',str);

      IF i != 0 THEN
        SET name = LEFT(str,i - 1);
        SET str = RIGHT(str,CHAR_LENGTH(str) - i);
        SET i = LOCATE(';',str);

        IF i != 0 THEN
          SET val = LEFT(str, i - 1);
        ELSE
          SET val = str;
        END IF;

      ELSE
        SET name = str;
        SET val = '';
      END IF;

      IF CHAR_LENGTH(name>0) THEN
        INSERT INTO tmp (`product_id`,`name`,`value`) VALUES (id,name,val);
      END IF;

      SET str = RIGHT(str,CHAR_LENGTH(str) - i);

    END WHILE;
END$$
DELIMITER ;

--
-- SPLIT EXTRAS
--

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
END$$

DELIMITER ;

CALL rhc_split_extras();
