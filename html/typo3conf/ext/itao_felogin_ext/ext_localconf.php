<?php

if (!defined ('TYPO3_MODE'))
    die ('Access denied.');
 
	$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['forgotPasswordMail'][] = 'tx_itaofeloginext_pi1->msg_in_utf8';
	$TYPO3_CONF_VARS['FE']['XCLASS']['ext/felogin/pi1/class.tx_felogin_pi1.php'] = t3lib_extMgm::extPath($_EXTKEY).'class.ux_tx_felogin_pi1.php';
	$TYPO3_CONF_VARS['MAIL']['transport'] = 'sendmail';
	
?>

