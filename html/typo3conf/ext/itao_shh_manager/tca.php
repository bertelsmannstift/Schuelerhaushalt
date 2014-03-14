<?php

if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

$TCA['tx_itaoshhmanager_communes'] = array(
	'ctrl' => $TCA['tx_itaoshhmanager_communes']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden,fe_group,titel,c_short,ref_state'
	),
	'feInterface' => $TCA['tx_itaoshhmanager_communes']['feInterface'],
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
				'default' => '0'
			)
		),
		'fe_group' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
					array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
					array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
				),
				'foreign_table' => 'fe_groups'
			)
		),
		'titel' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_communes.titel',
			'config' => array(
				'type' => 'input',
				'size' => '30',
				'eval' => 'required',
			)
		),
		'c_short' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_communes.c_short',
			'config' => array(
				'type' => 'input',
				'size' => '13',
				'eval' => 'required',
				'max' => 11,
			)
		),
		'headerimage' => Array(
			'exclude' => 1,
			'l10n_mode' => $l10n_mode_image,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_communes.headerimage',
			'config' => Array(
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size' => '10000',
				'uploadfolder' => 'uploads/media',
				'show_thumbs' => '1',
				'size' => 1,
				'autoSizeMax' => 15,
				'maxitems' => '1',
				'minitems' => '0'
			)
		),
		'ref_state' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_communes.ref_state',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_itaoshhmanager_bls',
				'foreign_table_where' => 'ORDER BY tx_itaoshhmanager_bls.uid',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'ref_communepage' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_communes.ref_communepage',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'hidden;;1;;1-1-1, titel,c_short, headerimage,  ref_state,ref_communepage')
	),
	'palettes' => array(
		'1' => array('showitem' => 'fe_group')
	)
); #ref_contactperson, ref_download,imprint;;;richtext[]:rte_transform[mode=ts],infotext;;;richtext[]:rte_transform[mode=ts],welcometext;;;richtext[]:rte_transform[mode=ts], downloadurl,  youtubelink,   headerimage,



$TCA['tx_itaoshhmanager_bls'] = array(
	'ctrl' => $TCA['tx_itaoshhmanager_bls']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden,title,bl_short'
	),
	'feInterface' => $TCA['tx_itaoshhmanager_bls']['feInterface'],
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
				'default' => '0'
			)
		),
		'title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_bls.title',
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'bl_short' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_bls.bl_short',
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'hidden;;1;;1-1-1, title;;;;2-2-2, bl_short;;;;3-3-3')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);


$communeid = ($_GET['communeid']) ? $_GET['communeid'] : 0;

$TCA['tx_itaoshhmanager_schools'] = array(
	'ctrl' => $TCA['tx_itaoshhmanager_schools']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden,fe_group,title,s_short, welcometext,ref_contactperson,ref_sortedoffers, ref_myoffers,ref_createoffer, resultpage'
	),
	'feInterface' => $TCA['tx_itaoshhmanager_schools']['feInterface'],
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
				'default' => '0'
			)
		),
		'fe_group' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
					array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
					array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
				),
				'foreign_table' => 'fe_groups'
			)
		),
		'title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_schools.title',
			'config' => array(
				'type' => 'input',
				'size' => '30',
				'eval' => 'required',
			)
		),
		's_short' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_schools.s_short',
			'config' => array(
				'type' => 'input',
				'size' => '13',
				'eval' => 'required',
				'max' => 11,
			)
		),
		'zip' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_schools.zip',
			'config' => array(
				'type' => 'input',
				'size' => '30',
				'eval' => '',
			)
		),
		'city' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_schools.city',
			'config' => array(
				'type' => 'input',
				'size' => '30',
				'eval' => '',
			)
		),
		'headerimage' => Array(
			'exclude' => 1,
			'l10n_mode' => $l10n_mode_image,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_schools.headerimage',
			'config' => Array(
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'max_size' => '10000',
				'uploadfolder' => 'uploads/media',
				'show_thumbs' => '1',
				'size' => 1,
				'autoSizeMax' => 15,
				'maxitems' => '1',
				'minitems' => '0'
			)
		),
		'ref_status' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_schools.ref_status',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_itaoshhmanager_status_school',
				'foreign_table_where' => ' and tx_itaoshhmanager_status_school.hidden=0 ORDER BY tx_itaoshhmanager_status_school.uid',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
				'default' => 1,
				'iconsInOptionTags' => 0,
				'noIconsBelowSelect' => 1,
			)
		),
		'ref_fegroup' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_schools.ref_fegroup',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'fe_groups',
				'foreign_table_where' => ' and fe_groups.hidden=0 ORDER BY fe_groups.title',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
				'default' => 1,
				'iconsInOptionTags' => 0,
				'noIconsBelowSelect' => 1,
			)
		),
		'ref_commune' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_schools.ref_commune',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_itaoshhmanager_communes',
				'foreign_table_where' => 'ORDER BY tx_itaoshhmanager_communes.titel',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
				'default' => $communeid,
			)
		),
		'resultpage' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_schools.resultpage',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'ref_schoolpage' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_schools.ref_schoolpage',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'ref_mp_schoolstartpage' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_schools.ref_mp_schoolstartpage',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'ref_sortedoffers' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_schools.ref_sortedoffers',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1
			)
		),
		'ref_myoffers' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_schools.ref_myoffers',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1
			)
		),
		'ref_createoffer' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_schools.ref_createoffer',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1
			)
		),
		'number_of_result_offers' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_schools.number_of_result_offers',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'trim,int',
				'default' => 5
			),
		),
		'offer_automatically_approved' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_schools.offer_automatically_approved',
			'config' => array(
				'type' => 'check',
				'default' => '1'
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'hidden;;1;;1-1-1, title;;;;2-2-2,s_short,ref_schoolpage, headerimage, ref_status, ref_commune,ref_mp_schoolstartpage,ref_sortedoffers, ref_myoffers,ref_createoffer, resultpage,ref_fegroup,number_of_result_offers,offer_automatically_approved')
	),
	'palettes' => array(
		'1' => array('showitem' => 'fe_group')
	)
); #ref_contactperson, zip, city,


$TCA['tx_itaozfadatamanager_status_kunde'] = array(
	'ctrl' => $TCA['tx_itaozfadatamanager_status_kunde']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden,title'
	),
	'feInterface' => $TCA['tx_itaozfadatamanager_status_kunde']['feInterface'],
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
				'default' => '0'
			)
		),
		'title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_zfa_datamanager/locallang_db.xml:tx_itaozfadatamanager_status_kunde.title',
			'config' => array(
				'type' => 'input',
				'size' => '30',
				'eval' => 'required',
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'hidden;;1;;1-1-1, title;;;;2-2-2')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);


$TCA['tx_itaoshhmanager_status_school'] = array(
	'ctrl' => $TCA['tx_itaoshhmanager_status_school']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden,title'
	),
	'feInterface' => $TCA['tx_itaoshhmanager_status_school']['feInterface'],
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
				'default' => '0'
			)
		),
		'title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_status_school.title',
			'config' => array(
				'type' => 'input',
				'size' => '30',
				'eval' => 'required',
			)
		),
		'st_image' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_status_school.st_image',
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
		'ordernr' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_status_school.ordernr',
			'config' => array(
				'type' => 'input',
				'size' => '30',
			)
		),
	),
	'types' => array(
		'0' => array('showitem' => 'hidden;;1;;1-1-1, title;;;;2-2-2,st_image,ordernr')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);


$TCA['tx_itaoshhmanager_resultanz'] = array(
	'ctrl' => $TCA['tx_itaoshhmanager_resultanz']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden,number_of_result_offers'
	),
	'feInterface' => $TCA['tx_itaoshhmanager_resultanz']['feInterface'],
	'columns' => array(
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
				'default' => '0'
			)
		),
		'ref_schoolid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_schools.title',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_itaoshhmanager_schools',
				'foreign_table_where' => 'ORDER BY tx_itaoshhmanager_schools.title',
				'size' => 1,
				'minitems' => 0,
				'maxitems' => 1,
				'default' => $communeid,
			)
		),
		'number_of_result_offers' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_schools.number_of_result_offers',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'trim,int',
				'default' => 5
			),
		),
	),
	'types' => array(
		'0' => array('showitem' => 'hidden;;1;;1-1-1, number_of_result_offers;;;;2-2-2,ref_schoolid')
	),
	'palettes' => array(
		'1' => array('showitem' => '')
	)
);

?>