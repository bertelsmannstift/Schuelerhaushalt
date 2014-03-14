<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2012 Edeltraud Gratzer <edeltraud.gratzer@itao.de>
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

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Weiterleitung zu Schulen' for the 'itao_shh_redirect' extension.
 *
 * @author	Edeltraud Gratzer <edeltraud.gratzer@itao.de>
 * @package	TYPO3
 * @subpackage	tx_itaoshhredirect
 */
class tx_itaoshhredirect_pi2 extends tslib_pibase {
	var $prefixId      = 'tx_itaoshhredirect_pi2';		// Same as class name
	var $scriptRelPath = 'pi2/class.tx_itaoshhredirect_pi2.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'itao_shh_redirect';	// The extension key.
	var $pi_checkCHash = true;
	
	/**
	 * The main method of the PlugIn
	 * Hier wird eine Weiterleitung zur Startseite der Schule gemacht, wenn der Benutzer eingeloggt ist und auf die Startseite www.schuelerhaushalt.de geht
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content, $conf) {
		$this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		#t3lib_utility_debug::debug($_GET);
		#t3lib_utility_debug::debug($_POST);
		#t3lib_utility_debug::debug(".");
		#echo "1";
		$content='';
		if (!$_GET['red']) {
			$this->checkRedirect();
		}
		# 0.: Wenn man auf der Startseite ist
		if ($GLOBALS['TSFE']->id == 1 || $GLOBALS['TSFE']->id == 32 ) { # startseite, willkommensseite oder seite nicht gefunden #  || $GLOBALS['TSFE']->id == 297
			# 1. herausfinden, ob der User eingeloggt ist: wenn nein, dann do nothing; wenn ja: schau, ob er sich Grade erst eingeloggt hat
			if ($GLOBALS['TSFE']->fe_user->user['uid']) {
#				t3lib_utility_debug::debug("a: ist eingeloggt");
				# 2. wenn grade erst eingeloggt, dann überlass alles der itao_zfalogin
				if ($_POST['submit']=="" && $_POST['user']=="" && $_POST['pass']=="") {
			
					# 3. UNTERSCHEIDE, ob von erstmaliger anmeldung oder nicht
					# 3. wenn nicht grade erst eingeloggt, dann weiterleitung
				
					$neue_pageid =  $GLOBALS['TSFE']->id;
					$usergroup = $GLOBALS['TSFE']->fe_user->user['usergroup'];	
					
					if ($usergroup!="") {
						# schauen, obs auch keiner von der Kommune ist:
						$usergroupArr = explode(",",$usergroup);
						if (is_array($usergroupArr)) {
							if (!in_array(1,$usergroupArr) && !in_array(5,$usergroupArr)) {
								$select = '*';
								$from = 'fe_groups';
								$where = 'uid in ('.$usergroup.')';
								$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where);
								if ($res) {
								  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
								  	if (intval($row['felogin_redirectPid']) > 0) {
								    	$redirectid = $row['felogin_redirectPid'];
								    	$neue_pageid = $row['felogin_redirectPid'];
								    }
								  }
								}
								
								$url = tslib_pibase::pi_getPageLink($neue_pageid);		
								
			#				t3lib_utility_debug::debug("redirect zu:".$url);
								header('Location: /'.$url);	
							}
						}
					}					
				}
			}
		}
		
		
	
		return $this->pi_wrapInBaseClass($content);
	}
	
	
	
	function checkRedirect() {
		# 1. alle Schulen selektieren
		$allSchools = $this->getAllSchools();
		# überall die Startseiten extrahieren ref_schoolpage
		if (is_array($allSchools)) {
			while (list ($key, $val) = each ($allSchools)) {
				$allStartPages[$val['ref_schoolpage']]['startpage'] = $val['ref_schoolpage'];
				$allStartPages[$val['ref_schoolpage']]['data'] = $val;
			}
		}		
		# 2. wenn die aktuelle Seite eine dieser Seiten ist, dann:
		if (is_array($allStartPages)) {
			if ($allStartPages[$GLOBALS['TSFE']->id]['startpage'] == $GLOBALS['TSFE']->id ) {
				$aktSchule = $allStartPages[$GLOBALS['TSFE']->id]['data']['uid'];
				$soll_gruppe = $allStartPages[$GLOBALS['TSFE']->id]['data']['ref_fegroup'];
				#t3lib_utility_debug::debug($aktSchule);
				# wenn der User eingeloggt ist
				if ($GLOBALS['TSFE']->fe_user->user['uid'] > 0) {
					$usergroup = $GLOBALS['TSFE']->fe_user->user['usergroup'];	
					if ($usergroup!="") {
						# schauen, obs auch keiner von der Kommune ist:
						$usergroupArr = explode(",",$usergroup);
						if (is_array($usergroupArr)) {
							
								$neue_pageid =  32; # Startseite
								# user ist NCIHT in seiner Schule!!
								#t3lib_utility_debug::debug("x");
								$select = '*';
								$from = 'fe_groups';
								$where = 'uid in ('.$usergroup.')';
								$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where);
								if ($res) {
								  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
								  	if (intval($row['felogin_redirectPid']) > 0) {
								    	$redirectid = $row['felogin_redirectPid'];
								    	$neue_pageid = $row['felogin_redirectPid'];
								    }
								  }
								}
							
								$url = tslib_pibase::pi_getPageLink($neue_pageid);	
							
							if (in_array($soll_gruppe,$usergroupArr )) {
								# dann ist alles gut
								#t3lib_utility_debug::debug($url);								
								#t3lib_utility_debug::debug($GLOBALS['TSFE']->id."//".$neue_pageid);								
								header('Location: /'.$url.'?&red=1');	
							} else {
								#t3lib_utility_debug::debug($url);
								#if (!$_GET['red']) {
									header('Location: /'.$url);	
								#}
								
							}
						}
					}
				}
				# wenn der User NCIHT eingeloggt ist
			}
		}
		# 3. schauen, ob ref_fegroup - die zugeordnete FE-Group auch die eigene ist;
		# 4. wenn nicht, dann weiterleiten wie oben
		
	}
	
	
	function getAllSchools() {					
		$select = '*';
		$from = 'tx_itaoshhmanager_schools';
		$where = 'hidden=0 and deleted=0';	
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $schools[$row['uid']] = $row;
		  }
		}
		return $schools;
	}
	
	
	
}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/itao_shh_redirect/pi2/class.tx_itaoshhredirect_pi2.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/itao_shh_redirect/pi2/class.tx_itaoshhredirect_pi2.php']);
}

?>