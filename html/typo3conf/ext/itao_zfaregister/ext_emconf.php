<?php

########################################################################
# Extension Manager/Repository config file for ext "itao_zfaregister".
#
# Auto generated 07-03-2011 15:17
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'itao ZFA-Register',
	'description' => 'This extension enhance the functionallity of the frontend registration process given by datamints_feuser.',
	'category' => 'fe',
	'author' => 'Peter Rauer',
	'author_email' => 'peter.rauer@itao.de',
	'shy' => '',
	'dependencies' => 'cms,datamints_feuser,itao_zfalogin',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'author_company' => 'itao GmbH & Co KG',
	'version' => '0.0.0',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'datamints_feuser' => '',
			'itao_zfalogin' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:12:{s:9:"ChangeLog";s:4:"e9dd";s:10:"README.txt";s:4:"ee2d";s:35:"class.ux_tx_datamintsfeuser_pi1.php";s:4:"5ddb";s:12:"ext_icon.gif";s:4:"cf3b";s:17:"ext_localconf.php";s:4:"7f5a";s:14:"ext_tables.php";s:4:"a13b";s:14:"ext_tables.sql";s:4:"1b0d";s:16:"locallang_db.xml";s:4:"b2ad";s:19:"doc/wizard_form.dat";s:4:"7184";s:20:"doc/wizard_form.html";s:4:"a0a4";s:20:"static/constants.txt";s:4:"73aa";s:16:"static/setup.txt";s:4:"5c29";}',
	'suggests' => array(
	),
);

?>