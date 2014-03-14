<?php 
	if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
	$TYPO3_CONF_VARS['FE']['XCLASS']['ext/datamints_feuser/pi1/class.tx_datamintsfeuser_pi1.php'] = t3lib_extMgm::extPath($_EXTKEY)."class.ux_tx_datamintsfeuser_pi1.php";
	
	
	#$TYPO3_CONF_VARS['SC_OPTIONS']['tce']['formevals']['tx_emailval_mapping'] = 'EXT:itao_zfaregister/class.tx_emailval_mapping.php'; 
	
?>