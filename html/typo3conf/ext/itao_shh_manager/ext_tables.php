<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

/*if (TYPO3_MODE == 'BE') {
	t3lib_extMgm::addModulePath('web_txitaoshhmanagerM1', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');
		
	t3lib_extMgm::addModule('web', 'txitaoshhmanagerM1', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');
}
*/

/* ====================== fuer Erweiterung der fe_users =============================*/
$tempColumns = array (
	'tx_itaoshhmanager_ssh_ref_school' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:fe_users.tx_itaoshhmanager_ssh_ref_school',		
		'config' => array (
			'type' => 'select',	
			'foreign_table' => 'tx_itaoshhmanager_schools',	
			'foreign_table_where' => ' and tx_itaoshhmanager_schools.deleted=0 and tx_itaoshhmanager_schools.hidden=0 ORDER BY tx_itaoshhmanager_schools.uid',	
			'size' => 1,	
			'minitems' => 0,
			'maxitems' => 1,
			'items' => array (
					array('', 0)
			),
		)
	),
	'tx_itaoshhmanager_ssh_ref_commune' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:fe_users.tx_itaoshhmanager_ssh_ref_commune',		
		'config' => array (
			'type' => 'select',	
			'foreign_table' => 'tx_itaoshhmanager_communes',	
			'foreign_table_where' => ' and tx_itaoshhmanager_communes.deleted=0 and tx_itaoshhmanager_communes.hidden=0 ORDER BY tx_itaoshhmanager_communes.uid',	
			'size' => 1,	
			'minitems' => 0,
			'maxitems' => 1,
			'items' => array (
					array('', 0)
			),
		)
	),
	
	'tx_itaoshhmanager_shh_classname' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:fe_users.tx_itaoshhmanager_shh_classname',		
		'config' => array (
			'type' => 'input',	
			'size' => '30',
		)
	),
	
	
	'tx_itaoshhmanager_shh_terms' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:itao_shh_manager/locallang_db.xml:fe_users.tx_itaoshhmanager_shh_terms',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
	
	'password_orig' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:fe_users.password_orig',		
		'config' => array (
			'type' => 'input',	
			'size' => '30',
			'eval' => 'nospace',
		)
	),
	
);


t3lib_div::loadTCA('fe_users');
t3lib_extMgm::addTCAcolumns('fe_users',$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('fe_users','tx_itaoshhmanager_ssh_ref_school;;;;1-1-1,tx_itaoshhmanager_ssh_ref_commune, tx_itaoshhmanager_shh_classname, tx_itaoshhmanager_shh_terms,password_orig');




/* ====================== fuer Erweiterung der fe_groups =============================*/
$tempColumns2 = array (
	'tx_itaoshhmanager_ssh_ref_school' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:fe_users.tx_itaoshhmanager_ssh_ref_school',		
		'config' => array (
			'type' => 'select',	
			'foreign_table' => 'tx_itaoshhmanager_schools',	
			'foreign_table_where' => 'ORDER BY tx_itaoshhmanager_schools.uid',	
			'size' => 3,	
			'minitems' => 0,
			'maxitems' => 10,
		)
	),
	
);


t3lib_div::loadTCA('fe_groups');
t3lib_extMgm::addTCAcolumns('fe_groups',$tempColumns2,1);
t3lib_extMgm::addToAllTCAtypes('fe_groups','tx_itaoshhmanager_ssh_ref_school');



/* ====================== fuer Erweiterung der be_users =============================*/
$tempColumns3 = array (
	'ref_school' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:be_users.ref_school',		
		'config' => array (
			'type' => 'select',	
			'foreign_table' => 'tx_itaoshhmanager_schools',	
			'foreign_table_where' => 'ORDER BY tx_itaoshhmanager_schools.uid',	
			'size' => 3,	
			'minitems' => 0,
			'maxitems' => 10,
		)
	),
	'ref_commune' => array (	
		'exclude' => 1,		
		'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:be_users.ref_commune',		
		'config' => array (
			'type' => 'select',	
			'foreign_table' => 'tx_itaoshhmanager_communes',	
			'foreign_table_where' => 'ORDER BY tx_itaoshhmanager_communes.titel',	
			'size' => 3,	
			'minitems' => 0,
			'maxitems' => 10,
		)
	),
	'password_orig' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:fe_users.password_orig',		
		'config' => array (
			'type' => 'input',	
			'size' => '30',
			'eval' => 'nospace',
		)
	),
	
);


t3lib_div::loadTCA('be_users');
t3lib_extMgm::addTCAcolumns('be_users',$tempColumns3,1);
t3lib_extMgm::addToAllTCAtypes('be_users','ref_school;;;;1-1-1, ref_commune,password_orig');




t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhmanager_communes');
t3lib_extMgm::addToInsertRecords('tx_itaoshhmanager_communes');

$TCA['tx_itaoshhmanager_communes'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_communes',		
		'label'     => 'titel',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY titel',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_itaoshhmanager_communes.gif',
	),
);


t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhmanager_bls');
t3lib_extMgm::addToInsertRecords('tx_itaoshhmanager_bls');

$TCA['tx_itaoshhmanager_bls'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_bls',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY title',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_itaoshhmanager_bls.gif',
	),
);


t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhmanager_schools');
t3lib_extMgm::addToInsertRecords('tx_itaoshhmanager_schools');

$TCA['tx_itaoshhmanager_schools'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_schools',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY title',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_itaoshhmanager_schools.gif',
	),
);


t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhmanager_status_school');
t3lib_extMgm::addToInsertRecords('tx_itaoshhmanager_status_school');

$TCA['tx_itaoshhmanager_status_school'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_status_school',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY uid',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_itaoshhmanager_status_school.gif',
	),
);


t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhmanager_resultanz');
t3lib_extMgm::addToInsertRecords('tx_itaoshhmanager_resultanz');

$TCA['tx_itaoshhmanager_resultanz'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_resultanz',		
		'label'     => 'number_of_result_offers',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY uid',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_itaoshhmanager_status_school.gif',
	),
);





if (TYPO3_MODE == 'BE') {
	# für SORTIERUNG
	   if (!isset($TBE_MODULES['txitaoshhmanagerM0'])) {
      $temp_TBE_MODULES = array();
      foreach($TBE_MODULES as $key => $val) {
         #if ($key=='file') {
         if ($key=='web') {
            $temp_TBE_MODULES['txitaoshhmanagerM0'] = $val; # wenns VOR Web soll, dann diese Zeile VOR die Z. 253 stellen!
            $temp_TBE_MODULES[$key] = $val;
         } else {
            $temp_TBE_MODULES[$key] = $val;
         }
      }
      $TBE_MODULES = $temp_TBE_MODULES;
   }


	# ENDE SORTIERUNG
	
	t3lib_extMgm::addModule('txitaoshhmanagerM0', 'txitaoshhmanagerM0', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod0/');
	t3lib_extMgm::addModulePath('txitaoshhmanagerM0', t3lib_extMgm::extPath($_EXTKEY) . 'mod0/');
	
	t3lib_extMgm::addModule('txitaoshhmanagerM0', 'txitaoshhmanagerM1', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');
	t3lib_extMgm::addModulePath('txitaoshhmanagerM0_txitaoshhmanagerM1', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');

	t3lib_extMgm::addModule('txitaoshhmanagerM0', 'txitaoshhmanagerM2', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod2/');
	t3lib_extMgm::addModulePath('txitaoshhmanagerM0_txitaoshhmanagerM2', t3lib_extMgm::extPath($_EXTKEY) . 'mod2/');

	t3lib_extMgm::addModule('txitaoshhmanagerM0', 'txitaoshhmanagerM4', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod4/');
	t3lib_extMgm::addModulePath('txitaoshhmanagerM0_txitaoshhmanagerM4', t3lib_extMgm::extPath($_EXTKEY) . 'mod4/');

	t3lib_extMgm::addModule('txitaoshhmanagerM0', 'txitaoshhmanagerM5', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod5/');
	t3lib_extMgm::addModulePath('txitaoshhmanagerM0_txitaoshhmanagerM5', t3lib_extMgm::extPath($_EXTKEY) . 'mod5/');

	t3lib_extMgm::addModule('txitaoshhmanagerM0', 'txitaoshhmanagerM3', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod3/');
	t3lib_extMgm::addModulePath('txitaoshhmanagerM0_txitaoshhmanagerM3', t3lib_extMgm::extPath($_EXTKEY) . 'mod3/');
/*
	t3lib_extMgm::addModule('txitaoshhmanagerM0', 'txitaoshhmanagerM3', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod3/');
	t3lib_extMgm::addModulePath('txitaoshhmanagerM0_txitaoshhmanagerM3', t3lib_extMgm::extPath($_EXTKEY) . 'mod3/');

	t3lib_extMgm::addModule('txitaoshhmanagerM0', 'txitaoshhmanagerM5', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod5/');
	t3lib_extMgm::addModulePath('txitaoshhmanagerM0_txitaoshhmanagerM5', t3lib_extMgm::extPath($_EXTKEY) . 'mod5/');
	*/
	
}

$TBE_MODULES['txitaoshhmanagerM0']= 'txitaoshhmanagerM1,txitaoshhmanagerM2,txitaoshhmanagerM4,txitaoshhmanagerM5,txitaoshhmanagerM3';#txitaoshhmanagerM2,txitaoshhmanagerM4,txitaoshhmanagerM3,txitaoshhmanagerM5,
#.t3lib_div::view_array($TBE_MODULES);


$TCA['tt_content']['columns']['imagecaption']['exclude'] = 1;
$TCA['tt_content']['columns']['titleText']['exclude'] = 1;
$TCA['tt_content']['columns']['target']['exclude'] = 1;
$TCA['tt_content']['columns']['CType']['exclude'] = 1;
$TCA['tt_content']['columns']['imagecols']['exclude'] = 1;




#if(TYPO3_MODE=="BE") {
#	require_once(PATH_t3lib."class.t3lib_userauthgroup.php");
#	$BE_USER = t3lib_div::makeInstance("t3lib_beUserAuth");
#	$BE_USER->start();
#}
#if (!$BE_USER->user['admin']) {
  $TBE_STYLES['inDocStyles_TBEstyle']         = 'div.t3-form-field-toggle-flexsection {display: none;}
  																							/* damit das Ordnersymbol nicht angezeigt wird: */
  																							span.t3-icon.t3-icon-insert-record { background-position: -360px -30px !important; display:none;}
  																							/* Damit Headerbild oben nicht auf der Seite unten angezeigt wird */
  																							.tpm-sub-elements .tpm-preview STRONG {display:none;}
  																							/* damit die Dateiendungen beim Bild-Upload ausgeblendet werden:*/
  																							.t3-form-palette-field .filetypes, table.typo3-TCEforms span.filetypes {display:none;}
  																							  ';                   // Additional default in-document styles.
#}  																							  




###  $TBE_STYLES['inDocStyles_TBEstyle'].= ' .t3-form-palette-field .filetypes {display:none;} .t3-form-palette-field .filetypes:after {content: "Text danach";}	';																						  
  																							  
  																							  
  																							/*.typo3-bigDoc	.typo3-message.message-information .message-body { background-color:blue;}
  																							.typo3-bigDoc	.typo3-message.message-information .message-body:after{ content: "Text danach";	}*/
  																							  
#$GLOBALS['TBE_STYLES']['inDocStyles_TBEstyle'] = 'body {color:lime;}';
#t3lib_utility_debug::debug($temp_eP);
// Setting up stylesheets (See template() constructor!)
#  $TBE_STYLES['stylesheet']                   = $temp_eP.'stylesheets/stylesheet.css';         // Alternative stylesheet to the default "typo3/stylesheet.css" stylesheet.
#  $TBE_STYLES['stylesheet2']                  = $temp_eP.'stylesheets/stylesheet.css';         // Additional stylesheet (not used by default).  Set BEFORE any in-document styles
#   $TBE_STYLES['styleSheetFile_post']          = '/fileadmin/templates/css/backend_ras.css'; #$temp_eP.'stylesheets/stylesheet_post.css';    // Additional stylesheet. Set AFTER any in-document styles


#   $TBE_STYLES['stylesheets']['modulemenu']    = '/fileadmin/templates/css/backend_ras.css'; #$temp_eP.'stylesheets/modulemenu.css';
#   $TBE_STYLES['stylesheets']['backend-style'] = '/fileadmin/templates/css/backend_ras.css'; #$temp_eP.'stylesheets/backend-style.css';
#   $TBE_STYLES['stylesheets']['admPanel'] = '/fileadmin/templates/css/backend_ras.css'; #$temp_eP.stylesheets/admPanel.css';



?>