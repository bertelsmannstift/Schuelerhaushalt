<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Pi1',
	array(
		'Download' => 'list, show, new, create, edit, update, delete',
		'Category' => 'list, show, new, create, edit, update, delete',
		
	),
	array(
		'Download' => 'create, update, delete',
		'Category' => 'create, update, delete',
		
	)
);

?>