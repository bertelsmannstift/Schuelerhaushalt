<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Edeltraud Gratzer <edeltraud.gratzer@itao.de>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */


$LANG->includeLLFile('EXT:itao_shh_manager/mod1/locallang.xml');

require_once(PATH_t3lib . 'class.t3lib_scbase.php');
require_once(t3lib_extMgm::extPath('itao_shh_manager') . '/lib/datamanager_library.inc.php');
require_once(t3lib_extMgm::extPath('itao_shh_manager') . '/lib/database.inc.php');
require_once(t3lib_extMgm::extPath('itao_shh_manager') . '/lib/general.inc.php');

$tmp_abspfad = dirname(__FILE__); # => /srv/www/bst-zfa/subs/dev/html/typo3conf/ext/itao_shh_manager/mod3
$tmp_abspfad_arr = explode("/",$tmp_abspfad );
array_pop($tmp_abspfad_arr);
$tmp_abspfad_fin = implode("/",$tmp_abspfad_arr);

array_pop($tmp_abspfad_arr);
array_pop($tmp_abspfad_arr);
array_pop($tmp_abspfad_arr);
$tmp_abspfad_fin2 = implode("/",$tmp_abspfad_arr);

class  tx_itaoshhmanager_pdfgenerator extends  t3lib_SCbase {
	
	
	function generateUserPDF($groupid, $schoolid,$schooldata) {
		# 1. alle User dieser Gruppe selektieren
		$communeid = $this->piVars['communeid'];
		$allUsers = tx_itaoshhmanager_database::getAllUsersBySchool($schoolid, $groupid, 0);
		#$allGroups = tx_itaoshhmanager_database::getAllUsergroups();
		# ordner anlegen
		$path = $this->tsvars['accountpath'];
		# ordner-pfad über tsvars	
		# damit dann HTML bauen
		$contenthtml = tx_itaoshhmanager_pdfgenerator::getHtmlForUsers($allUsers, $groupid, $schoolid,$schooldata);
		#t3lib_utility_debug::debug($contenthtml );
		# damit dann PDF bauen
		#$pdfdateiname = "zugangsdaten_".$schoolid."-".$groupid.".pdf";	

		if ($groupid!= $this->tsvars['groupid_verw_kommune'] && $groupid!= $this->tsvars['groupid_mod_kommune'] ) {
			$pdfdateiname = "zugangsdaten_s".$schoolid."-".$groupid.".pdf";	
		} else {
			$pdfdateiname = "zugangsdaten_c".$communeid."-".$groupid.".pdf";	
		}


		$pdf = tx_itaoshhmanager_pdfgenerator::getPDF($contenthtml,$pdfdateiname);
		
	}
	
	function getPDF($contenthtml,$dateiname,$forBe=0) {		
		#t3lib_utility_debug::debug($forBe);
		$tmp_abspfad = dirname(__FILE__); # => /srv/www/bst-zfa/subs/dev/html/typo3conf/ext/itao_shh_manager/mod1
		$tmp_abspfad_arr = explode("/",$tmp_abspfad );
		array_pop($tmp_abspfad_arr);					
		array_pop($tmp_abspfad_arr);
		array_pop($tmp_abspfad_arr);
		array_pop($tmp_abspfad_arr);
		$tmp_abspfad_fin2 = implode("/",$tmp_abspfad_arr);	
		$abs_path = $tmp_abspfad_fin2;		
		if ($forBe) {
			$abs_path .= "/".$this->tsvars['beaccountpath'];
		} else {
			$abs_path .= "/".$this->tsvars['accountpath'];
		}
		#t3lib_utility_debug::debug($abs_path);
		#"/uploads/tx_itaozfadatamanager/export_user/";
		$html =    '<html>
		<head>
		<style type="text/css">
			body {font-family: Arial, Lucida Grande, Verdana, Sans-serif;font-size:12px; line-height:1.6em;}
			A {color:black;}
		</style>

		</head>
		
		<body>';
# '
		$contenthtml2 = ($contenthtml=="") ? "Keine Zugänge für diese Benutzergruppe gewünscht." : $contenthtml;
		
		$html.=$contenthtml2;
		$html.='</body></html>'; 
		$fileandpath = tx_itaoshhmanager_pdfgenerator::generateHTMLFile($html,$dateiname, $abs_path);

		$filename = ($dateiname!="") ? $dateiname : "saved_pdf.pdf";

		$filename_html = str_replace(".pdf",".html", $filename);
		
		$abs1 = $_SERVER['DOCUMENT_ROOT']."/typo3conf/ext/itao_shh_manager/lib/";	
		if ($forBe) {
			$abs_uploads = $_SERVER['DOCUMENT_ROOT']."/".$this->tsvars['beaccountpath'];
		} else {
			$abs_uploads = $_SERVER['DOCUMENT_ROOT']."/".$this->tsvars['accountpath'];#"/uploads/tx_itaozfadatamanager/export_user/";	
		}
		
		#t3lib_utility_debug::debug("abs1:".$abs1."//abs_uploads:".$abs_uploads.$filename_html."//filename".$filename);
		
		exec($abs1.'wkhtmltopdf-amd64 '.$abs_uploads.$filename_html.' '.$abs_uploads.$filename);
		
	}
	
	function generateHTMLFile($contenthtml,$dateiname, $abs_path) {
		$filename = ($dateiname!="") ? $dateiname : "saved_pdf.pdf";
		$filename = str_replace(".pdf",".html", $filename);
		$fileandpath = $abs_path."".$filename;
		$file=fopen($fileandpath ,"w");
		fwrite($file, $contenthtml);
		fclose($file);
		return $fileandpath;
	}
	
				
	function getHtmlForUsers ($allUsers, $groupid, $schoolid,$schooldata) {#($nr,  $companyname, $username, $passwd) {		
		$communeid = $this->piVars['communeid'];
		$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);		
		$allGroups = tx_itaoshhmanager_database::getAllUsergroups();
		$anz_users = count($allUsers);
		$groupname = $allGroups[$groupid]['title'];
		if (is_array($allUsers)) {			
			while (list ($key, $val) = each ($allUsers)) {
					$nr++;
					$border = ($nr%3 ==0) ? "": "border-bottom:1px dashed black;" ;	
					$seitenumbruch = ($nr%3 == 0 && $nr!=$anz_users) ? '<div style="page-break-before: always;"></div>' : "";
					$is_seitenumbruch = ($nr%3 == 0 && $nr!=$anz_users) ? 'ja' : "nein";
					#t3lib_utility_debug::debug("nr%3 = ".($nr%3)."//nr=".$nr."//anz_users".$anz_users);
					#t3lib_utility_debug::debug("seitenumbruch:".$seitenumbruch);
					$abstand = ($nr%3 != 1) ? "<br />": ""; 
					$abstand2 = ($nr%3 == 1) ? "margin-top:20px;": ""; #"" : "";#
					#####$myHeight = ($nr%3 == 1) ? "33": "32";
					$myHeight = "32";#($nr%3 == 1) ? "33": "32";
					#F&uuml;r die Verbesserung Ihrer Schule
					$pw = ($val['password_orig']!="") ? $val['password_orig']: $val['password'];
					$str_registered = ($val['tx_itaozfalogin_changepassword']) ? ', Status: noch nicht registriert' : ', Status: registriert';
					if ($groupid!= $this->tsvars['groupid_verw_kommune'] && $groupid!= $this->tsvars['groupid_mod_kommune'] ) {
						$c_or_s = 'Schule "'.utf8_decode($schooldata['title']).'"';
					} else {
						$c_or_s = 'Kommune "'.utf8_decode($communedata['titel']).'"';
					}
					$html .= '<div style="'.$border.'margin-top:0px; margin-left:30px; margin-right: 30px; margin-bottom:0px;padding-bottom:40px;letter-spacing:0.7px;">
					'.$abstand.'
<br />Sch&uuml;lerhaushalt: DEINE Schule - DEINE Entscheidung<br />
<div style="text-align:right; width:100%;">Erstellungsdatum: '.date("d.m.Y, H:i").' Uhr</div>

<div style="font-size:16px;font-weight:bold;padding-top:5px;">'.$c_or_s.'</div>';
					$html.='
<div style="padding-top:10px;"><b>Zugangsdaten für Mitglied der Gruppe "'.utf8_decode($groupname).'"'.$str_registered.'</b></div><br />
<div style="margin-left:25px;line-height:1.8em;">
• Benutzerkennung: <span style="font-family:Courier;font-weight:bold; font-size:14px;">&nbsp;'.$val['username'].'</span><br />
• Freischalt-Passwort: <span style="font-family:Courier;font-weight:bold; font-size:14px;">&nbsp;'.$pw.'</span><br />
• Internet-Adresse:  <u>'.$this->tsvars['maindomain_pdf'].'</u>
</div>';

					$html.='<br />
<div style="border:1px solid black; padding: 7px 7px 7px 7px; margin-bottom:0px;margin-top:5px;margin-bottom:10px;">
W&auml;hrend der ersten Anmeldung m&uuml;ssen Sie ein <b>pers&ouml;nliches Passwort</b> festlegen. Das Freischalt-Passwort ist danach nicht mehr g&uuml;ltig. Bitte behandeln Sie diese Zugangsdaten sehr vertraulich! 
</div>
</div>';
					$html.=$seitenumbruch;
# Seitenumbruch rausgenommen, da mit webkitpdf dann als 2. Seite eine leere Seite erzeugt wurde; Rest war okay
			}
		} else {
			$html =' no content';
		}
		return $html;
	}
	
	
	/* fuer BE-User*/
	
	
	function generateBEUserPDF($groupid, $schoolid,$schooldata,$communeid,$communedata) {
		$by_commune[$this->tsvars['be_groupid_redadmin_kommune']] = 1;
		$by_commune[$this->tsvars['be_groupid_mod_kommune']] = 1;
		$by_commune[$this->tsvars['be_groupid_redadmin_schule']] = 0;
		$by_commune[$this->tsvars['be_groupid_mod_schule']] = 0;
		
		$pref[$this->tsvars['be_groupid_redadmin_kommune']] = 'rak';
		$pref[$this->tsvars['be_groupid_mod_kommune']] = 'modk';
		$pref[$this->tsvars['be_groupid_redadmin_schule']] = 'ras';
		$pref[$this->tsvars['be_groupid_mod_schule']] = 'mods';
		$uid_sk = ($by_commune[$groupid]) ? $communeid:$schoolid ;
				
		# 1. alle User dieser Gruppe selektieren
		$allUsers = tx_itaoshhmanager_database::getAllBeUsersBySchool($communeid, $schoolid, $groupid, $by_commune[$groupid]);
		#t3lib_utility_debug::debug($allUsers);
		# ordner anlegen
		$path = $this->tsvars['beaccountpath'];
		# ordner-pfad über tsvars	
		# damit dann HTML bauen
		$contenthtml = tx_itaoshhmanager_pdfgenerator::getHtmlForBEUsers($allUsers, $groupid, $schoolid,$schooldata,$communeid,$communedata,$by_commune[$groupid]);

		# damit dann PDF bauen
		$pdfdateiname = "red_zugangsdaten_".$pref[$groupid]."_".$uid_sk."-".$groupid.".pdf";	
		#t3lib_utility_debug::debug($contenthtml);
		#t3lib_utility_debug::debug($pdfdateiname);
		#$fileAdmin = t3lib_div::getIndpEnv('TYPO3_DOCUMENT_ROOT').'/'.$TYPO3_CONF_VARS[BE]['fileadminDir'];
		#$fileAdmin.='uploads/tx_itaozfadatamanager/export_user/';
		$pdf = tx_itaoshhmanager_pdfgenerator::getPDF($contenthtml,$pdfdateiname,1);
		
	}
	
	
	
		
				
	function getHtmlForBEUsers ($allUsers, $groupid, $schoolid,$schooldata,$communeid,$communedata,$by_commune) {		
		$allGroups = tx_itaoshhmanager_database::getAllBEUsergroups();
		$headertitle = ($by_commune) ? 'Kommune "'.utf8_decode($communedata['titel']).'"': 'Schule "'.utf8_decode($schooldata['title']).'"';
		$anz_users = count($allUsers);
		$groupname = $allGroups[$groupid]['title'];
		if (is_array($allUsers)) {			
			while (list ($key, $val) = each ($allUsers)) {
					$nr++;
					$border = ($nr%3 ==0) ? "": "border-bottom:1px dashed black;" ;	
					$seitenumbruch = ($nr%3 == 0 && $nr!=$anz_users) ? '<div style="page-break-before: always;"></div>' : "";
					$abstand = ($nr%3 != 1) ? "<br />": ""; 
					$abstand2 = ($nr%3 == 1) ? "margin-top:20px;": "";
					$myHeight = "32";
					#F&uuml;r die Verbesserung Ihrer Schule
					$pw = ($val['password_orig']!="") ? $val['password_orig']: $val['password'];
					$html .= '<div style="'.$border.'margin-top:0px; margin-left:30px; margin-right: 30px; margin-bottom:0px;padding-bottom:40px;letter-spacing:0.7px;">
					'.$abstand.'
<br />Sch&uuml;lerhaushalt: DEINE Schule - DEINE Entscheidung<br />
<div style="text-align:right; width:100%;">Erstellungsdatum: '.date("d.m.Y, H:i").' Uhr</div>

<div style="font-size:16px;font-weight:bold;padding-top:5px;">'.$headertitle.'</div>';
					$html.='
<div style="padding-top:10px;"><b>Zugangsdaten für Redakteur der Gruppe "'.utf8_decode($groupname).'"</b></div><br />
<div style="margin-left:25px;line-height:1.8em;">
• Benutzerkennung: <span style="font-family:Courier;font-weight:bold; font-size:14px;">&nbsp;'.$val['username'].'</span><br />
• Passwort: <span style="font-family:Courier;font-weight:bold; font-size:14px;">&nbsp;'.$pw.'</span><br />
• Internet-Adresse:  <u>www.schuelerhaushalt.de/typo3</u>
</div>';

					$html.='<br />
<div style="border:1px solid black; padding: 7px 7px 7px 7px; margin-bottom:0px;margin-top:5px;margin-bottom:10px;">
 <center>Bitte behandeln Sie diese Zugangsdaten sehr vertraulich! </center>
</div>
</div>';
			}
		} else {
			$html =' no content';
		}
		return $html;
	}
	
		
				
}

?>