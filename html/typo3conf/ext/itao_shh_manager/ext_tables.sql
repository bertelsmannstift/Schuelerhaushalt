#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (
	tx_itaoshhmanager_ssh_ref_school tinytext,
	tx_itaoshhmanager_ssh_ref_commune tinytext,
	tx_itaoshhmanager_shh_classname tinytext,
	tx_itaoshhmanager_shh_terms tinyint(4) DEFAULT '0' NOT NULL,
	password_orig varchar(255) DEFAULT '' NOT NULL
);

CREATE TABLE fe_groups (
	tx_itaoshhmanager_ssh_ref_school tinytext
);



CREATE TABLE be_users (
	ref_school tinytext,
	ref_commune tinytext,
	password_orig varchar(255) DEFAULT '' NOT NULL
);


#
# Table structure for table 'tx_itaoshhmanager_communes'
#
CREATE TABLE tx_itaoshhmanager_communes (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	titel tinytext,
	c_short varchar(255) DEFAULT '' NOT NULL,
	ref_state int(11) DEFAULT '0' NOT NULL,
	ref_communepage int(11) DEFAULT '0' NOT NULL,
	imprint text,
	ref_contactperson text,
	infotext text,
	headerimage text,
	welcometext text,
	ref_download text,
	downloadurl  tinytext,
	youtubelink tinytext,
	is_new tinyint(4) DEFAULT '1' NOT NULL,
	is_finished tinyint(4) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_itaoshhmanager_bls'
#
CREATE TABLE tx_itaoshhmanager_bls (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	title tinytext,
	bl_short tinytext,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);

#
# Table structure for table 'tx_itaoshhmanager_schools'
#
CREATE TABLE tx_itaoshhmanager_schools (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	title tinytext,
	s_short varchar(255) DEFAULT '' NOT NULL,
	zip tinytext
	city tinytext,
	ref_commune int(11) DEFAULT '0' NOT NULL,
	welcometext text,
	headerimage text,
	ref_contactperson text,
	resultpage text,
	ref_schoolpage text,
	ref_sortedoffers text,
	ref_myoffers text,
	ref_createoffer text,
	ref_status int(11) DEFAULT '1' NOT NULL,
	is_new tinyint(4) DEFAULT '1' NOT NULL,
	ref_fegroup int(11) DEFAULT '0' NOT NULL,
	ref_mp_schoolstartpage  text,
	number_of_result_offers int(11) DEFAULT '5' NOT NULL,
	offer_automatically_approved tinyint(4) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);

#
# Table structure for table 'tx_itaoshhmanager_status_school'
#
CREATE TABLE tx_itaoshhmanager_status_school (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	title tinytext,
	st_image tinytext,
	ordernr int(11) DEFAULT '0' NOT NULL,
	
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);




#
# Table structure for table 'tx_itaoshhmanager_pwlogging'
#
CREATE TABLE tx_itaoshhmanager_pwlogging (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	ref_beuser int(11) DEFAULT '0' NOT NULL,
	ref_feuser int(11) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);




#
# Table structure for table 'tx_itaoshhmanager_resultanz'
#
CREATE TABLE tx_itaoshhmanager_resultanz (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	ref_schoolid int(11) DEFAULT '0' NOT NULL,
	number_of_result_offers int(11) DEFAULT '5' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);