TRUNCATE rhc_groups;

INSERT INTO rhc_groups (group_name)
SELECT DISTINCT CategoryGroup as group_name
FROM `old_rhc_categories` WHERE CategoryGroup <> '';
