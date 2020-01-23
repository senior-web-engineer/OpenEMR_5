CREATE TABLE IF NOT EXISTS form_med_management (
id bigint(20) NOT NULL auto_increment,
date datetime default NULL,
pid bigint(20) default NULL,
user varchar(255) default NULL,
groupname varchar(255) default NULL,
authorized tinyint(4) default NULL,
activity tinyint(4) default NULL,
dcn varchar(10) default NULL,
location varchar(20) default NULL,
timestart time default NULL,
timeend time default NULL,



provider varchar(30),
units varchar(10) default '1',
servicecode varchar(10),

complaint longtext,


etoh varchar(10) NOT NULL default 'N/A',

drug_abuse varchar(10) NOT NULL default 'N/A',

ab_movements varchar(10) NOT NULL default 'N/A',

memory varchar(10) NOT NULL default 'N/A',

hallucinations varchar(10) NOT NULL default 'N/A',

sh_ideation varchar(10) NOT NULL default 'N/A',

paranoid varchar(10) NOT NULL default 'N/A',


mood longtext,

affect longtext,

axis1 longtext,

psychotropic_med longtext,

side_effect_explained varchar(3) NOT NULL default 'N/A',

labs_ordered longtext,

return_to_clinic tinyint(4),

time_frame varchar(8),

other longtext,

signature varchar(30),
credentials varchar(20),
sig_date        datetime default NULL,  

PRIMARY KEY (id)
) TYPE=MyISAM;
