#
# Table structure for table 'fe_users'
#
/*CREATE TABLE fe_users (
	tx_itaozfaregister_companyname varchar(255) DEFAULT '' NOT NULL,
	tx_itaozfaregister_numberofemployees int(11) DEFAULT '0' NOT NULL,
	tx_itaozfaregister_note text,
	tx_itaozfaregister_accepted tinyint(3) DEFAULT '0' NOT NULL
);*/
CREATE TABLE fe_users (
	tx_itaozfaregister_companyname varchar(255) DEFAULT '' NOT NULL,
	tx_itaozfaregister_numberofemployees int(11) DEFAULT '0' NOT NULL,	
	tx_itaozfaregister_numberofemployees_offline int(11) DEFAULT '0' NOT NULL,
	tx_itaozfaregister_ceofirstname varchar(255) DEFAULT '' NOT NULL,
	tx_itaozfaregister_ceolastname varchar(255) DEFAULT '' NOT NULL,
	tx_itaozfaregister_accepted tinyint(3) DEFAULT '0' NOT NULL,
	
	tx_itaozfaregister_is_parent tinyint(4) DEFAULT '1' NOT NULL,
	tx_itaozfaregister_parentuser int(11) DEFAULT '0' NOT NULL,
	tx_itaozfaregister_status int(11) DEFAULT '1' NOT NULL,
	tx_itaozfaregister_rechnungstatus int(11) DEFAULT '0' NOT NULL,
	tx_itaozfaregister_vertragstatus int(11) DEFAULT '0' NOT NULL,
	
	
	tx_itaozfaregister_erhebung int(11) DEFAULT '0' NOT NULL,
	tx_itaozfaregister_acc_gen tinyint(4) DEFAULT '0' NOT NULL,
	tx_itaozfaregister_exportpath text, 
	comments text, 
	tx_itaozfaregister_note text,
	tx_itaozfaregister_zertstatus int(11) DEFAULT '0' NOT NULL,
	tx_itaozfaregister_is_offline tinyint(4) DEFAULT '0' NOT NULL
	
	
);