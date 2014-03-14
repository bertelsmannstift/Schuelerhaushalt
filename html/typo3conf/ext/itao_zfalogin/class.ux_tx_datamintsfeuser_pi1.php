<?php 
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2011 Peter Rauer <peter.rauer@itao.de>
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

class ux_tx_datamintsfeuser_pi1 extends tx_datamintsfeuser_pi1 {
	
	/**
	 * Bereitet die uebergebenen Daten fuer den Import in die Datenbank vor, und fuehrt diesen, wenn es keine Fehler gab, aus.
	 *
	 * @return	string
	 */
	function sendForm() {
#t3lib_utility_debug::debug($_POST);
#break;
		$mode = '';
		$submode = '';
		$params = array();

		// Jedes Element trimmen.
		foreach ($this->piVars[$this->contentId] as $key => $value) {
			if (!is_array($value)) {
				$this->piVars[$this->contentId][$key] = trim($value);
			}
		}
	
		// Ueberpruefen ob Datenbankeintraege mit den uebergebenen Daten uebereinstimmen.
		$uniqueCheck = $this->uniqueCheckForm();

		// Eine Validierung durchfuehren ueber alle Felder die eine gesonderte Konfigurtion bekommen haben.
		$validCheck = $this->validateForm();

		// Ueberpruefen ob in allen benoetigten Feldern etwas drinn steht.
		$requireCheck = $this->requireCheckForm();

		// Wenn bei der Validierung ein Feld nicht den Anforderungen entspricht noch einmal die Form anzeigen und entsprechende Felder markieren.
		$valueCheck = array_merge((array)$uniqueCheck, (array)$validCheck, (array)$requireCheck);

		if (count($valueCheck) > 0) {
			return $this->showForm($valueCheck);
		}

		// Temporaeren Feldnamen fuer das 'Aktivierungslink zusenden' Feld erstellen.
		$fieldName = '--resendactivation--';

		// Wenn der User eine neue Aktivierungsmail beantragt hat.
		if ($this->piVars[$this->contentId][$this->cleanSpecialFieldKey($fieldName)] && in_array($fieldName, $this->arrUsedFields)) {
			$fieldName = $this->cleanSpecialFieldKey(array($this->piVars));

			// Falls der Anzeigetyp "list" ist (Liste der im Cookie gespeicherten User), alle uebergebenen User ermitteln und fuer das erneute zusenden verwenden. Ansonsten die uebergebene E-Mail verwenden.
			//if ($this->conf['shownotactivated'] == 'list') {
			//	$arrNotActivated = $this->getNotActivatedUserArray($this->piVars[$this->contentId][$fieldName]);
			//	$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid, tx_datamintsfeuser_approval_level', 'fe_users', 'pid = ' . intval($this->storagePid) . ' AND uid IN(' . implode(',', $arrNotActivated) . ') AND disable = 1 AND deleted = 0');
			//} else {
				$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid, tx_datamintsfeuser_approval_level', 'fe_users', 'pid = ' . intval($this->storagePid) . ' AND email = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr(strtolower($this->piVars[$this->contentId][$fieldName]), 'fe_users') . ' AND disable = 1 AND deleted = 0', '', '', '1');
			//}

			//while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
				$row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
				// Genehmigungstypen aufsteigend sortiert ermitteln. Das ist nötig um das Level dem richtigen Typ zuordnen zu können.
				// Beispiel: approvalcheck = ,doubleoptin,adminapproval => beim exploden kommt dann ein leeres Arrayelement herraus, das nach dem entfernen einen leeren Platz uebrig lässt.
				$arrApprovalTypes = $this->getApprovalTypes();
				$approvalType = $arrApprovalTypes[count($arrApprovalTypes) - $row['tx_datamintsfeuser_approval_level']];

				// Ausgabe vorbereiten.
				$mode = $fieldName;

				// Fehler anzeigen, falls das naechste aktuelle Genehmigungsverfahren den Admin betrifft.
				$submode = 'failure';

				// Aktivierungsmail senden und Ausgabe anpassen.
				if ($approvalType && !$this->isAdminMail($approvalType)) {
					$this->sendActivationMail($row['uid']);
					$submode = 'sent';
				}
			//}

			return $this->showMessageOutputRedirect($mode, $submode);
		}

		// Wenn der Bearbeitungsmodus, die Zielseite, und der User stimmen, dann wird in die Datenbank geschrieben.
		if ($this->piVars[$this->contentId]['submitmode'] == $this->conf['showtype'] && $this->piVars[$this->contentId]['pageid'] == $GLOBALS['TSFE']->id && $this->piVars[$this->contentId]['userid'] == $this->userId) {
			// Sonderfaelle!
			foreach ($this->arrUsedFields as $fieldName) {
				if ($this->feUsersTca['columns'][$fieldName]) {
					$fieldConfig = $this->feUsersTca['columns'][$fieldName]['config'];
					$fieldType = $fieldConfig['type'];

					// Ist das Feld schon gesaeubert worden (MySQL, PHP, HTML, ...).
					$isChecked = false;

					// Datumsfelder behandeln.
					if (strpos($fieldConfig['eval'], 'date') !== false) {
						$arrUpdate[$fieldName] = strtotime($this->piVars[$this->contentId][$fieldName]);
						$isChecked = true;
					}

					// Passwordfelder behandeln.
					if (strpos($fieldConfig['eval'], 'password') !== false) {
						// Password generieren und verschluesseln je nach Einstellung.
						$password = $this->generatePassword($fieldName);
						$arrUpdate[$fieldName] = $password['encrypted'];

						// Wenn kein Password uebergeben wurde auch keins schreiben.
						if (!$arrUpdate[$fieldName]) {
							unset($arrUpdate[$fieldName]);
						}

						$isChecked = true;
					}

					// Checkboxen behandeln.
					if ($fieldType == 'check' && !$this->piVars[$this->contentId][$fieldName]) {
						$arrUpdate[$fieldName] = '0';
					}

					// Multiple Selectboxen.
					if ($fieldType == 'select' && $fieldConfig['size'] > 1) {
						$arrCleanedValues = array();

						foreach ($this->piVars[$this->contentId][$fieldName] as $val) {
							$arrCleanedValues[] = intval($val);
						}

						$arrUpdate[$fieldName] = implode(',', $arrCleanedValues);
						$isChecked = true;
					}

					// Group, Bildfelder behandeln.
					if ($fieldType == 'group' && $fieldConfig['internal_type'] == 'file' && ($_FILES[$this->prefixId]['type'][$this->contentId][$fieldName] || $this->piVars[$this->contentId][$fieldName . '_delete'])) {
						// Das Bild hochladen oder loeschen. Gibt einen Fehlerstring zurueck falls ein Fehler auftritt. $arrUpdate wird per Referenz uebergeben und innerhalb der Funktion geaendert!
						$valueCheck[$fieldName] = $this->saveDeleteImage($fieldName, $arrUpdate);

						if ($valueCheck[$fieldName]) {
							return $this->showForm($valueCheck);
						}

						$isChecked = true;
					}

					// Group, Multiple Checkboxen.
					if ($fieldType == 'group' && $fieldConfig['internal_type'] == 'db') {
						$arrCleanedValues = array();
						$arrAllowed = t3lib_div::trimExplode(',', $fieldConfig['allowed'], true);

						foreach ($arrAllowed as $table) {
							if ($GLOBALS['TCA'][$table]) {
								foreach ($this->piVars[$this->contentId][$fieldName] as $val) {
									if (preg_match('/^' . $table . '_[0-9]+$/', $val)) {
										$arrCleanedValues[] = $val;
									}
								}
							}
						}

						// Falls nur eine Tabelle im TCA angegeben ist, wird nur die uid gespeichert.
						if (count($arrAllowed) == 1) {
							foreach ($arrCleanedValues as $key => $val) {
								$arrCleanedValues[$key] = substr($val, strripos($val, '_') + 1);
							}
						}

						$arrUpdate[$fieldName] = implode(',', $arrCleanedValues);
						$isChecked = true;
					}

					// Wenn noch nicht gesaeubert dann nachholen!
					if (!$isChecked && isset($this->piVars[$this->contentId][$fieldName])) {
						// Groesse ermitteln und anhand dessen und des Feldtyps das Feld saeubern.
						$size = $fieldConfig['size'];

						// Wenn eine Checkbox oder eine einfache Selectbox, dann darf nur eine Zahl kommen!
						if ($type == 'check' || ($type == 'select' && $size == 1)) {
							$arrUpdate[$fieldName] = intval($this->piVars[$this->contentId][$fieldName]);
						}

						// Ansonsten Standardsaeuberung.
						$arrUpdate[$fieldName] = strip_tags($this->piVars[$this->contentId][$fieldName]);

						// Wenn E-Mail Feld, alle Zeichen zu kleinen Zeichen konvertieren.
						if ($fieldName == 'email') {
							$arrUpdate[$fieldName] = strtolower($arrUpdate[$fieldName]);
						}
					}
				}
			}

			// Zusatzfelder setzten, die nicht aus der Form uebergeben wurden.
			$arrUpdate['tstamp'] = time();
		
			// Konvertiert alle moeglichen Zeichen die fuer die Ausgabe angepasst wurden zurueck.
			foreach ($arrUpdate as $key => $val) {
				$arrUpdate[$key] = htmlspecialchars_decode($val);
			}

			// Temporaeren Feldnamen fuer das 'User loeschen' Feld erstellen.
			$fieldName = '--userdelete--';

			// Wenn der User geloescht werden soll.
			if ($this->piVars[$this->contentId][$this->cleanSpecialFieldKey($fieldName)] && in_array($fieldName, $this->arrUsedFields)) {
				$arrUpdate['deleted'] = '1';
			}
#echo "1";
#t3lib_utility_debug::debug($arrUpdate);
#t3lib_utility_debug::debug($_POST);
			// Der User hat seine Daten editiert.
			if ($this->conf['showtype'] == 'edit' || ($this->conf['showtype'] == 'register' && $GLOBALS['TSFE']->id == 35)) { #'register') {#
#t3lib_utility_debug::debug($arrUpdate);
#echo "1";
				// itao GmbH & Co KG - Philipp Hanebrink - BEGIN
				//If password was changed, remove the force password change marker in the user entry
				if($arrUpdate['password'])
				{
					$arrUpdate['tx_itaozfalogin_changepassword'] = 0;
				}		
				// itao GmbH & Co KG - Philipp Hanebrink - END
				
				
				
				// itao GmbH & Co KG - Traude Gratzer - BEGIN
				// damit die richtige usergroup gesetzt wird; abhängig von schule
				#echo " // sc:".$arrUpdate['tx_itaoshhmanager_ssh_ref_school'];
				if($arrUpdate['tx_itaoshhmanager_ssh_ref_school']){
					$select = '*';
					$from = 'tx_itaoshhmanager_schools';
					$where = 'hidden=0 and deleted=0';	
					$where.=' and uid='.$arrUpdate['tx_itaoshhmanager_ssh_ref_school'];
					$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
					if ($res) {
					  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
					    $new_usergroup = $row['ref_fegroup'];
					  }
					}
					
					$arrUpdate['usergroup'] .= '7,'.$new_usergroup; # 7 fuer Gast-Usergruppe; muss noch aus TS ausgelesen werden!
					$arrUpdate['pid']= '17'; # pid auch noch auslesen!!
				}		
				// itao GmbH & Co KG - Traude Gratzer - END
			
				// User editieren.
				$GLOBALS['TYPO3_DB']->exec_UPDATEquery('fe_users', 'uid = ' . $this->userId , $arrUpdate);

				// User und Admin Benachrichtigung schicken, aber nur wenn etwas geaendert wurde.
				if ($this->conf['edit.']['sendusermail'] || $this->conf['edit.']['sendadminmail']) {
					$extraMarkers = $this->getChangedForMail($arrUpdate, $this->conf['edit.']);

					if ($this->conf['edit.']['sendusermail'] && !isset ($extraMarkers['nothing_changed'])) {
						$this->sendMail($this->userId, 'edit', false, $this->conf['edit.'], $extraMarkers);
					}

					if ($this->conf['edit.']['sendadminmail'] && !isset ($extraMarkers['nothing_changed'])) {
						$this->sendMail($this->userId, 'edit', true, $this->conf['edit.'], $extraMarkers);
					}
				}

				// Ausgabe vorbereiten.
				$mode = $this->conf['showtype'];
				$submode = 'success';

				// Wenn der User geloescht wurde, weiterleiten.
				if ($arrUpdate['deleted']) {
					$mode = 'userdelete';
				}
			}

			// Ein neuer User hat sich angemeldet.
			if ($this->conf['showtype'] == 'register') {
				// Standartkonfigurationen anwenden.
				$arrUpdate['pid'] = $this->storagePid;
				$arrUpdate['usergroup'] = ($arrUpdate['usergroup']) ? $arrUpdate['usergroup'] : $this->conf['register.']['usergroup'];
				$arrUpdate['crdate'] = $arrUpdate['tstamp'];

				// Extra Erstellungsdatumsfelder hinzufuegen.
				$arrCrdateFields = t3lib_div::trimExplode(',', $this->conf['register.']['crdatefields'], true);
				
				// itao GmbH & Co KG - Peter Rauer - BEGIN
				// Check if username is given else set username from setup! 
				if (!$this->piVars['username']) {
					if($this->conf['useEmailAsUsername'] == 1) {
						$arrUpdate['username'] = $arrUpdate['email'];
					} else {
						if (strlen(trim($this->conf['useFieldsAsUsername'])) > 0) 
							$arrUpdate['username'] = $this->buildUsernameFromFields($arrUpdate);
					}
				}
				// itao GmbH & Co KG - Peter Rauer - END	
				
				foreach ($arrCrdateFields as $val) {
					if (trim($val)) {
						$arrUpdate[trim($val)] = $arrUpdate['crdate'];
					}
				}

				// Genehmigungstypen aufsteigend sortiert ermitteln. Das ist nötig um das Level dem richtigen Typ zuordnen zu können.
				// Beispiel: approvalcheck = ,doubleoptin,adminapproval => beim exploden kommt dann ein leeres Arrayelement herraus, das nach dem entfernen einen leeren Platz uebrig lässt.
				$arrApprovalTypes = $this->getApprovalTypes();
				$approvalType = $arrApprovalTypes[0];

				// Maximales Genehmigungslevel ermitteln (Double Opt In / Admin Approval).
				$arrUpdate['tx_datamintsfeuser_approval_level'] = count($arrApprovalTypes);

				// Wenn ein Genehmigungstyp aktiviert ist, dann den User deaktivieren.
				if ($arrUpdate['tx_datamintsfeuser_approval_level'] > 0) {
					$arrUpdate['disable'] = '1';
				}

				// User erstellen.
				$GLOBALS['TYPO3_DB']->exec_INSERTquery('fe_users', $arrUpdate);

				// Userid ermittln un Global definieren!
				$userId = $GLOBALS['TYPO3_DB']->sql_insert_id();

				// Wenn nach der Registrierung weitergeleitet werden soll.
				if ($arrUpdate['tx_datamintsfeuser_approval_level'] > 0) {
					// Aktivierungsmail senden.
					$this->sendActivationMail($userId);

					// Ausgabe fuer gemischte Genehmigungstypen erstellen (z.B. erst adminapproval und dann doubleoptin).
					$mode = $approvalType;
					
					# aufgesplittet, weil sonst fehlermeldung "Warning: implode() [function.implode]: Invalid arguments passed in /srv/www/web-856/html/typo3conf/ext/itao_zfalogin/class.ux_tx_datamintsfeuser_pi1.php on line 339"
					###ORIGINAL:####
					$submode = implode('_', array_shift($arrApprovalTypes));
					/*$tgr_tmparr =  array_shift($arrApprovalTypes);
					if (is_array($tgr_tmparr)) {
						$submode = implode('_', $tgr_tmparr);
					}		
					#doubleoptin_success_sent 
					*/
					$submode .= ($submode) ? '_sent' : 'sent';
					$params = array('mode' => $this->conf['showtype']);
				} else {
					// Erstellt ein neues Passwort, falls Passwort generieren eingestellt ist. Das Passwort kannn dann ueber den Marker "###PASSWORD###" mit der Registrierungsmail gesendet werden.
					$extraMarkers = $this->generatePasswordForMail($userId);

					// Registrierungs E-Mail schicken.
					$this->sendMail($userId, 'registration', true, $this->conf['register.']);
					$this->sendMail($userId, 'registration', false, $this->conf['register.'], $extraMarkers);

					$mode = $this->conf['showtype'];
					$submode = 'success';
					$params = array('username' => $arrUpdate['username']);
				}
			}
		}

		// Include hook to get user and update information.
		if (is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['datamints_feuser']['sendForm_update'])) {
			foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['datamints_feuser']['sendForm_update'] as $_classRef) {
				$_getter = array(
					'userId' => ($userId) ? $userId : $this->userId,
					'showtype' => $this->conf['showtype'],
					'arrUpdate' => $arrUpdate,
					'arrUserData' => $GLOBALS['TSFE']->fe_user->user
				);
				$_setter = array(
					'pObj' => &$this
				);
				$_procObj = &t3lib_div::getUserObj($_classRef);
				$_procObj->sendForm_update($_getter, $_setter, $this);
			}
		}
		return $this->showMessageOutputRedirect($mode, $submode, $params);
	}
	
	/** 
	 * Builds the username from fields in setup.
	 * 
	 * @param	array			$submit: The data from registration form.
	 * @reurn	string			The username built by setup.
	 */
	function buildUsernameFromFields($submit) {
		$fields = t3lib_div::trimExplode(',', $this->conf['useFieldsAsUsername'], true);
		// minimum one field
		if (isset($fields) && count($fields)>0) {
			$uName = '';
			// if a single seperator is required
			$seperator = ($this->conf['useFieldAsUsernameSeperator'] && strlen(trim($this->conf['useFieldAsUsernameSeperator']))==1) ? $this->conf['useFieldAsUsernameSeperator'] : '';
			foreach ($fields as $field) {
				// first filter "-": Replace whitespaces!
				if (strpos($field, '-')>0) { $field = str_replace(' ','', $field); } 
				$uName .= str_replace(' ',$seperator,$submit[$field]) .$seperator; 	
			}
			if (strlen($seperator) > 0) { $uName = substr($uName, 0 ,strlen($uName)-1); }
		}
		// check username in database and give it a number if username already exists
		$uName .= $this->checkRequestedUsername($uName);
		
		return $uName;
	}
	
	/*
	 * Checks if a username is already present in database.
	 * 
	 *  @param	string			$uName: The username to look up.
	 *  @return	string			The number of this username.			
	 */
	function checkRequestedUsername($uName) {
		$res = $GLOBALS['TYPO3_DB']->sql_query("SELECT COUNT(*) AS count FROM fe_users WHERE username like '" .$uName ."'");
		$row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
		return ($row['count'] == 0) ? '' : $row['count'];
	}
	
	/**
	 * Ueberprueft ob das uebergebene Feld benoetigt wird um erfolgreich zu speichern.
	 *
	 * @param	string		$fieldName
	 * @return	string
	 */
	function checkIfRequired($fieldName) {
		if (array_intersect(array($fieldName, '--' . $fieldName . '--'), $this->arrRequiredFields)) {
			return '<span class="req-marker">*</span>';
		} else {
			return '';
		}
	}
	
	
		/**
	 * Erledigt allen Output der nichts mit dem eigendlichen Formular zu tun hat.
	 * Fuer besondere Faelle kann hier eine Ausnahme, oder zusaetzliche Konfigurationen gesetzt werden.
	 *
	 * @param	string		$mode
	 * @param	string		$submode
	 * @param	array		$params
	 * @return	string		$label
	 */
	function showMessageOutputRedirect($mode, $submode = '', $params = array()) {
		$redirect = true;

		// Label ermitteln
		$label = $this->getLabel($mode . (($submode) ? '_' . $submode : ''));

		// Zusaetzliche Konfigurationen die gesetzt werden, bevor die Ausgabe oder der Redirect ausgefuehrt werden.
		switch ($mode) {

			case 'register':
				// Login vollziehen, falls eine Redirectseite angegeben ist, wird dorthin automatisch umgeleitet.
				#if ($params['username'] && $this->conf['register.']['autologin']) {
				
				#echo "111";
				#break;
					$this->userAutoLogin($params['username'], $mode);
				#}
				


				break;

			case 'doubleoptin':
				// Login vollziehen, falls eine Redirectseite angegeben ist, wird dorthin automatisch umgeleitet.
				if ($params['userId'] && $this->conf['register.']['autologin']) {
					$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('username', 'fe_users', 'uid = ' . $params['userId'], '', '', '1');
					$row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);

					$this->userAutoLogin($row['username'], $mode);
				}

			case 'adminapproval':
				// WICHTIG: Kein break beim doubleoptin, da diese Konfiguration auch fuer doubleoptin gilt.
				if ($params['mode']) {
					if ($this->conf['redirect.'][$params['mode']]) {
						$mode = $params['mode'];
					} else {
						$redirect = false;
					}
				}

				break;

			case 'edit_error_no_login':
				$label = '<div class="error">' . $label . '</div>';
				break;

			case 'edit':
				// Einen Refresh der aktuellen Seite am Client ausfuehren, damit nach dem Editieren wieder das Formular angezeigt wird.
				$pageuid = 1;
				#echo "1";
				#echo t3lib_utility_debug::debug($GLOBALS['TSFE']->fe_user->user['uid']);
				$usergroup = $GLOBALS['TSFE']->fe_user->user['usergroup'];
				if ($usergroup!="") {
					$select = '*';
					$from = 'fe_groups';
					$where = 'uid in ('.$usergroup.')';
					$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where);
					if ($res) {
					  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
					  	if (intval($row['felogin_redirectPid']) > 0) {
					    	$redirectid = $row['felogin_redirectPid'];
					    	$pageuid = $row['felogin_redirectPid'];
					    }
					  }
					}
				}
				$GLOBALS['TSFE']->additionalHeaderData['refresh'] = '<meta http-equiv="refresh" content="1; url=' . t3lib_div::getIndpEnv('TYPO3_SITE_URL') . $this->pi_getPageLink($pageuid) . '" />';
				break;

			case 'doubleoptin':
				// Einen Refresh auf der aktuellen Seite am Client ausfuehren, damit nach dem Loeschen des Users die Startseite angezeigt wird.
				$GLOBALS['TSFE']->additionalHeaderData['refresh'] = '<meta http-equiv="refresh" content="2; url=' . t3lib_div::getIndpEnv('TYPO3_SITE_URL') . '" />';
				break;

		}

		if ($redirect && $this->conf['redirect.'][$mode]) {			
			if ($submode == "deleted") {
				$mode = "userdelete";
			}
			$this->userRedirect($this->conf['redirect.'][$mode]);
		}

		return $label;
	}
	
	
	/**
	 * Vollzieht einen Login ohne ein Passwort.
	 *
	 * @param	string		$username
	 * @param	string		$mode
	 * @return	void
	 */
	function userAutoLogin($username, $mode = '') {
		// Login vollziehen.
		$GLOBALS['TSFE']->fe_user->checkPid = 0;
		$info = $GLOBALS['TSFE']->fe_user->getAuthInfoArray();
		$user = $GLOBALS['TSFE']->fe_user->fetchUserRecord($info['db_user'], $username);
		$GLOBALS['TSFE']->fe_user->createUserSession($user);

		// Umleiten, damit der Login wirksam wird.

				$neue_pageid = (intval($this->conf['redirect.'][$mode]) > 0) ? $this->conf['redirect.'][$mode]: 1;
				$usergroup = $user['usergroup'];
				if ($usergroup!="") {
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
				}
		$this->userRedirect($neue_pageid);
	}
	
	
	
	/**
	 * Rendert Selectfelder.
	 *
	 * @param	string		$fieldName
	 * @param	array		$arrCurrentData
	 * @return	string		$content
	 */
	function showSelect($fieldName, $arrCurrentData) {
		# TGR: ProbleM: auch gelöschte Werte werden angezeigt! z.b. Schulen!
		$content = '';
		$optionlist = '';
		$countSelectFields = count($this->feUsersTca['columns'][$fieldName]['config']['items']);

		// Moeglichkeit das der gespeicherte Wert eine kommseparierte Liste ist, daher aufsplitten in ein Array, wie es auch von einem abgesendeten Formular kommen wuerde.
		if (!is_array($arrCurrentData[$fieldName])) {
			$arrCurrentData[$fieldName] = t3lib_div::trimExplode(',', $arrCurrentData[$fieldName], true);
		}

		// Items, die in der TCA-Konfiguration festgelegt wurden.
		for ($i = 0; $i < $countSelectFields; $i++) {
			$selected = (in_array($i, $arrCurrentData[$fieldName])) ? ' selected="selected"' : '';
			$optionlist .= '<option value="' . $this->feUsersTca['columns'][$fieldName]['config']['items'][$i][1] . '"' . $selected . '>' . $this->getLabel($this->feUsersTca['columns'][$fieldName]['config']['items'][$i][0]) . '</option>';
		}

		// Wenn Tabelle angegeben zusaetzlich Items aus Datenbank holen.
		if ($this->feUsersTca['columns'][$fieldName]['config']['foreign_table']) {
			// Select-Items aus DB holen.
			$tab = $this->feUsersTca['columns'][$fieldName]['config']['foreign_table'];
			$sel = 'uid, ' . $GLOBALS['TCA'][$tab]['ctrl']['label'];
			$whr = '1 ' . $this->feUsersTca['columns'][$fieldName]['config']['foreign_table_where'];

			$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($sel , $tab, $whr);

			while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
				$selected = (in_array($row['uid'], $arrCurrentData[$fieldName])) ? ' selected="selected"' : '';
				$optionlist .= '<option value="' . $row['uid'] . '"' . $selected . '>' . $row[$GLOBALS['TCA'][$tab]['ctrl']['label']] . '</option>';
			}
		}

		if ($this->feUsersTca['columns'][$fieldName]['config']['size'] > 1 ) { # Anpassung für SHH von TGR #&& $fieldName!='tx_itaoshhmanager_ssh_ref_school'
			// Mehrzeiliges Select (Auswahlliste).
			$content .= '<select id="' . $this->extKey . '_' . $this->contentId . '_' . $fieldName . '" name="' . $this->prefixId . '[' . $this->contentId . '][' . $fieldName . '][]" size="' . $this->feUsersTca['columns'][$fieldName]['config']['size'] . '" multiple="multiple">';
			$content .= $optionlist;
			$content .= '</select>';
		} else {
			// Einzeiliges Select (Dropdown).
			$content .= '<select id="' . $this->extKey . '_' . $this->contentId . '_' . $fieldName . '" name="' . $this->prefixId . '[' . $this->contentId . '][' . $fieldName . ']">';
			$content .= $optionlist;
			$content .= '</select>';
		}

		return $content;
	}
	
	
			/**
	 * Ueberprueft ob die Linkbestaetigung gueltig ist und aktiviert gegebenenfalls den User.
	 *
	 * @param	integer		$userId
	 * @return	string
	 */
	function makeApprovalCheck($userId) {
		// Userdaten ermitteln.
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid, tstamp, username, email, tx_datamintsfeuser_approval_level', 'fe_users', 'uid = ' . $userId, '', '', '1');
		$row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);

		// Genehmigungstyp ermitteln um die richtige E-Mail zu senden, bzw. die richtige Ausgabe zu ermitteln.
		$arrApprovalTypes = $this->getApprovalTypes();
		$approvalType = $arrApprovalTypes[count($arrApprovalTypes) - $row['tx_datamintsfeuser_approval_level']];

		// Wenn kein Genehmigungstyp ermittelt werden konnte.
		if (!$approvalType) {
			return $this->showMessageOutputRedirect('approvalcheck_failure');
		} else {
			// Ausgabe vorbereiten.
			$mode = $approvalType;
			$submode = 'failure';
			$params = array();
		}

		// Daten vorbereiten.
		$time = time();
		$hashApproval = md5('approval' . $row['uid'] . $row['tstamp'] . $this->extConf['encryptionKey']);
		$hashDisapproval = md5('disapproval' . $row['uid'] . $row['tstamp'] . $this->extConf['encryptionKey']);

		// Wenn der Hash richtig ist, des letzte Genehmigungslevel aber noch nicht erreicht ist.
		if ($this->piVars[$this->contentId]['hash'] == $hashApproval && $row['tx_datamintsfeuser_approval_level'] > 1) {
			// Genehmigungslevel updaten.
			$GLOBALS['TYPO3_DB']->exec_UPDATEquery('fe_users', 'uid = ' . $userId ,array('tstamp' => $time, 'tx_datamintsfeuser_approval_level' => $row['tx_datamintsfeuser_approval_level'] - 1));

			// Aktivierungsmail schicken.
			$this->sendActivationMail($userId);

			// Ausgabe vorbereiten.
			$submode = 'success';
		}

		// Wenn der Hash richtig ist, und das letzte Genehmigungslevel erreicht ist.
		if ($this->piVars[$this->contentId]['hash'] == $hashApproval && $row['tx_datamintsfeuser_approval_level'] == 1) {
			// Erstellt ein neues Passwort, falls Passwort generieren eingestellt ist. Das Passwort kannn dann ueber den Marker "###PASSWORD###" mit der Registrierungsmail gesendet werden.
			$extraMarkers = $this->generatePasswordForMail(intval($this->piVars[$this->contentId]['uid']));

			// User aktivieren.
			$GLOBALS['TYPO3_DB']->exec_UPDATEquery('fe_users', 'uid = ' . $userId ,array('tstamp' => $time, 'disable' => '0', 'tx_datamintsfeuser_approval_level' => '0'));

			// Registrierungs E-Mail schicken.
			$this->sendMail($userId, 'registration', true, $this->conf['register.']);
			$this->sendMail($userId, 'registration', false, $this->conf['register.'], $extraMarkers);

			// Ausgabe vorbereiten.
			$submode = 'success';
			$params = array('userId' => $userId);
		}

		// Wenn der Hash richtig ist, des letzte Genehmigungslevel aber noch nicht erreicht ist.
		if ($this->piVars[$this->contentId]['hash'] == $hashDisapproval) {
			// User loeschen.
			$GLOBALS['TYPO3_DB']->exec_UPDATEquery('fe_users', 'uid = ' . $userId ,array('tstamp' => $time, 'deleted' => '1'));

			// Eine Account-Abgelehnt Mail senden, wenn User ablehnt an den Administrator, oder andersrum.
			$this->sendMail($userId, 'disapproval', !$this->isAdminMail($approvalType), $this->conf['register.']);

			// Ausgabe vorbereiten.
			$submode = 'deleted';
		}

		return $this->showMessageOutputRedirect($mode, $submode, $params);
	}

	/**
	 * Gibt alle im Backend definierten Felder (TypoScipt/Flexform) formatiert und der Anzeigeart entsprechend aus.
	 *
	 * @param	array		$valueCheck
	 * @return	string		$content
	 */
	function showForm($valueCheck = array()) {
		$arrCurrentData = array();

		// Beim editieren der Userdaten, die Felder vorausfuellen.
		if ($this->conf['showtype'] == 'edit' && $this->userId) {
			$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'fe_users', 'uid = ' . $this->userId , '', '', '1');
            $row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);

			$arrCurrentData = $row;
		}

		// Wenn das Formular schon einmal abgesendet wurde aber ein Fehler auftrat, dann die bereits vom User uebertragenen Userdaten vorausfuellen.
		if ($this->piVars[$this->contentId]) {
			foreach ($this->piVars[$this->contentId] as $key => $val) {
				if (is_array($this->piVars[$this->contentId][$key])) {
					foreach ($this->piVars[$this->contentId][$key] as $subKey => $subVal) {
						$this->piVars[$this->contentId][$key][$subKey] = strip_tags($subVal);
					}
				} else {
					$this->piVars[$this->contentId][$key] = strip_tags($val);
				}
			}

			$arrCurrentData = array_merge((array)$row, (array)$this->piVars[$this->contentId]);
		}

		// Konvertiert alle moeglichen Zeichen der Ausgabe, die stoeren koennten (XSS).
		if ($arrCurrentData) {
			foreach ($arrCurrentData as $key => $val) {
				if (is_array($arrCurrentData[$key])) {
					foreach ($arrCurrentData[$key] as $subKey => $subVal) {
						$arrCurrentData[$key][$subKey] = strip_tags($subVal);
					}
				} else {
					$arrCurrentData[$key] = htmlspecialchars($val);
				}
			}
		}

		// Seite, die den Request entgegennimmt (TypoLink).
		$requestLink = $this->pi_getPageLink($this->conf['requestpid']);

		// Wenn keine Seite per TypoScript angegeben ist, wird die aktuelle Seite verwendet.
		if (!$this->conf['requestpid']) {
			$requestLink = $this->pi_getPageLink($GLOBALS['TSFE']->id);
		}

		// ID Zaehler fuer Items und Fieldsets.
		$iItem = 1;
		$iFieldset = 1;
		$iInfoItem = 1;

		// Formular start.
		$content = '<div>' . $this->pi_getLL('edit_default') . '</div>';
		$content .= '<form id="' . $this->extKey . '_' . $this->contentId . '_form" name="' . $this->prefixId . '[' . $this->contentId . ']" action="' . $requestLink . '" method="post" enctype="multipart/form-data"><fieldset class="form_fieldset_' . $iFieldset . '">';

		// Wenn eine Lgende fuer das erste Fieldset definiert wurde, diese ausgeben.
		if ($this->conf['legends.'][$iFieldset]) {
			$content .= '<legend class="form_legend_' . $iFieldset . '">' . $this->conf['legends.'][$iFieldset] . '</legend>';
		}

		// Alle ausgewaehlten Felder durchgehen.
		foreach ($this->arrUsedFields as $fieldName) {
			// Standardkonfigurationen laden.
			if (!$arrCurrentData[$fieldName] && $this->feUsersTca['columns'][$fieldName]['config']['default']) {
				$arrCurrentData[$fieldName] = $this->feUsersTca['columns'][$fieldName]['config']['default'];
			}

			// Wenn das im Flexform ausgewaehlte Feld existiert, dann dieses Feld ausgeben, alle anderen Felder werden ignoriert.
			if ($this->feUsersTca['columns'][$fieldName]) {
				// Form Item Anfang.
				$content .= '<div id="' . $this->extKey . '_' . $this->contentId . '_' . $fieldName . '_wrapper" class="form_item form_item_' . $iItem . ' form_type_' . $this->feUsersTca['columns'][$fieldName]['config']['type'] . '">';

				// Label schreiben.
				$content .= '<label for="' . $this->extKey . '_' . $this->contentId . '_' . $fieldName . '">' . $this->getLabel($fieldName) . '</label>';

				switch ($this->feUsersTca['columns'][$fieldName]['config']['type']) {

					case 'input':
						$content .= $this->showInput($fieldName, $arrCurrentData, $iItem);
						break;

					case 'text':
						$content .= $this->showText($fieldName, $arrCurrentData);
						break;

					case 'check':
						$content .= $this->showCheck($fieldName, $arrCurrentData);
						break;

					case 'radio':
						$content .= $this->showRadio($fieldName, $arrCurrentData);
						break;

					case 'select':
						$content .= $this->showSelect($fieldName, $arrCurrentData);
						break;

					case 'group':
						$content .= $this->showGroup($fieldName, $arrCurrentData);
						break;

				}

				// Extra Error Label ermitteln.
				$content .= $this->getErrorLabel($fieldName, $valueCheck);

				// Form Item Ende.
				$content .= '</div>';

				$iItem++;
			}

			// Separator anzeigen.
			if ($fieldName == '--separator--') {
				$iFieldset++;

				$content .= '</fieldset><fieldset class="form_fieldset_' . $iFieldset . '">';

				// Wenn eine Lgende fuer das Fieldset definiert wurde, diese ausgeben.
				if ($this->conf['legends.'][$iFieldset]) {
					$content .= '<legend class="form_legend_' . $iFieldset . '">' . $this->conf['legends.'][$iFieldset] . '</legend>';
				}
			}

			// Infoitem anzeigen.
			if ($fieldName == '--infoitem--') {
				if ($this->conf['infoitems.'][$iInfoItem]) {
					$content .= '<div class="form_infoitem_' . $iInfoItem . '">' . $this->conf['infoitems.'][$iInfoItem] . '</div>';
				}

				$iInfoItem++;
			}

			// Profil loeschen Link anzeigen.
			if ($fieldName == '--userdelete--' && $this->conf['showtype'] == 'edit' && $this->userId) {
				$fieldName = $this->cleanSpecialFieldKey($fieldName);

				$content .= '<div id="' . $this->extKey . '_' . $this->contentId . '_' . $fieldName . '_wrapper" class="form_item form_item_' . $iItem . ' form_type_' . $fieldName . '">';
				$content .= '<label for="' . $this->extKey . '_' . $this->contentId . '_' . $fieldName . '">' . $this->getLabel($fieldName) . '</label>';
				$content .= '<input type="checkbox" id="' . $this->extKey . '_' . $this->contentId . '_' . $fieldName . '" name="' . $this->prefixId . '[' . $this->contentId . '][' . $fieldName . ']" value="1" />';
				$content .= $this->getErrorLabel($fieldName, $valueCheck);
				$content .= '</div>';

				$iItem++;
			}

			// Passwortbestaetigung anzeigen.
			if ($fieldName == '--passwordconfirmation--' && $this->conf['showtype'] == 'edit' && $this->userId) {
				$fieldName = $this->cleanSpecialFieldKey($fieldName);

				$content .= '<div id="' . $this->extKey . '_' . $this->contentId . '_' . $fieldName . '_wrapper" class="form_item form_item_' . $iItem . ' form_type_' . $fieldName . '">';
				$content .= '<label for="' . $this->extKey . '_' . $this->contentId . '_' . $fieldName . '">' . $this->getLabel($fieldName) . '</label>';
				$content .= '<input type="password" id="' . $this->extKey . '_' . $this->contentId . '_' . $fieldName . '" name="' . $this->prefixId . '[' . $this->contentId . '][' . $fieldName . ']" value="" />';
				$content .= $this->getErrorLabel($fieldName, $valueCheck);
				$content .= '</div>';

				$iItem++;
			}

			// Aktivierung erneut senden anzeigen.
			if ($fieldName == '--resendactivation--') {
				$fieldName = $this->cleanSpecialFieldKey($fieldName);

				// Noch nicht fertig gestellte Listenansicht der nicht aktivierten User.
				//if ($this->conf['shownotactivated'] == 'list') {
				//	$arrNotActivated = $this->getNotActivatedUserArray();
				//	$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid, username', 'fe_users', 'pid = ' . intval($this->storagePid) . ' AND uid IN(' . implode(',', $arrNotActivated) . ') AND disable = 1 AND deleted = 0');

				//	while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
				//		$content .= '<div id="' . $this->extKey . '_' . $this->contentId . '_' . $fieldName . '_wrapper" class="form_item form_item_' . $iItem . ' form_type_' . $fieldName . ' ' . $this->conf['shownotactivated'] . '">';
				//		$content .= '<label for="' . $this->extKey . '_' . $this->contentId . '_' . $fieldName . '">' . $this->getLabel($fieldName) . ' ' . $row['username'] . '</label>';
				//		$content .= '<input type="checkbox" id="' . $this->extKey . '_' . $this->contentId . '_' . $fieldName . '" name="' . $this->prefixId . '[' . $this->contentId . '][' . $fieldName . '][' . $row['uid'] . ']" value="1" />';
				//		$content .= '</div>';

				//		$iItem++;
				//	}
				//} else {
					$content .= '<div id="' . $this->extKey . '_' . $this->contentId . '_' . $fieldName . '_wrapper" class="form_item form_item_' . $iItem . ' form_type_' . $fieldName . '">';
					$content .= '<label for="' . $this->extKey . '_' . $this->contentId . '_' . $fieldName . '">' . $this->getLabel($fieldName) . '</label>';
					$content .= '<input type="text" id="' . $this->extKey . '_' . $this->contentId . '_' . $fieldName . '" name="' . $this->prefixId . '[' . $this->contentId . '][' . $fieldName . ']" value="" />';
					$content .= $this->getErrorLabel($fieldName, $valueCheck);
					$content .= '</div>';

					$iItem++;
				//}
			}

			// Submit Button anzeigen.
			if ($fieldName == '--submit--') {
				$fieldName = $this->cleanSpecialFieldKey($fieldName);

				$content .= '<div id="' . $this->extKey . '_' . $this->contentId . '_' . $fieldName . '_wrapper" class="form_item form_item_' . $iItem . ' form_type_' . $fieldName . '">';
				$content .= '<input id="' . $this->extKey . '_' . $this->contentId . '_' . $fieldName . '" type="submit" value="' . $this->getLabel($fieldName . '_' . $this->conf['showtype']) . '"/>';
				$content .= '</div>';

				$iItem++;
			}
		}

		// UserId, PageId und Modus anhaengen.
		$content .= '<input type="hidden" name="' . $this->prefixId . '[' . $this->contentId . '][submit]" value="send" />';
		$content .= '<input type="hidden" name="' . $this->prefixId . '[' . $this->contentId . '][userid]" value="' . $this->userId . '" />';
		$content .= '<input type="hidden" name="' . $this->prefixId . '[' . $this->contentId . '][pageid]" value="' . $GLOBALS['TSFE']->id . '" />';
		$content .= '<input type="hidden" name="' . $this->prefixId . '[' . $this->contentId . '][submitmode]" value="' . $this->conf['showtype'] . '" />';
		$content .= $this->makeHiddenFields();

		$content .= '</fieldset>';
		$content .= '</form>';

		return $content;
	}
	
}

?>