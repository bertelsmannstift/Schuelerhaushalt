<?php
/***************************************************************
 *  Copyright notice
 * 
 *  (c) 2011 Philipp Hanebrink <philipp.hanebrink@itao.de>
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
class user_loginHandling{

	var $cObj;// The backReference to the mother cObj object set at call time
	
		
	function checkForcedPasswordChange($content,$conf) {
		global $_SERVER;
		//$backUid = $this->cObj->cObjGetSingle($conf['backUid'],$conf['backUid.']);
		$passwordChangePageUid = $this->cObj->cObjGetSingle($conf['passwordChangePageUid'],$conf['passwordChangePageUid.']);
		
		//redirect to password change site if force password change is set
		$forcePasswordChange = intval($GLOBALS['TSFE']->fe_user->user['tx_itaozfalogin_changepassword']);
		if($forcePasswordChange) {
			$url = tslib_pibase::pi_getPageLink($passwordChangePageUid);
			header('Location: /'.$url);
			exit;
		} else {
			# redirect after "normale" login:
			if ($_POST['submit']!="" && $_POST['user']!="" && $_POST['pass']!="") { # && $GLOBALS['TSFE']->fe_user->user['uid']
				if ($GLOBALS['TSFE']->fe_user->user['uid']) {
					$neue_pageid =  $GLOBALS['TSFE']->id;
					$usergroup = $GLOBALS['TSFE']->fe_user->user['usergroup'];
					if ($usergroup!="") {
						$select = '*';
						$from = 'fe_groups';
						$where = 'uid in ('.$usergroup.')';
						echo "<br />where ".$where."<br />";
						$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where);
						if ($res) {
						  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
						  	if (intval($row['felogin_redirectPid']) > 0) {
						    	$redirectid = $row['felogin_redirectPid'];
						    	$neue_pageid = $row['felogin_redirectPid'];
						    }
						  }
						}
						
						if ($usergroup == "1") { # dann ists ein Kommunenverwalter und muss auf die Startseite der Kommune weitergeleitet werden
							$communeid = $GLOBALS['TSFE']->fe_user->user['tx_itaoshhmanager_ssh_ref_commune'];
							$select = '*';
							$from = 'tx_itaoshhmanager_communes';
							$where = 'uid ='.$communeid;
							$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where);
							if ($res) {
							  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
							  	if (intval($row['ref_communepage']) > 0) {
							    	$redirectid = $row['ref_communepage'];
							    	$neue_pageid = ($row['ref_communepage']+2);
							    }
							  }
							}
						}
						
					}
					$url = tslib_pibase::pi_getPageLink($neue_pageid);

					header('Location: /'.$url);	
				} else {
					# hier muss abgefangen werden, wenn sich jemand FALSCH einloggt; dann wird nämlich eine ganz normaler form-übermittlung durchgeführt, sodass die felogin feststellen kann, dass falsch eingeloggt wurde und eine dementsprechende fehlermeldung raushaut.
					/*while (list ($key, $val) = each ($GLOBALS['TSFE']->fe_user->user)) {
					   echo "$key => $val<br>";
					}
					echo "<br />";
					while (list ($key, $val) = each ($_POST)) {
					   echo "$key => $val<br>";
					}
					reset($_POST);
					echo "<br />felogin:";
					while (list ($key, $val) = each ($_POST['tx_felogin_pi1'])) {
					   echo "$key => $val<br>";
					}
					#break;			
					*/
				}			
			}
		}
		
		
		return;
	}

}
?>