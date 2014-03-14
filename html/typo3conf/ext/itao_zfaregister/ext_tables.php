<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
$tempColumns = array (
	'tx_itaozfaregister_companyname' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_companyname',		
		'config' => array (
			'type' => 'input',	
			'size' => '30',	
			'eval' => 'required,trim',
		)
	),
	'tx_itaozfaregister_ceofirstname' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_ceofirstname',		
		'config' => array (
			'type' => 'input',	
			'size' => '15',	
			'eval' => 'required,trim',
		)
	),
	'tx_itaozfaregister_ceolastname' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_ceolastname',		
		'config' => array (
			'type' => 'input',	
			'size' => '25',	
			'eval' => 'required,trim',
		)
	),
	'tx_itaozfaregister_numberofemployees' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_numberofemployees',		
		'config' => array (
			'type'     => 'input',
			'size'     => '4',
			'max'      => '4',
			'eval'     => 'required,int',
			#'default'      => '',
			#,int
			'checkbox' => '0',
			'range'    => array (
				'upper' => 10000,
				'lower' => 1
			)
		)
	),
	'tx_itaozfaregister_numberofemployees_offline' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_numberofemployees_offline',		
		'config' => array (
			'type'     => 'input',
			'size'     => '4',
			'max'      => '4',
			'eval'     => 'int',
			#'default'      => '',
			#,int
			'checkbox' => '0',
			'range'    => array (
				'upper' => 10000,
				'lower' => 0
			)
		)
	),
	'tx_itaozfaregister_note' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_note',		
		'config' => array (
			'type' => 'text',
			'cols' => '30',	
			'rows' => '5',
		)
	),
	'tx_itaozfaregister_accepted' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_accepted',		
		'config' => array (
			'type' => 'check',		
			'items' => array(
				'1' => array(
					'0' => 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_accepted_checkb'
					)
				)
		)
	),
	
	
	
	
	'tx_itaozfaregister_is_parent' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_is_parent_empty',		
		'config' => array (
				'type' => 'check',		
				'items' => array(
					'1' => array(
						'0' => 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_is_parent'
						)
					) 
		)		
	),
	
	'tx_itaozfaregister_parentuser' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_parentuser',		
		'config' => array (
				'type' => 'select',	
				'items' => array (
					array('',0),
				),
				"foreign_table" => "fe_users",	
				"foreign_table_where" => "and fe_users.pid=9 ORDER BY fe_users.last_name",	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
				'iconsInOptionTags' => 0,
        'noIconsBelowSelect' => 1,
			)		
	),
		
	'tx_itaozfaregister_status' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_status',	
		'config' => array (
				'type' => 'select',	
				"foreign_table" => "tx_itaozfadatamanager_status_kunde",	#=> hier die Status-Tabelle nehmen!
				"foreign_table_where" => " and tx_itaozfadatamanager_status_kunde.hidden=0 and tx_itaozfadatamanager_status_kunde.deleted=0 ORDER BY tx_itaozfadatamanager_status_kunde.sorting",	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
				'iconsInOptionTags' => 0,
        'noIconsBelowSelect' => 1,
			)	
	),
	
	
		
	'tx_itaozfaregister_vertragstatus' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_vertragstatus',	
		'config' => array (
				'type' => 'select',	
				'items' => array (
					array('LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_vertragstatus.I',0),
					array('LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_vertragstatus.II',1),
					array('LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_vertragstatus.III',2),
				),
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
				'iconsInOptionTags' => 0,
        'noIconsBelowSelect' => 1,
			)	
	),
	
	
		
	'tx_itaozfaregister_rechnungstatus' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_rechnungstatus',	
		'config' => array (
				'type' => 'select',	
				'items' => array (
					array('LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_rechnungstatus.I',0),
					array('LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_rechnungstatus.II',1),
					array('LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_rechnungstatus.III',2),
				),
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
				'iconsInOptionTags' => 0,
        'noIconsBelowSelect' => 1,
			)	
	),
	
		
	'tx_itaozfaregister_zertstatus' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_zertstatus',	
		'config' => array (
				'type' => 'select',	
				'items' => array (
					array('LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_zertstatus.I',0),
					array('LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_zertstatus.II',1),
					array('LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_zertstatus.III',2),
				),
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
				'iconsInOptionTags' => 0,
        'noIconsBelowSelect' => 1,
			)	
	),
	
	
);

t3lib_extMgm::addStaticFile($_EXTKEY,"static/","Frontend User Enhanced");

t3lib_div::loadTCA('fe_users');
t3lib_extMgm::addTCAcolumns('fe_users',$tempColumns,1);
//t3lib_extMgm::addToAllTCAtypes('fe_users','tx_itaozfaregister_companyname;;;;1-1-1, tx_itaozfaregister_numberofemployees, tx_itaozfaregister_note, tx_itaozfaregister_accepted');


t3lib_extMgm::addToAllTCAtypes('fe_users','--div--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_flexformlabel,tx_itaozfaregister_companyname;;;;1-1-1, tx_itaozfaregister_numberofemployees, tx_itaozfaregister_numberofemployees_offline, tx_itaozfaregister_ceofirstname, tx_itaozfaregister_ceolastname, tx_itaozfaregister_accepted, tx_itaozfaregister_note,  tx_itaozfaregister_parentuser, tx_itaozfaregister_status'); #tx_itaozfaregister_is_parent,



$TCA['fe_users']['columns']['email']['config']['eval'] = 'required,trim';  #,tx_emailval_mapping
$TCA['fe_users']['columns']['first_name']['config']['eval'] = 'required,trim';
$TCA['fe_users']['columns']['last_name']['config']['eval'] = 'required,trim';
$TCA['fe_users']['columns']['address']['config']['eval'] = 'required,trim';
$TCA['fe_users']['columns']['zip']['config']['eval'] = 'required,trim';
$TCA['fe_users']['columns']['city']['config']['eval'] = 'required,trim';
$TCA['fe_users']['columns']['password']['config']['eval'] = 'nospace,required,password';
#$TCA['fe_users']['columns']['tx_itaozfaregister_numberofemployees']['config']['eval'] = 'required,int';
$TCA['fe_users']['columns']['date_of_birth']['exclude'] = 1;

$TCA['fe_users']['columns']['address']['config']['cols'] = '30';
$TCA['fe_users']['columns']['address']['config']['rows'] = '5';
$TCA['fe_users']['columns']['www']['config']['size'] = '30';
$TCA['fe_users']['columns']['city']['config']['size'] = '30';
$TCA['fe_users']['columns']['first_name']['config']['size'] = '15';
$TCA['fe_users']['columns']['last_name']['config']['size'] = '25';
$TCA['fe_users']['columns']['email']['config']['size'] = '30';
$TCA['fe_users']['columns']['comments']['config']['cols'] = '40';
$TCA['fe_users']['columns']['comments']['config']['rows'] = '5';
$TCA['fe_users']['columns']['comments']['config']['type'] = 'text';

$TCA['fe_users']['columns']['username']['exclude'] = 1;
$TCA['fe_users']['columns']['password']['exclude'] = 1;
$TCA['fe_users']['columns']['tx_itaozfalogin_changepassword']['exclude'] = 1;
$TCA['fe_users']['columns']['usergroup']['exclude'] = 1;
$TCA['fe_users']['columns']['tx_itaozfaregister_is_parent']['exclude'] = 1;


$TCA['fe_users']['columns']['cnum']['exclude'] = 1;
$TCA['fe_users']['columns']['status']['exclude'] = 1;
$TCA['fe_users']['columns']['zone']['exclude'] = 1;
$TCA['fe_users']['columns']['static_info_country']['exclude'] = 1;
$TCA['fe_users']['columns']['country']['exclude'] = 1;
$TCA['fe_users']['columns']['language']['exclude'] = 1;
$TCA['fe_users']['columns']['by_invitation']['exclude'] = 1;

# damit das Feld "offline-anzahl-mitarbeiter" nur angezeigt wird, wenn beim Kunden die Datenerhebung noch NICHT gestartet wurde.
$status = ($_GET['status']) ? $_GET['status'] : 0;
$is_admin = ($_GET['is_admin']) ? $_GET['is_admin'] : 0;
if (!$is_admin) {
	if ($status >= 4) {
		#unset($TCA['fe_users']['columns']['tx_itaozfaregister_numberofemployees_offline']);
		# das hat zur Folge, dass das Feld nur angezeigt wird, aber nicht mehr editable ist.
		$TCA['fe_users']['columns']['tx_itaozfaregister_numberofemployees_offline']['config']['type'] = 'none';
	}
}



# für Text neben Checkbox:
/*
	$TCA['fe_users']['columns']['module_sys_dmail_newsletter']['label'] = 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.module_sys_dmail_newsletter_empty';	
	$TCA['fe_users']['columns']['module_sys_dmail_newsletter']['config']['items'][1][0] = 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.module_sys_dmail_newsletternew';	
	
	$TCA['fe_users']['columns']['module_sys_dmail_html']['label'] = 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.module_sys_dmail_html_empty';
	$TCA['fe_users']['columns']['module_sys_dmail_html']['config']['items'][1][0] = 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.module_sys_dmail_htmlnew';
*/
	
	$TCA['fe_users']['columns']['disable']['label'] = 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.disable_empty';
	$TCA['fe_users']['columns']['disable']['config']['items'][1][0] = 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.disablenew';
	
#	$TCA['fe_users']['columns']['tx_itaozfalogin_changepassword'] = '';


# andere Std-Bezeichnung:

$TCA['fe_users']['columns']['www']['label'] = 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.www';
$TCA['fe_users']['columns']['address']['label'] = 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.addressnew';
$TCA['fe_users']['columns']['city']['label'] = 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.citynew';
$TCA['fe_users']['columns']['comments']['label'] = 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.commentsnew';

$TCA['fe_users']['columns']['starttime']['label'] = 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.starttimenew';
$TCA['fe_users']['columns']['endtime']['label'] = 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.endtimenew';

#$TCA['fe_users']['columns']['module_sys_dmail_newsletter']['label'] = 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.module_sys_dmail_newsletternew';
#$TCA['fe_users']['columns']['module_sys_dmail_html']['label'] = 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.module_sys_dmail_htmlnew';


/*
$TCA['fe_users']['types'][0]['showitem'] = '--palette--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.palette_account.title;account,usergroup,
	--palette--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.palette_isparent.title;isparent,

--div--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_flexformlabel,
	--palette--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.palette_company.title;company,
	--palette--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.palette_ceodata.title;ceodata,
	--palette--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.palette_address.title;addressdata,
	       

--div--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_flexformlabel_contact,
	--palette--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.palette_contact.title;contactdata, 
 	comments, tx_itaozfaregister_accepted, 
	--palette--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.palette_newsletter.title;newsletterdata, 
 
--div--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_flexformlabel_sonst, 
	--palette--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.palette_status.title;statusdata, tx_itaozfadatamanager_refpruefer,tx_itaozfaregister_note,

--div--;LLL:EXT:cms/locallang_tca.xml:fe_users.tabs.access,
	--palette--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.palette_access.title;accessdata,
	--palette--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.palette_time.title;timedata,
   

--div--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_flexformlabel_sonstPerData, company;;1;;1-1-1,cnum,   status, date_of_birth, zone, static_info_country, country,language,fax, by_invitation, image;;;;2-2-2, 
--div--;LLL:EXT:cms/locallang_tca.xml:fe_users.tabs.options, lockToDomain;;;;1-1-1, TSconfig;;;;2-2-2, 
--div--;LLL:EXT:cms/locallang_tca.xml:fe_users.tabs.extended, tx_extbase_type, felogin_redirectPid;;;;1-1-1,tx_datamintsfeuser_approval_level;;;;1-1-1, 
--div--;LLL:EXT:datamints_feuser/locallang_db.xml:tt_content.list_type_pi1

';*/


$TCA['fe_users']['types'][0]['showitem'] = '
--div--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_flexformlabel,
	--palette--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.palette_company.title;company,
	--palette--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.palette_ceodata.title;ceodata,
	--palette--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.palette_address.title;addressdata,   



--div--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_flexformlabel_allgemeines,
--palette--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.palette_account.title;account,usergroup,
	--palette--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.palette_isparent.title;isparent,

 

--div--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_flexformlabel_contact,
	--palette--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.palette_contact.title;contactdata, 
 	comments, tx_itaozfaregister_accepted, 
	--palette--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.palette_newsletter.title;newsletterdata, 
 
--div--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_flexformlabel_sonst, 
	--palette--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.palette_status.title;statusdata, tx_itaozfadatamanager_refpruefer,tx_itaozfaregister_note,

--div--;LLL:EXT:cms/locallang_tca.xml:fe_users.tabs.access,
	--palette--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.palette_access.title;accessdata,
	--palette--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.palette_time.title;timedata,
   

--div--;LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfaregister_flexformlabel_sonstPerData, company;;1;;1-1-1, country,fax, image;;;;2-2-2, 
--div--;LLL:EXT:cms/locallang_tca.xml:fe_users.tabs.options, lockToDomain;;;;1-1-1, TSconfig;;;;2-2-2, 
--div--;LLL:EXT:cms/locallang_tca.xml:fe_users.tabs.extended, tx_extbase_type, felogin_redirectPid;;;;1-1-1,tx_datamintsfeuser_approval_level;;;;1-1-1, 
--div--;LLL:EXT:datamints_feuser/locallang_db.xml:tt_content.list_type_pi1

'; 
#cnum,   status, date_of_birth, zone, static_info_country,language, by_invitation,
 


#tx_datamintsfeuser_firstname, tx_datamintsfeuser_surname, name;;2;;2-2-2, telephone, 
$TCA['fe_users']['palettes'][2] = array();#['showitem'] = '';
$TCA['fe_users']['palettes']['account']['canNotCollapse'] = 1;
$TCA['fe_users']['palettes']['account']['showitem'] = 'username, lastlogin, --linebreak--,password,tx_itaozfalogin_changepassword';

$TCA['fe_users']['palettes']['isparent']['canNotCollapse'] = 1;
$TCA['fe_users']['palettes']['isparent']['showitem'] = 'tx_itaozfaregister_parentuser'; #tx_itaozfaregister_is_parent,--linebreak--,

$TCA['fe_users']['palettes']['company']['canNotCollapse'] = 1;
$TCA['fe_users']['palettes']['company']['showitem'] = 'tx_itaozfaregister_companyname,tx_itaozfaregister_numberofemployees,--linebreak--, www,tx_itaozfaregister_numberofemployees_offline';

$TCA['fe_users']['palettes']['ceodata']['canNotCollapse'] = 1;
$TCA['fe_users']['palettes']['ceodata']['showitem'] = 'tx_itaozfaregister_ceofirstname, tx_itaozfaregister_ceolastname';

$TCA['fe_users']['palettes']['addressdata']['canNotCollapse'] = 1;
$TCA['fe_users']['palettes']['addressdata']['showitem'] = 'address,--linebreak--,zip, city';

$TCA['fe_users']['palettes']['contactdata']['canNotCollapse'] = 1;
$TCA['fe_users']['palettes']['contactdata']['showitem'] = 'first_name, last_name, --linebreak--,email, telephone';
/*
$TCA['fe_users']['palettes']['newsletterdata']['canNotCollapse'] = 1;
$TCA['fe_users']['palettes']['newsletterdata']['showitem'] = 'module_sys_dmail_newsletter,module_sys_dmail_category,module_sys_dmail_html';
*/
$TCA['fe_users']['palettes']['statusdata']['canNotCollapse'] = 1;
$TCA['fe_users']['palettes']['statusdata']['showitem'] = 'tx_itaozfaregister_vertragstatus,tx_itaozfaregister_rechnungstatus,  --linebreak--,tx_itaozfaregister_status, tx_itaozfaregister_erhebung,--linebreak--,tx_itaozfaregister_zertstatus';

$TCA['fe_users']['palettes']['accessdata']['canNotCollapse'] = 1;
$TCA['fe_users']['palettes']['accessdata']['showitem'] = ' disable';

$TCA['fe_users']['palettes']['timedata']['canNotCollapse'] = 1;
$TCA['fe_users']['palettes']['timedata']['showitem'] = 'starttime, endtime,';



$TCA['fe_users']['columns']['tx_itaozfaregister_numberofemployees_offline']['config']['eval'] .= ',tx_check_offlines';
$TYPO3_CONF_VARS['SC_OPTIONS']['tce']['formevals']['tx_check_offlines'] = 'EXT:itao_zfa_datamanager/class.tx_check_offlines.php';

$TCA['fe_users']['columns']['tx_itaozfaregister_numberofemployees']['config']['eval'] .= ',tx_check_offlines_ges';
$TYPO3_CONF_VARS['SC_OPTIONS']['tce']['formevals']['tx_check_offlines_ges'] = 'EXT:itao_zfa_datamanager/class.tx_check_offlines_ges.php';

 

?>