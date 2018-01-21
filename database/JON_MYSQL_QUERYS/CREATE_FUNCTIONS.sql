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
