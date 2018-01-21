TRUNCATE `rhc_categories`;

INSERT INTO `rhc_categories` (
  `cat_name`,
  `slug`,
  `sort_order`
)
SELECT
  `old_rhc_categories`.Name as cat_name,
  LOWER(
    REPLACE(
      REPLACE(
        `old_rhc_categories`.Name,
        ' & ',
        '-'
      ),
      ' ',
      '-'
    )
  ) as slug,
  `old_rhc_categories`.List_Order as sort_order
FROM `old_rhc_categories` WHERE `old_rhc_categories`.Category_ID > 0;

truncate `rhc_categories_xrefs`;

-- Category
INSERT INTO `rhc_categories_xrefs` (
  product_id, category_id)
(SELECT
`rhc_products`.id AS product_id,
`rhc_categories`.id AS category_id
FROM `rhc_products`, `networked db`, `rhc_categories`
WHERE `networked db`.Category <> ''
AND `networked db`.RHC = `rhc_products`.rhc_ref
AND `networked db`.Category = `rhc_categories`.cat_name)
-- Cat1
UNION
(SELECT
`rhc_products`.id AS product_id,
`rhc_categories`.id AS category_id
FROM `rhc_products`, `networked db`, `rhc_categories`
WHERE `networked db`.Cat1 <> ''
AND `networked db`.RHC = `rhc_products`.rhc_ref
AND `networked db`.Cat1 = `rhc_categories`.cat_name)
-- Cat2
UNION
(SELECT
`rhc_products`.id AS product_id,
`rhc_categories`.id AS category_id
FROM `rhc_products`, `networked db`, `rhc_categories`
WHERE `networked db`.Cat2 <> ''
AND `networked db`.RHC = `rhc_products`.rhc_ref
AND `networked db`.Cat2 = `rhc_categories`.cat_name)
-- Cat3
UNION
(SELECT
`rhc_products`.id AS product_id,
`rhc_categories`.id AS category_id
FROM `rhc_products`, `networked db`, `rhc_categories`
WHERE `networked db`.Cat3 <> ''
AND `networked db`.RHC = `rhc_products`.rhc_ref
AND `networked db`.Cat3 = `rhc_categories`.cat_name)
ORDER BY product_id;
