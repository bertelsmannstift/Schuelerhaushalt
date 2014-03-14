<?php

########################################################################
# Extension Manager/Repository config file for ext "itao_download".
#
# Auto generated 16-10-2012 12:19
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'itao Download',
	'description' => 'This extensions allows you to offer several file types as download for FE User.',
	'category' => 'plugin',
	'author' => 'Peter Rauer',
	'author_email' => 'peter.rauer@itao.de',
	'author_company' => 'itao GmbH & Co. KG',
	'shy' => '',
	'dependencies' => 'cms,extbase,fluid',
	'conflicts' => '',
	'priority' => '',
	'module' => '',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 1,
	'createDirs' => 'uploads/tx_itao_download/',
	'modify_tables' => '',
	'clearCacheOnLoad' => 0,
	'lockType' => '',
	'version' => '0.0.1',
	'constraints' => array(
		'depends' => array(
			'cms' => '',
			'extbase' => '',
			'fluid' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'suggests' => array(
	),
	'_md5_values_when_last_written' => 'a:60:{s:13:"Changelog.txt";s:4:"edbf";s:12:"ext_icon.gif";s:4:"da64";s:17:"ext_localconf.php";s:4:"2b09";s:14:"ext_tables.php";s:4:"619f";s:14:"ext_tables.sql";s:4:"032c";s:16:"kickstarter.json";s:4:"e7f5";s:41:"Classes/Controller/CategoryController.php";s:4:"ea4c";s:41:"Classes/Controller/DownloadController.php";s:4:"6a53";s:33:"Classes/Domain/Model/Category.php";s:4:"4991";s:33:"Classes/Domain/Model/Download.php";s:4:"8b69";s:48:"Classes/Domain/Repository/CategoryRepository.php";s:4:"7dbc";s:48:"Classes/Domain/Repository/DownloadRepository.php";s:4:"1ced";s:40:"Configuration/FlexForms/flexform_pi1.xml";s:4:"f480";s:30:"Configuration/TCA/Category.php";s:4:"850d";s:30:"Configuration/TCA/Download.php";s:4:"6b37";s:38:"Configuration/TypoScript/constants.txt";s:4:"00d6";s:34:"Configuration/TypoScript/setup.txt";s:4:"dc53";s:46:"Resources/Private/Backend/Layouts/Default.html";s:4:"2df8";s:50:"Resources/Private/Backend/Partials/FormErrors.html";s:4:"f5bc";s:58:"Resources/Private/Backend/Partials/Category/EmbedList.html";s:4:"4929";s:59:"Resources/Private/Backend/Partials/Category/FormFields.html";s:4:"2ff2";s:59:"Resources/Private/Backend/Partials/Category/Properties.html";s:4:"8b32";s:59:"Resources/Private/Backend/Partials/Download/FormFields.html";s:4:"f799";s:59:"Resources/Private/Backend/Partials/Download/Properties.html";s:4:"1c75";s:54:"Resources/Private/Backend/Templates/Category/Edit.html";s:4:"017f";s:54:"Resources/Private/Backend/Templates/Category/List.html";s:4:"234a";s:53:"Resources/Private/Backend/Templates/Category/New.html";s:4:"a070";s:54:"Resources/Private/Backend/Templates/Category/Show.html";s:4:"8e84";s:54:"Resources/Private/Backend/Templates/Download/Edit.html";s:4:"5ace";s:54:"Resources/Private/Backend/Templates/Download/List.html";s:4:"6f0c";s:53:"Resources/Private/Backend/Templates/Download/New.html";s:4:"d64c";s:54:"Resources/Private/Backend/Templates/Download/Show.html";s:4:"84e3";s:40:"Resources/Private/Language/locallang.xml";s:4:"f756";s:43:"Resources/Private/Language/locallang_be.xml";s:4:"ab9d";s:82:"Resources/Private/Language/locallang_csh_tx_itaodownload_domain_model_category.xml";s:4:"e540";s:82:"Resources/Private/Language/locallang_csh_tx_itaodownload_domain_model_download.xml";s:4:"6de8";s:43:"Resources/Private/Language/locallang_db.xml";s:4:"2bfe";s:53:"Resources/Private/Language/locallang_flexform_pi1.xml";s:4:"0c28";s:45:"Resources/Private/Language/locallang_mod1.xml";s:4:"c79c";s:38:"Resources/Private/Layouts/Default.html";s:4:"4626";s:42:"Resources/Private/Partials/FormErrors.html";s:4:"f5bc";s:51:"Resources/Private/Partials/Category/FormFields.html";s:4:"2ff2";s:51:"Resources/Private/Partials/Category/Properties.html";s:4:"8b32";s:51:"Resources/Private/Partials/Download/FormFields.html";s:4:"5298";s:51:"Resources/Private/Partials/Download/Properties.html";s:4:"1c75";s:46:"Resources/Private/Templates/Category/Edit.html";s:4:"fb71";s:46:"Resources/Private/Templates/Category/List.html";s:4:"93d3";s:45:"Resources/Private/Templates/Category/New.html";s:4:"fb7f";s:46:"Resources/Private/Templates/Category/Show.html";s:4:"5174";s:46:"Resources/Private/Templates/Download/Edit.html";s:4:"fc76";s:46:"Resources/Private/Templates/Download/List.html";s:4:"d618";s:45:"Resources/Private/Templates/Download/New.html";s:4:"9e6c";s:46:"Resources/Private/Templates/Download/Show.html";s:4:"38a8";s:30:"Resources/Public/CSS/style.css";s:4:"14be";s:35:"Resources/Public/Icons/relation.gif";s:4:"e615";s:64:"Resources/Public/Icons/tx_itaodownload_domain_model_category.gif";s:4:"905a";s:64:"Resources/Public/Icons/tx_itaodownload_domain_model_download.gif";s:4:"da64";s:29:"Resources/Public/Js/script.js";s:4:"0b3a";s:35:"Tests/Domain/Model/CategoryTest.php";s:4:"82cf";s:35:"Tests/Domain/Model/DownloadTest.php";s:4:"60a6";}',
);

?>