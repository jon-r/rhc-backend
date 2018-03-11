

-- move h w d to dimensions

TRUNCATE `rhc_products`;

INSERT INTO `rhc_products` (
  `rhc_ref`,
  `rhc_status`,
  `curlew_ref`,
  `curlew_status`,
  `shop_notes`,
  `photos_status`,
  `print_status`,
  `print_notes`,
  `invoice`,
  `product_name`,
  `description`,
  `quantity`,
  `price`,
  `original_price`,
  `is_job_lot`,
  `is_featured`,
  `site_flag`,
  `site_icon`,
  `site_seo_text`,
  `date_live`,
  `date_sold`,
  `video_link`
)
SELECT
  `networked db`.RHC AS rhc_ref,
  IF(`networked db`.LiveonRHC <> 0,'added','to add') AS rhc_status,
  `networked db`.CurlewRef AS curlew_ref,
  IF(`networked db`.LiveonCurlew <> 0,'added',
    IF(`networked db`.NotForCurlew <> 0, 'to skip', 'to add')
  ) AS curlew_status,
  `networked db`.ExtraComments AS shop_notes,
  IF(`networked db`.HasPics <> 0, 'done', 'to take') AS photos_status,
  IF(`networked db`.PrintAttached <> 0, 'done',
    IF(`networked db`.HasPrinted <> 0, 'to attach',
      IF(`networked db`.SkipPrint <> 0, 'to skip',
        'to print'
      )
    )
  ) AS print_status,
  `networked db`.PrintSize AS print_notes,
  `networked db`.InvoiceNumber AS invoice,
  `networked db`.ProductName AS product_name,
  CONCAT(
    `networked db`.`Line 1`,
    IF(`networked db`.`Line 2` <> '0', CONCAT('\n\n', `networked db`.`Line 2`), ''),
    IF(`networked db`.`Line 3` <> '0', CONCAT('\n\n', `networked db`.`Line 3`), ''),
    IF(`networked db`.`Condition/Damages` <> '0', CONCAT('\n\n', `networked db`.`Condition/Damages`), '')
  ) AS description,
  `networked db`.Quantity AS quantity,
  `networked db`.Price AS price,
  '0.00' AS original_price,
  '0' AS is_job_lot,
  '0' AS is_featured,
  '' AS site_flag,
  rhc_set_icon(
    `networked db`.Power,
    `networked db`.Category,
    `networked db`.Cat1,
    `networked db`.Cat2,
    `networked db`.Cat3
  ) AS site_icon,
  `networked db`.SEO_meta_text AS site_seo_text,
  `networked db`.DateLive AS date_live,
  `networked db`.DateSold AS date_sold,
  `networked db`.video_link AS video_link

FROM `networked db` WHERE 1;
