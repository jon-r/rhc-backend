
DROP TEMPORARY TABLE IF EXISTS tmp;
CREATE TEMPORARY TABLE tmp (`product_id` mediumint, `name` varchar(255), `value` varchar(255)) engine=memory;
CALL rhc_split_extras();

INSERT INTO `rhc_specs` (
  product_id,
  name,
  value
)
-- Height
(SELECT `rhc_products`.id as product_id,'Height' as name,`networked db`.Height as value
FROM `networked db`, `rhc_products` WHERE `networked db`.RHC = `rhc_products`.rhc_ref AND `networked db`.Height<>0)
UNION
-- Width
(SELECT `rhc_products`.id as product_id,'Width' as name,`networked db`.Width as value
FROM `networked db`, `rhc_products` WHERE `networked db`.RHC = `rhc_products`.rhc_ref AND `networked db`.Width<>0)
UNION
-- Depth
(SELECT `rhc_products`.id as product_id,'Depth' as name,`networked db`.Depth as value
FROM `networked db`, `rhc_products` WHERE `networked db`.RHC = `rhc_products`.rhc_ref AND `networked db`.Depth<>0)
UNION
-- Model
(SELECT `rhc_products`.id as product_id,'Model' as name,`networked db`.Model as value
FROM `networked db`, `rhc_products` WHERE `networked db`.RHC = `rhc_products`.rhc_ref AND `networked db`.Model<>'0' AND `networked db`.Model<>'')
UNION
-- Brand
(SELECT `rhc_products`.id as product_id,'Brand' as name,`networked db`.Brand as value
FROM `networked db`, `rhc_products` WHERE `networked db`.RHC = `rhc_products`.rhc_ref AND `networked db`.Brand<>'0'  AND `networked db`.Brand<>'')
UNION
-- Power
(SELECT * FROM tmp)
-- UNION
-- extras

ORDER BY product_id;




-- Width,
-- Depth,
-- Model,
-- Brand,
-- Wattage,
-- Power,


-- ExtraMeasurements -- need some split for this one
