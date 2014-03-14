<?php

/**
  * Lib for General
  */

$LANG->includeLLFile('EXT:itao_shh_manager/mod1/locallang.xml');
require_once(PATH_t3lib . 'class.t3lib_scbase.php');

require_once(t3lib_extMgm::extPath('itao_shh_manager') . '/lib/datamanager_library.inc.php');	

#include t3lib_extMgm::extPath('itao_shh_manager') . '/res/html2doc.php';
require_once (t3lib_extMgm::extPath('itao_shh_manager') . '/res/html2doc.php');



/**
 * Library for the 'itao_shh_manager' extension.
 * Function for general actions
 *
 * @author	Edeltraud Gratzer <edeltraud.gratzer@itao.de>
 * @package	TYPO3
 * @subpackage	tx_itaozfadatamanager
 */
class  tx_itaoshhmanager_general extends  t3lib_SCbase {	
	
	function getPiVars() {
		global $LANG;
		global $_SERVER;
		
		/* für übertragene Variablen*/
		$this->piVars = $_GET;
		while (list ($key, $val) = each ($_POST)) {
			$this->piVars[$key] = $val;
		}
		reset($this->piVars);
		while (list ($key2, $val2) = each ($this->piVars)) {
			$this->piVars[$key2] = str_replace('\"', '"', str_replace("\'", "'", $val2));
		}
		reset($this->piVars);
		
		
		/* Constanten*/
		$tmp_abspfad = dirname(__FILE__); # => /srv/www/bst-zfa/subs/dev/html/typo3conf/ext/itao_zfa_datamanager/mod3
		$tmp_abspfad_arr = explode("/",$tmp_abspfad );
		array_pop($tmp_abspfad_arr); #=> /srv/www/bst-zfa/subs/dev/html/typo3conf/ext/itao_zfa_datamanager 
		array_pop($tmp_abspfad_arr); #=> /srv/www/bst-zfa/subs/dev/html/typo3conf/ext 
		array_pop($tmp_abspfad_arr); #=> /srv/www/bst-zfa/subs/dev/html/typo3conf
		array_pop($tmp_abspfad_arr); #=> /srv/www/bst-zfa/subs/dev/html  
		$this->absoluter_bildpfad = implode("/",$tmp_abspfad_arr);
		
		
		$this->exportpath = 'http://'.$_SERVER['HTTP_HOST'].'/uploads/tx_itaosshmanager/export_user/';
		
		/* andere globale Variablen:*/
		/*
		$this->backLink_startpage = '<a href="'.$this->indexpath.'" title="'.$LANG->getLL('link_backStartpage').'">&laquo; <u>'.$LANG->getLL('link_backStartpage').'</u></a>';
		$this->backLink_bereiche_startpage = '<a href="'.$this->indexpath.'&smnr='.$this->piVars['smnr'].'" title="'.$LANG->getLL('link_bereiche_backStartpage').'">&laquo; <u>'.$LANG->getLL('link_bereiche_backStartpage').'</u></a>';
		*/	
	}
	
	/**
		* Hier wird geprüft, ob der eingeloggte Redakteur die Rechte hat, bestimmte Aktionen durchzuführen bzw. bzw. Ansichten zu sehen.
		* $objNr = Typ des Datensatzes oder der Ansicht
				- objNr = 0 = Kommunenübersicht
				- objNr = 1 = Kommune 
				- objNr = 2 = Schule
				- objNr = 3 = Vorschlag
				- objNr = 4 = Zugänge / FEBenutzer
				- objNr = 5 = Zugänge / BE-Benutzer Kommune
				- objNr = 6 = Zugänge / BE-Benutzer Schule
				- objNr = 7 = FE-Benutzer bearbeiten
		* $objAction = gibt an, was gemacht werden soll 
				- 1 = view
				- 2 = new
				- 3 = edit
				- 4 = action (nur für Vorschläge freishcalten etc.
		*/	
	function hasRights($objNr, $objAction) {		
		global $BE_USER;
		$hasRight = 0;
		
		############## Diese Fälle werden zu berücksichtigen sein:########################
		## Kommunenübersicht anzeigen = nur technischer Admin
		## Redakteur anlegen = nur technischer Admin (noch nicht berücksichtigt)
		## Kommune anlegen = nur technischer Admin
		## Tab Stammdaten Kommune anzeigen = Technischer Admin, Red.Adm.-Kommune
		## Kommune bearbeiten = Red.Adm.-Kommune
		## Schule anlegen = Red.Adm.-Kommune
		# ###Generierung Logins = Red.Adm.-Kommune => RAUS lt. Kathy
		## Schule bearbeiten = Red.Adm.-Schule
		## Generierung Logins = Red.Adm.-Schule
		## Vorschläge bearbeiten = Mod. Kommune, Mod. Schule
		# Vorschläge freigeben/sperren = Mod. Kommune, Mod. Schule
		# Moderatoren für Kommune muss man das Recht geben, die Schulen anzusehen, sonst können die nicht zu den Vorschlaegen wandern...
		# #################################################################################
		
		$darf_array = array();
		# 1. Ebene: objNr, 2. Ebene: action; als Wert ein array mit den uids der gruppen, die dürfen
		$darf_arr[0][1] = array($this->tsvars['be_groupid_techadmin']);
		$darf_arr[1][2] = array($this->tsvars['be_groupid_techadmin']);
		$darf_arr[1][1] = array($this->tsvars['be_groupid_techadmin'],$this->tsvars['be_groupid_redadmin_kommune']);
		$darf_arr[1][3] = array($this->tsvars['be_groupid_redadmin_kommune'],$this->tsvars['be_groupid_techadmin']);		
		$darf_arr[2][1] = array($this->tsvars['be_groupid_mod_kommune'],$this->tsvars['be_groupid_techadmin'],$this->tsvars['be_groupid_redadmin_kommune']);	
		$darf_arr[2][2] = array($this->tsvars['be_groupid_redadmin_kommune'],$this->tsvars['be_groupid_techadmin'],$this->tsvars['be_groupid_redadmin_schule']);
		$darf_arr[2][3] = array($this->tsvars['be_groupid_redadmin_schule'],$this->tsvars['be_groupid_techadmin'],$this->tsvars['be_groupid_redadmin_kommune']);
		$darf_arr[4][2] = array($this->tsvars['be_groupid_redadmin_schule'],$this->tsvars['be_groupid_techadmin'],$this->tsvars['be_groupid_redadmin_kommune']);
		$darf_arr[3][3] = array($this->tsvars['be_groupid_mod_kommune'], $this->tsvars['be_groupid_mod_schule'],$this->tsvars['be_groupid_techadmin']); #,$this->tsvars['be_groupid_redadmin_kommune'],$this->tsvars['be_groupid_redadmin_schule']
		$darf_arr[3][4] = array($this->tsvars['be_groupid_mod_kommune'], $this->tsvars['be_groupid_mod_schule'],$this->tsvars['be_groupid_techadmin']); #,$this->tsvars['be_groupid_redadmin_kommune'],$this->tsvars['be_groupid_redadmin_schule']
		$darf_arr[5][2] = array($this->tsvars['be_groupid_techadmin'],$this->tsvars['be_groupid_redadmin_kommune']);
		$darf_arr[6][2] = array($this->tsvars['be_groupid_techadmin'],$this->tsvars['be_groupid_redadmin_kommune'],$this->tsvars['be_groupid_redadmin_schule']);
		$darf_arr[7][3] = array($this->tsvars['be_groupid_techadmin'],$this->tsvars['be_groupid_mod_schule'],$this->tsvars['be_groupid_redadmin_schule']);
		
		$rechte_ist_arr = ($BE_USER->user['usergroup']!="" ) ? explode(",", $BE_USER->user['usergroup']) : array();
		########## nur zum testen:
		#$rechte_ist_arr = explode(",", "2,5,7");
		#$objNr = 0;
		#$objAction = 1;
		########## testen ende
		$rechte_soll_arr = $darf_arr[$objNr][$objAction];
		
		while (list ($key, $val) = each ($rechte_soll_arr)) {
			if (in_array($val,$rechte_ist_arr )) {
				$hasRight = 1;
			}
		}
		#t3lib_utility_debug::debug("hat Recht: ".$hasRight);
				
		if ($BE_USER->user['admin']) {
			$hasRight = 1;
		}
		
		
		return $hasRight;
	}
	
	function isInBeUserGroup($ist_groups, $soll_group) {
		global $BE_USER;
		$has_right = ($BE_USER->user['admin']) ? 1: 0;
		
		$ist_arr = explode(",", $ist_groups);
		if (in_array($soll_group, $ist_arr)) {
			$has_right = 1;
		}
		return $has_right;
	}
	
	# hier wird geprüft, ob der BE-user sich auf der Modul-Startseite befindet und ob er darauf zugreifen darf;
	# wenn nicht, wird er dorthin weitergeleitet, wohin er darf.
	function checkRightsStartseite() {
		global $BE_USER;
		if (!$this->piVars['communeid'] && !$this->piVars['schoolid']) {
			#t3lib_utility_debug::debug("keine ids");
			$hasRight = tx_itaoshhmanager_general::hasRights(0,1);
			#t3lib_utility_debug::debug("hasright:".$hasRight);
			if (!$hasRight) {
				$rechte_ist_arr = ($BE_USER->user['usergroup']!="" ) ? explode(",", $BE_USER->user['usergroup']) : array();
				
			#t3lib_utility_debug::debug("keine rechte");
				# red admin kommune zu zugeordneter kommune - detailpage
				if (in_array($this->tsvars['be_groupid_redadmin_kommune'],$rechte_ist_arr )) { 
					$this->piVars['communeid'] = $BE_USER->user['ref_commune'];
					if ($this->myModule=="mod2") {
						$this->piVars['beuser'] = 1;
					}
					if ($this->myModule=="mod4") {
						$this->piVars['benutzer'] = 1;
					}
					
				}
				
				# red admin schule zu zugeordneter schule - detailpage
				if (in_array($this->tsvars['be_groupid_redadmin_schule'],$rechte_ist_arr )) { 
					$this->piVars['schoolid'] = $BE_USER->user['ref_school'];
					$schooldata = tx_itaoshhmanager_database::getSchoolById($BE_USER->user['ref_school']);
					$this->piVars['communeid'] = $schooldata['ref_commune'];
					if ($this->myModule=="mod3") {
						$this->piVars['vorschlaege'] = 1;
					}
					if ($this->myModule=="mod2") {
						$this->piVars['beuser_school'] = 1;
					}
					
					if ($this->myModule=="mod4") {
						$this->piVars['benutzer_school'] = 1;
					}
				}
				
				# moderator kommune zu zugeordneter schule - vorschläge-details
				if (in_array($this->tsvars['be_groupid_mod_kommune'],$rechte_ist_arr )) { 
					$this->piVars['communeid'] = $BE_USER->user['ref_commune'];#$schooldata['ref_commune'];
				}
				
				
				if (in_array($this->tsvars['be_groupid_mod_schule'],$rechte_ist_arr )) { 
					$this->piVars['schoolid'] = $BE_USER->user['ref_school'];
					$schooldata = tx_itaoshhmanager_database::getSchoolById($BE_USER->user['ref_school']);
					$this->piVars['communeid'] = $schooldata['ref_commune'];
					$this->piVars['vorschlaege'] = 1;
				}
			}
		}
		
		# sonderfall fuer weiterleitung moderator kommune:
		#if ($this->piVars['schoolid']) {
		$rechte_ist_arr = ($BE_USER->user['usergroup']!="" ) ? explode(",", $BE_USER->user['usergroup']) : array();
		if (in_array($this->tsvars['be_groupid_mod_kommune'],$rechte_ist_arr )) { 
			if ($this->piVars['schoolid'] && !$this->piVars['vorschlaege']) {
				$this->piVars['vorschlaege'] = 1;
				#t3lib_utility_debug::debug("jetzt in vorschl. rein".$this->piVars['vorschlaege']);
			} else {
				#t3lib_utility_debug::debug("NICHT in vorschlage".$this->piVars['vorschlaege']);
			}
		}
		
		/*if (in_array($this->tsvars['be_groupid_mod_schule'],$rechte_ist_arr )) { 
			if (!$this->piVars['schoolid']) {
				$this->piVars['schoolid'] = $BE_USER->user['ref_school'];
			} 
		}*/
	}
	
	
	
	function getNewLink($label_new, $object_type, $pid, $tca_params, $back_params, $modulenr ="1") {		
		$markerArray_newlink['###MODULNR###'] = $modulenr;
		$markerArray_newlink['###OBJECT_LABEL###'] = $label_new;
		$markerArray_newlink['###OBJECT_TYPE###'] = $object_type;
		$markerArray_newlink['###PID_COMMUNES###'] = $pid; 
		$markerArray_newlink['###TCA_PARAMS###'] = '';
		$markerArray_newlink['###BACK_PARAMS###'] = '';
		if (is_array($tca_params)) {
			if (count($tca_params) > 0) {
				while (list ($key, $val) = each ($tca_params)) {
					$markerArray_newlink['###TCA_PARAMS###'].='&amp;'.$key.'='.$val;
				}
			}
		}
		 
		if (is_array($back_params)) {
			if (count($back_params) > 0) {
				while (list ($key2, $val2) = each ($back_params)) {
					$markerArray_newlink['###BACK_PARAMS###'].='%26'.$key2.'='.$val2;
				}
			}
		}
		$html = tx_itaoshhmanager_library::template_ausgeben($markerArray_newlink, 'TYPO3_NEW_LINK', 'layout/be_template.html');
		return $html;
	}
	
	
	
	function getEditLink($label_new, $object_type, $object_uid, $tca_params, $back_params, $modulenr ="1", $linkText="", $unterstrichen=1) {		
		$markerArray_newlink['###MODULNR###'] = '1';
		$markerArray_newlink['###OBJECT_LABEL###'] = $label_new;
		$markerArray_newlink['###OBJECT_TYPE###'] = $object_type;
		$markerArray_newlink['###OBJECT_UID###'] = $object_uid; 
		$markerArray_newlink['###TCA_PARAMS###'] = '';
		$markerArray_newlink['###BACK_PARAMS###'] = '';
		
		if ($linkText!="") {		
			if ($unterstrichen) {
				$markerArray_newlink['###EDIT_TEXT###'] = " <u>".$linkText."</u>";
			} else {
				$markerArray_newlink['###EDIT_TEXT###'] = " ".$linkText;
			}
		} else {
			$markerArray_newlink['###EDIT_TEXT###'] = "";
		}
		$markerArray_newlink['###IMAGEPATH###'] = $this->imagepath2;		
		
		if (is_array($tca_params)) {
			if (count($tca_params) > 0) {
				while (list ($key, $val) = each ($tca_params)) {
					$markerArray_newlink['###TCA_PARAMS###'].='&amp;'.$key.'='.$val;
				}
			}
		}		
		 
		if (is_array($back_params)) {
			if (count($back_params) > 0) {
				while (list ($key2, $val2) = each ($back_params)) {
					$markerArray_newlink['###BACK_PARAMS###'].='%26'.$key2.'='.$val2;
				}
			}
		}
		$html = tx_itaoshhmanager_library::template_ausgeben($markerArray_newlink, 'TYPO3_EDIT_LINK', 'layout/be_template.html');
		return $html;
	}
	
	
	function generateFlashMessage($flheader, $fltext,$successful) {	
		if ($successful) {	
			$msg = t3lib_div::makeInstance('t3lib_FlashMessage', $fltext, $flheader, t3lib_FlashMessage::OK);
		} else {
			$msg = t3lib_div::makeInstance('t3lib_FlashMessage', $fltext, $flheader, t3lib_FlashMessage::ERROR);
		}
		t3lib_FlashMessageQueue::addMessage($msg);
	}	
	
	
	
	/** 
	  *Loads the TypoScript for the given extension prefix, e.g. tx_cspuppyfunctions_pi1, for use in a backend module.
	  *
	  * @param string $extKey
	  * @return array
	  */

	function loadTypoScriptForBEModule($extKey,$update=0) {
		require_once(PATH_t3lib . 'class.t3lib_page.php');
		require_once(PATH_t3lib . 'class.t3lib_tstemplate.php');
		require_once(PATH_t3lib . 'class.t3lib_tsparser_ext.php');
		list($page) = t3lib_BEfunc::getRecordsByField('pages', 'pid', 0);
		$pageUid = intval(1);#$page['uid']);
		$sysPageObj = t3lib_div::makeInstance('t3lib_pageSelect');
		$rootLine = $sysPageObj->getRootLine($pageUid);
		$TSObj = t3lib_div::makeInstance('t3lib_tsparser_ext');
		$TSObj->tt_track = 0;
		$TSObj->init();
		$TSObj->runThroughTemplates($rootLine);
		$TSObj->generateConfig();
		if ($update) {
			$this->tsvars_offers = $TSObj->setup['plugin.'][$extKey . '.'];	
			#$this->tsvars_offers['actions.']['commented'];
			
		} else {
			$this->tsvars = $TSObj->setup['plugin.'][$extKey . '.'];		
		}
	}
	
	
	
	
	function generateWahlzettel($communeid,$schoolid,$allOffers2,$forPdf=0) {
		global $BE_USER;
																						
		$allOffers = tx_itaoshhmanager_database::getAllOffersBySchool($schoolid,0,10, $sort_dir,0,1,1);
		# 1. HTML generieren
		$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
		$ma_doc['###SCHOOLNAME###'] = $schooldata['title'];
		$ma_doc['###ALLVORSCHLAGE_FOR_DOC###'] = '';
		while (list ($key, $val) = each ($allOffers)) {	
			#if ($xy < 11 || ($val['internal_id']!=15 && $val['internal_id']!=38)) {
				$ma_doc_rows['###OFFER_TITLE###'] = htmlentities(utf8_decode($val['title'])); #$val['title'];#
				#$costs = ($val['costs_fixed']!="")? $val['costs_fixed'] : $val['costs']; 
				$costs = ($val['costs']!="")? $val['costs'] : $val['costs_student']; 
				$ma_doc_rows['###OFFER_COSTS###'] = ($costs!="") ? $costs.'&nbsp;&euro;' : '&nbsp;';
				#$ma_doc_rows['###OFFER_COSTS###'] = ($val['costs']) ? $val['costs'] : '&nbsp;';
				$ma_doc_rows['###OFFER_INTID###'] = $val['internal_id'];
				$ma_doc['###ALLVORSCHLAGE_FOR_DOC###'] .= tx_itaoshhmanager_library::template_ausgeben($ma_doc_rows, 'TEMPLATE_WAHLZETTEL_DOC_ROWS', 'layout/be_template.html');
			#}
			$xy++;
		}
		$ma_doc['###ESC_AE###'] = htmlentities(chr(228));
		$html = tx_itaoshhmanager_library::template_ausgeben($ma_doc, 'TEMPLATE_WAHLZETTEL_DOC', 'layout/be_template.html');
		
		$tmp_abspfad = dirname(__FILE__); # => /srv/www/bst-zfa/subs/dev/html/typo3conf/ext/itao_shh_manager/mod1
		$tmp_abspfad_arr = explode("/",$tmp_abspfad );
		array_pop($tmp_abspfad_arr);					
		array_pop($tmp_abspfad_arr);
		array_pop($tmp_abspfad_arr);
		array_pop($tmp_abspfad_arr);
		$tmp_abspfad_fin2 = implode("/",$tmp_abspfad_arr);	
		$abs_path = $tmp_abspfad_fin2;
		$theBaseUrl = 'http://'.$_SERVER['HTTP_HOST'].'/uploads/tx_itaoshhmanager/pdfs_wahlzettel/';
		
		if ($forPdf) {
			# HTML speichern
			$dateiname_html = $schoolid.'_wahlzettel.html';
			$dateiname_pdf = $schoolid.'_wahlzettel.pdf';
			$fileandpath = tx_itaoshhmanager_general::generateHTMLFileForDoc($html,$dateiname_html, $abs_path);
			# PDF umwandeln
			$abs1 = $_SERVER['DOCUMENT_ROOT']."/typo3conf/ext/itao_shh_manager/lib/";	
			$abs_uploads = $_SERVER['DOCUMENT_ROOT'].'/uploads/tx_itaoshhmanager/pdfs_wahlzettel/';
			exec($abs1.'wkhtmltopdf-amd64 '.$abs_uploads.$dateiname_html.' '.$abs_uploads.$dateiname_pdf);
#			if ($BE_USER->user['admin'] || $BE_USER->user['username'] == 'alexander.koop') {
				header('Pragma: no-cache');
				header("Content-Type: application/octet-stream"); #application/pdf"); #application/pdf"); #application/octet-stream"); #
				header("Content-Disposition: attachment; filename=\"Wahlzettel.pdf\""); 
				$datei = $abs_path.'/uploads/tx_itaoshhmanager/pdfs_wahlzettel/'.$dateiname_pdf;
				$groesse = filesize($datei);
				#t3lib_utility_debug::debug("groesse:".$groesse."//datei:".$datei);
				header("Content-Length: $groesse"); 
#				readfile($datei);
				$file = @fopen($datei, 'rb'); 
				fpassthru($file); 
				fclose($file);
        exit;
#			} else {
#				header('Location: '.$theBaseUrl.$schoolid.'_wahlzettel.pdf');
#			}
			# rediret
		} else {	
		
	#		$dateiname = $schoolid.'_wahlzettel.html';
			$dateiname = $schoolid.'_wahlzettel.doc';
			$fileandpath = tx_itaoshhmanager_general::generateHTMLFileForDoc($html,$dateiname, $abs_path);
			# 2. dann doc generieren
			
		
	#		$htmltodoc= new HTML_TO_DOC();
	#		$htmltodoc->createDocFromURL($theBaseUrl.$dateiname, $schoolid.'_wahlzettel');
#			if ($BE_USER->user['admin'] || $BE_USER->user['username'] == 'alexander.koop') {
				header('Pragma: no-cache');
				header("Content-Type: application/octet-stream"); #application/pdf"); #application/pdf"); #application/octet-stream"); #
				header("Content-Disposition: attachment; filename=\"Wahlzettel.doc\""); 
				$datei = $abs_path.'/uploads/tx_itaoshhmanager/pdfs_wahlzettel/'.$dateiname;
				$groesse = filesize($datei);
				#t3lib_utility_debug::debug("groesse:".$groesse."//datei:".$datei);
				header("Content-Length: $groesse"); 
#				readfile($datei);
				$file = @fopen($datei, 'rb'); 
				fpassthru($file); 
				fclose($file);
        exit;
#			} else {
#				header('Location: '.$theBaseUrl.$schoolid.'_wahlzettel.doc');
#			}
		}
		#t3lib_utility_debug::debug($html);
		return $html;
	}
	
	
	
	
	function generateHTMLFileForDoc($contenthtml,$dateiname, $abs_path) {
		$filename = ($dateiname!="") ? $dateiname : "saved_pdf.html";
		#$filename = str_replace(".pdf",".html", $filename);
		$fileandpath = $abs_path.'/uploads/tx_itaoshhmanager/pdfs_wahlzettel/'.$filename;
		#t3lib_utility_debug::debug($fileandpath);
		$file=fopen($fileandpath ,"w");
		fwrite($file, $contenthtml);
		fclose($file);
		return $fileandpath;
	}
	

	
	
	
	
	

				
}

?>