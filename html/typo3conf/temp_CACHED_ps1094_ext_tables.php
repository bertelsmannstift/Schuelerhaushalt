<?php

###########################
## EXTENSION: cms
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/cms/ext_tables.php
###########################

$_EXTKEY = 'cms';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE'))	die ('Access denied.');


if (TYPO3_MODE == 'BE') {
	t3lib_extMgm::addModule('web','layout','top',t3lib_extMgm::extPath($_EXTKEY).'layout/');
	t3lib_extMgm::addLLrefForTCAdescr('_MOD_web_layout','EXT:cms/locallang_csh_weblayout.xml');
	t3lib_extMgm::addLLrefForTCAdescr('_MOD_web_info','EXT:cms/locallang_csh_webinfo.xml');

	t3lib_extMgm::insertModuleFunction(
		'web_info',
		'tx_cms_webinfo_page',
		t3lib_extMgm::extPath($_EXTKEY).'web_info/class.tx_cms_webinfo.php',
		'LLL:EXT:cms/locallang_tca.xml:mod_tx_cms_webinfo_page'
	);
	t3lib_extMgm::insertModuleFunction(
		'web_info',
		'tx_cms_webinfo_lang',
		t3lib_extMgm::extPath($_EXTKEY).'web_info/class.tx_cms_webinfo_lang.php',
		'LLL:EXT:cms/locallang_tca.xml:mod_tx_cms_webinfo_lang'
	);
}


	// Add allowed records to pages:
t3lib_extMgm::allowTableOnStandardPages('pages_language_overlay,tt_content,sys_template,sys_domain,backend_layout');


// ******************************************************************
// This is the standard TypoScript content table, tt_content
// ******************************************************************
$TCA['tt_content'] = array (
	'ctrl' => array (
		'label' => 'header',
		'label_alt' => 'subheader,bodytext',
		'sortby' => 'sorting',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'title' => 'LLL:EXT:cms/locallang_tca.xml:tt_content',
		'delete' => 'deleted',
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'type' => 'CType',
		'hideAtCopy' => TRUE,
		'prependAtCopy' => 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'copyAfterDuplFields' => 'colPos,sys_language_uid',
		'useColumnsForDefaultValues' => 'colPos,sys_language_uid',
		'shadowColumnsForNewPlaceholders' => 'colPos',
		'transOrigPointerField' => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
		'languageField' => 'sys_language_uid',
		'enablecolumns' => array (
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
			'fe_group' => 'fe_group',
		),
		'typeicon_column' => 'CType',
		'typeicon_classes' => array(
			'header' => 'mimetypes-x-content-header',
			'textpic' => 'mimetypes-x-content-text-picture',
			'image' => 'mimetypes-x-content-image',
			'bullets' => 'mimetypes-x-content-list-bullets',
			'table' => 'mimetypes-x-content-table',
			'splash' => 'mimetypes-x-content-splash',
			'uploads' => 'mimetypes-x-content-list-files',
			'multimedia' => 'mimetypes-x-content-multimedia',
			'media' => 'mimetypes-x-content-multimedia',
			'menu' => 'mimetypes-x-content-menu',
			'list' => 'mimetypes-x-content-plugin',
			'mailform' => 'mimetypes-x-content-form',
			'search' => 'mimetypes-x-content-form-search',
			'login' => 'mimetypes-x-content-login',
			'shortcut' => 'mimetypes-x-content-link',
			'script' => 'mimetypes-x-content-script',
			'div' => 'mimetypes-x-content-divider',
			'html' => 'mimetypes-x-content-html',
			'text' => 'mimetypes-x-content-text',
			'default' => 'mimetypes-x-content-text',
		),
		'typeicons' => array (
			'header' => 'tt_content_header.gif',
			'textpic' => 'tt_content_textpic.gif',
			'image' => 'tt_content_image.gif',
			'bullets' => 'tt_content_bullets.gif',
			'table' => 'tt_content_table.gif',
			'splash' => 'tt_content_news.gif',
			'uploads' => 'tt_content_uploads.gif',
			'multimedia' => 'tt_content_mm.gif',
			'media' => 'tt_content_mm.gif',
			'menu' => 'tt_content_menu.gif',
			'list' => 'tt_content_list.gif',
			'mailform' => 'tt_content_form.gif',
			'search' => 'tt_content_search.gif',
			'login' => 'tt_content_login.gif',
			'shortcut' => 'tt_content_shortcut.gif',
			'script' => 'tt_content_script.gif',
			'div' => 'tt_content_div.gif',
			'html' => 'tt_content_html.gif'
		),
		'thumbnail' => 'image',
		'requestUpdate' => 'list_type,rte_enabled,menu_type',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tbl_tt_content.php',
		'dividers2tabs' => 1,
		'searchFields' => 'header,header_link,subheader,bodytext,pi_flexform',
	)
);

// ******************************************************************
// fe_users
// ******************************************************************
$TCA['fe_users'] = array (
	'ctrl' => array (
		'label' => 'username',
		'default_sortby' => 'ORDER BY username',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'fe_cruser_id' => 'fe_cruser_id',
		'title' => 'LLL:EXT:cms/locallang_tca.xml:fe_users',
		'delete' => 'deleted',
		'enablecolumns' => array (
			'disabled' => 'disable',
			'starttime' => 'starttime',
			'endtime' => 'endtime'
		),
		'typeicon_classes' => array(
			'default' => 'status-user-frontend',
		),
		'useColumnsForDefaultValues' => 'usergroup,lockToDomain,disable,starttime,endtime',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tbl_cms.php',
		'dividers2tabs' => 1,
		'searchFields' => 'username,name,first_name,last_name,middle_name,address,telephone,fax,email,title,zip,city,country,company',
	),
	'feInterface' => array (
		'fe_admin_fieldList' => 'username,password,usergroup,name,address,telephone,fax,email,title,zip,city,country,www,company',
	)
);

// ******************************************************************
// fe_groups
// ******************************************************************
$TCA['fe_groups'] = array (
	'ctrl' => array (
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'delete' => 'deleted',
		'prependAtCopy' => 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'enablecolumns' => array (
			'disabled' => 'hidden'
		),
		'title' => 'LLL:EXT:cms/locallang_tca.xml:fe_groups',
		'typeicon_classes' => array(
			'default' => 'status-user-group-frontend',
		),
		'useColumnsForDefaultValues' => 'lockToDomain',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tbl_cms.php',
		'dividers2tabs' => 1,
		'searchFields' => 'title,description',
	)
);

// ******************************************************************
// sys_domain
// ******************************************************************
$TCA['sys_domain'] = array (
	'ctrl' => array (
		'label' => 'domainName',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',
		'title' => 'LLL:EXT:cms/locallang_tca.xml:sys_domain',
		'iconfile' => 'domain.gif',
		'enablecolumns' => array (
			'disabled' => 'hidden'
		),
		'typeicon_classes' => array(
			'default' => 'mimetypes-x-content-domain',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tbl_cms.php',
		'searchFields' => 'domainName,redirectTo',
	)
);

// ******************************************************************
// pages_language_overlay
// ******************************************************************
$TCA['pages_language_overlay'] = array (
	'ctrl' => array (
		'label'                           => 'title',
		'tstamp'                          => 'tstamp',
		'title'                           => 'LLL:EXT:cms/locallang_tca.xml:pages_language_overlay',
		'versioningWS'                    => TRUE,
		'versioning_followPages'          => TRUE,
		'origUid'                         => 't3_origuid',
		'crdate'                          => 'crdate',
		'cruser_id'                       => 'cruser_id',
		'delete'                          => 'deleted',
		'enablecolumns'                   => array (
			'disabled'  => 'hidden',
			'starttime' => 'starttime',
			'endtime'   => 'endtime'
		),
		'transOrigPointerField'           => 'pid',
		'transOrigPointerTable'           => 'pages',
		'transOrigDiffSourceField'        => 'l18n_diffsource',
		'shadowColumnsForNewPlaceholders' => 'title',
		'languageField'                   => 'sys_language_uid',
		'mainpalette'                     => 1,
		'dynamicConfigFile'               => t3lib_extMgm::extPath($_EXTKEY) . 'tbl_cms.php',
		'type'                            => 'doktype',
		'typeicon_classes' => array(
			'default' => 'mimetypes-x-content-page-language-overlay',
		),
		'dividers2tabs'                   => TRUE,
		'searchFields' => 'title,subtitle,nav_title,keywords,description,abstract,author,author_email,url',
	)
);


// ******************************************************************
// sys_template
// ******************************************************************
$TCA['sys_template'] = array (
	'ctrl' => array (
		'label' => 'title',
		'tstamp' => 'tstamp',
		'sortby' => 'sorting',
		'prependAtCopy' => 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy',
		'title' => 'LLL:EXT:cms/locallang_tca.xml:sys_template',
		'versioningWS' => TRUE,
		'origUid' => 't3_origuid',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'delete' => 'deleted',
		'adminOnly' => 1,	// Only admin, if any
		'iconfile' => 'template.gif',
		'thumbnail' => 'resources',
		'enablecolumns' => array (
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime'
		),
		'typeicon_column' => 'root',
		'typeicon_classes' => array(
			'default' => 'mimetypes-x-content-template-extension',
			'1' => 'mimetypes-x-content-template',
		),
		'typeicons' => array (
			'0' => 'template_add.gif'
		),
		'dividers2tabs' => 1,
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tbl_cms.php',
		'searchFields' => 'title,constants,config',
	)
);


// ******************************************************************
// layouts
// ******************************************************************
$TCA['backend_layout'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:cms/locallang_tca.xml:backend_layout',
		'label'     => 'title',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'versioningWS' => TRUE,
		'origUid' => 't3_origuid',
		'sortby' => 'sorting',
		'delete' => 'deleted',
		'enablecolumns' => array (
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tbl_cms.php',
		'iconfile' => 'backend_layout.gif',
		'selicon_field' => 'icon',
		'selicon_field_path' => 'uploads/media',
		'thumbnail' => 'resources',
	)
);


###########################
## EXTENSION: sv
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/sv/ext_tables.php
###########################

$_EXTKEY = 'sv';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE == 'BE') {
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['sv']['services'] = array(
		'title'       => 'LLL:EXT:sv/reports/locallang.xml:report_title',
		'description' => 'LLL:EXT:sv/reports/locallang.xml:report_description',
		'icon'		  => 'EXT:sv/reports/tx_sv_report.png',
		'report'      => 'tx_sv_reports_ServicesList'
	);
}

###########################
## EXTENSION: em
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/em/ext_tables.php
###########################

$_EXTKEY = 'em';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

if (TYPO3_MODE === 'BE') {
	t3lib_extMgm::addModule('tools', 'em', '', t3lib_extMgm::extPath($_EXTKEY) . 'classes/');

		// register Ext.Direct
	t3lib_extMgm::registerExtDirectComponent(
		'TYPO3.EM.ExtDirect',
		t3lib_extMgm::extPath($_EXTKEY) . 'classes/connection/class.tx_em_connection_extdirectserver.php:tx_em_Connection_ExtDirectServer',
		'tools_em',
		'admin'
	);

	t3lib_extMgm::registerExtDirectComponent(
		'TYPO3.EMSOAP.ExtDirect',
		t3lib_extMgm::extPath($_EXTKEY) . 'classes/connection/class.tx_em_connection_extdirectsoap.php:tx_em_Connection_ExtDirectSoap',
		'tools_em',
		'admin'
	);

		// register reports check
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['Extension Manager'][] = 'tx_em_reports_ExtensionStatus';

	$icons = array(
		'extension-required' => t3lib_extMgm::extRelPath('em') . 'res/icons/extension-required.png'
 	);
 	t3lib_SpriteManager::addSingleIcons($icons, 'em');
}

###########################
## EXTENSION: recordlist
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/recordlist/ext_tables.php
###########################

$_EXTKEY = 'recordlist';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

if (TYPO3_MODE === 'BE') {
	t3lib_extMgm::addModulePath('web_list', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');
	t3lib_extMgm::addModule('web', 'list', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');
}

###########################
## EXTENSION: extbase
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/extbase/ext_tables.php
###########################

$_EXTKEY = 'extbase';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) die ('Access denied.');

if (TYPO3_MODE == 'BE') {
	// register Extbase dispatcher for modules
	$TBE_MODULES['_dispatcher'][] = 'Tx_Extbase_Core_Bootstrap';
}

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['extbase'][] = 'tx_extbase_utility_extbaserequirementscheck';

t3lib_div::loadTCA('fe_users');
if (!isset($TCA['fe_users']['ctrl']['type'])) {
	$tempColumns = array(
		'tx_extbase_type' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:extbase/Resources/Private/Language/locallang_db.xml:fe_users.tx_extbase_type',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('LLL:EXT:extbase/Resources/Private/Language/locallang_db.xml:fe_users.tx_extbase_type.0', '0'),
					array('LLL:EXT:extbase/Resources/Private/Language/locallang_db.xml:fe_users.tx_extbase_type.Tx_Extbase_Domain_Model_FrontendUser', 'Tx_Extbase_Domain_Model_FrontendUser')
				),
				'size' => 1,
				'maxitems' => 1,
				'default' => '0'
			)
		)
	);
	t3lib_extMgm::addTCAcolumns('fe_users', $tempColumns, 1);
	t3lib_extMgm::addToAllTCAtypes('fe_users', 'tx_extbase_type');
	$TCA['fe_users']['ctrl']['type'] = 'tx_extbase_type';
}
$TCA['fe_users']['types']['Tx_Extbase_Domain_Model_FrontendUser'] = $TCA['fe_users']['types']['0'];

t3lib_div::loadTCA('fe_groups');
if (!isset($TCA['fe_groups']['ctrl']['type'])) {
	$tempColumns = array(
		'tx_extbase_type' => array(
			'exclude' => 1,
			'label'   => 'LLL:EXT:extbase/Resources/Private/Language/locallang_db.xml:fe_groups.tx_extbase_type',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('LLL:EXT:extbase/Resources/Private/Language/locallang_db.xml:fe_groups.tx_extbase_type.0', '0'),
					array('LLL:EXT:extbase/Resources/Private/Language/locallang_db.xml:fe_groups.tx_extbase_type.Tx_Extbase_Domain_Model_FrontendUserGroup', 'Tx_Extbase_Domain_Model_FrontendUserGroup')
				),
				'size' => 1,
				'maxitems' => 1,
				'default' => '0'
			)
		)
	);
	t3lib_extMgm::addTCAcolumns('fe_groups', $tempColumns, 1);
	t3lib_extMgm::addToAllTCAtypes('fe_groups', 'tx_extbase_type');
	$TCA['fe_groups']['ctrl']['type'] = 'tx_extbase_type';
}
$TCA['fe_groups']['types']['Tx_Extbase_Domain_Model_FrontendUserGroup'] = $TCA['fe_groups']['types']['0'];

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks']['Tx_Extbase_Scheduler_Task'] = array(
	'extension'        => $_EXTKEY,
	'title'            => 'LLL:EXT:extbase/Resources/Private/Language/locallang_db.xml:task.name',
	'description'      => 'LLL:EXT:extbase/Resources/Private/Language/locallang_db.xml:task.description',
	'additionalFields' => 'Tx_Extbase_Scheduler_FieldProvider'
);


###########################
## EXTENSION: css_styled_content
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/css_styled_content/ext_tables.php
###########################

$_EXTKEY = 'css_styled_content';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

	// add flexform
t3lib_extMgm::addPiFlexFormValue('*', 'FILE:EXT:css_styled_content/flexform_ds.xml','table');
$TCA['tt_content']['types']['table']['showitem']='CType;;4;;1-1-1, hidden, header;;3;;2-2-2, linkToTop;;;;4-4-4,
			--div--;LLL:EXT:cms/locallang_ttc.xml:CType.I.5, layout;;10;;3-3-3, cols, bodytext;;9;nowrap:wizards[table], text_properties, pi_flexform,
			--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access, starttime, endtime, fe_group';

t3lib_extMgm::addStaticFile($_EXTKEY, 'static/', 'CSS Styled Content');
t3lib_extMgm::addStaticFile($_EXTKEY, 'static/v3.8/', 'CSS Styled Content TYPO3 v3.8');
t3lib_extMgm::addStaticFile($_EXTKEY, 'static/v3.9/', 'CSS Styled Content TYPO3 v3.9');
t3lib_extMgm::addStaticFile($_EXTKEY, 'static/v4.2/', 'CSS Styled Content TYPO3 v4.2');
t3lib_extMgm::addStaticFile($_EXTKEY, 'static/v4.3/', 'CSS Styled Content TYPO3 v4.3');
t3lib_extMgm::addStaticFile($_EXTKEY, 'static/v4.4/', 'CSS Styled Content TYPO3 v4.4');
t3lib_extMgm::addStaticFile($_EXTKEY, 'static/v4.5/', 'CSS Styled Content TYPO3 v4.5');
t3lib_extMgm::addStaticFile($_EXTKEY, 'static/v4.6/', 'CSS Styled Content TYPO3 v4.6');

$TCA['tt_content']['columns']['section_frame']['config']['items'][0] = array('LLL:EXT:css_styled_content/locallang_db.php:tt_content.tx_cssstyledcontent_section_frame.I.0', '0');
$TCA['tt_content']['columns']['section_frame']['config']['items'][9] = array('LLL:EXT:css_styled_content/locallang_db.php:tt_content.tx_cssstyledcontent_section_frame.I.9', '66');


###########################
## EXTENSION: info
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/info/ext_tables.php
###########################

$_EXTKEY = 'info';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

if (TYPO3_MODE === 'BE') {
	t3lib_extMgm::addModule('web', 'info', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');
}

###########################
## EXTENSION: perm
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/perm/ext_tables.php
###########################

$_EXTKEY = 'perm';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

if (TYPO3_MODE === 'BE') {
	t3lib_extMgm::addModule('web', 'perm', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');
	$TYPO3_CONF_VARS['BE']['AJAX']['SC_mod_web_perm_ajax::dispatch'] = t3lib_extMgm::extPath($_EXTKEY) . 'mod1/class.sc_mod_web_perm_ajax.php:SC_mod_web_perm_ajax->dispatch';
}

###########################
## EXTENSION: func
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/func/ext_tables.php
###########################

$_EXTKEY = 'func';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

if (TYPO3_MODE === 'BE') {
	t3lib_extMgm::addModule('web', 'func', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');
}

###########################
## EXTENSION: filelist
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/filelist/ext_tables.php
###########################

$_EXTKEY = 'filelist';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

if (TYPO3_MODE === 'BE') {
	t3lib_extMgm::addModule('file', 'list', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');
}

###########################
## EXTENSION: about
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/about/ext_tables.php
###########################

$_EXTKEY = 'about';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

	// Avoid that this block is loaded in frontend or within upgrade wizards
if (TYPO3_MODE === 'BE' && !(TYPO3_REQUESTTYPE & TYPO3_REQUESTTYPE_INSTALL)) {
	Tx_Extbase_Utility_Extension::registerModule(
		$_EXTKEY,
		'help',
		'about',
		'top',
		array(
			'About' => 'index',
		),
		array(
			'access' => 'user,group',
			'icon' => 'EXT:about/ext_icon.gif',
			'labels' => 'LLL:EXT:lang/locallang_mod_help_about.xlf',
		)
	);
}

###########################
## EXTENSION: version
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/version/ext_tables.php
###########################

$_EXTKEY = 'version';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

if (TYPO3_MODE=='BE')	{
	if (!t3lib_extMgm::isLoaded('workspaces')) {
		$GLOBALS['TBE_MODULES_EXT']['xMOD_alt_clickmenu']['extendCMclasses'][]=array(
			'name' => 'tx_version_cm1',
			'path' => t3lib_extMgm::extPath($_EXTKEY).'class.tx_version_cm1.php'
		);
	}
}

###########################
## EXTENSION: tsconfig_help
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/tsconfig_help/ext_tables.php
###########################

$_EXTKEY = 'tsconfig_help';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE == 'BE')	{

	t3lib_extMgm::addModule('help','txtsconfighelpM1','',t3lib_extMgm::extPath($_EXTKEY).'mod1/');
}

###########################
## EXTENSION: context_help
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/context_help/ext_tables.php
###########################

$_EXTKEY = 'context_help';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

t3lib_extMgm::addLLrefForTCAdescr('fe_groups','EXT:context_help/locallang_csh_fe_groups.xml');
t3lib_extMgm::addLLrefForTCAdescr('fe_users','EXT:context_help/locallang_csh_fe_users.xml');
t3lib_extMgm::addLLrefForTCAdescr('pages','EXT:context_help/locallang_csh_pages.xml');
t3lib_extMgm::addLLrefForTCAdescr('pages_language_overlay','EXT:context_help/locallang_csh_pageslol.xml');
t3lib_extMgm::addLLrefForTCAdescr('static_template','EXT:context_help/locallang_csh_statictpl.xml');
t3lib_extMgm::addLLrefForTCAdescr('sys_domain','EXT:context_help/locallang_csh_sysdomain.xml');
t3lib_extMgm::addLLrefForTCAdescr('sys_template','EXT:context_help/locallang_csh_systmpl.xml');
t3lib_extMgm::addLLrefForTCAdescr('tt_content','EXT:context_help/locallang_csh_ttcontent.xml');

// Labels for TYPO3 4.5 and greater.  These labels override the ones set above, while still falling back to the original labels if no translation is available.
$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:context_help/locallang_csh_pages.xml'][] = 'EXT:context_help/4.5/locallang_csh_pages.xml';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['locallangXMLOverride']['EXT:context_help/locallang_csh_ttcontent.xml'][] = 'EXT:context_help/4.5/locallang_csh_ttcontent.xml';


###########################
## EXTENSION: extra_page_cm_options
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/extra_page_cm_options/ext_tables.php
###########################

$_EXTKEY = 'extra_page_cm_options';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE')	{
	$GLOBALS['TBE_MODULES_EXT']['xMOD_alt_clickmenu']['extendCMclasses'][]=array(
		'name' => 'tx_extrapagecmoptions',
		'path' => t3lib_extMgm::extPath($_EXTKEY).'class.tx_extrapagecmoptions.php'
	);
}

###########################
## EXTENSION: sys_note
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/sys_note/ext_tables.php
###########################

$_EXTKEY = 'sys_note';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE')	{
	$TCA['sys_note'] = Array (
		'ctrl' => Array (
			'label' => 'subject',
			'default_sortby' => 'ORDER BY crdate',
			'tstamp' => 'tstamp',
			'crdate' => 'crdate',
			'cruser_id' => 'cruser',
			'prependAtCopy' => 'LLL:EXT:lang/locallang_general.php:LGL.prependAtCopy',
			'delete' => 'deleted',
			'title' => 'LLL:EXT:sys_note/locallang_tca.php:sys_note',
			'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY).'ext_icon.gif',
		),
		'interface' => Array (
			'showRecordFieldList' => 'category,subject,message,author,email,personal'
		),
		'columns' => Array (
			'category' => Array (
				'label' => 'LLL:EXT:lang/locallang_general.php:LGL.category',
				'config' => Array (
					'type' => 'select',
					'items' => Array (
						Array('', '0'),
						Array('LLL:EXT:sys_note/locallang_tca.php:sys_note.category.I.1', '1'),
						Array('LLL:EXT:sys_note/locallang_tca.php:sys_note.category.I.2', '3'),
						Array('LLL:EXT:sys_note/locallang_tca.php:sys_note.category.I.3', '4'),
						Array('LLL:EXT:sys_note/locallang_tca.php:sys_note.category.I.4', '2')
					),
					'default' => '0'
				)
			),
			'subject' => Array (
				'label' => 'LLL:EXT:sys_note/locallang_tca.php:sys_note.subject',
				'config' => Array (
					'type' => 'input',
					'size' => '40',
					'max' => '256'
				)
			),
			'message' => Array (
				'label' => 'LLL:EXT:sys_note/locallang_tca.php:sys_note.message',
				'config' => Array (
					'type' => 'text',
					'cols' => '40',
					'rows' => '15'
				)
			),
			'author' => Array (
				'label' => 'LLL:EXT:lang/locallang_general.php:LGL.author',
				'config' => Array (
					'type' => 'input',
					'size' => '20',
					'eval' => 'trim',
					'max' => '80'
				)
			),
			'email' => Array (
				'label' => 'LLL:EXT:lang/locallang_general.php:LGL.email',
				'config' => Array (
					'type' => 'input',
					'size' => '20',
					'eval' => 'trim',
					'max' => '80'
				)
			),
			'personal' => Array (
				'label' => 'LLL:EXT:sys_note/locallang_tca.php:sys_note.personal',
				'config' => Array (
					'type' => 'check'
				)
			)
		),
		'types' => Array (
			'0' => Array('showitem' => 'category;;;;2-2-2, author, email, personal, subject;;;;3-3-3, message')
		)
	);

	t3lib_extMgm::allowTableOnStandardPages('sys_note');
}

t3lib_extMgm::addLLrefForTCAdescr('sys_note','EXT:sys_note/locallang_csh_sysnote.xml');

###########################
## EXTENSION: tstemplate
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/tstemplate/ext_tables.php
###########################

$_EXTKEY = 'tstemplate';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE')	t3lib_extMgm::addModule('web','ts','',t3lib_extMgm::extPath($_EXTKEY).'ts/');

###########################
## EXTENSION: tstemplate_ceditor
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/tstemplate_ceditor/ext_tables.php
###########################

$_EXTKEY = 'tstemplate_ceditor';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE')	{
	t3lib_extMgm::insertModuleFunction(
		'web_ts',
		'tx_tstemplateceditor',
		t3lib_extMgm::extPath($_EXTKEY).'class.tx_tstemplateceditor.php',
		'LLL:EXT:tstemplate/ts/locallang.xml:constantEditor'
	);
}

###########################
## EXTENSION: tstemplate_info
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/tstemplate_info/ext_tables.php
###########################

$_EXTKEY = 'tstemplate_info';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE')	{
	t3lib_extMgm::insertModuleFunction(
		'web_ts',
		'tx_tstemplateinfo',
		t3lib_extMgm::extPath($_EXTKEY).'class.tx_tstemplateinfo.php',
		'LLL:EXT:tstemplate/ts/locallang.xml:infoModify'
	);
}

###########################
## EXTENSION: tstemplate_objbrowser
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/tstemplate_objbrowser/ext_tables.php
###########################

$_EXTKEY = 'tstemplate_objbrowser';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE')	{
	t3lib_extMgm::insertModuleFunction(
		'web_ts',
		'tx_tstemplateobjbrowser',
		t3lib_extMgm::extPath($_EXTKEY).'class.tx_tstemplateobjbrowser.php',
		'LLL:EXT:tstemplate/ts/locallang.xml:objectBrowser'
	);
}

###########################
## EXTENSION: tstemplate_analyzer
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/tstemplate_analyzer/ext_tables.php
###########################

$_EXTKEY = 'tstemplate_analyzer';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE')	{
	t3lib_extMgm::insertModuleFunction(
		'web_ts',
		'tx_tstemplateanalyzer',
		t3lib_extMgm::extPath($_EXTKEY).'class.tx_tstemplateanalyzer.php',
		'LLL:EXT:tstemplate/ts/locallang.xml:templateAnalyzer'
	);
}

###########################
## EXTENSION: func_wizards
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/func_wizards/ext_tables.php
###########################

$_EXTKEY = 'func_wizards';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE')	{
	t3lib_extMgm::insertModuleFunction(
		'web_func',
		'tx_funcwizards_webfunc',
		t3lib_extMgm::extPath($_EXTKEY).'class.tx_funcwizards_webfunc.php',
		'LLL:EXT:func_wizards/locallang.php:mod_wizards'
	);
	t3lib_extMgm::addLLrefForTCAdescr('_MOD_web_func','EXT:func_wizards/locallang_csh.xml');
}

###########################
## EXTENSION: wizard_crpages
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/wizard_crpages/ext_tables.php
###########################

$_EXTKEY = 'wizard_crpages';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE')	{
	t3lib_extMgm::insertModuleFunction(
		'web_func',
		'tx_wizardcrpages_webfunc_2',
		t3lib_extMgm::extPath($_EXTKEY).'class.tx_wizardcrpages_webfunc_2.php',
		'LLL:EXT:wizard_crpages/locallang.php:wiz_crMany',
		'wiz'
	);
	t3lib_extMgm::addLLrefForTCAdescr('_MOD_web_func','EXT:wizard_crpages/locallang_csh.xml');
}

###########################
## EXTENSION: wizard_sortpages
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/wizard_sortpages/ext_tables.php
###########################

$_EXTKEY = 'wizard_sortpages';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE')	{
	t3lib_extMgm::insertModuleFunction(
		'web_func',
		'tx_wizardsortpages_webfunc_2',
		t3lib_extMgm::extPath($_EXTKEY).'class.tx_wizardsortpages_webfunc_2.php',
		'LLL:EXT:wizard_sortpages/locallang.php:wiz_sort',
		'wiz'
	);
	t3lib_extMgm::addLLrefForTCAdescr('_MOD_web_func','EXT:wizard_sortpages/locallang_csh.xml');
}

###########################
## EXTENSION: lowlevel
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/lowlevel/ext_tables.php
###########################

$_EXTKEY = 'lowlevel';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE')	{
	t3lib_extMgm::addModule('tools','dbint','',t3lib_extMgm::extPath($_EXTKEY).'dbint/');
	t3lib_extMgm::addModule('tools','config','',t3lib_extMgm::extPath($_EXTKEY).'config/');

/*
	t3lib_extMgm::insertModuleFunction(
		'web_func',
		'tx_lowlevel_cleaner',
		t3lib_extMgm::extPath($_EXTKEY).'class.tx_lowlevel_cleaner.php',
		'Cleaner',
		'function',
		'online'
	);
*/
}

###########################
## EXTENSION: install
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/install/ext_tables.php
###########################

$_EXTKEY = 'install';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE === 'BE') {
	t3lib_extMgm::addModulePath('tools_install',t3lib_extMgm::extPath ($_EXTKEY) . 'mod/');
	t3lib_extMgm::addModule('tools', 'install', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod/');

	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['typo3'][] = 'tx_install_report_InstallStatus';
}


###########################
## EXTENSION: belog
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/belog/ext_tables.php
###########################

$_EXTKEY = 'belog';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE')	{
	t3lib_extMgm::addModule('tools','log','',t3lib_extMgm::extPath($_EXTKEY).'mod/');
	t3lib_extMgm::insertModuleFunction(
		'web_info',
		'tx_belog_webinfo',
		t3lib_extMgm::extPath($_EXTKEY).'class.tx_belog_webinfo.php',
		'Log'
	);
}

###########################
## EXTENSION: beuser
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/beuser/ext_tables.php
###########################

$_EXTKEY = 'beuser';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE')	{
	t3lib_extMgm::addModule('tools','beuser','top',t3lib_extMgm::extPath($_EXTKEY).'mod/');

	$GLOBALS['TBE_MODULES_EXT']['xMOD_alt_clickmenu']['extendCMclasses'][] = array(
		'name' => 'tx_beuser',
		'path' => t3lib_extMgm::extPath($_EXTKEY).'class.tx_beuser.php'
	);
}

###########################
## EXTENSION: aboutmodules
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/aboutmodules/ext_tables.php
###########################

$_EXTKEY = 'aboutmodules';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

	// Avoid that this block is loaded in frontend or within upgrade wizards
if (TYPO3_MODE === 'BE' && !(TYPO3_REQUESTTYPE & TYPO3_REQUESTTYPE_INSTALL)) {
	Tx_Extbase_Utility_Extension::registerModule(
		$_EXTKEY,
		'help',
		'aboutmodules',
		'after:about',
		array(
			'Modules' => 'index',
		),
		array(
			'access' => 'user,group',
			'icon' => 'EXT:aboutmodules/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xlf',
		)
	);
}


###########################
## EXTENSION: setup
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/setup/ext_tables.php
###########################

$_EXTKEY = 'setup';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE')	{
	t3lib_extMgm::addModule('user','setup','after:task',t3lib_extMgm::extPath($_EXTKEY).'mod/');
	t3lib_extMgm::addLLrefForTCAdescr('_MOD_user_setup','EXT:setup/locallang_csh_mod.xml');
}

$GLOBALS['TYPO3_USER_SETTINGS'] = array(
	'ctrl' => array (
		'dividers2tabs' => 1
	),
	'columns' => array (
		'realName' => array(
			'type' => 'text',
			'label' => 'LLL:EXT:setup/mod/locallang.xml:beUser_realName',
			'table' => 'be_users',
			'csh' => 'beUser_realName',
		),
		'email' => array(
			'type' => 'text',
			'label' => 'LLL:EXT:setup/mod/locallang.xml:beUser_email',
			'table' => 'be_users',
			'csh' => 'beUser_email',
		),
		'emailMeAtLogin' => array(
			'type' => 'check',
			'label' => 'LLL:EXT:setup/mod/locallang.xml:emailMeAtLogin',
			'csh' => 'emailMeAtLogin',
		),
		'password' => array(
			'type' => 'password',
			'label' => 'LLL:EXT:setup/mod/locallang.xml:newPassword',
			'table' => 'be_users',
			'csh' => 'newPassword',
			'eval' => 'md5',
		),
		'password2' => array(
			'type' => 'password',
			'label' => 'LLL:EXT:setup/mod/locallang.xml:newPasswordAgain',
			'table' => 'be_users',
			'csh' => 'newPasswordAgain',
			'eval' => 'md5',
		),
		'lang' => array(
			'type' => 'select',
			'itemsProcFunc' => 'SC_mod_user_setup_index->renderLanguageSelect',
			'label' => 'LLL:EXT:setup/mod/locallang.xml:language',
			'csh' => 'language',
		),
		'startModule' => array(
			'type' => 'select',
			'itemsProcFunc' => 'SC_mod_user_setup_index->renderStartModuleSelect',
			'label' => 'LLL:EXT:setup/mod/locallang.xml:startModule',
			'csh' => 'startModule',
		),
		'thumbnailsByDefault' => array(
			'type' => 'check',
			'label' => 'LLL:EXT:setup/mod/locallang.xml:showThumbs',
			'csh' => 'showThumbs',
		),
		'edit_wideDocument' => array(
			'type' => 'check',
			'label' => 'LLL:EXT:setup/mod/locallang.xml:edit_wideDocument',
			'csh' => 'edit_wideDocument',
		),
		'titleLen' => array(
			'type' => 'text',
			'label' => 'LLL:EXT:setup/mod/locallang.xml:maxTitleLen',
			'csh' => 'maxTitleLen',
		),
		'edit_RTE' => array(
			'type' => 'check',
			'label' => 'LLL:EXT:setup/mod/locallang.xml:edit_RTE',
			'csh' => 'edit_RTE',
		),
		'edit_docModuleUpload' => array(
			'type' => 'check',
			'label' => 'LLL:EXT:setup/mod/locallang.xml:edit_docModuleUpload',
			'csh' => 'edit_docModuleUpload',
		),
		'disableCMlayers' => array(
			'type' => 'check',
			'label' => 'LLL:EXT:setup/mod/locallang.xml:disableCMlayers',
			'csh' => 'disableCMlayers',
		),
		'copyLevels' => array(
			'type' => 'text',
			'label' => 'LLL:EXT:setup/mod/locallang.xml:copyLevels',
			'csh' => 'copyLevels',
		),
		'recursiveDelete' => array(
			'type' => 'check',
			'label' => 'LLL:EXT:setup/mod/locallang.xml:recursiveDelete',
			'csh' => 'recursiveDelete',
		),
		'simulate' => array(
			'type' => 'select',
			'itemsProcFunc' => 'SC_mod_user_setup_index->renderSimulateUserSelect',
			'access' => 'admin',
			'label' => 'LLL:EXT:setup/mod/locallang.xml:simulate',
			'csh' => 'simuser'
		),
		'enableFlashUploader' => array(
			'type' => 'check',
			'label' => 'LLL:EXT:setup/mod/locallang.xml:enableFlashUploader',
			'csh' => 'enableFlashUploader',
		),
		'resizeTextareas' => array(
			'type' => 'check',
			'label' => 'LLL:EXT:setup/mod/locallang.xml:resizeTextareas',
			'csh' => 'resizeTextareas',
		),
		'resizeTextareas_Flexible' => array(
			'type' => 'check',
			'label' => 'LLL:EXT:setup/mod/locallang.xml:resizeTextareas_Flexible',
			'csh' => 'resizeTextareas_Flexible',
		),
		'resizeTextareas_MaxHeight' => array(
			'type' => 'text',
			'label' => 'LLL:EXT:setup/mod/locallang.xml:flexibleTextareas_MaxHeight',
			'csh' => 'flexibleTextareas_MaxHeight',
		),
		'debugInWindow' => array(
			'type' => 'check',
			'label' => 'LLL:EXT:setup/mod/locallang.xml:debugInWindow',
			'access' => 'admin',
		),
	),
	'showitem' => '--div--;LLL:EXT:setup/mod/locallang.xml:personal_data,realName,email,emailMeAtLogin,password,password2,lang,
			--div--;LLL:EXT:setup/mod/locallang.xml:opening,startModule,thumbnailsByDefault,titleLen,
			--div--;LLL:EXT:setup/mod/locallang.xml:editFunctionsTab,edit_RTE,edit_wideDocument,edit_docModuleUpload,enableFlashUploader,resizeTextareas,resizeTextareas_Flexible,resizeTextareas_MaxHeight,disableCMlayers,copyLevels,recursiveDelete,
			--div--;LLL:EXT:setup/mod/locallang.xml:adminFunctions,simulate,debugInWindow'

);

###########################
## EXTENSION: taskcenter
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/taskcenter/ext_tables.php
###########################

$_EXTKEY = 'taskcenter';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

if (TYPO3_MODE == 'BE') {
	t3lib_extMgm::addModulePath('tools_txtaskcenterM1', t3lib_extMgm::extPath($_EXTKEY) . 'task/');
	t3lib_extMgm::addModule('user','task', 'top', t3lib_extMgm::extPath($_EXTKEY) . 'task/');

	$GLOBALS['TYPO3_CONF_VARS']['BE']['AJAX']['Taskcenter::saveCollapseState']	= 'EXT:taskcenter/classes/class.tx_taskcenter_status.php:tx_taskcenter_status->saveCollapseState';
	$GLOBALS['TYPO3_CONF_VARS']['BE']['AJAX']['Taskcenter::saveSortingState']	= 'EXT:taskcenter/classes/class.tx_taskcenter_status.php:tx_taskcenter_status->saveSortingState';
}

###########################
## EXTENSION: info_pagetsconfig
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/info_pagetsconfig/ext_tables.php
###########################

$_EXTKEY = 'info_pagetsconfig';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE')	{
	t3lib_extMgm::insertModuleFunction(
		'web_info',
		'tx_infopagetsconfig_webinfo',
		t3lib_extMgm::extPath($_EXTKEY).'class.tx_infopagetsconfig_webinfo.php',
		'LLL:EXT:info_pagetsconfig/locallang.php:mod_pagetsconfig'
	);
}

t3lib_extMgm::addLLrefForTCAdescr('_MOD_web_info','EXT:info_pagetsconfig/locallang_csh_webinfo.xml');


###########################
## EXTENSION: viewpage
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/viewpage/ext_tables.php
###########################

$_EXTKEY = 'viewpage';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE')	t3lib_extMgm::addModule('web','view','after:layout',t3lib_extMgm::extPath($_EXTKEY).'view/');

###########################
## EXTENSION: rtehtmlarea
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/rtehtmlarea/ext_tables.php
###########################

$_EXTKEY = 'rtehtmlarea';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

		// Add static template for Click-enlarge rendering
	t3lib_extMgm::addStaticFile($_EXTKEY,'static/clickenlarge/','Clickenlarge Rendering');

		// Add acronyms table
	$TCA['tx_rtehtmlarea_acronym'] = Array (
		'ctrl' => Array (
			'title' => 'LLL:EXT:rtehtmlarea/locallang_db.xml:tx_rtehtmlarea_acronym',
			'label' => 'term',
			'default_sortby' => 'ORDER BY term',
			'sortby' => 'sorting',
			'delete' => 'deleted',
			'enablecolumns' => Array (
				'disabled' => 'hidden',
				'starttime' => 'starttime',
				'endtime' => 'endtime',
			),
			'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
			'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY).'extensions/Acronym/skin/images/acronym.gif',
		),
	);
	t3lib_extMgm::allowTableOnStandardPages('tx_rtehtmlarea_acronym');
	t3lib_extMgm::addLLrefForTCAdescr('tx_rtehtmlarea_acronym','EXT:' . $_EXTKEY . '/locallang_csh_abbreviation.xml');

		// Add contextual help files
	$htmlAreaRteContextHelpFiles = array(
		'General' => 'EXT:' . $_EXTKEY . '/locallang_csh.xlf',
		'Acronym' => 'EXT:' . $_EXTKEY . '/extensions/Acronym/locallang_csh.xlf',
		'EditElement' => 'EXT:' . $_EXTKEY . '/extensions/EditElement/locallang_csh.xlf',
		'Language' => 'EXT:' . $_EXTKEY . '/extensions/Language/locallang_csh.xlf',
		'MicrodataSchema' => 'EXT:' . $_EXTKEY . '/extensions/MicrodataSchema/locallang_csh.xlf',
		'PlainText' => 'EXT:' . $_EXTKEY . '/extensions/PlainText/locallang_csh.xlf',
		'RemoveFormat' => 'EXT:' . $_EXTKEY . '/extensions/RemoveFormat/locallang_csh.xlf',
		'TableOperations' => 'EXT:' . $_EXTKEY . '/extensions/TableOperations/locallang_csh.xlf',
	);
	foreach ($htmlAreaRteContextHelpFiles as $key => $file) {
		t3lib_extMgm::addLLrefForTCAdescr('xEXT_' . $_EXTKEY . '_' . $key, $file);
	}
	unset($htmlAreaRteContextHelpFiles);

		// Extend TYPO3 User Settings Configuration
if (TYPO3_MODE === 'BE' && t3lib_extMgm::isLoaded('setup') && is_array($GLOBALS['TYPO3_USER_SETTINGS'])) {
	$GLOBALS['TYPO3_USER_SETTINGS']['columns'] = array_merge(
		$GLOBALS['TYPO3_USER_SETTINGS']['columns'],
		array(
			'rteWidth' => array(
				'type' => 'text',
				'label' => 'LLL:EXT:rtehtmlarea/locallang.xml:rteWidth',
				'csh' => 'xEXT_rtehtmlarea_General:rteWidth',
			),
			'rteHeight' => array(
				'type' => 'text',
				'label' => 'LLL:EXT:rtehtmlarea/locallang.xml:rteHeight',
				'csh' => 'xEXT_rtehtmlarea_General:rteHeight',
			),
			'rteResize' => array(
				'type' => 'check',
				'label' => 'LLL:EXT:rtehtmlarea/locallang.xml:rteResize',
				'csh' => 'xEXT_rtehtmlarea_General:rteResize',
			),
			'rteMaxHeight' => array(
				'type' => 'text',
				'label' => 'LLL:EXT:rtehtmlarea/locallang.xml:rteMaxHeight',
				'csh' => 'xEXT_rtehtmlarea_General:rteMaxHeight',
			),
			'rteCleanPasteBehaviour' => array(
				'type' => 'select',
				'label' => 'LLL:EXT:rtehtmlarea/htmlarea/plugins/PlainText/locallang.xml:rteCleanPasteBehaviour',
				'items' => array(
					'plainText' => 'LLL:EXT:rtehtmlarea/htmlarea/plugins/PlainText/locallang.xml:plainText',
					'pasteStructure' => 'LLL:EXT:rtehtmlarea/htmlarea/plugins/PlainText/locallang.xml:pasteStructure',
					'pasteFormat' => 'LLL:EXT:rtehtmlarea/htmlarea/plugins/PlainText/locallang.xml:pasteFormat',
				),
				'csh' => 'xEXT_rtehtmlarea_PlainText:behaviour',
			),
		)
	);
	$GLOBALS['TYPO3_USER_SETTINGS']['showitem'] .= ',--div--;LLL:EXT:rtehtmlarea/locallang.xml:rteSettings,rteWidth,rteHeight,rteResize,rteMaxHeight,rteCleanPasteBehaviour';
}

###########################
## EXTENSION: t3skin
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/t3skin/ext_tables.php
###########################

$_EXTKEY = 't3skin';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE == 'BE' || (TYPO3_MODE == 'FE' && isset($GLOBALS['BE_USER']))) {
	global $TBE_STYLES;

		// register as a skin
	$TBE_STYLES['skins'][$_EXTKEY] = array(
		'name' => 't3skin',
	);

		// Support for other extensions to add own icons...
	$presetSkinImgs = is_array($TBE_STYLES['skinImg']) ?
		$TBE_STYLES['skinImg'] :
		array();

	$TBE_STYLES['skins'][$_EXTKEY]['stylesheetDirectories']['sprites'] = 'EXT:t3skin/stylesheets/sprites/';

	/**
	 * Setting up backend styles and colors
	 */
	$TBE_STYLES['mainColors'] = array(	// Always use #xxxxxx color definitions!
		'bgColor'    => '#FFFFFF',		// Light background color
		'bgColor2'   => '#FEFEFE',		// Steel-blue
		'bgColor3'   => '#F1F3F5',		// dok.color
		'bgColor4'   => '#E6E9EB',		// light tablerow background, brownish
		'bgColor5'   => '#F8F9FB',		// light tablerow background, greenish
		'bgColor6'   => '#E6E9EB',		// light tablerow background, yellowish, for section headers. Light.
		'hoverColor' => '#FF0000',
		'navFrameHL' => '#F8F9FB'
	);

	$TBE_STYLES['colorschemes'][0] = '-|class-main1,-|class-main2,-|class-main3,-|class-main4,-|class-main5';
	$TBE_STYLES['colorschemes'][1] = '-|class-main11,-|class-main12,-|class-main13,-|class-main14,-|class-main15';
	$TBE_STYLES['colorschemes'][2] = '-|class-main21,-|class-main22,-|class-main23,-|class-main24,-|class-main25';
	$TBE_STYLES['colorschemes'][3] = '-|class-main31,-|class-main32,-|class-main33,-|class-main34,-|class-main35';
	$TBE_STYLES['colorschemes'][4] = '-|class-main41,-|class-main42,-|class-main43,-|class-main44,-|class-main45';
	$TBE_STYLES['colorschemes'][5] = '-|class-main51,-|class-main52,-|class-main53,-|class-main54,-|class-main55';

	$TBE_STYLES['styleschemes'][0]['all'] = 'CLASS: formField';
	$TBE_STYLES['styleschemes'][1]['all'] = 'CLASS: formField1';
	$TBE_STYLES['styleschemes'][2]['all'] = 'CLASS: formField2';
	$TBE_STYLES['styleschemes'][3]['all'] = 'CLASS: formField3';
	$TBE_STYLES['styleschemes'][4]['all'] = 'CLASS: formField4';
	$TBE_STYLES['styleschemes'][5]['all'] = 'CLASS: formField5';

	$TBE_STYLES['styleschemes'][0]['check'] = 'CLASS: checkbox';
	$TBE_STYLES['styleschemes'][1]['check'] = 'CLASS: checkbox';
	$TBE_STYLES['styleschemes'][2]['check'] = 'CLASS: checkbox';
	$TBE_STYLES['styleschemes'][3]['check'] = 'CLASS: checkbox';
	$TBE_STYLES['styleschemes'][4]['check'] = 'CLASS: checkbox';
	$TBE_STYLES['styleschemes'][5]['check'] = 'CLASS: checkbox';

	$TBE_STYLES['styleschemes'][0]['radio'] = 'CLASS: radio';
	$TBE_STYLES['styleschemes'][1]['radio'] = 'CLASS: radio';
	$TBE_STYLES['styleschemes'][2]['radio'] = 'CLASS: radio';
	$TBE_STYLES['styleschemes'][3]['radio'] = 'CLASS: radio';
	$TBE_STYLES['styleschemes'][4]['radio'] = 'CLASS: radio';
	$TBE_STYLES['styleschemes'][5]['radio'] = 'CLASS: radio';

	$TBE_STYLES['styleschemes'][0]['select'] = 'CLASS: select';
	$TBE_STYLES['styleschemes'][1]['select'] = 'CLASS: select';
	$TBE_STYLES['styleschemes'][2]['select'] = 'CLASS: select';
	$TBE_STYLES['styleschemes'][3]['select'] = 'CLASS: select';
	$TBE_STYLES['styleschemes'][4]['select'] = 'CLASS: select';
	$TBE_STYLES['styleschemes'][5]['select'] = 'CLASS: select';

	$TBE_STYLES['borderschemes'][0] = array('', '', '', 'wrapperTable');
	$TBE_STYLES['borderschemes'][1] = array('', '', '', 'wrapperTable1');
	$TBE_STYLES['borderschemes'][2] = array('', '', '', 'wrapperTable2');
	$TBE_STYLES['borderschemes'][3] = array('', '', '', 'wrapperTable3');
	$TBE_STYLES['borderschemes'][4] = array('', '', '', 'wrapperTable4');
	$TBE_STYLES['borderschemes'][5] = array('', '', '', 'wrapperTable5');



		// Setting the relative path to the extension in temp. variable:
	$temp_eP = t3lib_extMgm::extRelPath($_EXTKEY);

		// Alternative dimensions for frameset sizes:
	$TBE_STYLES['dims']['leftMenuFrameW'] = 190;		// Left menu frame width
	$TBE_STYLES['dims']['topFrameH']      = 42;			// Top frame height
	$TBE_STYLES['dims']['navFrameWidth']  = 280;		// Default navigation frame width

		// Setting roll-over background color for click menus:
		// Notice, this line uses the the 'scriptIDindex' feature to override another value in this array (namely $TBE_STYLES['mainColors']['bgColor5']), for a specific script "typo3/alt_clickmenu.php"
	$TBE_STYLES['scriptIDindex']['typo3/alt_clickmenu.php']['mainColors']['bgColor5'] = '#dedede';

		// Setting up auto detection of alternative icons:
	$TBE_STYLES['skinImgAutoCfg'] = array(
		'absDir'             => t3lib_extMgm::extPath($_EXTKEY).'icons/',
		'relDir'             => t3lib_extMgm::extRelPath($_EXTKEY).'icons/',
		'forceFileExtension' => 'gif',	// Force to look for PNG alternatives...
#		'scaleFactor'        => 2/3,	// Scaling factor, default is 1
		'iconSizeWidth'      => 16,
		'iconSizeHeight'     => 16,
	);

		// Changing icon for filemounts, needs to be done here as overwriting the original icon would also change the filelist tree's root icon
	$TCA['sys_filemounts']['ctrl']['iconfile'] = '_icon_ftp_2.gif';

		// Adding flags to sys_language
	t3lib_div::loadTCA('sys_language');
	$TCA['sys_language']['ctrl']['typeicon_column'] = 'flag';
	$TCA['sys_language']['ctrl']['typeicon_classes'] = array(
		'default' => 'mimetypes-x-sys_language',
		'mask'	=> 'flags-###TYPE###'
	);
	$flagNames = array(
		'multiple', 'ad', 'ae', 'af', 'ag', 'ai', 'al', 'am', 'an', 'ao', 'ar', 'as', 'at', 'au', 'aw', 'ax', 'az',
		'ba', 'bb', 'bd', 'be', 'bf', 'bg', 'bh', 'bi', 'bj', 'bm', 'bn', 'bo', 'br', 'bs', 'bt', 'bv', 'bw', 'by', 'bz',
		'ca', 'catalonia', 'cc', 'cd', 'cf', 'cg', 'ch', 'ci', 'ck', 'cl', 'cm', 'cn', 'co', 'cr', 'cs', 'cu', 'cv', 'cx', 'cy', 'cz',
		'de', 'dj', 'dk', 'dm', 'do', 'dz',
		'ec', 'ee', 'eg', 'eh', 'england', 'er', 'es', 'et', 'europeanunion',
		'fam', 'fi', 'fj', 'fk', 'fm', 'fo', 'fr',
		'ga', 'gb', 'gd', 'ge', 'gf', 'gh', 'gi', 'gl', 'gm', 'gn', 'gp', 'gq', 'gr', 'gs', 'gt', 'gu', 'gw', 'gy',
		'hk', 'hm', 'hn', 'hr', 'ht', 'hu',
		'id', 'ie', 'il', 'in', 'io', 'iq', 'ir', 'is', 'it',
		'jm', 'jo', 'jp',
		'ke', 'kg', 'kh', 'ki', 'km', 'kn', 'kp', 'kr', 'kw', 'ky', 'kz',
		'la', 'lb', 'lc', 'li', 'lk', 'lr', 'ls', 'lt', 'lu', 'lv', 'ly',
		'ma', 'mc', 'md', 'me', 'mg', 'mh', 'mk', 'ml', 'mm', 'mn', 'mo', 'mp', 'mq', 'mr', 'ms', 'mt', 'mu', 'mv', 'mw', 'mx', 'my', 'mz',
		'na', 'nc', 'ne', 'nf', 'ng', 'ni', 'nl', 'no', 'np', 'nr', 'nu', 'nz',
		'om',
		'pa', 'pe', 'pf', 'pg', 'ph', 'pk', 'pl', 'pm', 'pn', 'pr', 'ps', 'pt', 'pw', 'py',
		'qa', 'qc',
		're', 'ro', 'rs', 'ru', 'rw',
		'sa', 'sb', 'sc', 'scotland', 'sd', 'se', 'sg', 'sh', 'si', 'sj', 'sk', 'sl', 'sm', 'sn', 'so', 'sr', 'st', 'sv', 'sy', 'sz',
		'tc', 'td', 'tf', 'tg', 'th', 'tj', 'tk', 'tl', 'tm', 'tn', 'to', 'tr', 'tt', 'tv', 'tw', 'tz',
		'ua', 'ug', 'um', 'us', 'uy', 'uz',
		'va', 'vc', 've', 'vg', 'vi', 'vn', 'vu',
		'wales', 'wf', 'ws',
		'ye', 'yt',
		'za', 'zm', 'zw'
	);
	foreach ($flagNames as $flagName) {
		$TCA['sys_language']['columns']['flag']['config']['items'][] = array($flagName, $flagName, 'EXT:t3skin/images/flags/'. $flagName . '.png');
	}

		// Manual setting up of alternative icons. This is mainly for module icons which has a special prefix:
	$TBE_STYLES['skinImg'] = array_merge($presetSkinImgs, array (
		'gfx/ol/blank.gif'                         => array('clear.gif','width="18" height="16"'),
		'MOD:web/website.gif'                      => array($temp_eP.'icons/module_web.gif','width="24" height="24"'),
		'MOD:web_layout/layout.gif'                => array($temp_eP.'icons/module_web_layout.gif','width="24" height="24"'),
		'MOD:web_view/view.gif'                    => array($temp_eP.'icons/module_web_view.png','width="24" height="24"'),
		'MOD:web_list/list.gif'                    => array($temp_eP.'icons/module_web_list.gif','width="24" height="24"'),
		'MOD:web_info/info.gif'                    => array($temp_eP.'icons/module_web_info.png','width="24" height="24"'),
		'MOD:web_perm/perm.gif'                    => array($temp_eP.'icons/module_web_perms.png','width="24" height="24"'),
		'MOD:web_func/func.gif'                    => array($temp_eP.'icons/module_web_func.png','width="24" height="24"'),
		'MOD:web_ts/ts1.gif'                       => array($temp_eP.'icons/module_web_ts.gif','width="24" height="24"'),
		'MOD:web_modules/modules.gif'              => array($temp_eP.'icons/module_web_modules.gif','width="24" height="24"'),
		'MOD:web_txversionM1/cm_icon.gif'          => array($temp_eP.'icons/module_web_version.gif','width="24" height="24"'),
		'MOD:file/file.gif'                        => array($temp_eP.'icons/module_file.gif','width="22" height="24"'),
		'MOD:file_list/list.gif'                   => array($temp_eP.'icons/module_file_list.gif','width="22" height="24"'),
		'MOD:file_images/images.gif'               => array($temp_eP.'icons/module_file_images.gif','width="22" height="22"'),
		'MOD:user/user.gif'                        => array($temp_eP.'icons/module_user.gif','width="22" height="22"'),
		'MOD:user_task/task.gif'                   => array($temp_eP.'icons/module_user_taskcenter.gif','width="22" height="22"'),
		'MOD:user_setup/setup.gif'                 => array($temp_eP.'icons/module_user_setup.gif','width="22" height="22"'),
		'MOD:user_doc/document.gif'                => array($temp_eP.'icons/module_doc.gif','width="22" height="22"'),
		'MOD:user_ws/sys_workspace.gif'            => array($temp_eP.'icons/module_user_ws.gif','width="22" height="22"'),
		'MOD:tools/tool.gif'                       => array($temp_eP.'icons/module_tools.gif','width="25" height="24"'),
		'MOD:tools_beuser/beuser.gif'              => array($temp_eP.'icons/module_tools_user.gif','width="24" height="24"'),
		'MOD:tools_em/em.gif'                      => array($temp_eP.'icons/module_tools_em.png','width="24" height="24"'),
		'MOD:tools_em/install.gif'                 => array($temp_eP.'icons/module_tools_em.gif','width="24" height="24"'),
		'MOD:tools_dbint/db.gif'                   => array($temp_eP.'icons/module_tools_dbint.gif','width="25" height="24"'),
		'MOD:tools_config/config.gif'              => array($temp_eP.'icons/module_tools_config.gif','width="24" height="24"'),
		'MOD:tools_install/install.gif'            => array($temp_eP.'icons/module_tools_install.gif','width="24" height="24"'),
		'MOD:tools_log/log.gif'                    => array($temp_eP.'icons/module_tools_log.gif','width="24" height="24"'),
		'MOD:tools_txphpmyadmin/thirdparty_db.gif' => array($temp_eP.'icons/module_tools_phpmyadmin.gif','width="24" height="24"'),
		'MOD:tools_isearch/isearch.gif'            => array($temp_eP.'icons/module_tools_isearch.gif','width="24" height="24"'),
		'MOD:help/help.gif'                        => array($temp_eP.'icons/module_help.gif','width="23" height="24"'),
		'MOD:help_about/info.gif'                  => array($temp_eP.'icons/module_help_about.gif','width="25" height="24"'),
		'MOD:help_aboutmodules/aboutmodules.gif'   => array($temp_eP.'icons/module_help_aboutmodules.gif','width="24" height="24"'),
		'MOD:help_cshmanual/about.gif'         => array($temp_eP.'icons/module_help_cshmanual.gif','width="25" height="24"'),
		'MOD:help_txtsconfighelpM1/moduleicon.gif' => array($temp_eP.'icons/module_help_ts.gif','width="25" height="24"'),
	));

		// Logo at login screen
	$TBE_STYLES['logo_login'] = $temp_eP . 'images/login/typo3logo-white-greyback.gif';

		// extJS theme
	$TBE_STYLES['extJS']['theme'] =  $temp_eP . 'extjs/xtheme-t3skin.css';

	// Adding HTML template for login screen
	$TBE_STYLES['htmlTemplates']['templates/login.html'] = 'sysext/t3skin/templates/login.html';

	$GLOBALS['TBE_STYLES']['stylesheets']['admPanel'] = t3lib_extMgm::siteRelPath('t3skin') . 'stylesheets/standalone/admin_panel.css';

	foreach ($flagNames as $flagName) {
		t3lib_SpriteManager::addIconSprite(
			array(
				'flags-' . $flagName,
				'flags-' . $flagName . '-overlay',
			)
		);
	}
	unset($flagNames, $flagName);

}


###########################
## EXTENSION: t3editor
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/t3editor/ext_tables.php
###########################

$_EXTKEY = 't3editor';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

if (TYPO3_MODE === 'BE') {
		// Register AJAX handlers:
	$TYPO3_CONF_VARS['BE']['AJAX']['tx_t3editor::saveCode'] = 'EXT:t3editor/classes/class.tx_t3editor.php:tx_t3editor->ajaxSaveCode';
	$TYPO3_CONF_VARS['BE']['AJAX']['tx_t3editor::getPlugins'] = 'EXT:t3editor/classes/class.tx_t3editor.php:tx_t3editor->getPlugins';
	$TYPO3_CONF_VARS['BE']['AJAX']['tx_t3editor_TSrefLoader::getTypes'] = 'EXT:t3editor/classes/ts_codecompletion/class.tx_t3editor_tsrefloader.php:tx_t3editor_TSrefLoader->processAjaxRequest';
	$TYPO3_CONF_VARS['BE']['AJAX']['tx_t3editor_TSrefLoader::getDescription'] = 'EXT:t3editor/classes/ts_codecompletion/class.tx_t3editor_tsrefloader.php:tx_t3editor_TSrefLoader->processAjaxRequest';
	$TYPO3_CONF_VARS['BE']['AJAX']['tx_t3editor_codecompletion::loadTemplates'] = 'EXT:t3editor/classes/ts_codecompletion/class.tx_t3editor_codecompletion.php:tx_t3editor_codecompletion->processAjaxRequest';

	t3lib_div::loadTCA('tt_content');
		// Add the t3editor wizard on the bodytext field of tt_content
	$TCA['tt_content']['columns']['bodytext']['config']['wizards']['t3editor'] = array(
		'enableByTypeConfig' => 1,
		'type' => 'userFunc',
		'userFunc' => 'EXT:t3editor/classes/class.tx_t3editor_tceforms_wizard.php:tx_t3editor_tceforms_wizard->main',
		'title' => 't3editor',
		'icon' => 'wizard_table.gif',
		'script' => 'wizard_table.php',
		'params' => array(
			'format' => 'html',
		),
	);
		// Activate the t3editor only for type html
	$TCA['tt_content']['types']['html']['showitem'] = str_replace('bodytext,', 'bodytext;LLL:EXT:cms/locallang_ttc.xml:bodytext.ALT.html_formlabel;;nowrap:wizards[t3editor],', $TCA['tt_content']['types']['html']['showitem']);
}

###########################
## EXTENSION: reports
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/reports/ext_tables.php
###########################

$_EXTKEY = 'reports';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

if (TYPO3_MODE == 'BE') {
	t3lib_extMgm::addModulePath('tools_txreportsM1', t3lib_extMgm::extPath($_EXTKEY) . 'mod/');
	t3lib_extMgm::addModule('tools', 'txreportsM1', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod/');

	$statusReport = array(
		'title'       => 'LLL:EXT:reports/reports/locallang.xml:status_report_title',
		'description' => 'LLL:EXT:reports/reports/locallang.xml:status_report_description',
		'report'      => 'tx_reports_reports_Status'
	);

	if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status'])) {
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status'] = array();
	}

	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status'] = array_merge(
		$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status'],
		$statusReport
	);

	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['typo3'][] = 'tx_reports_reports_status_Typo3Status';
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['system'][] = 'tx_reports_reports_status_SystemStatus';
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['security'][] = 'tx_reports_reports_status_SecurityStatus';
	$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['reports']['tx_reports']['status']['providers']['configuration'][] = 'tx_reports_reports_status_ConfigurationStatus';

}


###########################
## EXTENSION: form
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/form/ext_tables.php
###########################

$_EXTKEY = 'form';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

	// Add Default TS to Include static (from extensions)
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript/', 'Default TS');

$TCA['tt_content']['columns']['bodytext']['config']['wizards']['forms'] = array(
	'notNewRecords' => 1,
	'enableByTypeConfig' => 1,
	'type' => 'script',
	'title' => 'Form wizard',
	'icon' => 'wizard_forms.gif',
	'script' => t3lib_extMgm::extRelPath('form') . 'Classes/Controller/Wizard.php',
	'params' => array(
		'xmlOutput' => 0
	)
);

$TCA['tt_content']['types']['mailform']['showitem'] = '
	CType;;4;;1-1-1,
	hidden,
	header;;3;;2-2-2,
	linkToTop;;;;3-3-3,
	--div--;LLL:EXT:cms/locallang_ttc.xml:CType.I.8,
	bodytext;LLL:EXT:cms/locallang_ttc.php:bodytext.ALT.mailform;;nowrap:wizards[forms];3-3-3,
	--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access,
	starttime,
	endtime,
	fe_group
';

###########################
## EXTENSION: rsaauth
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/rsaauth/ext_tables.php
###########################

$_EXTKEY = 'rsaauth';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die('Access denied.');
}

// Define the table for keys. Make sure that it cannot be edited or seen by
// any user in any way.
$TCA['tx_rsaauth_keys'] = array (
	'ctrl' => array (
		'adminOnly' => TRUE,
		'hideTable' => TRUE,
		'is_static' => TRUE,
		'label' => 'uid',
		'readOnly' => TRUE,
		'rootLevel' => 1,
		'title' => 'Oops! You should not see this!'
	),
	'columns' => array(
	),
	'types' => array(
		'0' => array(
			'showitem' => ''
		)
	)
);


###########################
## EXTENSION: saltedpasswords
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/saltedpasswords/ext_tables.php
###########################

$_EXTKEY = 'saltedpasswords';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}


t3lib_div::loadTCA('fe_users');
$GLOBALS['TCA']['fe_users']['columns']['password']['config']['max'] = 60;

if (tx_saltedpasswords_div::isUsageEnabled('FE')) {

		// Get eval field operations methods as array keys
	$operations = array_flip(t3lib_div::trimExplode(',', $GLOBALS['TCA']['fe_users']['columns']['password']['config']['eval'], TRUE));

		// Remove md5 and temporary password from the list of evaluated methods
	unset($operations['md5'], $operations['password']);

		// Append new methods to have "password" as last operation.
	$operations['tx_saltedpasswords_eval_fe'] = 1;
	$operations['password'] = 1;

	$GLOBALS['TCA']['fe_users']['columns']['password']['config']['eval'] = implode(',', array_keys($operations));
	unset($operations);
}


t3lib_div::loadTCA('be_users');
$GLOBALS['TCA']['be_users']['columns']['password']['config']['max'] = 60;

if (tx_saltedpasswords_div::isUsageEnabled('BE')) {

		// Get eval field operations methods as array keys
	$operations = array_flip(t3lib_div::trimExplode(',', $GLOBALS['TCA']['be_users']['columns']['password']['config']['eval'], TRUE));

		// Remove md5 and temporary password from the list of evaluated methods
	unset($operations['md5'], $operations['password']);

		// Append new methods to have "password" as last operation.
	$operations['tx_saltedpasswords_eval_be'] = 1;
	$operations['password'] = 1;

	$GLOBALS['TCA']['be_users']['columns']['password']['config']['eval'] = implode(',', array_keys($operations));
	unset($operations);

		// Prevent md5 hashing on client side via JS
	$GLOBALS['TYPO3_USER_SETTINGS']['columns']['password']['eval'] = '';
	$GLOBALS['TYPO3_USER_SETTINGS']['columns']['password2']['eval'] = '';
}



###########################
## EXTENSION: cshmanual
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/cshmanual/ext_tables.php
###########################

$_EXTKEY = 'cshmanual';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE') {
	t3lib_extMgm::addModule('help','cshmanual','top',t3lib_extMgm::extPath($_EXTKEY).'mod/');
}

###########################
## EXTENSION: recycler
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/recycler/ext_tables.php
###########################

$_EXTKEY = 'recycler';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE == 'BE') {

		// add module

	t3lib_extMgm::addModulePath('web_txrecyclerM1',t3lib_extMgm::extPath ($_EXTKEY).'mod1/');
	t3lib_extMgm::addModule('web','txrecyclerM1','',t3lib_extMgm::extPath($_EXTKEY).'mod1/');

}

###########################
## EXTENSION: scheduler
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/scheduler/ext_tables.php
###########################

$_EXTKEY = 'scheduler';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];



if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

if (TYPO3_MODE == 'BE') {
		// Add module
	t3lib_extMgm::addModule('tools', 'txschedulerM1', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');

		// Add context sensitive help (csh) to the backend module
	t3lib_extMgm::addLLrefForTCAdescr('_MOD_tools_txschedulerM1', 'EXT:' . $_EXTKEY . '/mod1/locallang_csh_scheduler.xml');
}

###########################
## EXTENSION: fluid
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/fluid/ext_tables.php
###########################

$_EXTKEY = 'fluid';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) die ('Access denied.');

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Fluid: (Optional) default ajax configuration');

###########################
## EXTENSION: realurl
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3conf/ext/realurl/ext_tables.php
###########################

$_EXTKEY = 'realurl';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE')	{
//	t3lib_extMgm::addModule('tools','txrealurlM1','',t3lib_extMgm::extPath($_EXTKEY).'mod1/');

	// Add Web>Info module:
	t3lib_extMgm::insertModuleFunction(
		'web_info',
		'tx_realurl_modfunc1',
		t3lib_extMgm::extPath($_EXTKEY) . 'modfunc1/class.tx_realurl_modfunc1.php',
		'LLL:EXT:realurl/locallang_db.xml:moduleFunction.tx_realurl_modfunc1',
		'function',
		'online'
	);
}

t3lib_div::loadTCA('pages');
$TCA['pages']['columns'] += array(
	'tx_realurl_pathsegment' => array(
		'label' => 'LLL:EXT:realurl/locallang_db.xml:pages.tx_realurl_pathsegment',
		'displayCond' => 'FIELD:tx_realurl_exclude:!=:1',
		'exclude' => 1,
		'config' => array (
			'type' => 'input',
			'max' => 255,
			'eval' => 'trim,nospace,lower'
		),
	),
	'tx_realurl_pathoverride' => array(
		'label' => 'LLL:EXT:realurl/locallang_db.xml:pages.tx_realurl_path_override',
		'exclude' => 1,
		'config' => array (
			'type' => 'check',
			'items' => array(
				array('', '')
			)
		)
	),
	'tx_realurl_exclude' => array(
		'label' => 'LLL:EXT:realurl/locallang_db.xml:pages.tx_realurl_exclude',
		'exclude' => 1,
		'config' => array (
			'type' => 'check',
			'items' => array(
				array('', '')
			)
		)
	),
	'tx_realurl_nocache' => array(
		'label' => 'LLL:EXT:realurl/locallang_db.xml:pages.tx_realurl_nocache',
		'exclude' => 1,
		'config' => array (
			'type' => 'check',
			'items' => array(
				array('', ''),
			),
		),
	)
);

$TCA['pages']['ctrl']['requestUpdate'] .= ',tx_realurl_exclude';

$TCA['pages']['palettes']['137'] = array(
	'showitem' => 'tx_realurl_pathoverride'
);

if (t3lib_div::compat_version('4.3')) {
	t3lib_extMgm::addFieldsToPalette('pages', '3', 'tx_realurl_nocache', 'after:cache_timeout');
}
if (t3lib_div::compat_version('4.2')) {
	// For 4.2 or new add fields to advanced page only
	t3lib_extMgm::addToAllTCAtypes('pages', 'tx_realurl_pathsegment;;137;;,tx_realurl_exclude', '1', 'after:nav_title');
	t3lib_extMgm::addToAllTCAtypes('pages', 'tx_realurl_pathsegment;;137;;,tx_realurl_exclude', '4,199,254', 'after:title');
}
else {
	// Put it for standard page
	t3lib_extMgm::addToAllTCAtypes('pages', 'tx_realurl_pathsegment;;137;;,tx_realurl_exclude', '2', 'after:nav_title');
	t3lib_extMgm::addToAllTCAtypes('pages', 'tx_realurl_pathsegment;;137;;,tx_realurl_exclude', '1,5,4,199,254', 'after:title');
}

t3lib_extMgm::addLLrefForTCAdescr('pages','EXT:realurl/locallang_csh.xml');

$TCA['pages_language_overlay']['columns'] += array(
	'tx_realurl_pathsegment' => array(
		'label' => 'LLL:EXT:realurl/locallang_db.xml:pages.tx_realurl_pathsegment',
		'exclude' => 1,
		'config' => array (
			'type' => 'input',
			'max' => 255,
			'eval' => 'trim,nospace,lower'
		),
	),
);

t3lib_extMgm::addToAllTCAtypes('pages_language_overlay', 'tx_realurl_pathsegment', '', 'after:nav_title');


###########################
## EXTENSION: static_info_tables
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3conf/ext/static_info_tables/ext_tables.php
###########################

$_EXTKEY = 'static_info_tables';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

t3lib_extMgm::addStaticFile(STATIC_INFO_TABLES_EXTkey, 'static/static_info_tables/', 'Static Info tables');

$TCA['static_territories'] = array(
	'ctrl' => array(
		'label' => 'tr_name_en',
		'label_alt' => 'tr_name_en,tr_iso_nr',
		'readOnly' => 1,	// This should always be true, as it prevents the static data from being altered
		'adminOnly' => 1,
		'rootLevel' => 1,
		'is_static' => 1,
		'default_sortby' => 'ORDER BY tr_name_en',
		'title' => 'LLL:EXT:'.STATIC_INFO_TABLES_EXTkey.'/locallang_db.xml:static_territories.title',
		'dynamicConfigFile' => PATH_BE_staticinfotables.'tca.php',
		'iconfile' => PATH_BE_staticinfotables_rel.'icon_static_territories.gif',
	),
	'interface' => array(
		'showRecordFieldList' => 'tr_name_en,tr_iso_nr'
	)
);

// Country reference data from ISO 3166-1
$TCA['static_countries'] = array(
	'ctrl' => array(
		'label' => 'cn_short_en',
		'label_alt' => 'cn_short_en,cn_iso_2',
		'readOnly' => 1,	// This should always be true, as it prevents the static data from being altered
		'adminOnly' => 1,
		'rootLevel' => 1,
		'is_static' => 1,
		'default_sortby' => 'ORDER BY cn_short_en',
		'delete' => 'deleted',
		'title' => 'LLL:EXT:'.STATIC_INFO_TABLES_EXTkey.'/locallang_db.xml:static_countries.title',
		'dynamicConfigFile' => PATH_BE_staticinfotables.'tca.php',
		'iconfile' => PATH_BE_staticinfotables_rel.'icon_static_countries.gif',
	),
	'interface' => array(
		'showRecordFieldList' => 'cn_iso_2,cn_iso_3,cn_iso_nr,cn_official_name_local,cn_official_name_en,cn_capital,cn_tldomain,cn_currency_iso_3,cn_currency_iso_nr,cn_phone,cn_uno_member,cn_eu_member,cn_address_format,cn_short_en'
	)
);

// Country subdivision reference data from ISO 3166-2
$TCA['static_country_zones'] = array(
	'ctrl' => array(
		'label' => 'zn_name_local',
		'label_alt' => 'zn_name_local,zn_code',
		'readOnly' => 1,
		'adminOnly' => 1,
		'rootLevel' => 1,
		'is_static' => 1,
		'default_sortby' => 'ORDER BY zn_name_local',
		'title' => 'LLL:EXT:'.STATIC_INFO_TABLES_EXTkey.'/locallang_db.xml:static_country_zones.title',
		'dynamicConfigFile' => PATH_BE_staticinfotables.'tca.php',
		'iconfile' => PATH_BE_staticinfotables_rel.'icon_static_countries.gif',
	),
	'interface' => array(
		'showRecordFieldList' => 'zn_country_iso_nr,zn_country_iso_3,zn_code,zn_name_local,zn_name_en'
	)
);

// Language reference data from ISO 639-1
$TCA['static_languages'] = array(
	'ctrl' => array(
		'label' => 'lg_name_en',
		'label_alt' => 'lg_name_en,lg_iso_2',
		'readOnly' => 1,
		'adminOnly' => 1,
		'rootLevel' => 1,
		'is_static' => 1,
		'default_sortby' => 'ORDER BY lg_name_en',
		'title' => 'LLL:EXT:'.STATIC_INFO_TABLES_EXTkey.'/locallang_db.xml:static_languages.title',
		'dynamicConfigFile' => PATH_BE_staticinfotables.'tca.php',
		'iconfile' => PATH_BE_staticinfotables_rel.'icon_static_languages.gif',
	),
	'interface' => array(
		'showRecordFieldList' => 'lg_name_local,lg_name_en,lg_iso_2,lg_typo3,lg_country_iso_2,lg_collate_locale,lg_sacred,lg_constructed'
	)
);

// Currency reference data from ISO 4217
$TCA['static_currencies'] = array(
	'ctrl' => array(
		'label' => 'cu_name_en',
		'label_alt' => 'cu_name_en,cu_iso_3',
		'readOnly' => 1,
		'adminOnly' => 1,
		'rootLevel' => 1,
		'is_static' => 1,
		'default_sortby' => 'ORDER BY cu_name_en',
		'title' => 'LLL:EXT:'.STATIC_INFO_TABLES_EXTkey.'/locallang_db.xml:static_currencies.title',
		'dynamicConfigFile' => PATH_BE_staticinfotables.'tca.php',
		'iconfile' => PATH_BE_staticinfotables_rel.'icon_static_currencies.gif',
	),
	'interface' => array(
		'showRecordFieldList' => 'cu_iso_3,cu_iso_nr,cu_name_en,cu_symbol_left,cu_symbol_right,cu_thousands_point,cu_decimal_point,cu_decimal_digits,cu_sub_name_en,cu_sub_divisor,cu_sub_symbol_left,cu_sub_symbol_right'
	)
);

$TCA['static_countries']['ctrl']['readOnly'] = 0;
$TCA['static_languages']['ctrl']['readOnly'] = 0;
$TCA['static_country_zones']['ctrl']['readOnly'] = 0;
$TCA['static_currencies']['ctrl']['readOnly'] = 0;
$TCA['static_territories']['ctrl']['readOnly'] = 0;


// ******************************************************************
// sys_language
// ******************************************************************

t3lib_div::loadTCA('sys_language');
$TCA['sys_language']['columns']['static_lang_isocode']['config'] = array(
	'type' => 'select',
	'items' => array(
		array('',0),
	),
	#'foreign_table' => 'static_languages',
	#'foreign_table_where' => 'AND static_languages.pid=0 ORDER BY static_languages.lg_name_en',
	'itemsProcFunc' => 'tx_staticinfotables_div->selectItemsTCA',
	'itemsProcFunc_config' => array(
		'table' => 'static_languages',
		'indexField' => 'uid',
		// I think that will make more sense in the future
		// 'indexField' => 'lg_iso_2',
		'prependHotlist' => 1,
		//	defaults:
		//'hotlistLimit' => 8,
		//'hotlistSort' => 1,
		//'hotlistOnly' => 0,
		//'hotlistApp' => TYPO3_MODE,
	),
	'size' => 1,
	'minitems' => 0,
	'maxitems' => 1,
);

$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'EXT:'.STATIC_INFO_TABLES_EXTkey.'/class.tx_staticinfotables_syslanguage.php:&tx_staticinfotables_syslanguage';


###########################
## EXTENSION: templavoila
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3conf/ext/templavoila/ext_tables.php
###########################

$_EXTKEY = 'templavoila';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


# TYPO3 CVS ID: $Id$
if (!defined ('TYPO3_MODE'))  die ('Access denied.');

// unserializing the configuration so we can use it here:
$_EXTCONF = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['templavoila']);

if (TYPO3_MODE=='BE') {

		// Adding click menu item:
	$GLOBALS['TBE_MODULES_EXT']['xMOD_alt_clickmenu']['extendCMclasses'][] = array(
		'name' => 'tx_templavoila_cm1',
		'path' => t3lib_extMgm::extPath($_EXTKEY).'class.tx_templavoila_cm1.php'
	);
	include_once(t3lib_extMgm::extPath('templavoila').'class.tx_templavoila_handlestaticdatastructures.php');

		// Adding backend modules:
	t3lib_extMgm::addModule('web','txtemplavoilaM1','top',t3lib_extMgm::extPath($_EXTKEY).'mod1/');
	t3lib_extMgm::addModule('web','txtemplavoilaM2','',t3lib_extMgm::extPath($_EXTKEY).'mod2/');

		// Remove default Page module (layout) manually if wanted:
	if (!$_EXTCONF['enable.']['oldPageModule']) {
		$tmp = $GLOBALS['TBE_MODULES']['web'];
		$GLOBALS['TBE_MODULES']['web'] = str_replace (',,',',',str_replace ('layout','',$tmp));
		unset ($GLOBALS['TBE_MODULES']['_PATHS']['web_layout']);
	}

		// Registering CSH:
	t3lib_extMgm::addLLrefForTCAdescr('be_groups','EXT:templavoila/locallang_csh_begr.xml');
	t3lib_extMgm::addLLrefForTCAdescr('pages','EXT:templavoila/locallang_csh_pages.xml');
	t3lib_extMgm::addLLrefForTCAdescr('tt_content','EXT:templavoila/locallang_csh_ttc.xml');
	t3lib_extMgm::addLLrefForTCAdescr('tx_templavoila_datastructure','EXT:templavoila/locallang_csh_ds.xml');
	t3lib_extMgm::addLLrefForTCAdescr('tx_templavoila_tmplobj','EXT:templavoila/locallang_csh_to.xml');
	t3lib_extMgm::addLLrefForTCAdescr('xMOD_tx_templavoila','EXT:templavoila/locallang_csh_module.xml');
	t3lib_extMgm::addLLrefForTCAdescr('xEXT_templavoila','EXT:templavoila/locallang_csh_intro.xml');
	t3lib_extMgm::addLLrefForTCAdescr('_MOD_web_txtemplavoilaM1','EXT:templavoila/locallang_csh_pm.xml');


	t3lib_extMgm::insertModuleFunction(
		'tools_txextdevevalM1',
		'tx_templavoila_extdeveval',
		t3lib_extMgm::extPath($_EXTKEY).'class.tx_templavoila_extdeveval.php',
		'TemplaVoila L10N Mode Conversion Tool'
	);
}

	// Adding tables:
$TCA['tx_templavoila_tmplobj'] = Array (
	'ctrl' => Array (
		'title' => 'LLL:EXT:templavoila/locallang_db.xml:tx_templavoila_tmplobj',
		'label' => 'title',
		'label_userFunc' => 'EXT:templavoila/classes/class.tx_templavoila_label.php:&tx_templavoila_label->getLabel',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',
		'default_sortby' => 'ORDER BY title',
		'delete' => 'deleted',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY).'icon_to.gif',
		'selicon_field' => 'previewicon',
		'selicon_field_path' => 'uploads/tx_templavoila',
		'type' => 'parent',
		'versioningWS' => TRUE,
		'origUid' => 't3_origuid',
		'shadowColumnsForNewPlaceholders' => 'title,datastructure,rendertype,sys_language_uid,parent,rendertype_ref',
	)
);
$TCA['tx_templavoila_datastructure'] = Array (
	'ctrl' => Array (
		'title' => 'LLL:EXT:templavoila/locallang_db.xml:tx_templavoila_datastructure',
		'label' => 'title',
		'label_userFunc' => 'EXT:templavoila/classes/class.tx_templavoila_label.php:&tx_templavoila_label->getLabel',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',
		'default_sortby' => 'ORDER BY title',
		'delete' => 'deleted',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY).'icon_ds.gif',
		'selicon_field' => 'previewicon',
		'selicon_field_path' => 'uploads/tx_templavoila',
		'versioningWS' => TRUE,
		'origUid' => 't3_origuid',
		'shadowColumnsForNewPlaceholders' => 'scope,title',
	)
);

t3lib_extMgm::allowTableOnStandardPages('tx_templavoila_datastructure');
t3lib_extMgm::allowTableOnStandardPages('tx_templavoila_tmplobj');


	// Adding access list to be_groups
t3lib_div::loadTCA('be_groups');
$tempColumns = array (
	'tx_templavoila_access' => array(
		'label' => 'LLL:EXT:templavoila/locallang_db.xml:be_groups.tx_templavoila_access',
		'config' => Array (
			'type' => 'group',
			'internal_type' => 'db',
			'allowed' => 'tx_templavoila_datastructure,tx_templavoila_tmplobj',
			'prepend_tname' => 1,
			'size' => 5,
			'autoSizeMax' => 15,
			'multiple' => 1,
			'minitems' => 0,
			'maxitems' => 1000,
			'show_thumbs'=> 1,
		),
	)
);
t3lib_extMgm::addTCAcolumns('be_groups', $tempColumns, 1);
t3lib_extMgm::addToAllTCAtypes('be_groups','tx_templavoila_access;;;;1-1-1', '1');

	// Adding the new content element, "Flexible Content":
t3lib_div::loadTCA('tt_content');
$tempColumns = array(
	'tx_templavoila_ds' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:templavoila/locallang_db.xml:tt_content.tx_templavoila_ds',
		'config' => Array (
			'type' => 'select',
			'items' => Array (
				Array('',0),
			),
			'allowNonIdValues' => 1,
			'itemsProcFunc' => 'tx_templavoila_handleStaticdatastructures->dataSourceItemsProcFunc',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
			'selicon_cols' => 10,
		)
	),
	'tx_templavoila_to' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:templavoila/locallang_db.xml:tt_content.tx_templavoila_to',
		'displayCond' => 'FIELD:CType:=:' . $_EXTKEY . '_pi1',
		'config' => Array (
			'type' => 'select',
			'items' => Array (
				Array('',0),
			),
			'itemsProcFunc' => 'tx_templavoila_handleStaticdatastructures->templateObjectItemsProcFunc',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
			'selicon_cols' => 10,
		)
	),
	'tx_templavoila_flex' => Array (
		'l10n_cat' => 'text',
		'exclude' => 1,
		'label' => 'LLL:EXT:templavoila/locallang_db.xml:tt_content.tx_templavoila_flex',
		'displayCond' => 'FIELD:tx_templavoila_ds:REQ:true',
		'config' => Array (
			'type' => 'flex',
			'ds_pointerField' => 'tx_templavoila_ds',
			'ds_tableField' => 'tx_templavoila_datastructure:dataprot',
		)
	),
	'tx_templavoila_pito' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:templavoila/locallang_db.xml:tt_content.tx_templavoila_pito',
		'config' => Array (
			'type' => 'select',
			'items' => Array (
				Array('',0),
			),
			'itemsProcFunc' => 'tx_templavoila_handleStaticdatastructures->pi_templates',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
			'selicon_cols' => 10,
		)
	),
);
t3lib_extMgm::addTCAcolumns('tt_content', $tempColumns, 1);

$TCA['tt_content']['ctrl']['typeicons'][$_EXTKEY . '_pi1'] = t3lib_extMgm::extRelPath($_EXTKEY) . '/icon_fce_ce.png';
$GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes'][$_EXTKEY . '_pi1'] =  'extensions-templavoila-type-fce';
t3lib_extMgm::addPlugin(array('LLL:EXT:templavoila/locallang_db.xml:tt_content.CType_pi1', $_EXTKEY . '_pi1', 'EXT:' . $_EXTKEY . '/icon_fce_ce.png'), 'CType');

if ($_EXTCONF['enable.']['selectDataStructure']) {
	if ($TCA['tt_content']['ctrl']['requestUpdate'] != '') {
		$TCA['tt_content']['ctrl']['requestUpdate'] .= ',';
	}
	$TCA['tt_content']['ctrl']['requestUpdate'] .= 'tx_templavoila_ds';
}


if(tx_templavoila_div::convertVersionNumberToInteger(TYPO3_version) >= 4005000) {

		$TCA['tt_content']['types'][$_EXTKEY . '_pi1']['showitem'] =
					'--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.general;general,
					--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.headers;headers,
				--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,
					--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.visibility;visibility,
					--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.access;access,
				--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.appearance,
					--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.frames;frames,
				--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.extended';
		if ($_EXTCONF['enable.']['selectDataStructure']) {
			t3lib_extMgm::addToAllTCAtypes('tt_content', 'tx_templavoila_ds;;;;1-1-1,tx_templavoila_to', $_EXTKEY . '_pi1', 'after:layout');
		} else {
			t3lib_extMgm::addToAllTCAtypes('tt_content', 'tx_templavoila_to', $_EXTKEY . '_pi1', 'after:layout');
		}
		t3lib_extMgm::addToAllTCAtypes('tt_content', 'tx_templavoila_flex;;;;1-1-1', $_EXTKEY . '_pi1', 'after:subheader');

} else {
	$TCA['tt_content']['types'][$_EXTKEY . '_pi1']['showitem'] =
		'CType;;4;;1-1-1, hidden, header;;' . (($_EXTCONF['enable.']['renderFCEHeader']) ? '3' : '' ) . ';;2-2-2, linkToTop;;;;3-3-3,
		--div--;LLL:EXT:templavoila/locallang_db.xml:tt_content.CType_pi1,' . (($_EXTCONF['enable.']['selectDataStructure']) ? 'tx_templavoila_ds,' : '') . 'tx_templavoila_to,tx_templavoila_flex;;;;2-2-2,
		--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.access, starttime, endtime, fe_group';
}


	// For pages:
$tempColumns = array (
	'tx_templavoila_ds' => array (
		'exclude' => 1,
		'label' => 'LLL:EXT:templavoila/locallang_db.xml:pages.tx_templavoila_ds',
		'config' => array (
			'type' => 'select',
			'items' => Array (
				array('',0),
			),
			'allowNonIdValues' => 1,
			'itemsProcFunc' => 'tx_templavoila_handleStaticdatastructures->dataSourceItemsProcFunc',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
			'suppress_icons' => 'ONLY_SELECTED',
			'selicon_cols' => 10,
		)
	),
	'tx_templavoila_to' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:templavoila/locallang_db.xml:pages.tx_templavoila_to',
		'displayCond' => 'FIELD:tx_templavoila_ds:REQ:true',
		'config' => Array (
			'type' => 'select',
			'items' => Array (
				Array('',0),
			),
			'itemsProcFunc' => 'tx_templavoila_handleStaticdatastructures->templateObjectItemsProcFunc',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
			'suppress_icons' => 'ONLY_SELECTED',
			'selicon_cols' => 10,
		)
	),
	'tx_templavoila_next_ds' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:templavoila/locallang_db.xml:pages.tx_templavoila_next_ds',
		'config' => Array (
			'type' => 'select',
			'items' => Array (
				Array('',0),
			),
			'allowNonIdValues' => 1,
			'itemsProcFunc' => 'tx_templavoila_handleStaticdatastructures->dataSourceItemsProcFunc',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
			'suppress_icons' => 'ONLY_SELECTED',
			'selicon_cols' => 10,
		)
	),
	'tx_templavoila_next_to' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:templavoila/locallang_db.xml:pages.tx_templavoila_next_to',
		'displayCond' => 'FIELD:tx_templavoila_next_ds:REQ:true',
		'config' => Array (
			'type' => 'select',
			'items' => Array (
				Array('',0),
			),
			'itemsProcFunc' => 'tx_templavoila_handleStaticdatastructures->templateObjectItemsProcFunc',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
			'suppress_icons' => 'ONLY_SELECTED',
			'selicon_cols' => 10,
		)
	),
	'tx_templavoila_flex' => Array (
		'exclude' => 1,
		'label' => 'LLL:EXT:templavoila/locallang_db.xml:pages.tx_templavoila_flex',
		'config' => Array (
			'type' => 'flex',
			'ds_pointerField' => 'tx_templavoila_ds',
			'ds_pointerField_searchParent' => 'pid',
			'ds_pointerField_searchParent_subField' => 'tx_templavoila_next_ds',
			'ds_tableField' => 'tx_templavoila_datastructure:dataprot',
		)
	),
);
t3lib_extMgm::addTCAcolumns('pages', $tempColumns, 1);
if ($_EXTCONF['enable.']['selectDataStructure']) {

	if(tx_templavoila_div::convertVersionNumberToInteger(TYPO3_version) >= 4005000) {
		t3lib_extMgm::addToAllTCAtypes('pages', 'tx_templavoila_ds;;;;1-1-1,tx_templavoila_to', '', 'replace:backend_layout');
		t3lib_extMgm::addToAllTCAtypes('pages', 'tx_templavoila_next_ds;;;;1-1-1,tx_templavoila_next_to', '', 'replace:backend_layout_next_level');
		t3lib_extMgm::addToAllTCAtypes('pages', 'tx_templavoila_flex;;;;1-1-1', '', 'after:title');
	} else {
		t3lib_extMgm::addToAllTCAtypes('pages','tx_templavoila_ds;;;;1-1-1,tx_templavoila_to,tx_templavoila_next_ds;;;;1-1-1,tx_templavoila_next_to,tx_templavoila_flex;;;;1-1-1');
	}

	if ($TCA['pages']['ctrl']['requestUpdate'] != '') {
		$TCA['pages']['ctrl']['requestUpdate'] .= ',';
	}
	$TCA['pages']['ctrl']['requestUpdate'] .= 'tx_templavoila_ds,tx_templavoila_next_ds';

} else {
	if(tx_templavoila_div::convertVersionNumberToInteger(TYPO3_version) >= 4005000) {
		if (!$_EXTCONF['enable.']['oldPageModule']) {
			t3lib_extMgm::addToAllTCAtypes('pages', 'tx_templavoila_to;;;;1-1-1', '', 'replace:backend_layout');
			t3lib_extMgm::addToAllTCAtypes('pages', 'tx_templavoila_next_to;;;;1-1-1', '', 'replace:backend_layout_next_level');
			t3lib_extMgm::addToAllTCAtypes('pages', 'tx_templavoila_flex;;;;1-1-1', '', 'after:title');
		} else {
			t3lib_extMgm::addFieldsToPalette('pages', 'layout', '--linebreak--, tx_templavoila_to;;;;1-1-1, tx_templavoila_next_to;;;;1-1-1', 'after:backend_layout_next_level');
			t3lib_extMgm::addToAllTCAtypes('pages', 'tx_templavoila_flex;;;;1-1-1', '', 'after:title');
		}
	} else {
		t3lib_extMgm::addToAllTCAtypes('pages','tx_templavoila_to;;;;1-1-1,tx_templavoila_next_to;;;;1-1-1,tx_templavoila_flex;;;;1-1-1');
	}

	unset($TCA['pages']['columns']['tx_templavoila_to']['displayCond']);
	unset($TCA['pages']['columns']['tx_templavoila_next_to']['displayCond']);
}

	// Configure the referencing wizard to be used in the web_func module:
if (TYPO3_MODE=='BE')	{
	t3lib_extMgm::insertModuleFunction(
		'web_func',
		'tx_templavoila_referenceElementsWizard',
		t3lib_extMgm::extPath($_EXTKEY).'func_wizards/class.tx_templavoila_referenceelementswizard.php',
		'LLL:EXT:templavoila/locallang.xml:wiz_refElements',
		'wiz'
	);
	t3lib_extMgm::insertModuleFunction(
		'web_func',
		'tx_templavoila_renameFieldInPageFlexWizard',
		t3lib_extMgm::extPath($_EXTKEY).'func_wizards/class.tx_templavoila_renamefieldinpageflexwizard.php',
		'LLL:EXT:templavoila/locallang.xml:wiz_renameFieldsInPage',
		'wiz'
	);
	t3lib_extMgm::addLLrefForTCAdescr('_MOD_web_func','EXT:wizard_crpages/locallang_csh.xml');
}
	// complex condition to make sure the icons are available during frontend editing...
if (TYPO3_MODE == 'BE' ||
	(TYPO3_MODE == 'FE' && isset($GLOBALS['BE_USER']) && method_exists($GLOBALS['BE_USER'], 'isFrontendEditingActive')  && $GLOBALS['BE_USER']->isFrontendEditingActive())
) {
	$icons = array(
		'paste' => t3lib_extMgm::extRelPath('templavoila') . 'mod1/clip_pasteafter.gif',
		'pasteSubRef' => t3lib_extMgm::extRelPath('templavoila') . 'mod1/clip_pastesubref.gif',
		'makelocalcopy' => t3lib_extMgm::extRelPath('templavoila') . 'mod1/makelocalcopy.gif',
		'clip_ref' => t3lib_extMgm::extRelPath('templavoila') . 'mod1/clip_ref.gif',
		'clip_ref-release' => t3lib_extMgm::extRelPath('templavoila') . 'mod1/clip_ref_h.gif',
		'unlink' => t3lib_extMgm::extRelPath('templavoila') . 'mod1/unlink.png',
		'htmlvalidate' => t3lib_extMgm::extRelPath('templavoila') . 'resources/icons/html_go.png',
		'type-fce' => t3lib_extMgm::extRelPath('templavoila') . 'icon_fce_ce.png'
	);
	t3lib_SpriteManager::addSingleIcons($icons, $_EXTKEY);
}

###########################
## EXTENSION: crawler
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3conf/ext/crawler/ext_tables.php
###########################

$_EXTKEY = 'crawler';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE=='BE')	{

		// add info module function
	t3lib_extMgm::insertModuleFunction(
		'web_info',
		'tx_crawler_modfunc1',
		t3lib_extMgm::extPath($_EXTKEY).'modfunc1/class.tx_crawler_modfunc1.php',
		'LLL:EXT:crawler/locallang_db.php:moduleFunction.tx_crawler_modfunc1'
	);

		// add context menu item
	$GLOBALS['TBE_MODULES_EXT']['xMOD_alt_clickmenu']['extendCMclasses'][] = array(
		'name' => 'tx_crawler_contextMenu',
		'path' => t3lib_extMgm::extPath($_EXTKEY).'class.tx_crawler_contextMenu.php'
	);

}

t3lib_extMgm::allowTableOnStandardPages('tx_crawler_configuration');

$TCA["tx_crawler_configuration"] = array (
    "ctrl" => array (
        'title'     => 'LLL:EXT:crawler/locallang_db.xml:tx_crawler_configuration',
        'label'     => 'name',
        'tstamp'    => 'tstamp',
        'crdate'    => 'crdate',
        'cruser_id' => 'cruser_id',
        'default_sortby' => "ORDER BY crdate",
        'delete' => 'deleted',
        'enablecolumns' => array (
            'disabled' => 'hidden',
        ),
        'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
        'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_crawler_configuration.gif',
    ),
    "feInterface" => array (
        "fe_admin_fieldList" => "hidden, name, processing_instruction_filter, processing_instruction_parameters_ts, configuration, base_url, pidsonly, begroups,fegroups, sys_workspace_uid, realurl, chash, exclude",
    )
);


###########################
## EXTENSION: itao_fix
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3conf/ext/itao_fix/ext_tables.php
###########################

$_EXTKEY = 'itao_fix';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}


###########################
## EXTENSION: datamints_feuser
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3conf/ext/datamints_feuser/ext_tables.php
###########################

$_EXTKEY = 'datamints_feuser';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';

if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_datamintsfeuser_pi1_wizicon'] = t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_datamintsfeuser_pi1_wizicon.php';
}

t3lib_extMgm::addPlugin(array('LLL:EXT:datamints_feuser/locallang_db.xml:tt_content.list_type_pi1', $_EXTKEY . '_pi1', t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'), 'list_type');

// Static Template festlegen.
t3lib_extMgm::addStaticFile($_EXTKEY,'pi1/static/', 'Frontend User Management');

// Extension Konfiguration auslesen.
$confArray = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY]);

// Flexform und Flexformfunktionen einbinden.
include_once(t3lib_extMgm::extPath($_EXTKEY).'class.tx_flexform_getFieldNames.php');
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY . '_pi1'] = 'pi_flexform';

if ($confArray['useIRRE']) {
	t3lib_extMgm::addPiFlexFormValue($_EXTKEY . '_pi1','FILE:EXT:' . $_EXTKEY . '/flexform_data_pi1_irre.xml');
} else {
	t3lib_extMgm::addPiFlexFormValue($_EXTKEY . '_pi1','FILE:EXT:' . $_EXTKEY . '/flexform_data_pi1.xml');
}


$tempColumns = array (
	'tx_datamintsfeuser_firstname' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:datamints_feuser/locallang_db.xml:fe_users.tx_datamintsfeuser_firstname',		
		'config' => array (
			'type' => 'input',
			'size' => '30',
			'eval' => 'trim',
		)
	),
	'tx_datamintsfeuser_surname' => array (		
		'exclude' => 1,
		'label' => 'LLL:EXT:datamints_feuser/locallang_db.xml:fe_users.tx_datamintsfeuser_surname',
		'config' => array (
			'type' => 'input',
			'size' => '30',
			'eval' => 'trim',
		)
	),
	'tx_datamintsfeuser_approval_level' => array (
		'exclude' => 1,
		'label' => 'LLL:EXT:datamints_feuser/locallang_db.xml:fe_users.tx_datamintsfeuser_approval_level',
		'config' => Array (
			'type'     => 'input',
			'size'     => '2',
			'eval'     => 'int',
			'range'    => array (
				'upper' => '2',
				'lower' => '0'
			),
			'default' => 0
		)
	),
);

t3lib_div::loadTCA('fe_users');
t3lib_extMgm::addTCAcolumns('fe_users', $tempColumns, 1);

//$TCA['fe_users']['types'][0]['showitem'] = str_replace('name;;1;;1-1-1,', 'name;;1;;1-1-1, tx_datamintsfeuser_firstname, tx_datamintsfeuser_surname,', $TCA['fe_users']['types'][0]['showitem']);
//t3lib_extMgm::addFieldsToAllPalettesOfField('fe_users', 'name', 'tx_datamintsfeuser_firstname, tx_datamintsfeuser_surname, --linebreak--', 'before:title,before:first_name');
t3lib_extMgm::addToAllTCAtypes('fe_users', 'tx_datamintsfeuser_firstname, tx_datamintsfeuser_surname', '', 'after:name');
t3lib_extMgm::addToAllTCAtypes( 'fe_users', '--div--;LLL:EXT:datamints_feuser/locallang_db.xml:tt_content.list_type_pi1, tx_datamintsfeuser_approval_level;;;;1-1-1');


###########################
## EXTENSION: itao_zfalogin
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3conf/ext/itao_zfalogin/ext_tables.php
###########################

$_EXTKEY = 'itao_zfalogin';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


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

###########################
## EXTENSION: felogin
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/felogin/ext_tables.php
###########################

$_EXTKEY = 'felogin';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$_EXTCONF = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['felogin']);

t3lib_div::loadTCA('tt_content');

if(t3lib_utility_VersionNumber::convertVersionNumberToInteger(TYPO3_version) >= 4002000) {
	t3lib_extMgm::addPiFlexFormValue('*', 'FILE:EXT:' . $_EXTKEY . '/flexform.xml', 'login');
} else {
	t3lib_extMgm::addPiFlexFormValue('default', 'FILE:EXT:' . $_EXTKEY . '/flexform.xml');
}

t3lib_extMgm::addTcaSelectItem(
	'tt_content',
	'CType',
	array(
		'LLL:EXT:cms/locallang_ttc.xml:CType.I.10',
		'login',
		'i/tt_content_login.gif',
	),
	'mailform',
	'after'
);

$TCA['tt_content']['types']['login']['showitem'] = '--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.general;general,
													--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.header;header,
													--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.plugin,
													pi_flexform;;;;1-1-1,
													--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,
													--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.visibility;visibility,
													--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.access;access,
													--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.appearance,
													--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.frames;frames,
													--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.behaviour,
													--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.extended';

	// Adds the redirect field to the fe_groups table
$tempColumns = array(
	'felogin_redirectPid' => array(
		'exclude' => 1,
		'label'  => 'LLL:EXT:felogin/locallang_db.xml:felogin_redirectPid',
		'config' => array(
			'type' => 'group',
			'internal_type' => 'db',
			'allowed' => 'pages',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
			'wizards' => array(
				'suggest' => array(
					'type' => 'suggest',
				),
			),
		)
	),
);

t3lib_div::loadTCA('fe_groups');
t3lib_extMgm::addTCAcolumns('fe_groups', $tempColumns, 1);
t3lib_extMgm::addToAllTCAtypes('fe_groups', 'felogin_redirectPid;;;;1-1-1', '', 'after:TSconfig');

	// Adds the redirect field and the forgotHash field to the fe_users-table
$tempColumns = array(
	'felogin_redirectPid' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:felogin/locallang_db.xml:felogin_redirectPid',
		'config' => array(
			'type' => 'group',
			'internal_type' => 'db',
			'allowed' => 'pages',
			'size' => 1,
			'minitems' => 0,
			'maxitems' => 1,
			'wizards' => array(
				'suggest' => array(
					'type' => 'suggest',
				),
			),
		)
	),
	'felogin_forgotHash' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:felogin/locallang_db.xml:felogin_forgotHash',
		'config' => array(
			'type' => 'passthrough',
		)
	),
);

t3lib_div::loadTCA('fe_users');
t3lib_extMgm::addTCAcolumns('fe_users', $tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('fe_users', 'felogin_redirectPid;;;;1-1-1', '', 'after:TSconfig');


###########################
## EXTENSION: dragdrop
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3conf/ext/dragdrop/ext_tables.php
###########################

$_EXTKEY = 'dragdrop';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

###########################
## EXTENSION: itao_shh_redirect
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3conf/ext/itao_shh_redirect/ext_tables.php
###########################

$_EXTKEY = 'itao_shh_redirect';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key,pages';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:itao_shh_redirect/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_itaoshhredirect_pi1_wizicon'] = t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_itaoshhredirect_pi1_wizicon.php';
}




t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi2']='layout,select_key,pages';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:itao_shh_redirect/locallang_db.xml:tt_content.list_type_pi2',
	$_EXTKEY . '_pi2',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_itaoshhredirect_pi2_wizicon'] = t3lib_extMgm::extPath($_EXTKEY).'pi2/class.tx_itaoshhredirect_pi2_wizicon.php';
}

###########################
## EXTENSION: phpmyadmin
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3conf/ext/phpmyadmin/ext_tables.php
###########################

$_EXTKEY = 'phpmyadmin';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


/**
 * TYPO3 Extension configuration for the tx_phpmyadmin Extension
 *
 * @author		mehrwert <typo3@mehrwert.de>
 * @package		TYPO3
 * @subpackage	tx_phpmyadmin
 * @license		GPL
 * @version		$Id: ext_tables.php 65377 2012-08-13 16:27:56Z mehrwert $
 */

if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

	// Get config
$extensionConfiguration = unserialize($TYPO3_CONF_VARS['EXT']['extConf']['phpmyadmin']);

	// Check for IP restriction (devIpMask), and die if not allowed
$showPhpMyAdminInWebModule = (boolean) $extensionConfiguration['showPhpMyAdminInWebModule'];

	// If the backend is loaded, add the module
if (TYPO3_MODE == 'BE') {
	t3lib_extMgm::addModule('tools', 'txphpmyadmin', '', t3lib_extMgm::extPath($_EXTKEY) . 'modsub/');
}

	// Require the utilities class and define logoff method for hook
require_once(t3lib_extMgm::extPath('phpmyadmin').'res/class.tx_phpmyadmin_utilities.php');

	// Do not load post processing class if TYPO3 is in CLI mode
if (!defined('TYPO3_cliMode') || !TYPO3_cliMode) {
	$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_userauth.php']['logoff_post_processing'][] = 'tx_phpmyadmin_utilities->pmaLogOff';
}

	// The subdirectory where the pMA source is located (used for cookie removal and script inclusion)
$TYPO3_CONF_VARS['EXTCONF']['phpmyadmin']['pmaDirname'] = 'phpMyAdmin-3.5.2.2-all-languages';


###########################
## EXTENSION: sr_freecap
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3conf/ext/sr_freecap/ext_tables.php
###########################

$_EXTKEY = 'sr_freecap';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}
if (TYPO3_MODE === 'BE') {
		// GDlib is a requirement for the BE module
	if ($GLOBALS['TYPO3_CONF_VARS']['GFX']['gdlib']) {
		t3lib_extMgm::addModule('tools', 'txsrfreecapM1', '', t3lib_extMgm::extPath($_EXTKEY).'mod1/');
	}
}

###########################
## EXTENSION: indexed_search
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3/sysext/indexed_search/ext_tables.php
###########################

$_EXTKEY = 'indexed_search';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

t3lib_extMgm::addPlugin(Array('LLL:EXT:indexed_search/locallang.php:mod_indexed_search', $_EXTKEY));

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY] = 'layout,select_key,pages';

// Registers the Extbase plugin to be listed in the Backend.
if (t3lib_extMgm::isLoaded('extbase')) {
	$extensionName = t3lib_div::underscoredToUpperCamelCase($_EXTKEY);
		Tx_Extbase_Utility_Extension::registerPlugin($_EXTKEY, 'Pi2',
			// the title shown in the backend dropdown field
		'Indexed Search (experimental)'
	);
	$pluginSignature = strtolower($extensionName) . '_pi2';
	$TCA['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,select_key,pages,recursive';
}

if (TYPO3_MODE=='BE')    {
	t3lib_extMgm::addModule('tools','isearch','after:log',t3lib_extMgm::extPath($_EXTKEY).'mod/');

	t3lib_extMgm::insertModuleFunction(
		'web_info',
		'tx_indexedsearch_modfunc1',
		t3lib_extMgm::extPath($_EXTKEY).'modfunc1/class.tx_indexedsearch_modfunc1.php',
		'LLL:EXT:indexed_search/locallang.php:mod_indexed_search'
	);
	t3lib_extMgm::insertModuleFunction(
		"web_info",
		"tx_indexedsearch_modfunc2",
		t3lib_extMgm::extPath($_EXTKEY)."modfunc2/class.tx_indexedsearch_modfunc2.php",
		"LLL:EXT:indexed_search/locallang.php:mod2_indexed_search"
	);
}

t3lib_extMgm::allowTableOnStandardPages('index_config');
t3lib_extMgm::addLLrefForTCAdescr('index_config','EXT:indexed_search/locallang_csh_indexcfg.xml');

$TCA['index_config'] = array(
	'ctrl' => array(
		'title' => 'LLL:EXT:indexed_search/locallang_db.php:index_config',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'type' => 'type',
		'default_sortby' => 'ORDER BY crdate',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'tca.php',
		'iconfile' => 'default.gif',
	),
	'feInterface' => array(
		'fe_admin_fieldList' => 'hidden, starttime, title, description, type, depth, table2index, alternative_source_pid, get_params, chashcalc, filepath, extensions',
	)
);


	// Example of crawlerhook (see also ext_localconf.php!)
/*
	t3lib_div::loadTCA('index_config');
	$TCA['index_config']['columns']['type']['config']['items'][] =  Array('My Crawler hook!', 'tx_myext_example1');
	$TCA['index_config']['types']['tx_myext_example1'] = $TCA['index_config']['types']['0'];
*/


###########################
## EXTENSION: macina_searchbox
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3conf/ext/macina_searchbox/ext_tables.php
###########################

$_EXTKEY = 'macina_searchbox';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ("TYPO3_MODE")) 	die ("Access denied.");

t3lib_div::loadTCA("tt_content");
$TCA["tt_content"]["types"]["list"]["subtypes_excludelist"][$_EXTKEY."_pi1"]="layout,select_key";


t3lib_extMgm::addPlugin(Array("LLL:EXT:macina_searchbox/locallang_db.php:tt_content.list_type", $_EXTKEY."_pi1"),"list_type");


if (TYPO3_MODE=="BE")	$TBE_MODULES_EXT["xMOD_db_new_content_el"]["addElClasses"]["tx_macinasearchbox_pi1_wizicon"] = t3lib_extMgm::extPath($_EXTKEY)."pi1/class.tx_macinasearchbox_pi1_wizicon.php";

###########################
## EXTENSION: itao_fancy_gallery
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3conf/ext/itao_fancy_gallery/ext_tables.php
###########################

$_EXTKEY = 'itao_fancy_gallery';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$tempColumns = Array (
	"itao_fancy_gallery" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:itao_fancy_gallery/locallang_db.xml:tt_content.gallery",		
		"config" => Array (
			"type" => "check",
		)
	)
);


t3lib_div::loadTCA("tt_content");
t3lib_extMgm::addTCAcolumns("tt_content",$tempColumns,1);
t3lib_extMgm::addStaticFile($_EXTKEY,'static/', 'Perfect Lightbox');

$GLOBALS['TCA']['tt_content']['palettes']['7']['showitem'] .= ', itao_fancy_gallery';
# BEN: Quickfix for TYPO3 4.5
$GLOBALS['TCA']['tt_content']['palettes']['imagelinks']['showitem'] .= ', itao_fancy_gallery';

###########################
## EXTENSION: itao_shh_offers
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3conf/ext/itao_shh_offers/ext_tables.php
###########################

$_EXTKEY = 'itao_shh_offers';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Offers',
	'Vorschläge'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'SchoolData',
	'Schuldaten'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'OfferStatus',
	'Status meiner Vorschläge'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Print',
	'Vorschläge Drucken'
);
	
Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Feedback',
	'Feedback'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'SortAndFilter',
	'Box: Vorschläge sortieren und filtern'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'RedirectToCommunePage',
	'Weiterleitung auf Kommunenseite (Kommunenverwalter)'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'CommuneList',
	'Liste der Kommunen'
);


$extensionName = t3lib_div::underscoredToUpperCamelCase($_EXTKEY);

// Flexform Offers
$pluginSignature = strtolower($extensionName) . '_offers';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForms/offers_flexform.xml');

// Flexform School
$pluginSignature = strtolower($extensionName) . '_schooldata';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForms/schooldata_flexform.xml');

// Flexform Print
$pluginSignature = strtolower($extensionName) . '_print';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForms/print_flexform.xml');


t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Vorschläge');

			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_offer', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_offer.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_offer');
			$TCA['tx_itaoshhoffers_domain_model_offer'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer',
					'label' => 'title',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Offer.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/offer.gif',
					'default_sortby' => 'title',
					'foreign_default_sortby' => 'title',
					'searchFields' => 'title'
				),
			);


			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_idea', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_idea.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_idea');
			$TCA['tx_itaoshhoffers_domain_model_idea'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_idea',
					'label' => 'name',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Idea.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/idea.gif'
				),
			);
			
			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_promoter', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_promoter.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_promoter');
			$TCA['tx_itaoshhoffers_domain_model_promoter'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_promoter',
					'label' => 'name',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Promoter.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/promoter.gif'
				),
			);

			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_status', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_status.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_status');
			$TCA['tx_itaoshhoffers_domain_model_status'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_status',
					'label' => 'title',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Status.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/status.gif'
				),
			);
			
			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_action', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_action.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_action');
			$TCA['tx_itaoshhoffers_domain_model_action'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_action',
					'label' => 'title',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Action.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/status.gif',
					'default_sortby' => 'tstamp',
					'searchFields' => 'title'
				),
			);

//			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_likedislike', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_likedislike.xml');
//			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_likedislike');
//			$TCA['tx_itaoshhoffers_domain_model_likedislike'] = array(
//				'ctrl' => array(
//					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_likedislike',
//					'label' => 'status',
//					'tstamp' => 'tstamp',
//					'crdate' => 'crdate',
//					'cruser_id' => 'cruser_id',
//					'dividers2tabs' => TRUE,
//					'versioningWS' => 2,
//					'versioning_followPages' => TRUE,
//					'origUid' => 't3_origuid',
//					'languageField' => 'sys_language_uid',
//					'transOrigPointerField' => 'l10n_parent',
//					'transOrigDiffSourceField' => 'l10n_diffsource',
//					'delete' => 'deleted',
//					'enablecolumns' => array(
//						'disabled' => 'hidden',
//						'starttime' => 'starttime',
//						'endtime' => 'endtime',
//					),
//					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/LikeDislike.php',
//					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/like.gif'
//				),
//			);
			
			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_dislike', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_dislike.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_dislike');
			$TCA['tx_itaoshhoffers_domain_model_dislike'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_dislike',
					'label' => 'fe_user',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Dislike.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/like.gif'
				),
			);

			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_like', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_like.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_like');
			$TCA['tx_itaoshhoffers_domain_model_like'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_like',
					'label' => 'fe_user',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Like.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/like.gif'
				),
			);

			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_comment', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_comment.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_comment');
			$TCA['tx_itaoshhoffers_domain_model_comment'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_comment',
					'label' => 'text',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Comment.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/comment.gif'
				),
			);

			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_commentlog', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_commentlog.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_commentlog');
			$TCA['tx_itaoshhoffers_domain_model_commentlog'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_commentlog',
					'label' => 'date',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/CommentLog.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/log.gif'
				),
			);
			
			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_filter', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_filter.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_filter');
			$TCA['tx_itaoshhoffers_domain_model_filter'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_filter',
					'label' => 'title',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Filter.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/filter.gif'
				),
			);
			
			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_filteroption', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_filteroption.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_filteroption');
			$TCA['tx_itaoshhoffers_domain_model_filteroption'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_filteroption',
					'label' => 'title',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/FilterOption.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/option.gif',
					'default_sortby' => 'sorting'
				),
			);
			
			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_sort', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_sort.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_sort');
			$TCA['tx_itaoshhoffers_domain_model_sort'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_sort',
					'label' => 'title',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Sort.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/sort.gif'
				),
			);
			
			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_sortoption', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_sortoption.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_sortoption');
			$TCA['tx_itaoshhoffers_domain_model_sortoption'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_sortoption',
					'label' => 'title',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/SortOption.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/option.gif',
					'default_sortby' => 'sorting'
				),
			);

$tmp_itao_shh_offers_columns = array(

);

t3lib_extMgm::addTCAcolumns('fe_users',$tmp_itao_shh_offers_columns);

$TCA['fe_users']['columns'][$TCA['fe_users']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:fe_users.tx_extbase_type.Tx_ItaoShhOffers_FeUser','Tx_ItaoShhOffers_FeUser');

$TCA['fe_users']['types']['Tx_ItaoShhOffers_FeUser']['showitem'] = $TCA['fe_users']['types']['1']['showitem'];
$TCA['fe_users']['types']['Tx_ItaoShhOffers_FeUser']['showitem'] .= ',--div--;LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_feuser,';
$TCA['fe_users']['types']['Tx_ItaoShhOffers_FeUser']['showitem'] .= '';

			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_offerlog', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_offerlog.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_offerlog');
			$TCA['tx_itaoshhoffers_domain_model_offerlog'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offerlog',
					'label' => 'date',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/OfferLog.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/log.gif',
					'default_sortby' => 'date'
				),
			);


###########################
## EXTENSION: itao_felogin_ext
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3conf/ext/itao_felogin_ext/ext_tables.php
###########################

$_EXTKEY = 'itao_felogin_ext';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];



require_once(t3lib_extMgm::extPath('itao_felogin_ext') . 'pi1/class.tx_itaofeloginext_pi1.php');


###########################
## EXTENSION: itao_shh_manager
## FILE:      /vols/local/vol1/www/web-856/html.sv/typo3conf/ext/itao_shh_manager/ext_tables.php
###########################

$_EXTKEY = 'itao_shh_manager';
$_EXTCONF = $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf'][$_EXTKEY];


if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

/*if (TYPO3_MODE == 'BE') {
	t3lib_extMgm::addModulePath('web_txitaoshhmanagerM1', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');
		
	t3lib_extMgm::addModule('web', 'txitaoshhmanagerM1', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');
}
*/

/* ====================== fuer Erweiterung der fe_users =============================*/
$tempColumns = array (
	'tx_itaoshhmanager_ssh_ref_school' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:fe_users.tx_itaoshhmanager_ssh_ref_school',		
		'config' => array (
			'type' => 'select',	
			'foreign_table' => 'tx_itaoshhmanager_schools',	
			'foreign_table_where' => ' and tx_itaoshhmanager_schools.deleted=0 and tx_itaoshhmanager_schools.hidden=0 ORDER BY tx_itaoshhmanager_schools.uid',	
			'size' => 1,	
			'minitems' => 0,
			'maxitems' => 1,
			'items' => array (
					array('', 0)
			),
		)
	),
	'tx_itaoshhmanager_ssh_ref_commune' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:fe_users.tx_itaoshhmanager_ssh_ref_commune',		
		'config' => array (
			'type' => 'select',	
			'foreign_table' => 'tx_itaoshhmanager_communes',	
			'foreign_table_where' => ' and tx_itaoshhmanager_communes.deleted=0 and tx_itaoshhmanager_communes.hidden=0 ORDER BY tx_itaoshhmanager_communes.uid',	
			'size' => 1,	
			'minitems' => 0,
			'maxitems' => 1,
			'items' => array (
					array('', 0)
			),
		)
	),
	
	'tx_itaoshhmanager_shh_classname' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:fe_users.tx_itaoshhmanager_shh_classname',		
		'config' => array (
			'type' => 'input',	
			'size' => '30',
		)
	),
	
	
	'tx_itaoshhmanager_shh_terms' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:itao_shh_manager/locallang_db.xml:fe_users.tx_itaoshhmanager_shh_terms',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
	
	'password_orig' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:fe_users.password_orig',		
		'config' => array (
			'type' => 'input',	
			'size' => '30',
			'eval' => 'nospace',
		)
	),
	
);


t3lib_div::loadTCA('fe_users');
t3lib_extMgm::addTCAcolumns('fe_users',$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes('fe_users','tx_itaoshhmanager_ssh_ref_school;;;;1-1-1,tx_itaoshhmanager_ssh_ref_commune, tx_itaoshhmanager_shh_classname, tx_itaoshhmanager_shh_terms,password_orig');




/* ====================== fuer Erweiterung der fe_groups =============================*/
$tempColumns2 = array (
	'tx_itaoshhmanager_ssh_ref_school' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:fe_users.tx_itaoshhmanager_ssh_ref_school',		
		'config' => array (
			'type' => 'select',	
			'foreign_table' => 'tx_itaoshhmanager_schools',	
			'foreign_table_where' => 'ORDER BY tx_itaoshhmanager_schools.uid',	
			'size' => 3,	
			'minitems' => 0,
			'maxitems' => 10,
		)
	),
	
);


t3lib_div::loadTCA('fe_groups');
t3lib_extMgm::addTCAcolumns('fe_groups',$tempColumns2,1);
t3lib_extMgm::addToAllTCAtypes('fe_groups','tx_itaoshhmanager_ssh_ref_school');



/* ====================== fuer Erweiterung der be_users =============================*/
$tempColumns3 = array (
	'ref_school' => array (		
		'exclude' => 1,		
		'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:be_users.ref_school',		
		'config' => array (
			'type' => 'select',	
			'foreign_table' => 'tx_itaoshhmanager_schools',	
			'foreign_table_where' => 'ORDER BY tx_itaoshhmanager_schools.uid',	
			'size' => 3,	
			'minitems' => 0,
			'maxitems' => 10,
		)
	),
	'ref_commune' => array (	
		'exclude' => 1,		
		'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:be_users.ref_commune',		
		'config' => array (
			'type' => 'select',	
			'foreign_table' => 'tx_itaoshhmanager_communes',	
			'foreign_table_where' => 'ORDER BY tx_itaoshhmanager_communes.titel',	
			'size' => 3,	
			'minitems' => 0,
			'maxitems' => 10,
		)
	),
	'password_orig' => array (		
		'exclude' => 0,		
		'label' => 'LLL:EXT:itao_shh_manager/locallang_db.xml:fe_users.password_orig',		
		'config' => array (
			'type' => 'input',	
			'size' => '30',
			'eval' => 'nospace',
		)
	),
	
);


t3lib_div::loadTCA('be_users');
t3lib_extMgm::addTCAcolumns('be_users',$tempColumns3,1);
t3lib_extMgm::addToAllTCAtypes('be_users','ref_school;;;;1-1-1, ref_commune,password_orig');




t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhmanager_communes');
t3lib_extMgm::addToInsertRecords('tx_itaoshhmanager_communes');

$TCA['tx_itaoshhmanager_communes'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_communes',		
		'label'     => 'titel',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY titel',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_itaoshhmanager_communes.gif',
	),
);


t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhmanager_bls');
t3lib_extMgm::addToInsertRecords('tx_itaoshhmanager_bls');

$TCA['tx_itaoshhmanager_bls'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_bls',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY title',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_itaoshhmanager_bls.gif',
	),
);


t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhmanager_schools');
t3lib_extMgm::addToInsertRecords('tx_itaoshhmanager_schools');

$TCA['tx_itaoshhmanager_schools'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_schools',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY title',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_itaoshhmanager_schools.gif',
	),
);


t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhmanager_status_school');
t3lib_extMgm::addToInsertRecords('tx_itaoshhmanager_status_school');

$TCA['tx_itaoshhmanager_status_school'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_status_school',		
		'label'     => 'title',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY uid',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_itaoshhmanager_status_school.gif',
	),
);


t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhmanager_resultanz');
t3lib_extMgm::addToInsertRecords('tx_itaoshhmanager_resultanz');

$TCA['tx_itaoshhmanager_resultanz'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:itao_shh_manager/locallang_db.xml:tx_itaoshhmanager_resultanz',		
		'label'     => 'number_of_result_offers',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY uid',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',	
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_itaoshhmanager_status_school.gif',
	),
);





if (TYPO3_MODE == 'BE') {
	# f�r SORTIERUNG
	   if (!isset($TBE_MODULES['txitaoshhmanagerM0'])) {
      $temp_TBE_MODULES = array();
      foreach($TBE_MODULES as $key => $val) {
         #if ($key=='file') {
         if ($key=='web') {
            $temp_TBE_MODULES['txitaoshhmanagerM0'] = $val; # wenns VOR Web soll, dann diese Zeile VOR die Z. 253 stellen!
            $temp_TBE_MODULES[$key] = $val;
         } else {
            $temp_TBE_MODULES[$key] = $val;
         }
      }
      $TBE_MODULES = $temp_TBE_MODULES;
   }


	# ENDE SORTIERUNG
	
	t3lib_extMgm::addModule('txitaoshhmanagerM0', 'txitaoshhmanagerM0', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod0/');
	t3lib_extMgm::addModulePath('txitaoshhmanagerM0', t3lib_extMgm::extPath($_EXTKEY) . 'mod0/');
	
	t3lib_extMgm::addModule('txitaoshhmanagerM0', 'txitaoshhmanagerM1', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');
	t3lib_extMgm::addModulePath('txitaoshhmanagerM0_txitaoshhmanagerM1', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');

	t3lib_extMgm::addModule('txitaoshhmanagerM0', 'txitaoshhmanagerM2', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod2/');
	t3lib_extMgm::addModulePath('txitaoshhmanagerM0_txitaoshhmanagerM2', t3lib_extMgm::extPath($_EXTKEY) . 'mod2/');

	t3lib_extMgm::addModule('txitaoshhmanagerM0', 'txitaoshhmanagerM4', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod4/');
	t3lib_extMgm::addModulePath('txitaoshhmanagerM0_txitaoshhmanagerM4', t3lib_extMgm::extPath($_EXTKEY) . 'mod4/');

	t3lib_extMgm::addModule('txitaoshhmanagerM0', 'txitaoshhmanagerM5', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod5/');
	t3lib_extMgm::addModulePath('txitaoshhmanagerM0_txitaoshhmanagerM5', t3lib_extMgm::extPath($_EXTKEY) . 'mod5/');

	t3lib_extMgm::addModule('txitaoshhmanagerM0', 'txitaoshhmanagerM3', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod3/');
	t3lib_extMgm::addModulePath('txitaoshhmanagerM0_txitaoshhmanagerM3', t3lib_extMgm::extPath($_EXTKEY) . 'mod3/');
/*
	t3lib_extMgm::addModule('txitaoshhmanagerM0', 'txitaoshhmanagerM3', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod3/');
	t3lib_extMgm::addModulePath('txitaoshhmanagerM0_txitaoshhmanagerM3', t3lib_extMgm::extPath($_EXTKEY) . 'mod3/');

	t3lib_extMgm::addModule('txitaoshhmanagerM0', 'txitaoshhmanagerM5', '', t3lib_extMgm::extPath($_EXTKEY) . 'mod5/');
	t3lib_extMgm::addModulePath('txitaoshhmanagerM0_txitaoshhmanagerM5', t3lib_extMgm::extPath($_EXTKEY) . 'mod5/');
	*/
	
}

$TBE_MODULES['txitaoshhmanagerM0']= 'txitaoshhmanagerM1,txitaoshhmanagerM2,txitaoshhmanagerM4,txitaoshhmanagerM5,txitaoshhmanagerM3';#txitaoshhmanagerM2,txitaoshhmanagerM4,txitaoshhmanagerM3,txitaoshhmanagerM5,
#.t3lib_div::view_array($TBE_MODULES);


$TCA['tt_content']['columns']['imagecaption']['exclude'] = 1;
$TCA['tt_content']['columns']['titleText']['exclude'] = 1;
$TCA['tt_content']['columns']['target']['exclude'] = 1;
$TCA['tt_content']['columns']['CType']['exclude'] = 1;
$TCA['tt_content']['columns']['imagecols']['exclude'] = 1;




#if(TYPO3_MODE=="BE") {
#	require_once(PATH_t3lib."class.t3lib_userauthgroup.php");
#	$BE_USER = t3lib_div::makeInstance("t3lib_beUserAuth");
#	$BE_USER->start();
#}
#if (!$BE_USER->user['admin']) {
  $TBE_STYLES['inDocStyles_TBEstyle']         = 'div.t3-form-field-toggle-flexsection {display: none;}
  																							/* damit das Ordnersymbol nicht angezeigt wird: */
  																							span.t3-icon.t3-icon-insert-record { background-position: -360px -30px !important; display:none;}
  																							/* Damit Headerbild oben nicht auf der Seite unten angezeigt wird */
  																							.tpm-sub-elements .tpm-preview STRONG {display:none;}
  																							/* damit die Dateiendungen beim Bild-Upload ausgeblendet werden:*/
  																							.t3-form-palette-field .filetypes, table.typo3-TCEforms span.filetypes {display:none;}
  																							  ';                   // Additional default in-document styles.
#}  																							  




###  $TBE_STYLES['inDocStyles_TBEstyle'].= ' .t3-form-palette-field .filetypes {display:none;} .t3-form-palette-field .filetypes:after {content: "Text danach";}	';																						  
  																							  
  																							  
  																							/*.typo3-bigDoc	.typo3-message.message-information .message-body { background-color:blue;}
  																							.typo3-bigDoc	.typo3-message.message-information .message-body:after{ content: "Text danach";	}*/
  																							  
#$GLOBALS['TBE_STYLES']['inDocStyles_TBEstyle'] = 'body {color:lime;}';
#t3lib_utility_debug::debug($temp_eP);
// Setting up stylesheets (See template() constructor!)
#  $TBE_STYLES['stylesheet']                   = $temp_eP.'stylesheets/stylesheet.css';         // Alternative stylesheet to the default "typo3/stylesheet.css" stylesheet.
#  $TBE_STYLES['stylesheet2']                  = $temp_eP.'stylesheets/stylesheet.css';         // Additional stylesheet (not used by default).  Set BEFORE any in-document styles
#   $TBE_STYLES['styleSheetFile_post']          = '/fileadmin/templates/css/backend_ras.css'; #$temp_eP.'stylesheets/stylesheet_post.css';    // Additional stylesheet. Set AFTER any in-document styles


#   $TBE_STYLES['stylesheets']['modulemenu']    = '/fileadmin/templates/css/backend_ras.css'; #$temp_eP.'stylesheets/modulemenu.css';
#   $TBE_STYLES['stylesheets']['backend-style'] = '/fileadmin/templates/css/backend_ras.css'; #$temp_eP.'stylesheets/backend-style.css';
#   $TBE_STYLES['stylesheets']['admPanel'] = '/fileadmin/templates/css/backend_ras.css'; #$temp_eP.stylesheets/admPanel.css';



?>
