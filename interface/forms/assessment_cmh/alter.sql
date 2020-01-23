ALTER TABLE `openemr`.`form_assessment_cmh` 
CHANGE COLUMN `timestart` `time_start` VARCHAR(10) NULL DEFAULT NULL ,
CHANGE COLUMN `timeend` `time_end` VARCHAR(10) NULL DEFAULT NULL ,
ADD COLUMN `note_type` VARCHAR(50) NULL AFTER `provider` ,
CHANGE COLUMN `referral_source` `referral_source` VARCHAR(50) NULL DEFAULT NULL ;
