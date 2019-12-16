ALTER TABLE `requirements` CHANGE `name` `name` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

ALTER TABLE `requirements` ADD `description` TEXT NOT NULL AFTER `name`;