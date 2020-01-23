ALTER TABLE `form_med_management` 
ADD COLUMN `diagnosis1` VARCHAR(255) NULL AFTER `servicecode`,
ADD COLUMN `diagnosis2` VARCHAR(255) NULL AFTER `diagnosis1`,
ADD COLUMN `diagnosis3` VARCHAR(255) NULL AFTER `diagnosis2`,
ADD COLUMN `diagnosis4` VARCHAR(255) NULL AFTER `diagnosis3`;