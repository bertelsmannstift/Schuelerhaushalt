<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TYPO3_CONF_VARS['SYS']['sitename'] = 'New TYPO3 site';

$TYPO3_CONF_VARS['BE']['installToolPassword'] = '';

$TYPO3_CONF_VARS['EXT']['extList'] = 'info,perm,func,filelist,about,version,tsconfig_help,context_help,extra_page_cm_options,impexp,sys_note,tstemplate,tstemplate_ceditor,tstemplate_info,tstemplate_objbrowser,tstemplate_analyzer,func_wizards,wizard_crpages,wizard_sortpages,lowlevel,install,belog,beuser,aboutmodules,setup,taskcenter,info_pagetsconfig,viewpage,rtehtmlarea,css_styled_content,t3skin,t3editor,reports,felogin,form';

$typo_db_extTableDef_script = 'extTables.php';

## STANDARDVORLAGE Konfiguration

// Datenbank konfigurationen - begin

$typo_db_username = '';
$typo_db_password = '';
$typo_db_host = '';
$typo_db = '';

// Datenbank konfigurationen - end

// Cookie Domain begin

$TYPO3_CONF_VARS['SYS']['cookieDomain'] = 'sv.schuelerhaushalt.de';
$TYPO3_CONF_VARS['BE']['cookieDomain'] = 'sv.schuelerhaushalt.de';

// Cookie Domain end

## STANDARDVORLAGE Konfiguration ende

## INSTALL SCRIPT EDIT POINT TOKEN - all lines after this points may be changed by the install script!

$TYPO3_CONF_VARS['EXT']['extList'] = 'extbase,css_styled_content,info,perm,func,filelist,about,version,tsconfig_help,context_help,extra_page_cm_options,sys_note,tstemplate,tstemplate_ceditor,tstemplate_info,tstemplate_objbrowser,tstemplate_analyzer,func_wizards,wizard_crpages,wizard_sortpages,lowlevel,install,belog,beuser,aboutmodules,setup,taskcenter,info_pagetsconfig,viewpage,rtehtmlarea,t3skin,t3editor,reports,form,rsaauth,saltedpasswords,cshmanual,feedit,recycler,scheduler,fluid,realurl,static_info_tables,templavoila,crawler,itao_fix,sk_etracker,kb_tv_cont_slide,datamints_feuser,itao_zfalogin,felogin,dragdrop,itao_shh_redirect,phpmyadmin,sr_freecap,indexed_search,macina_searchbox,indexed_search_mysql,itao_fancy_gallery,itao_shh_offers,itao_felogin_ext,itao_shh_manager';	// Modified or inserted by TYPO3 Extension Manager. Modified or inserted by TYPO3 Core Update Manager. 
// Updated by TYPO3 Core Update Manager 01-10-12 11:06:20
$TYPO3_CONF_VARS['SYS']['encryptionKey'] = '29c701eddcd6bed60df4ee4fc4e140eeb2614f35f1569a41bb62eebef7c621ba5fb94a272624920b6fefb07d3b93fe56';	//  Modified or inserted by TYPO3 Install Tool.
$TYPO3_CONF_VARS['SYS']['compat_version'] = '4.7';	//  Modified or inserted by TYPO3 Install Tool.

// Updated by TYPO3 Install Tool 01-10-12 11:06:20
$TYPO3_CONF_VARS['EXT']['extConf']['saltedpasswords'] = 'a:2:{s:3:"FE.";a:2:{s:7:"enabled";s:1:"1";s:21:"saltedPWHashingMethod";s:28:"tx_saltedpasswords_salts_md5";}s:3:"BE.";a:2:{s:7:"enabled";s:1:"1";s:21:"saltedPWHashingMethod";s:28:"tx_saltedpasswords_salts_md5";}}';	//  Modified or inserted by TYPO3 Core Update Manager.
$TYPO3_CONF_VARS['BE']['loginSecurityLevel']  = 'rsa';	//  Modified or inserted by TYPO3 Core Update Manager.
$TYPO3_CONF_VARS['FE']['loginSecurityLevel']  = 'rsa';	//  Modified or inserted by TYPO3 Core Update Manager.
// Updated by TYPO3 Core Update Manager 01-10-12 11:06:35

$TYPO3_CONF_VARS['BE']['versionNumberInFilename'] = '0';	//  Modified or inserted by TYPO3 Install Tool.
$TYPO3_CONF_VARS['FE']['hidePagesIfNotTranslatedByDefault'] = '1';	//  Modified or inserted by TYPO3 Install Tool.
// Updated by TYPO3 Install Tool 01-10-12 11:07:47
$TYPO3_CONF_VARS['EXT']['extList_FE'] = 'extbase,css_styled_content,version,install,rtehtmlarea,t3skin,form,rsaauth,saltedpasswords,feedit,fluid,realurl,static_info_tables,templavoila,crawler,itao_fix,sk_etracker,kb_tv_cont_slide,datamints_feuser,itao_zfalogin,felogin,dragdrop,itao_shh_redirect,phpmyadmin,sr_freecap,indexed_search,macina_searchbox,indexed_search_mysql,itao_fancy_gallery,itao_shh_offers,itao_felogin_ext,itao_shh_manager';	// Modified or inserted by TYPO3 Extension Manager. 
// Updated by TYPO3 Extension Manager 01-10-12 11:14:22
$TYPO3_CONF_VARS['INSTALL']['wizardDone']['tx_coreupdates_installsysexts'] = '1';	//  Modified or inserted by TYPO3 Upgrade Wizard.
// Updated by TYPO3 Upgrade Wizard 01-10-12 11:14:22
// Updated by TYPO3 Extension Manager 01-10-12 11:14:27
$TYPO3_CONF_VARS['INSTALL']['wizardDone']['tx_coreupdates_installnewsysexts'] = '1';	//  Modified or inserted by TYPO3 Upgrade Wizard.
// Updated by TYPO3 Upgrade Wizard 01-10-12 11:14:27
$TYPO3_CONF_VARS['EXT']['extConf']['realurl'] = 'a:5:{s:10:"configFile";s:26:"typo3conf/realurl_conf.php";s:14:"enableAutoConf";s:1:"0";s:14:"autoConfFormat";s:1:"0";s:12:"enableDevLog";s:1:"0";s:19:"enableChashUrlDebug";s:1:"0";}';	//  Modified or inserted by TYPO3 Extension Manager.
// Updated by TYPO3 Extension Manager 01-10-12 12:34:02
$TYPO3_CONF_VARS['BE']['installToolPassword'] = '3ff37b4e38eefb937e7f0e691f0de3ab';	//  Modified or inserted by TYPO3 Install Tool.
$TYPO3_CONF_VARS['SYS']['sitename'] = 'Schülerhaushalt';	//  Modified or inserted by TYPO3 Install Tool.
$TYPO3_CONF_VARS['BE']['disable_exec_function'] = '0';	//  Modified or inserted by TYPO3 Install Tool.
$TYPO3_CONF_VARS['GFX']['gdlib_png'] = '0';	//  Modified or inserted by TYPO3 Install Tool.
$TYPO3_CONF_VARS['GFX']['im_combine_filename'] = 'composite';	//  Modified or inserted by TYPO3 Install Tool.
// Updated by TYPO3 Install Tool 01-10-12 14:51:30
//$TYPO3_CONF_VARS['EXT']['extConf']['indexed_search'] = 'a:18:{s:8:"pdftools";s:9:"/usr/bin/";s:8:"pdf_mode";s:2:"20";s:5:"unzip";s:9:"/usr/bin/";s:6:"catdoc";s:9:"/usr/bin/";s:6:"xlhtml";s:9:"/usr/bin/";s:7:"ppthtml";s:9:"/usr/bin/";s:5:"unrtf";s:9:"/usr/bin/";s:9:"debugMode";s:1:"0";s:18:"fullTextDataLength";s:1:"0";s:23:"disableFrontendIndexing";s:1:"0";s:21:"enableMetaphoneSearch";s:1:"1";s:6:"minAge";s:2:"24";s:6:"maxAge";s:2:"24";s:16:"maxExternalFiles";s:1:"5";s:26:"useCrawlerForExternalFiles";s:1:"0";s:11:"flagBitMask";s:3:"192";s:16:"ignoreExtensions";s:0:"";s:17:"indexExternalURLs";s:1:"0";}';	// Modified or inserted by TYPO3 Extension Manager. 
$TYPO3_CONF_VARS['EXT']['extConf']['em'] = 'a:1:{s:17:"selectedLanguages";s:2:"de";}';	//  Modified or inserted by TYPO3 Extension Manager.
// Updated by TYPO3 Extension Manager 16-10-12 16:28:27
// Updated by TYPO3 Install Tool 17-10-12 00:12:31
$TYPO3_CONF_VARS['EXT']['extConf']['datamints_feuser'] = 'a:2:{s:7:"useIRRE";s:1:"1";s:13:"encryptionKey";s:32:"b98OQ8c5hhmH1dwVyk3po8K8I9kQ0KHm";}';	// Modified or inserted by TYPO3 Extension Manager. 
// Updated by TYPO3 Extension Manager 24-10-12 17:17:09

/*404 Handling*/
#Muss 1 sein
#$TYPO3_CONF_VARS['SYS']['curlUse'] = "1";

#Muss leer sein
$TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT']['init']['postVarSet_failureMode'] = "";

#Hier der logische Teil
$TYPO3_CONF_VARS['FE']['pageNotFound_handling'] = "/service/seite-nicht-gefunden";
$TYPO3_CONF_VARS['FE']['pageNotFound_handling_statheader'] = "HTTP/1.0 404 Not Found";

$TYPO3_CONF_VARS['FE']['lockIP'] = 0;
$TYPO3_CONF_VARS['FE']['lifetime'] = 0;#604800;
#$TYPO3_CONF_VARS['FE']['permalogin'] = 1;

$TYPO3_CONF_VARS['SYS']['doNotCheckReferer'] = '1';	//  Modified or inserted by TYPO3 Install Tool.

$TYPO3_CONF_VARS['BE']['enabledBeUserIPLock'] = '0'; 
#$TYPO3_CONF_VARS['SYS']['reverseProxyIP'] = '91.20.168.52';	//  Modified or inserted by TYPO3 Install Tool.

// Updated by TYPO3 Install Tool 31-10-12 09:29:18
// Updated by TYPO3 Extension Manager 28-11-12 12:08:48
// Updated by TYPO3 Install Tool 10-12-12 13:17:20
// Updated by TYPO3 Extension Manager 17-01-13 11:19:19
$TYPO3_CONF_VARS['BE']['maxFileSize'] = '51200';	//  Modified or inserted by TYPO3 Install Tool.
$TYPO3_CONF_VARS['SYS']['displayErrors'] = '1';

// Log Abschaltung
$TYPO3_CONF_VARS['SYS']['enableDeprecationLog'] = 0;
$TYPO3_CONF_VARS['SYS']['displayErrors'] = 0;
$TYPO3_CONF_VARS['SYS']['systemLog'] = '';
$TYPO3_CONF_VARS['SYS']['systemLogLevel'] = '';
$TYPO3_CONF_VARS['BE']['allowDonateWindow'] = 0;
$TYPO3_CONF_VARS['SYS']['errorHandlerErrors'] = 0;
$TYPO3_CONF_VARS['SYS']['exceptionalErrors'] = 0;
$TYPO3_CONF_VARS['SYS']['syslogErrorReporting'] = 0;
$TYPO3_CONF_VARS['SYS']['belogErrorReporting'] = 0;
// Log Abschaltung
// Updated by TYPO3 Extension Manager 29-05-13 17:10:55
?>
