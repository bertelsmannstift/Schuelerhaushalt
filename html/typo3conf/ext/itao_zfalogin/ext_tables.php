<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
$tempColumns = array (
	'tx_itaozfalogin_changepassword' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:itao_zfalogin/locallang_db.xml:fe_users.tx_itaozfalogin_changepassword',		
		'config' => array (
			'type' => 'check',		
			'items' => array(
				'1' => array(
					'0' => 'LLL:EXT:itao_zfaregister/locallang_db.xml:fe_users.tx_itaozfalogin_changepassword_label'
				)
			) 
		)
	),
);

//t3lib_extMgm::addStaticFile($_EXTKEY,"static/","Frontend User Login Enhanced");

t3lib_div::loadTCA('fe_users');
t3lib_extMgm::addTCAcolumns('fe_users',$tempColumns,1);
#t3lib_extMgm::addToAllTCAtypes('fe_users','--div--;LLL:EXT:itao_zfalogin/locallang_db.xml:fe_users.tx_itaozfalogin_flexformlabel,tx_itaozfalogin_changepassword');
?>