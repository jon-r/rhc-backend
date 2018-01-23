
DROP TEMPORARY TABLE IF EXISTS tmp;
CREATE TEMPORARY TABLE tmp (`product_id` mediumint, `name` varchar(255), `value` varchar(255), `sort_order` int DEFAULT 6) engine=memory;
CALL rhc_split_extras();

INSERT INTO `rhc_specs` (
  product_id,
  name,
  value,
  sort_order
)
-- Height
(SELECT
  `rhc_products`.id as product_id,
  'Height' as name,
  `networked db`.Height as value,
  2 as sort_order
FROM `networked db`, `rhc_products`
WHERE `networked db`.RHC = `rhc_products`.rhc_ref AND `networked db`.Height<>0)
UNION
-- Width
(SELECT
  `rhc_products`.id as product_id,
  'Width' as name,
  `networked db`.Width as value,
  3 as sort_order
FROM `networked db`, `rhc_products`
WHERE `networked db`.RHC = `rhc_products`.rhc_ref AND `networked db`.Width<>0)
UNION
-- Depth
(SELECT
  `rhc_products`.id as product_id,
  'Depth' as name,
  `networked db`.Depth as value,
  4 as sort_order
FROM `networked db`, `rhc_products`
WHERE `networked db`.RHC = `rhc_products`.rhc_ref AND `networked db`.Depth<>0)
UNION
-- Model
(SELECT
  `rhc_products`.id as product_id,
  'Model' as name,
  `networked db`.Model as value,
  1 as sort_order
FROM `networked db`, `rhc_products`
WHERE `networked db`.RHC = `rhc_products`.rhc_ref AND `networked db`.Model<>'0' AND `networked db`.Model<>'')
UNION
-- Brand
(SELECT
  `rhc_products`.id as product_id,
  'Brand' as name,
  `networked db`.Brand as value,
  0 as sort_order
FROM `networked db`, `rhc_products`
WHERE `networked db`.RHC = `rhc_products`.rhc_ref AND `networked db`.Brand<>'0'  AND `networked db`.Brand<>'')
UNION
-- Power
(SELECT
  `rhc_products`.id as product_id,
  'Power' as name,
  rhc_set_power(`networked db`.Wattage, `networked db`.power) as value,
  5 as sort_order
FROM `networked db`, `rhc_products`
WHERE `networked db`.RHC = `rhc_products`.rhc_ref AND `networked db`.Brand<>'0'  AND `networked db`.Brand<>'')
UNION
-- extras
(SELECT * FROM tmp)

ORDER BY product_id;




-- Width,
-- Depth,
-- Model,
-- Brand,
-- Wattage,
-- Power,


-- ExtraMeasurements -- need some split for this one
