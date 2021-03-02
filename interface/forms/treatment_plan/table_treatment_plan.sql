CREATE TABLE `form_treatment_plan` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `pid` bigint(20) DEFAULT '0',
  `user` varchar(255) DEFAULT NULL,
  `groupname` varchar(255) DEFAULT NULL,
  `authorized` tinyint(4) DEFAULT '0',
  `activity` tinyint(4) DEFAULT '0',
  `units` tinyint(4) DEFAULT '1',
  `service_code` varchar(10) DEFAULT NULL,
  `service_name` varchar(45) DEFAULT NULL,
  `diagnosis1` varchar(55) DEFAULT NULL,
  `diagnosis2` varchar(55) DEFAULT NULL,
  `diagnosis3` varchar(55) DEFAULT NULL,
  `diagnosis4` varchar(55) DEFAULT NULL,
  `modality_note` varchar(255) DEFAULT '0',
  `approach_note` varchar(255) DEFAULT '0',
  `status` varchar(45) DEFAULT NULL,
  `comments_log` longblob,
  `provider_print_name` varchar(45) DEFAULT NULL,
  `provider_signature` varchar(4000) DEFAULT NULL,
  `provider_credentials` varchar(20) DEFAULT NULL,
  `provider_signature_date` date DEFAULT NULL,
  `supervisor_print_name` varchar(40) DEFAULT NULL,
  `supervisor_signature` varchar(4000) DEFAULT NULL,
  `supervisor_credentials` varchar(20) DEFAULT NULL,
  `supervisor_signature_date` date DEFAULT NULL,
  `physician_print_name` varchar(40) DEFAULT NULL,
  `physician_signature` varchar(4000) DEFAULT NULL,
  `physician_credentials` varchar(20) DEFAULT NULL,
  `physician_signature_date` date DEFAULT NULL,
  `patient_print_name` varchar(40) DEFAULT NULL,
  `patient_signature` varchar(4000) DEFAULT NULL,
  `patient_signature_date` date DEFAULT NULL,
  `guardian_print_name` varchar(40) DEFAULT NULL,
  `guardian_signature` varchar(4000) DEFAULT NULL,
  `guardian_signature_date` date DEFAULT NULL,
  `provider` varchar(45) DEFAULT NULL,
  `signatures_on_file` varchar(3) DEFAULT NULL,
  `encounter` bigint(20) DEFAULT NULL,
  `billing_status` varchar(30) DEFAULT 'Not Billed',
  `billing_id` bigint(20) DEFAULT NULL,
  `form_status` varchar(45) DEFAULT 'In Progress',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `form_treatment_plan_behavioraldefinitions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) DEFAULT '0',
  `form_id` bigint(20) DEFAULT '0',
  `problem_id` bigint(20) DEFAULT NULL,
  `tp_problem_number` bigint(20) DEFAULT '0',
  `GroupID` bigint(20) DEFAULT '0',
  `ProblemNumber` bigint(20) DEFAULT '0',
  `DefinitionNumber` bigint(20) DEFAULT '0',
  `Description` longtext,
  `IsCustom` tinyint(4) DEFAULT '0',
  `IsDeleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `form_treatment_plan_clonelog` (
  `idform_treatment_Plan_cloneLog` int(11) NOT NULL AUTO_INCREMENT,
  `target_tbl` varchar(45) DEFAULT NULL,
  `from_id` int(11) DEFAULT '0',
  `to_id` int(11) DEFAULT '0',
  `original_form_id` int(11) DEFAULT '0',
  `pid` int(11) DEFAULT '0',
  `batch` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idform_treatment_Plan_cloneLog`),
  UNIQUE KEY `idform_treatment_Plan_cloneLog_UNIQUE` (`idform_treatment_Plan_cloneLog`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `form_treatment_plan_diagnosis` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `form_id` bigint(20) DEFAULT NULL,
  `pid` bigint(20) DEFAULT NULL,
  `GroupID` bigint(20) DEFAULT NULL,
  `LegalCode` varchar(10) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `cgaf_score` varchar(45) DEFAULT NULL,
  `pgaf_score` varchar(45) DEFAULT NULL,
  `stress_rating` varchar(45) DEFAULT NULL,
  `Axis` tinyint(4) DEFAULT NULL,
  `IsDeleted` tinyint(4) DEFAULT '0',
  `problem_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `form_treatment_plan_dischargecriteria` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `form_id` bigint(20) DEFAULT NULL,
  `pid` bigint(20) DEFAULT NULL,
  `Criteria` longtext,
  `user` varchar(45) DEFAULT NULL,
  `IsDeleted` tinyint(4) DEFAULT '0',
  `problem_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `form_treatment_plan_goals` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) DEFAULT '0',
  `form_id` bigint(20) DEFAULT '0',
  `problem_id` bigint(20) DEFAULT NULL,
  `tp_problem_number` bigint(20) DEFAULT '0',
  `GroupID` bigint(20) DEFAULT '0',
  `ProblemNumber` bigint(20) DEFAULT '0',
  `GoalNumber` bigint(20) DEFAULT '0',
  `Description` longtext,
  `IsCustom` tinyint(4) DEFAULT '0',
  `goal_status` varchar(20) DEFAULT NULL,
  `goal_action` varchar(20) DEFAULT NULL,
  `review_status` longtext,
  `IsDeleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `form_treatment_plan_interventions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) DEFAULT '0',
  `form_id` bigint(20) DEFAULT '0',
  `problem_id` bigint(20) DEFAULT NULL,
  `tp_problem_number` bigint(20) DEFAULT '0',
  `sessions` bigint(20) DEFAULT NULL,
  `user` varchar(50) DEFAULT '0',
  `GroupID` bigint(20) DEFAULT '0',
  `ProblemNumber` bigint(20) DEFAULT '0',
  `ObjectiveID` bigint(20) DEFAULT '0',
  `InterventionNumber` bigint(20) DEFAULT '0',
  `Description` longtext,
  `ShortDescription` longtext,
  `IsCustom` tinyint(4) DEFAULT '0',
  `IsEvidenceBased` tinyint(4) DEFAULT '0',
  `IsDeleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `form_treatment_plan_modalities` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) DEFAULT '0',
  `form_id` bigint(20) DEFAULT '0',
  `problem_id` bigint(20) DEFAULT NULL,
  `user` bigint(20) DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `modality` varchar(50) DEFAULT NULL,
  `hcpt` varchar(20) DEFAULT NULL,
  `intervals` bigint(20) DEFAULT NULL,
  `frequency` varchar(30) DEFAULT NULL,
  `duration_hour` tinyint(10) DEFAULT NULL,
  `duration_minute` tinyint(10) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `Description` longtext,
  `tp_problem_number` bigint(20) DEFAULT NULL,
  `IsDeleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `form_treatment_plan_modalitynotes` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `form_id` bigint(20) DEFAULT NULL,
  `pid` bigint(20) DEFAULT NULL,
  `Notes` longtext,
  `user` varchar(45) DEFAULT NULL,
  `IsDeleted` tinyint(4) DEFAULT '0',
  `problem_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `form_treatment_plan_objectives` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) DEFAULT '0',
  `form_id` bigint(20) DEFAULT '0',
  `problem_id` bigint(20) DEFAULT NULL,
  `tp_problem_number` bigint(20) DEFAULT '0',
  `target_date` date DEFAULT NULL,
  `sessions` bigint(20) DEFAULT '0',
  `IsCritical` tinyint(4) DEFAULT '0',
  `GroupID` bigint(20) DEFAULT '0',
  `ProblemNumber` bigint(20) DEFAULT '0',
  `ObjectiveNumber` bigint(20) DEFAULT '0',
  `Description` longtext,
  `IsCustom` tinyint(4) DEFAULT '0',
  `IsEvidenceBased` tinyint(4) DEFAULT '0',
  `IsDeleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `form_treatment_plan_problems` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) DEFAULT '0',
  `form_id` bigint(20) DEFAULT '0',
  `tp_problem_number` bigint(20) DEFAULT '0',
  `GroupID` bigint(20) DEFAULT '0',
  `ProblemNumber` bigint(20) DEFAULT '0',
  `Description` longtext,
  `approach_note` longtext,
  `IsCustom` bigint(4) DEFAULT '0',
  `IsDeleted` tinyint(4) DEFAULT '0',
  `IsPrimary` tinyint(4) DEFAULT '0',
  `tabIndx` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `form_treatment_plan_strength` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `form_id` bigint(20) DEFAULT NULL,
  `pid` bigint(20) DEFAULT NULL,
  `GroupID` bigint(20) DEFAULT NULL,
  `Description` varchar(1000) DEFAULT NULL,
  `type` tinyint(4) DEFAULT '1',
  `user` varchar(45) DEFAULT NULL,
  `IsDeleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `form_treatment_plan_summary` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `form_id` bigint(20) DEFAULT NULL,
  `pid` bigint(20) DEFAULT NULL,
  `user` varchar(45) DEFAULT NULL,
  `Description` varchar(5000) DEFAULT NULL,
  `IsDeleted` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
