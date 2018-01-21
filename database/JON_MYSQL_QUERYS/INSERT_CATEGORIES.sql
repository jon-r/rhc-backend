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


-- TRUNCATE `rhc_cats_xref`;

-- todo
-- setting FOREIGN KEYs
-- JOIN via SELECT (inner join?)
-- https://code.tutsplus.com/articles/sql-for-beginners-part-3-database-relationships--net-8561



-- CALL $('{egory,1,2,3}', 'INSERT INTO rhc_cats_xref (
--   cat_index,
--   product_index
-- )
-- SELECT
--   rhc_categories.cat_index AS cat_index,
--   rhcproduct_index
-- ')
