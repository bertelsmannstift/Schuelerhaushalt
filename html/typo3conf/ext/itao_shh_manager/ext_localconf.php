<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_itaoshhmanager_communes=0
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_itaoshhmanager_bls=1
');
t3lib_extMgm::addUserTSConfig('
	options.saveDocNew.tx_itaoshhmanager_schools=0
');
?>