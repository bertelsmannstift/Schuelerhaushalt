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

			// Der User hat seine Daten editiert.
			if ($this->conf['showtype'] == 'edit') {

				// itao GmbH & Co KG - Philipp Hanebrink - BEGIN
				//If password was changed, remove the force password change marker in the user entry
				if($arrUpdate['password'])
				{
					$arrUpdate['tx_itaozfalogin_changepassword'] = 0;
				}		
				// itao GmbH & Co KG - Philipp Hanebrink - END
			
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
					$submode = implode('_', array_shift($arrApprovalTypes));
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
	
}

?>