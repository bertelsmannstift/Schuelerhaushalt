<?php
if (!defined ('TYPO3_MODE')){
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Pi1',
	'itao Download'
);

// Use of $_EXTKEY does not work with underscores ...
$extensionName = t3lib_div::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature_pi1 = strtolower($extensionName) . '_pi1';

$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature_pi1] = 'pi_flexform';;
t3lib_extMgm::addPiFlexFormValue($pluginSignature_pi1, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_pi1.xml');



/*
if (TYPO3_MODE === 'BE') {

	// Registers a Backend Module
	
	Tx_Extbase_Utility_Extension::registerModule(
		$_EXTKEY,
		'user',	 // Make module a submodule of 'web'
		'mod1',	// Submodule key
		'',						// Position
		array(
			'Download' => 'list, show, new, create, edit, update, delete',
			'Category' => 'list, show, new, create, edit, update, delete',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod1.xml',
		)
	);

}
*/

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'itao Download');


t3lib_extMgm::addLLrefForTCAdescr('tx_itaodownload_domain_model_download', 'EXT:itao_download/Resources/Private/Language/locallang_csh_tx_itaodownload_domain_model_download.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_itaodownload_domain_model_download');
$TCA['tx_itaodownload_domain_model_download'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:itao_download/Resources/Private/Language/locallang_db.xml:tx_itaodownload_domain_model_download',
		'label' 			=> 'title',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'dividers2tabs' => true,
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l10n_parent',
		'transOrigDiffSourceField' 	=> 'l10n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Download.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_itaodownload_domain_model_download.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_itaodownload_domain_model_category', 'EXT:itao_download/Resources/Private/Language/locallang_csh_tx_itaodownload_domain_model_category.xml');
t3lib_extMgm::allowTableOnStandardPages('tx_itaodownload_domain_model_category');
$TCA['tx_itaodownload_domain_model_category'] = array(
	'ctrl' => array(
		'title'				=> 'LLL:EXT:itao_download/Resources/Private/Language/locallang_db.xml:tx_itaodownload_domain_model_category',
		'label' 			=> 'title',
		'tstamp' 			=> 'tstamp',
		'crdate' 			=> 'crdate',
		'dividers2tabs' => true,
		'versioningWS' 		=> 2,
		'versioning_followPages'	=> TRUE,
		'origUid' 			=> 't3_origuid',
		'languageField' 	=> 'sys_language_uid',
		'transOrigPointerField' 	=> 'l10n_parent',
		'transOrigDiffSourceField' 	=> 'l10n_diffsource',
		'delete' 			=> 'deleted',
		'enablecolumns' 	=> array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
			),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Category.php',
		'iconfile' 			=> t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_itaodownload_domain_model_category.gif'
	),
);

?>