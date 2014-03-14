<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

if (TYPO3_MODE == 'BE') {
	$GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['XCLASS']['ext/cms/layout/class.tx_cms_layout.php']
		= t3lib_extMgm::extPath($_EXTKEY) . 'Classes/XClass/class.ux_tx_cms_layout.php';

	$GLOBALS['TYPO3_CONF_VARS'][TYPO3_MODE]['AJAX']['Dragdrop::changeOrderAction']
		= 'EXT:dragdrop/Classes/class.tx_dragdrop.php:tx_dragdrop->changeOrderAction';
}
?>