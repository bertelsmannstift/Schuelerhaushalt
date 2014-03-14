<?php

/**
  * Lib for Database
  */

$LANG->includeLLFile('EXT:itao_shh_manager/mod1/locallang.xml');
require_once(PATH_t3lib . 'class.t3lib_scbase.php');


#require_once(t3lib_extMgm::extPath('itao_shh_manager') . '/lib/pdf_generator.php');


/**
 * Database-Library for the 'itao_shh_manager' extension.
 * Function for Database Queries
 *
 * @author	Edeltraud Gratzer <edeltraud.gratzer@itao.de>
 * @package	TYPO3
 * @subpackage	tx_itaosshmanager
 */
class  tx_itaoshhmanager_database extends  t3lib_SCbase {		
	
	
	############################################## SELECTS ##########################################################	
	
	function getAllCommunes() {								
		$select = '*';
		$from = 'tx_itaoshhmanager_communes';
		$where = 'hidden=0 and deleted=0';	
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $communes[$row['uid']] = $row;
		  }
		}
		return $communes;
	}
	function getCommunesById($communeid) {								
		$select = '*';
		$from = 'tx_itaoshhmanager_communes';
		$where = 'hidden=0 and deleted=0';	
		$where.=' and uid='.$communeid;
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $commune = $row;
		  }
		}
		return $commune;
	}
	
	
	function getAllSchoolsByCommune($communeid) {					
		$select = '*';
		$from = 'tx_itaoshhmanager_schools';
		$where = 'hidden=0 and deleted=0';	
		$where.=' and ref_commune='.$communeid;
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $schools[$row['uid']] = $row;
		  }
		}
		return $schools;
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
	
	
	function getSchoolById($schoolid) {					
		$select = '*';
		$from = 'tx_itaoshhmanager_schools';
		$where = 'hidden=0 and deleted=0';	
		$where.=' and uid='.$schoolid;
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $school = $row;
		  }
		}
		return $school;
	}
	
	function getAllPhasen() {								
		$select = '*';
		$from = 'tx_itaoshhmanager_status_school';
		$where = 'hidden=0 and deleted=0';	
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $phasen[$row['uid']] = $row;
		  }
		}
		return $phasen;
	}
	
	
	
	function getAllPhasen_sorted() {								
		$select = '*';
		$from = 'tx_itaoshhmanager_status_school';
		$where = 'hidden=0 and deleted=0';	
		$orderBy = 'ordernr asc';
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy,$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $phasen[$row['ordernr']] = $row;
		  }
		}
		return $phasen;
	}
	
	
	function getUserData($userid){								
		$select = '*';
		$from = 'fe_users';
		$where = 'uid='.$userid;	
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $user = $row;
		  }
		}
		return $user;
	}		
	
	function getLikesDislikesPerOffer($offerid) {									
		$select = 'tx_itaoshhoffers_domain_model_likedislike.*';
		$from = 'tx_itaoshhoffers_offer_likedislike_mm, tx_itaoshhoffers_domain_model_likedislike';
		$where = 'tx_itaoshhoffers_offer_likedislike_mm.uid_local='.$offerid;	
		$where.=' and tx_itaoshhoffers_domain_model_likedislike.uid = tx_itaoshhoffers_offer_likedislike_mm.uid_foreign';
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $dis_likes[$row['status']][] = $row;
		  }
		}
		return $dis_likes;
	}
	
	
	
	function getAllUsergroups(){								
		$select = '*';
		$from = 'fe_groups';
		$where = 'hidden=0 and deleted=0';	
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $groups[$row['uid']] = $row;
		  }
		}
		return $groups;
	}	
	
	
	function getAllBEUsergroups(){								
		$select = '*';
		$from = 'be_groups';
		$where = 'hidden=0 and deleted=0';	
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $groups[$row['uid']] = $row;
		  }
		}
		return $groups;
	}	
	
	function doUserAct($deactuserid,$actuserid) {
		if ($deactuserid > 0) {
			$userid = $deactuserid;
			$fields_values_upd = array('disable' => 1);
		} else {
			$userid = $actuserid;
			$fields_values_upd = array('disable' => 0);
		}
		$table = 'fe_users';
		$where = 'uid='.$userid;
		#$fields_values_upd = array('disable' => 0);
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values_upd);
	}
	
	function doPasswordBack($userid) {
		global $LANG, $BE_USER;
		$select = '*';
		$from = 'fe_users';
		$where = 'uid='.$userid;
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='uid asc',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		  	$userdata = $row;
		  }
		}
		$origpw = $userdata['password_orig'];
		
		$table = 'fe_users';
		$where = 'uid='.$userid;
		$fields_values_upd = array('password' => tx_itaoshhmanager_library::my_hashPassword($origpw), 'tx_itaozfalogin_changepassword' => 1);
		$x = $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values_upd);
		if ($x) {
			tx_itaoshhmanager_general::generateFlashMessage($LANG->getLL('pw_erfolgreich_h'), $LANG->getLL('pw_erfolgreich_tx'),1);
		} else {
			tx_itaoshhmanager_general::generateFlashMessage($LANG->getLL('pw_noterfolgreich_h'), $LANG->getLL('pw_noterfolgreich_tx'),0);
		}
		#
		
		# noch logging für PW zurücksetzen!
		$table = 'tx_itaoshhmanager_pwlogging';
		$fields_valuespw = array(
			'pid' => $this->tsvars['pid_feusers'],
			'tstamp' => time(),
			'crdate' => time(),
			'cruser_id' => $BE_USER->user['uid'],
			'ref_beuser' => $BE_USER->user['uid'],
			'ref_feuser' => $userid,
			
			);						
		$GLOBALS['TYPO3_DB']->exec_INSERTquery($table,$fields_valuespw);
	}
	
	function getAllPwLoggingsByUser($feuser) {
		$select = '*';
		$from = 'tx_itaoshhmanager_pwlogging';
		$where = 'ref_feuser='.$feuser;
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where);
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {	
		  	$changed[$row['tstamp']] = $row;
		  }
		}
		return $changed;
	}
	
	function getAllUsersBySchool($schoolid, $groupid, $registered=0,$sort_nach=1, $sort_dir="",$with_disabled=0) {	
		$communeid = $this->piVars['communeid'];		
		$sc_in = 0;
		$gr_in = 0;		
		$select = '*';
		$from = 'fe_users';
		$where = 'deleted=0 ';#disable=0 and 
		if (!$with_disabled) {
			$where .= ' and disable=0 ';
		}	
		if ($registered) {
			#$where.=' and tx_itaoshhmanager_shh_classname!=""';
			$where.=' and last_name!=""';#tx_itaozfalogin_changepassword = 0 ';
			
		}	
		
		# fuer Suche:
		############ Volltextsuche:
		#$search_value =$this->piVars['search_value']; 
		$search_value = $GLOBALS["BE_USER"]->getSessionData("search_valueuser");
		#if ($this->piVars['search_value'] && !$for_sidebox) {
		if ($search_value /*&& !$for_sidebox*/ && $this->piVars['smnr']==8) {
			#fe_users.
			$where_search = 'username LIKE "%'.$search_value.'%"';
			$where_search .= ' OR first_name LIKE "%'.$search_value.'%"';
			$where_search .= ' OR last_name LIKE "%'.$search_value.'%"';
			$where_search .= ' OR tx_itaoshhmanager_shh_classname LIKE "%'.$search_value.'%" ';			
			$where.=' AND ('.$where_search.')';
		}
		
		$search_value_state = $GLOBALS["BE_USER"]->getSessionData("filter_state");
		$search_value_group = $GLOBALS["BE_USER"]->getSessionData("filter_usergroups");
		if ($search_value_state > 0 && $this->piVars['smnr']==8) {
			if ($search_value_state == 1) {
				$where.=' and disable = 0';
			} else {
				$where.=' and disable = 1';
			}
		}
		if ($search_value_group > 0 && $this->piVars['smnr']==8) {
				$where_search_group = 'usergroup like "'.$search_value_group.',%" ';
				$where_search_group .= ' OR usergroup like "%,'.$search_value_group.'" ';
				$where_search_group .= ' OR usergroup like "%,'.$search_value_group.',%" ';
			$where.=' AND ('.$where_search_group.')';
		}
		
		#t3lib_utility_debug::debug( "<br>select $select from $from where $where");
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='uid asc',$orderBy='last_name',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {	
		  	$sc_in = 0;
		  	$commune_in = 0;
				$gr_in = 0;		  	
		  	# nach groupid pruefen
		  	if ($row['usergroup']!="") {
		  		$row_groupsarr = explode(",", $row['usergroup']);
		  		#t3lib_utility_debug::debug($row_groupsarr);
		  		if (is_array($row_groupsarr)) {
		  			if (in_array($groupid,$row_groupsarr)) { 
		  				$gr_in = 1;
		  			}
		  		}
		  	}
		  	# nach schule pruefen
		  	if ($groupid!= $this->tsvars['groupid_verw_kommune'] && $groupid!= $this->tsvars['groupid_mod_kommune'] ) {
			  	if ($row['tx_itaoshhmanager_ssh_ref_school']!="") {
			  		$row_schoolarr = explode(",", $row['tx_itaoshhmanager_ssh_ref_school']);
			  		if (is_array($row_schoolarr)) {
			  			if (in_array($schoolid,$row_schoolarr)) {
			  				$sc_in = 1;
			  			}
			  		}
			  	} 
			  } else {	
			  	if ($row['tx_itaoshhmanager_ssh_ref_commune']!="") { # dann nach Kommune
			  		$row_schoolarr = explode(",", $row['tx_itaoshhmanager_ssh_ref_commune']);
			  		if (is_array($row_schoolarr)) {
			  			if (in_array($communeid,$row_schoolarr)) {
			  				$sc_in = 1;
			  			}
			  		}
			  	}
		  		
		  	}
		    
		    if ($sc_in && $gr_in) {
		    	$user[$row['uid']] = $row;
		    }
		    
		    if ($groupid == 0 && $sc_in) {
		    	$user[$row['uid']] = $row;		    	
		    }
		    
		  }
		}
		
		#t3lib_utility_debug::debug($user);
		return $user;
	}
	
	
	
	
	function getAllBeUsersBySchool($communeid, $schoolid, $groupid, $byCommune=0) {		
		#t3lib_utility_debug::debug("comm:".$communeid."//sc:".$schoolid."//group:".$groupid."byComm:".$byCommune);	
		$sc_in = 0;
		$gr_in = 0;		
		$select = '*';
		$from = 'be_users';
		$where = 'disable=0 and deleted=0';	
		$orderBy = 'uid asc';
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,'',$orderBy,'');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {	
		  	$sc_in = 0;
				$gr_in = 0;		  	
		  	# nach groupid pruefen
		  	if ($row['usergroup']!="") {
		  		$row_groupsarr = explode(",", $row['usergroup']);
		  		if (is_array($row_groupsarr)) {
		  			if (in_array($groupid,$row_groupsarr)) { 
		  				$gr_in = 1;
		  			}
		  		}
		  	}
		  	#t3lib_utility_debug::debug("grin:".$gr_in);
		  	if ($byCommune) {
			  	# nach Kommune pruefen
			  	if ($row['ref_commune']!="") {
			  		$row_commarr = explode(",", $row['ref_commune']);
			  		if (is_array($row_commarr)) {
			  			if (in_array($communeid,$row_commarr)) {
			  				$sc_in = 1;
			  			}
			  		}
			  	}
		  	} else {		  	
			  	# nach schule pruefen
			  	if ($row['ref_school']!="") {
			  		$row_schoolarr = explode(",", $row['ref_school']);
			  		if (is_array($row_schoolarr)) {
			  			if (in_array($schoolid,$row_schoolarr)) {
			  				$sc_in = 1;
			  			}
			  		}
			  	}	
			  }	  
		  	#t3lib_utility_debug::debug("sc_in:".$sc_in);  
		    if ($sc_in && $gr_in) {
		    	$user[$row['uid']] = $row;
		    }
		    
		  }
		}
		#t3lib_utility_debug::debug($user);
		return $user;
	}
	
	
	function getAnzAccountBySchool($schoolid, $registered=0,$for_sidebox = 0) {	
		$communeid = $this->piVars['communeid'];		
		$sc_in = 0;
		$gr_in = 0;		
		$select = '*';
		$from = 'fe_users';
		$where = '';		
		$anz=$insges=0;
		if ($registered) {
			$where.=' tx_itaozfalogin_changepassword=0';
		}	
		#t3lib_utility_debug::debug($where);
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {	
		  	# nach schule pruefen
		  	if ($row['tx_itaoshhmanager_ssh_ref_school']!="" && $row['tx_itaoshhmanager_ssh_ref_school']!=0) {
		  		$tmp.='//hat ref_school'.$row['tx_itaoshhmanager_ssh_ref_school'];
		  		$row_schoolarr = explode(",", $row['tx_itaoshhmanager_ssh_ref_school']);
		  		if (is_array($row_schoolarr)) {
		  			if (in_array($schoolid,$row_schoolarr)) {
		  				#$sc_in = 1;
		  				$user[$row['uid']] = $row;
		  				$insges++;
		  			}
		  		}
		  	} else {
		  		# nach Kommune pruefen
			  	if ($row['tx_itaoshhmanager_ssh_ref_commune']!=""&& $row['tx_itaoshhmanager_ssh_ref_commune']!=0) {
		  		$tmp.='//hat ref_commune'.$row['tx_itaoshhmanager_ssh_ref_commune'];
			  		$row_schoolarr = explode(",", $row['tx_itaoshhmanager_ssh_ref_commune']);
			  		
			  		if (is_array($row_schoolarr)) {
			  			if (in_array($communeid,$row_schoolarr)) {
			  				#$sc_in = 1;
			  				$user[$row['uid']] = $row;
		  				$insges++;
			  			}
			  		}
			  	}
			  }
		    /*
		    if ($sc_in && $gr_in) {
		    	$user[$row['uid']] = $row;
		    }
		    */
		  }
		}
		#t3lib_utility_debug::debug($tmp);
		$anz = count($user);		
		if ($for_sidebox) {
			$anz = $insges;
		}
		return $anz;
	}
	
	
	
	function getAnzBeAccountBySchool($communeid,$schoolid,$is_school,$groupid) {			
		$sc_in = 0;
		$gr_in = 0;		
		$select = '*';
		$from = 'be_users';
		$where = 'disable = 0 and deleted=0 and admin!=1';
		# and usergroup='.$groupid;
		$user = array();
		#t3lib_utility_debug::debug("$communeid,$schoolid,$is_school,$groupid");
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {	
		  	
		  	# nach schule pruefen
		  	if ($is_school) {
			  	if ($row['ref_school']!="") {
			  		$row_schoolarr = explode(",", $row['ref_school']);
			  		if (is_array($row_schoolarr)) {
			  			if (in_array($schoolid,$row_schoolarr)) {
			  				#$sc_in = 1;
							  	if ($row['usergroup']!="") {
							  		$row_groupsarr = explode(",", $row['usergroup']);
							  		#t3lib_utility_debug::debug($row_groupsarr);
							  		if (is_array($row_groupsarr)) {
							  			if (in_array($groupid,$row_groupsarr)) { 
							  				$user[$row['uid']] = $row;
							  			}
							  		}
							  	}
			  				#$user[$row['uid']] = $row;
			  			}
			  		}
			  	}
		  	} else {	
		  		#t3lib_utility_debug::debug("is commune");	  		
			  	# nach Kommune pruefen
			  	if ($row['ref_commune']!="") {			  		
			  		# groupid noch abragen!!!!
		  		#t3lib_utility_debug::debug("ref_commune=".$row['ref_commune']);
			  		$row_commarr = explode(",", $row['ref_commune']);
			  		if (is_array($row_commarr)) {
			  			#t3lib_utility_debug::debug($row_commarr);
			  			#t3lib_utility_debug::debug("communeid:".$communeid);
			  			if (in_array($communeid,$row_commarr)) {
			  				
							  	if ($row['usergroup']!="") {
							  		$row_groupsarr = explode(",", $row['usergroup']);
							  		#t3lib_utility_debug::debug($row_groupsarr);
							  		if (is_array($row_groupsarr)) {
							  			if (in_array($groupid,$row_groupsarr)) { 
							  				$user[$row['uid']] = $row;
							  			}
							  		}
							  	}
			  				
			  				
			  				
			  			}
			  		}
			  	}
		  	}
		  	
		  	
		  }
		}
		
		#t3lib_utility_debug::debug($user);
		$anz = count($user);		
		return $anz;
	}
	
	
	
	
	function generateAccounts($groupid, $anz_accounts, $schoolid,$schooldata) {	
		global $BE_USER, $LANG;
		$communeid = $this->piVars['communeid'];
		if ($groupid == $this->tsvars['groupid_verw_kommune'] || $groupid == $this->tsvars['groupid_mod_kommune']) {
			$schoolid=0;
		}
		################## 1. die User in der DB anlegen ###############################
		$schoolgroupid = $schooldata['ref_fegroup'];
		if ($groupid != $this->tsvars['groupid_verw_kommune'] && $groupid != $this->tsvars['groupid_mod_kommune']) {
			$usergroupids = $groupid.','.$schoolgroupid;	
		} else {
			$usergroupids = $groupid;
		}
		$schoolprefix = tx_itaoshhmanager_library::generateSchoolprefix($schooldata,$groupid);
		
		#$kundenid, $akt_nr, $username_prefix, $kundendata
		$table = 'fe_users';	
		$anz_vorher = tx_itaoshhmanager_database::getAnzAccountBySchool($schoolid);			
		#t3lib_utility_debug::debug($anz_vorher);		
		for ($x=1; $x<=$anz_accounts; $x++) {
			$username = tx_itaoshhmanager_library::generateUsername($schoolprefix,($anz_vorher+$x));#$username_prefix."_".$akt_nr; 
			$password = tx_itaoshhmanager_library::generatePassword();			
			$table = 'fe_users';
			
			$fields_values = array(
						'pid' => $this->tsvars['pid_feusers'],
						'tstamp' => time(),
						'crdate' => time(),
						'cruser_id' => $BE_USER->user['uid'],
						'username' => $username,
						'password' => $password,
						'password_orig' => $password,
						'usergroup' => $usergroupids,
						'disable' => 0,
						'tx_itaoshhmanager_ssh_ref_school' => $schoolid,
						'tx_itaoshhmanager_ssh_ref_commune' => $communeid
						);		
			#t3lib_utility_debug::debug($fields_values);
			$GLOBALS['TYPO3_DB']->exec_INSERTquery($table,$fields_values);
			$newuid = mysql_insert_id();
			if ($newuid > 0) {
				$generated++;				
			}
		
		}
		
		################## 2. PDF generieren ###############################
		$pdf_generated = tx_itaoshhmanager_pdfgenerator::generateUserPDF($groupid, $schoolid,$schooldata);
		
		# und dann auch noch PDF generieren!!
		$ok = ($generated > 0) ? 1:0 ;
		return $ok;
	}
	
	
	function getErgebnisseiteSchule($schoolid) {
		$select = '*';
		$from = 'tx_itaoshhmanager_schools';
		$where = 'uid='.$schoolid;
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $resultpage = $row['resultpage'];
		  }
		}
		return $resultpage;
	}
	
	function getErgebnisseitenKommune($communeid) {
		$select = '*';
		$from = 'tx_itaoshhmanager_schools';
		$where = 'ref_commune='.$communeid;
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $resultpages[] = $row['resultpage'];
		  }
		}
		if (is_array($resultpages)) {
			$resultpage = implode(",", $resultpages);
		}
		return $resultpage;
	}
	
	function generateBEAccounts($groupid, $anz_accounts, $schoolid,$schooldata,$communeid,$communedata) {	
		global $BE_USER, $LANG;
		$by_commune[$this->tsvars['be_groupid_redadmin_kommune']] = 1;
		$by_commune[$this->tsvars['be_groupid_mod_kommune']] = 1;
		$by_commune[$this->tsvars['be_groupid_redadmin_schule']] = 0;
		$by_commune[$this->tsvars['be_groupid_mod_schule']] = 0;
		################## 1. die User in der DB anlegen ###############################
		#$schoolgroupid = $schooldata['ref_fegroup'];
		$is_school = ($by_commune[$groupid]) ? 0: 1;
		#t3lib_utility_debug::debug("is_school:".$is_school);
		#t3lib_utility_debug::debug($communedata);
		$usergroupids = $groupid;	
		$daprefix = ($is_school) ? tx_itaoshhmanager_library::generateBeUserPrefix($is_school,$schooldata, $communedata) : tx_itaoshhmanager_library::generateBeUserPrefix($is_school,array(),$communedata);
		#$schoolprefix = tx_itaoshhmanager_library::generateSchoolprefix($schooldata);
		$by_commune[$this->tsvars['be_groupid_redadmin_kommune']] = 1;
		$by_commune[$this->tsvars['be_groupid_mod_kommune']] = 1;
		$by_commune[$this->tsvars['be_groupid_redadmin_schule']] = 0;
		$by_commune[$this->tsvars['be_groupid_mod_schule']] = 0;
		if ($by_commune[$groupid]) {
			$mountpointid = ($communedata['ref_communepage']+1);
		} else {
			$mountpointid = ($schooldata['ref_schoolpage']+10); # neu!!! + 10, weils ja nicht die Verweisseite, sondern die zu bearbeitende seite sein soll
		}
		
		# hier berücksichtigen, dass die db_mountpoints für die Ergebnisseiten gesetzt werden müssen:
		/*if ($groupid == $this->tsvars['be_groupid_redadmin_kommune']) {			
			$respage_commune = tx_itaoshhmanager_database::getErgebnisseitenKommune($communeid);
			if ($respage_commune!="") {
				$mountpointid.=','.$respage_commune;
			}
		}
		*/
		/*
		if ($groupid == $this->tsvars['be_groupid_redadmin_schule']) {
			$respage_school = tx_itaoshhmanager_database::getErgebnisseiteSchule($schoolid);
			$mountpointid.=','.$respage_school;
		}
		*/
		
		#$reArrN = array( ($copied + 9), ($copied + 7),($copied + 6), ($copied + 8), ($copied + 11)  ); #Neue V., Meine V., Fotos, V. anschauen, Ergebnisse
		if ($groupid == $this->tsvars['be_groupid_redadmin_schule']) {
			$copied = $schooldata['ref_schoolpage'];
			#$respage_school = tx_itaoshhmanager_database::getErgebnisseiteSchule($schoolid);
			#####$reArrN = array( ($copied + 9), ($copied + 7),($copied + 6), ($copied + 8)  ); #, ($copied + 11)
			###$reArrN = array( ($copied + 7), ($copied + 5),($copied + 4), ($copied + 6)  ); #, ($copied + 11)
			#######$reArrN = array( ($copied + 8), ($copied + 6),($copied + 4), ($copied + 7)  ); #, ($copied + 11)
###			$reArrN = array( ($copied + 9),($copied + 7), ($copied + 6),($copied + 5), ($copied + 3), ($copied + 2)  ); # sollte sein: Schule-Inhaltsseite, Neue V., ansehen, meine, Ergebnisse, Fotos
			
			# neu am 04.02.2013: lt. Tickets 3262 + 3161 NUR hauptseite bearbeitbar für RAS;
			$reArrN = array( ($copied + 3) ); # sollte sein: Schule-Inhaltsseite
			
			$respage_school = implode(",", $reArrN);
			$mountpointid.=','.$respage_school;
		}
		
		#$kundenid, $akt_nr, $username_prefix, $kundendata
		$table = 'be_users';	
		$anz_vorher = tx_itaoshhmanager_database::getAnzBeAccountBySchool($communeid,$schoolid,$is_school,$groupid);			
		#t3lib_utility_debug::debug($anz_vorher);		
		for ($x=1; $x<=$anz_accounts; $x++) {
			$username = tx_itaoshhmanager_library::generateBEUsername($daprefix,($anz_vorher+$x), $groupid);#$username_prefix."_".$akt_nr; 
			$password = tx_itaoshhmanager_library::generatePassword();			
			$table = 'be_users';
			$fields_values = array(
						'tstamp' => time(),
						'crdate' => time(),
						'cruser_id' => $BE_USER->user['uid'],
						'username' => $username,
						'password' => tx_itaoshhmanager_library::my_hashPassword($password),
						'password_orig' => $password,
						'usergroup' => $groupid,
						'db_mountpoints' => $mountpointid,
						'disable' => 0,
						'options' => 3,
						'lang' => 'de',
						'TSconfig' => 'setup.default.copyLevels = 100'						
						);	
			if (!$by_commune[$groupid]) {
				$fields_values['ref_school'] = $schoolid;
			}	else {
				$fields_values['ref_commune'] = $communeid;
			}
			if ($groupid == $this->tsvars['be_groupid_redadmin_kommune']) {
				#$fields_values['db_mountpoints'] .= ','.$this->tsvars['school_model_pageid'];
			}
			#t3lib_utility_debug::debug($fields_values);
			$GLOBALS['TYPO3_DB']->exec_INSERTquery($table,$fields_values);
			$newuid = mysql_insert_id();
			if ($newuid > 0) {
				$generated++;				
			}
		
		}
		
		################## 2. PDF generieren ###############################
		$pdf_generated = tx_itaoshhmanager_pdfgenerator::generateBEUserPDF($groupid, $schoolid,$schooldata,$communeid,$communedata );
		
		# und dann auch noch PDF generieren!!
		$ok = ($generated > 0) ? 1:0 ;
		return $ok;
	}
	
	
	
	/* Diese Funktion sieht nach, ob es Schulen gibt, die noch keine Usergruppe haben;
			wenn ja, wird für diese Schule eine Usergruppe generiert; und gleichzeitig die redirect-Seite dafür angelegt		
	 */
	function checkSchoolsForUsergroups() {
		$select = '*';
		$from = 'tx_itaoshhmanager_schools';
		$where = 'is_new=1';
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $schulenOhneGruppe[$row['uid']] = $row;
		  }
		}
		#ref_schoolpage; felogin_redirectPid
		if (is_array($schulenOhneGruppe)) {			
			while (list ($key, $val) = each ($schulenOhneGruppe)) {
				$table = 'fe_groups';
				$fields_values = array(
							'pid' => $this->tsvars['pid_feusers'],
							'tstamp' => time(),
							'crdate' => time(),
							'cruser_id' => $BE_USER->user['uid'],
							'title' => $val['title'],
							'subgroup' => $this->tsvars['groupid_school'],
							'tx_itaoshhmanager_ssh_ref_school' => $key,
							'felogin_redirectPid' => $val['ref_schoolpage']
							);		
				$GLOBALS['TYPO3_DB']->exec_INSERTquery($table,$fields_values);
				$newgroupid = mysql_insert_id(); 
				if ($newgroupid > 0) {
					# und dann noch das is_new auf 0 setzen
					# und die fe-group in schools eintragen
					# und auch noch die pid auf die ref_schoolpage setzen, damit der schulredakteur dann die rechte drauf hat
					$table = 'tx_itaoshhmanager_schools';
					$where = 'uid='.$key;
					$fields_values_upd = array('is_new' => 0, 'ref_fegroup' => $newgroupid, 'pid' => $val['ref_schoolpage']);
					$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values_upd);
				}
				
				# und hier der Aufruf, dass der Seitenstrang kopiert und angepasst wird:
				tx_itaoshhmanager_database::doPageCopy_newStructure($val,$newgroupid);
			}
		}
		
		
	}
	
	
	function getLastSortingPageCommune($commpageuid) {		
		$select = '*';
		$from = 'pages';
		$where = 'pid='.$commpageuid;
		$where.=' and deleted=0 and hidden=0';
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='','sorting asc',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $lastpage = $row;
		  }
		}
		
		return $lastpage['uid'];	
	}
	
	
	function doPageCopy_newStructure($schooldata,$usergroupid) {
		global $LANG, $BE_USER, $_SERVER;
		if ($BE_USER->user['admin']) {
			$warvorheradmin = 1;
		} else {
			$warvorheradmin = 0;
			$BE_USER->user['admin'] = 1;
		}
		$communeid = $schooldata['ref_commune'];
		$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);
		$vorlageNode = t3lib_tree_pagetree_Commands::getNode($this->tsvars['school_model_pageid_newstructure']);
		# wohin?

		$newCommPageUid = $communedata['ref_communepage'];
		
		$lastPageSorting = tx_itaoshhmanager_database::getLastSortingPageCommune($newCommPageUid);
		$afterPageUid = ($lastPageSorting) ? ($lastPageSorting*-1): $newCommPageUid ;
		
		$copied = t3lib_tree_pagetree_Commands::copyNode($vorlageNode,$afterPageUid); #($this->tsvars['school_model_pageid']*-1));
		
		# was muss jetzt alles geändert werden:		
		
		#hier noch sorting einfügen:
		
		# 1. Seitenname der Hauptseite				
		$table = 'pages';				
		$where = 'uid = '.$copied;	
		$fields_values = array('title' => $schooldata['title'], 'nav_hide' => 0);
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);		
		
		$table = 'pages';				
		#$where = 'uid = '.($copied+9);	
		$where = 'uid = '.($copied+10);
		$fields_values = array('title' => $schooldata['title']);
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		
		
		# 2. TS der Hauptseite; braucht die pageId der Zwischenseite # Update funzt nicht, weil der Redakteur nicht das Recht hat, TS zu bearbeiten.	
		$zwischenseite_uid = tx_itaoshhmanager_database::getZwischenseite($copied);		
		$table = 'sys_template';			
		$setup_code = "[loginUser = *]
lib.mainnav {
special = directory
special.value = ".$copied."
}
[global]
";
		$fields_values = array('pid' => $copied, 'deleted' => 0, 'tstamp' => time(),'crdate' => time(), 'title' => 'Navigation anpassen', 'cruser_id' => $BE_USER->user['uid'],
														'config' => $setup_code);
		$GLOBALS['TYPO3_DB']->exec_INSERTquery($table,$fields_values);
		
		/*
		# 3. neu generierte Usergroup setzen auf der Zwischenseite		
		$table = 'pages';				
		$where = 'uid = '.$zwischenseite_uid;	
		$fields_values = array('fe_group' => $usergroupid);
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		*/
		
		# 4. Hauptseite der Schule im schul-ds eintragen
		$table = 'tx_itaoshhmanager_schools';				
		$where = 'uid = '.$schooldata['uid'];			
		$fields_values = array('pid' => $this->tsvars['pid_offers'], 'ref_schoolpage' => $copied,  'ref_sortedoffers' => ($copied+7), 'ref_myoffers' => ($copied+6), 'ref_createoffer' => ($copied+8), 'resultpage' => ($copied+3)); #'ref_mp_schoolstartpage' => ($copied+10),
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		
		
		
		# 5. Seitenberechtigungen für Redakteure? prüfen und ggf. setzen		
		$table = 'pages';				
		$where = 'uid = '.$copied;	
		$where.=' or pid='.$copied;
		#$where.=' or pid='.$zwischenseite_uid;
		$fields_values = array('perms_userid' => 0, 'perms_groupid' => $this->tsvars['be_groupid_techadmin'], 'perms_user' => 31, 'perms_group' => 31, 'perms_everybody' => 0 );
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		# extra ändern für schul-hauptseite:
		$table = 'pages';				
		$where = 'uid = '.($copied+10);	
		$fields_values = array('perms_userid' => 0, 'perms_groupid' => 7, 'perms_user' => 31, 'perms_group' => 31, 'perms_everybody' => 0 );
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		
		# ändern für Unterseiten lt. Koop 16.11.2012:
		$table = 'pages';				
		$reArrN = array( ($copied + 8), ($copied + 6),($copied + 2), ($copied + 7), ($copied + 3) ); #Neue V., Meine V., Fotos, V. anschauen, Ergebnisse
		$where = 'uid in ('.implode(",", $reArrN).')';	
		$fields_values = array('perms_userid' => 0, 'perms_groupid' => 7, 'perms_user' => 31, 'perms_group' => 31, 'perms_everybody' => 0 );
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		
		
		# 6. die redirect-page in der fe_group noch setzen; oben kann sie nämlich noch nicht gesetzt werden.		
		$table = 'fe_groups';				
		$where = 'uid = '.$usergroupid;	
		$fields_values = array('felogin_redirectPid' => ($copied+10));
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		
		# 7. und auch pid von Schul-Datensatz hat oben nicht geklappt, geht erst jetzt:		
		$table = 'tx_itaoshhmanager_schools';
		$where = 'uid='.$schooldata['uid'];
		$fields_values = array('pid' => $this->tsvars['pid_offers']);
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);

		
		# 9.Plugin auf Seite "Vorschläge der Schule" - richtige Schule einsetzen:
		$select = '*';
		$from = 'tt_content';
		$where = 'pid='.($copied + 9);
		$where.=' and list_type like "itaoshhoffers_offers"';
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($rowx = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $thecontent = $rowx['pi_flexform'];
		    $contentuidvorschl = $rowx['uid'];
		  }
		}
		$thenewcontent = str_replace('<value index="vDEF">37</value>', '<value index="vDEF">'.$schooldata['uid'].'</value>', $thecontent);
		$table = 'tt_content';				
		$where = 'uid = '.$contentuidvorschl;	
		$fields_values = array('pi_flexform' => $thenewcontent );
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		
		# 10. Navtitle für Mountpoint:
		/*$table = 'pages';				
		$where = 'uid = '.($copied+10);	
		$fields_values = array('nav_title' => $schooldata['title']);
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		*/
		
		# 11. Weblink - URL Anpassen:
		$table = 'tx_jpweblinks_list';					
		$where = 'pid = '.($copied+1);
		$urlweblink = "http://".$_SERVER['HTTP_HOST']."/index.php?id=".($copied+9);
		$fields_values = array('url' => $urlweblink);
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);

		
		# 13. Link auf der Seite Ergebnisse 'finden Sie "hier" ' auf richtige Ergebnisseite einstellen:
		$select = '*';
		$from = 'tt_content';
		$where = 'pid='.($copied+10); # jetzt die erste Unterseite
		$where.=' and hidden=1';
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($rowx = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		  	$content_new = str_replace("link 743", "link ".($copied+3), $rowx['bodytext']); # neue Ergebnisseite - im nicht eingeloggten Bereich
		    $table = 'tt_content';				
				$where = 'uid = '.$rowx['uid'];	
				$fields_values = array('bodytext' => $content_new);
				$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		  }
		}
		
		# 14. NEU: Std-Anzahl von angezeigten Ergebnissen setzen:	
		$table = 'tx_itaoshhmanager_resultanz';			
		$fields_values = array('pid' => $this->tsvars['pid_offers'], 'tstamp' => time(),'crdate' => time(), 
														'ref_schoolid' => $schooldata['uid']);
		$GLOBALS['TYPO3_DB']->exec_INSERTquery($table,$fields_values);
		
		# 15. Seitenberechtigungen fuer Seite "Uebersicht" => die soll nicht mehr im FE und BE sichtbar sein	
		$table = 'pages';				
		$where = 'uid = '.($copied+5);	
		$fields_values = array('perms_group' => 26 ); #'perms_userid' => 0, 'perms_groupid' => $this->tsvars['be_groupid_techadmin'], 'perms_user' => 31, , 'perms_everybody' => 0
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		
		
		
		if (!$warvorheradmin) {
			$BE_USER->user['admin'] = 0;
		}
			
	}
				
	
	
	
	
	
	
	
	
	
	
	
	function doPageCopy($schooldata,$usergroupid) {
		global $LANG, $BE_USER, $_SERVER;
		if ($BE_USER->user['admin']) {
			$warvorheradmin = 1;
		} else {
			$warvorheradmin = 0;
			$BE_USER->user['admin'] = 1;
		}
		$communeid = $schooldata['ref_commune'];
		$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);
		$vorlageNode = t3lib_tree_pagetree_Commands::getNode($this->tsvars['school_model_pageid']);
		# wohin?
		/*if (!$BE_USER->user['admin']) {
			$seitenrechte = $BE_USER->user['db_mountpoints'];
			$sr_arr = explode(",",$seitenrechte); 
			#t3lib_utility_debug::debug($sr_arr );
			$newCommPageUid = $sr_arr[0];
		} else {
			$newCommPageUid = $this->tsvars['pid_kommunen'];
		}*/
		$newCommPageUid = $communedata['ref_communepage'];
		$copied = t3lib_tree_pagetree_Commands::copyNode($vorlageNode,$newCommPageUid); #($this->tsvars['school_model_pageid']*-1));
		
		# was muss jetzt alles geändert werden:		
		
		# 1. Seitenname der Hauptseite				
		$table = 'pages';				
		$where = 'uid = '.$copied;	
		$fields_values = array('title' => $schooldata['title'], 'nav_hide' => 0);
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		
		
		# 2. TS der Hauptseite; braucht die pageId der Zwischenseite # Update funzt nicht, weil der Redakteur nicht das Recht hat, TS zu bearbeiten.	
		$zwischenseite_uid = tx_itaoshhmanager_database::getZwischenseite($copied);		
		$table = 'sys_template';				
		#$where = 'pid = '.$copied;
		$setup_code = "[loginUser = *]
lib.mainnav {
special = directory
special.value = ".$zwischenseite_uid."
}
[global]
";
		$fields_values = array('pid' => $zwischenseite_uid, 'deleted' => 0, 'tstamp' => time(),'crdate' => time(), 'title' => 'Navigation anpassen', 'cruser_id' => $BE_USER->user['uid'],
														'config' => $setup_code);
		#$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		$GLOBALS['TYPO3_DB']->exec_INSERTquery($table,$fields_values);
		
		
		# 3. neu generierte Usergroup setzen auf der Zwischenseite		
		$table = 'pages';				
		$where = 'uid = '.$zwischenseite_uid;	
		$fields_values = array('fe_group' => $usergroupid);
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		
		# 4. Hauptseite der Schule im schul-ds eintragen
		$table = 'tx_itaoshhmanager_schools';				
		$where = 'uid = '.$schooldata['uid'];	
		#####$fields_values = array('pid' => $this->tsvars['pid_offers'], 'ref_schoolpage' => $copied, 'ref_mp_schoolstartpage' => ($copied+10), 'ref_sortedoffers' => ($copied+8), 'ref_myoffers' => ($copied+7), 'ref_createoffer' => ($copied+9), 'resultpage' => ($copied+11));
		###$fields_values = array('pid' => $this->tsvars['pid_offers'], 'ref_schoolpage' => $copied, 'ref_mp_schoolstartpage' => ($copied+8), 'ref_sortedoffers' => ($copied+6), 'ref_myoffers' => ($copied+5), 'ref_createoffer' => ($copied+7), 'resultpage' => ($copied+9));
		
		#######$fields_values = array('pid' => $this->tsvars['pid_offers'], 'ref_schoolpage' => $copied, 'ref_mp_schoolstartpage' => ($copied+9), 'ref_sortedoffers' => ($copied+7), 'ref_myoffers' => ($copied+6), 'ref_createoffer' => ($copied+8), 'resultpage' => ($copied+10));
		
		#####$fields_values = array('pid' => $this->tsvars['pid_offers'], 'ref_schoolpage' => $copied, 'ref_mp_schoolstartpage' => ($copied+10), 'ref_sortedoffers' => ($copied+7), 'ref_myoffers' => ($copied+6), 'ref_createoffer' => ($copied+8), 'resultpage' => ($copied+11));
		
		$fields_values = array('pid' => $this->tsvars['pid_offers'], 'ref_schoolpage' => $copied, 'ref_mp_schoolstartpage' => ($copied+10), 'ref_sortedoffers' => ($copied+8), 'ref_myoffers' => ($copied+7), 'ref_createoffer' => ($copied+9), 'resultpage' => ($copied+11));
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		
		
		
		# 5. Seitenberechtigungen für Redakteure? prüfen und ggf. setzen		
		$table = 'pages';				
		$where = 'uid = '.$copied;	
#		$where.=' and uid!='.($copied+5); # damit Seite "Uebersicht" NCIHT geaendert wird
		$where.=' or pid='.$copied;
		$where.=' or pid='.$zwischenseite_uid;
		$fields_values = array('perms_userid' => 0, 'perms_groupid' => $this->tsvars['be_groupid_techadmin'], 'perms_user' => 31, 'perms_group' => 31, 'perms_everybody' => 0 );
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		# extra ändern für schul-hauptseite:
		$table = 'pages';				
		$where = 'uid = '.$copied;	
		#$fields_values = array('perms_userid' => 0, 'perms_groupid' => $this->tsvars['be_groupid_techadmin'], 'perms_user' => 31, 'perms_group' => 31, 'perms_everybody' => 19 );
		$fields_values = array('perms_userid' => 0, 'perms_groupid' => 7, 'perms_user' => 31, 'perms_group' => 31, 'perms_everybody' => 0 );
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		
		# 14. Seitenberechtigungen fuer Seite "Uebersicht" => die soll nicht mehr im FE und BE sichtbar sein	
		$table = 'pages';				
		$where = 'uid = '.($copied+5);	
		$fields_values = array('perms_group' => 26 ); #'perms_userid' => 0, 'perms_groupid' => $this->tsvars['be_groupid_techadmin'], 'perms_user' => 31, , 'perms_everybody' => 0
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		#echo "ERROR:".mysql_errno() . ": " . mysql_error() ;
		
		# ändern für Unterseiten lt. Koop 16.11.2012:
		$table = 'pages';				
		#####$reArrN = array( ($copied + 9), ($copied + 7),($copied + 6), ($copied + 8), ($copied + 11)  ); #Neue V., Meine V., Fotos, V. anschauen, Ergebnisse
		###$reArrN = array( ($copied + 7), ($copied + 5),($copied + 4), ($copied + 6), ($copied + 9)  ); #Neue V., Meine V., Fotos, V. anschauen, Ergebnisse
		#######$reArrN = array( ($copied + 8), ($copied + 6),($copied + 4), ($copied + 7), ($copied + 10), ($copied + 5)  ); #Neue V., Meine V., Fotos, V. anschauen, Ergebnisse
		#####$reArrN = array( ($copied + 8), ($copied + 6),($copied + 4), ($copied + 7), ($copied + 11), ($copied + 5)  ); #Neue V., Meine V., Fotos, V. anschauen, Ergebnisse
		$reArrN = array( ($copied + 9), ($copied + 7),($copied + 4), ($copied + 8), ($copied + 11), ($copied + 6)  ); #Neue V., Meine V., Fotos, V. anschauen, Ergebnisse
		$where = 'uid in ('.implode(",", $reArrN).')';	
		#$fields_values = array('perms_userid' => 0, 'perms_groupid' => $this->tsvars['be_groupid_techadmin'], 'perms_user' => 31, 'perms_group' => 31, 'perms_everybody' => 19 );
		$fields_values = array('perms_userid' => 0, 'perms_groupid' => 7, 'perms_user' => 31, 'perms_group' => 31, 'perms_everybody' => 0 );
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		
		
		# 6. die redirect-page in der fe_group noch setzen; oben kann sie nämlich noch nicht gesetzt werden.		
		$table = 'fe_groups';				
		$where = 'uid = '.$usergroupid;	
		####$fields_values = array('felogin_redirectPid' => ($copied+10));
		###$fields_values = array('felogin_redirectPid' => ($copied+8));
		#######$fields_values = array('felogin_redirectPid' => ($copied+9));
		$fields_values = array('felogin_redirectPid' => ($copied+10));
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		
		# 7. und auch pid von Schul-Datensatz hat oben nicht geklappt, geht erst jetzt:		
		$table = 'tx_itaoshhmanager_schools';
		$where = 'uid='.$schooldata['uid'];
		$fields_values = array('pid' => $this->tsvars['pid_offers']);
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		
		/*# 8. Zwischenseite mit richtiger FE-Group ausstatten: 
		$table = 'pages';				
		$where = 'uid = '.$copied;	
		$fields_values = array('fe_group' => $usergroupid );
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		*/
		
		#6. Seite an richtige Stelle verschieben
		
		# 9.Plugin auf Seite "Vorschläge der Schule" - richtige Schule einsetzen:
		$select = '*';
		$from = 'tt_content';
		####$where = 'pid='.($copied + 12);
		###$where = 'pid='.($copied + 10);
		#######$where = 'pid='.($copied + 11);
		$where = 'pid='.($copied + 13);
		$where.=' and list_type like "itaoshhoffers_offers"';
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($rowx = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $thecontent = $rowx['pi_flexform'];
		    $contentuidvorschl = $rowx['uid'];
		  }
		}
		$thenewcontent = str_replace('<value index="vDEF">37</value>', '<value index="vDEF">'.$schooldata['uid'].'</value>', $thecontent);
		$table = 'tt_content';				
		$where = 'uid = '.$contentuidvorschl;	
		$fields_values = array('pi_flexform' => $thenewcontent );
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		
		# 10. Navtitle für Mountpoint:
		$table = 'pages';				
		###$where = 'uid = '.($copied+10);	
		###$where = 'uid = '.($copied+8);	
		#######$where = 'uid = '.($copied+9);	
		$where = 'uid = '.($copied+10);	
		$fields_values = array('nav_title' => $schooldata['title']);
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		
		# 11. Weblink - URL Anpassen:
		$table = 'tx_jpweblinks_list';				
		###$where = 'pid = '.($copied+3);				
		$where = 'pid = '.($copied+2);
		####$urlweblink = "http://".$_SERVER['HTTP_HOST']."/index.php?id=".($copied+12);
		###$urlweblink = "http://".$_SERVER['HTTP_HOST']."/index.php?id=".($copied+10);
		#######$urlweblink = "http://".$_SERVER['HTTP_HOST']."/index.php?id=".($copied+11);
		$urlweblink = "http://".$_SERVER['HTTP_HOST']."/index.php?id=".($copied+13);
		$fields_values = array('url' => $urlweblink);
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		
		# 12. Plugin Ansprechpartner auf Schul-startseite - pages anpassen:
		/*$select = '*';
		$from = 'tt_content';
		$where = 'pid='.$copied;
		$where.=' and list_type like "jp_staff_pi1"';
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($rowx = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $thecontent = $rowx['pi_flexform'];
		    $contentuidvorschl = $rowx['uid'];
		  }
		}
		$thenewcontent = str_replace('<value index="vDEF">390</value>', '<value index="vDEF">'.($copied+4).'</value>', $thecontent);
		$table = 'tt_content';				
		$where = 'uid = '.$contentuidvorschl;	
		$fields_values = array('pi_flexform' => $thenewcontent );
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		*/
		
		# 12. Ergebnisseiten: hier muss einiges gemacht werden, damit RedAdmKommune und RedAdminSchule + Techn.Admin die Seiten bearbeiten dürfen:
		# a. Titel ändern in "Ergebnis [Schule]", Nav-Titel ändern in "Ergebnisse"
		# b. Seiterechte ändern in 31/31/19
		# 16.11.2012: Hr. Koop will nun DOCH nicht, dass RedAdmKommune die Ergebnisseite pflegen kann!
		/*$table = 'pages';				
		$where = 'uid = '.($copied+11);	
		$fields_values = array('title' => "Ergebnisse", 'nav_title' => "Ergebnisse", 
														'perms_userid' => 0, 'perms_groupid' => $this->tsvars['be_groupid_techadmin'], 'perms_user' => 31, 'perms_group' => 31, 'perms_everybody' => 19);
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		*/
		
		# c. Seitenfreigabe zu allen Red.AdminKommune hinzufügen
		/*$select = '*';
		$from = 'be_users';
		$where = 'usergroup like "'.$this->tsvars['be_groupid_redadmin_kommune'].'"';
		$where.=' and ref_commune like "'.$communeid.'"';
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($rowx = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		  	$dbmountsvorher = $rowx['db_mountpoints'];
		    $table = 'be_users';				
				$where = 'uid = '.$rowx['uid'];	
				$fields_values = array('db_mountpoints' => $dbmountsvorher.",".($copied+11));
				$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		  }
		}
		*/
		
		# 13. Link auf der Seite Ergebnisse 'finden Sie "hier" ' auf richtige Ergebnisseite einstellen:
		$select = '*';
		$from = 'tt_content';
		$where = 'pid='.$copied;
		$where.=' and hidden=1';
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($rowx = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		  	####$content_new = str_replace("link 743", "link ".($copied+11), $rowx['bodytext']);
		  	###$content_new = str_replace("link 743", "link ".($copied+9), $rowx['bodytext']);
		  	#######$content_new = str_replace("link 743", "link ".($copied+10), $rowx['bodytext']);
		  	$content_new = str_replace("link 743", "link ".($copied+12), $rowx['bodytext']); # neue Ergebnisseite - im nicht eingeloggten Bereich
		    $table = 'tt_content';				
				$where = 'uid = '.$rowx['uid'];	
				$fields_values = array('bodytext' => $content_new);
				$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		  }
		}
		
#		t3lib_utility_debug::debug("update ".$table. "//where".$where);
#		t3lib_utility_debug::debug($fields_values);
		
		
		
		#t3lib_utility_debug::debug($copied);		
		if (!$warvorheradmin) {
			$BE_USER->user['admin'] = 0;
		}
			
	}
				
	
	
	
	
	
	
	function getAllOffersBySchool($schoolid, $byState=0,$sort_nach = 1, $sort_dir="asc",$for_sidebox=0, $wo_abgewiesen = 0,$nur_parent=0,$wo_own=0) {
		
		$sortArr[1] = 'title';						
		$sortArr[2] = 'fe_user'; ####submitted by					
		$sortArr[3] = 'crdate';						
		$sortArr[4] = 'status';				
		$sortArr[9] = 'classidea';					
		$sortArr[5] = 'comments';						
		$sortArr[6] = 'costs_help';				
		$sortArr[7] = 'likes_dislikes';		###	LIKES - anzahl	#'crdate';#
		$sortArr[8] = 'likes_dislikes';	###dislikes - anzahl #'crdate';#	
		$sortArr[10] = 'internal_id';	
		$sortArr[11] = 'votes';		
		
		#t3lib_utility_debug::debug("sort_nach".$sort_nach."//sort_dir".$sort_dir."//blubb:".$blubb);
		
		$select = 'tx_itaoshhoffers_domain_model_offer.*, fe_users.tx_itaoshhmanager_ssh_ref_school as ref_school,fe_users.name,fe_users.first_name,fe_users.last_name,fe_users.username ';
		$from = 'tx_itaoshhoffers_domain_model_offer INNER JOIN fe_users
						 ON tx_itaoshhoffers_domain_model_offer.fe_user = fe_users.uid';
		$where = 'fe_users.tx_itaoshhmanager_ssh_ref_school = '.$schoolid;
		$where.=' and tx_itaoshhoffers_domain_model_offer.hidden=0 and tx_itaoshhoffers_domain_model_offer.deleted=0';
		if ($nur_parent) {
			$where.=' AND tx_itaoshhoffers_domain_model_offer.parent_offer=0';
		}
		
		############ Volltextsuche:
		#$search_value =$this->piVars['search_value']; 
		$search_value = $GLOBALS["BE_USER"]->getSessionData("search_value");
		#if ($this->piVars['search_value'] && !$for_sidebox) {
		if ($search_value && !$for_sidebox) {
			#fe_users.
			$where_search = 'tx_itaoshhoffers_domain_model_offer.title LIKE "%'.$search_value.'%"';
			$where_search .= ' OR tx_itaoshhoffers_domain_model_offer.description LIKE "%'.$search_value.'%"';
			$where_search .= ' OR tx_itaoshhoffers_domain_model_offer.costs LIKE "%'.$search_value.'%"';
			$where_search .= ' OR fe_users.first_name LIKE "%'.$search_value.'%" ';
			$where_search .= ' OR fe_users.last_name LIKE "%'.$search_value.'%" ';
			$where_search .= ' OR fe_users.username LIKE "%'.$search_value.'%" ';
			#$where_search .= ' or username LIKE "%'.$ses['search_pruefer_value'].'%" ';
			
			$where.=' AND ('.$where_search.')';
		}
		
		if ($wo_abgewiesen) {
			$where.=' and status = 2 ';
		}
		if ($wo_own) {
			$where.=' and tx_itaoshhoffers_domain_model_offer.uid!='.$wo_own;
		}
		
		############ SORTIERUNG
		$orderBy = "tx_itaoshhoffers_domain_model_offer.".$sortArr[$sort_nach]." ".$sort_dir;
		$orderBy .= ', tx_itaoshhoffers_domain_model_offer.crdate desc';
		
		if ($sort_nach == 2 || $sort_nach== 9) { # dann nach fe_user
			$orderBy = 'fe_users.last_name '." ".$sort_dir;
			$orderBy .= ', fe_users.first_name '." ".$sort_dir;
			$orderBy .= ', fe_users.username '." ".$sort_dir;
		}
	
		#t3lib_utility_debug::debug("select ".$select." from ".$from.' where '. $where.' order by '.$orderBy);
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy,$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		  	if ($byState) {
		    	$offers[$row['status']][$row['uid']] = $row;
		  	} else {
		    	$offers[$row['uid']] = $row;
		    }
		  }
		}
		if (is_array($offers)) {
			reset($offers);
		}
		if ($sort_nach== 7 || $sort_nach == 8) { # wenn likes oder dislikes, dann muss hier neu sortiert werden
			$offers = tx_itaoshhmanager_database::orderOffers($offers,$sort_nach,$sort_dir);
		}
		if ($sort_nach== 9) { # classidea, dann muss hier neu sortiert werden
			$offers = tx_itaoshhmanager_database::orderOffers_byClassidea($offers,$sort_nach,$sort_dir);
		}
		
		
		
		return $offers;
	}
	
	
	function orderOffers_byClassidea($offers,$sort_nach,$sort_dir) {
		global $BE_USER;
		while (list ($key, $val) = each ($offers)) {
			$allIdeas = tx_itaoshhmanager_database::getIdeaByOffer($val['uid'],1,$sort_dir);
			$xyz = 0;
			$klasse = "";
			while (list ($keyid, $valid) = each ($allIdeas)) {
				$klasse = ($xyz==0) ? trim(strtolower(strval($valid['class']))) : '';
				$xyz++;
				
				$offerOfClass[$val['uid']] = $klasse;
				$newsortarr[$klasse][$val['uid']] = $val;				
			}
		}
		if ($sort_dir == "asc") {
			asort($offerOfClass); # sortiert nach values
			ksort($newsortarr);
			#natcasesort($offerOfClass);
		} else {
			arsort($offerOfClass); # sortiert nach values
			krsort($newsortarr);
		}
		reset($offers);
###		if ($BE_USER->user['admin']) {
			#t3lib_utility_debug::debug($offerOfClass);
			#t3lib_utility_debug::debug($offers);	
			/*while (list ($key, $val) = each ($newsortarr)) {
			}		
			reset($newsortarr);
			*/
			$offers_old2 = $offers;
			unset($offers);
			while (list ($keyid2, $valid2) = each ($newsortarr)) {
				#$offers[$keyid] = $offers_old[$keyid];
				while (list ($keyid3, $valid3) = each ($valid2)) {
					$offers[$keyid3] = $offers_old2[$keyid3];
					$blubb[$keyid2][$valid3['uid']] = $valid3;
					$blubb2[$keyid2][] = $valid3['title'];
				}
			}
			#t3lib_utility_debug::debug($offers);	
			/*if ($BE_USER->user['admin']) {
				if ($sort_dir == "asc") {
					ksort($blubb);
					ksort($blubb2);
				} else {
					krsort($blubb);
					krsort($blubb2);
				}
				$offers_old3 = $offers;
				unset($offers);
				while (list ($keyid2, $valid2) = each ($blubb)) {
					#$offers[$keyid] = $offers_old[$keyid];
					while (list ($keyid3, $valid3) = each ($valid2)) {
						$offers[$keyid3] = $offers_old2[$keyid3];
						#$blubb[$keyid2][$valid3['uid']] = $valid3;
					}
				}
				t3lib_utility_debug::debug($blubb2);	
				
			}
			*/
###		} else {
###			$offers_old = $offers;
###			unset($offers);
###			while (list ($keyid, $valid) = each ($offerOfClass)) {
###				$offers[$keyid] = $offers_old[$keyid];
###			}
###		}
		#t3lib_utility_debug::debug($offers);
		return $offers;
	}
	
	function orderOffers($offers,$sort_nach,$sort_dir) {
		if ($sort_nach== 7 || $sort_nach == 8) { # dann order nach likes / dislikes			
			while (list ($key, $val) = each ($offers)) {
				$dis_likes_ergebnisse = tx_itaoshhmanager_database::getLikesDislikesPerOffer($val['uid']);				
				$all_dis_likes[1][$val['uid']] = (is_array($dis_likes_ergebnisse[1])) ? count($dis_likes_ergebnisse[1]) : 0 ;			
				$all_dis_likes[2][$val['uid']] = (is_array($dis_likes_ergebnisse[2])) ? count($dis_likes_ergebnisse[2]) : 0 ;
				#$allLikes 	= (is_array($all_dis_likes)) ? count($all_dis_likes[1]) : 0 ;
				#$allDislikes  	= (is_array($all_dis_likes)) ? count($all_dis_likes[2]) : 0 ;
			}
			reset($all_dis_likes);
			#t3lib_utility_debug::debug($all_dis_likes);
			krsort($all_dis_likes[1]);
			krsort($all_dis_likes[2]);
			reset($offers);
			reset($all_dis_likes);
			#t3lib_utility_debug::debug($all_dis_likes);
			if ($sort_dir == "asc") {
				asort($all_dis_likes[1]);
				asort($all_dis_likes[2]);
			} else {
				arsort($all_dis_likes[1]);
				arsort($all_dis_likes[2]);
			}
			
			# für likes:
			$l_nl = ($sort_nach== 7) ? 1: 2;
			$tmp_likes = $all_dis_likes[$l_nl];
			# das wird jetzt gemacht, dass auch die Einträge, die OHNE like/dislike-Einträge sind, nach crdate sortiert werden.
			while (list ($key, $val) = each ($tmp_likes)) {
				if ($val > 0) {
					$likes_with[$key] = $val;
				} else {
					$likes_without[$key] = $val; 
				}				
			}
			krsort($likes_without);
			reset($likes_without);
			reset($likes_with);
			
			unset($all_dis_likes);
			if ($sort_dir == 'asc') {
				$all_dis_likes[$l_nl] = $likes_without;
				while (list ($key, $val) = each ($likes_with)) {
					$all_dis_likes[$l_nl][$key] = $val;
				}				
			} else {
				$all_dis_likes[$l_nl] = $likes_with;
				while (list ($key, $val) = each ($likes_without)) {
					$all_dis_likes[$l_nl][$key] = $val;
				}
			}			
			
			
						
			if ($sort_nach== 7) {
				while (list ($key, $val) = each ($all_dis_likes[1])) {
					$offers_sorted[$key] = $offers[$key];
				}
			} else {
				while (list ($key, $val) = each ($all_dis_likes[2])) {
					$offers_sorted[$key] = $offers[$key];
				}
			}			
		}
		$offers = $offers_sorted;
		return $offers;
	}
	
	
	
	
	function getAllStatiOffer() {						
		$select = '*';
		$from = 'tx_itaoshhoffers_domain_model_status';
		$where = 'hidden=0 and deleted=0';	
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $status[$row['uid']] = $row;
		  }
		}
		return $status;
	}		
	
	
	function getOfferById($offerid){								
		$select = 'tx_itaoshhoffers_domain_model_offer.*, fe_users.tx_itaoshhmanager_ssh_ref_school as ref_school,fe_users.name,fe_users.first_name,fe_users.last_name,fe_users.username';
		$from = 'tx_itaoshhoffers_domain_model_offer  INNER JOIN fe_users
						 ON tx_itaoshhoffers_domain_model_offer.fe_user = fe_users.uid';
		$where = 'tx_itaoshhoffers_domain_model_offer.uid='.$offerid;	
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $offer = $row;
		  }
		}
		return $offer;
	}	
	
	function getIdeaByOffer($offerid,$forsorting=0,$sortdir = '') {				
		$select = '*';
		$from = 'tx_itaoshhoffers_domain_model_idea';
		$where = 'offer='.$offerid;	
		if ($forsorting) {
			$where.=' and class!="" ';
			$limit = '1';
		}
		$orderBy='class '.$sortdir;
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,'',$orderBy,$limit);
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $ideas[$row['uid']] = $row;
		  }
		}
		return $ideas;
	}
	
	function getCommentsByOffer($offerid) {				
		$select = '*';
		$from = 'tx_itaoshhoffers_domain_model_comment';
		$where = 'offer='.$offerid;	
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $comments[$row['uid']] = $row;
		  }
		}
		return $comments;
	}
	
	#$what = 2 => activieren
	# $what = 3 => abweisen
	function updateOffer($offerid,$what) {
		global $BE_USER, $LANG;		
		# 1. update offer
		$table = 'tx_itaoshhoffers_domain_model_offer';
		$where = 'uid='.$offerid;
		$fields_values_upd = array('status' => $what);
		$upd_ok = $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values_upd);
		# 2. log-eintrag speichern
		
		$description = $LANG->getLL('offer_func_'.$what);
		$table = 'tx_itaoshhoffers_domain_model_offerlog';
		$fields_values = array(
					'pid' => $this->tsvars['pid_offers'],
					'date' => time(),
					'tstamp' => time(),
					'crdate' => time(),
					'cruser_id' => $BE_USER->user['uid'],
					'action' => $what,
					'offer' => $offerid,
					'description' => $description
					);		
		$ins_ok = $GLOBALS['TYPO3_DB']->exec_INSERTquery($table,$fields_values);
		
		# und dann noch flash-message:
			$erg = ($what == 2) ? $LANG->getLL('offact_freigegeben') : $LANG->getLL('offact_abgewiesen') ;
		if ($upd_ok) {
			tx_itaoshhmanager_general::generateFlashMessage($LANG->getLL('offact_header_1'), $LANG->getLL('offact_text_1').$erg,1);
		} else {
			tx_itaoshhmanager_general::generateFlashMessage($LANG->getLL('offact_header_0'), $LANG->getLL('offact_text_0a').$erg.$LANG->getLL('offact_text_0b'),0);
		}
	}
	
	
	function deleteOffer($offerid) {
		global $BE_USER, $LANG;		
		# 1. update offer
		$table = 'tx_itaoshhoffers_domain_model_offer';
		$where = 'uid='.$offerid;
		$fields_values_upd = array('deleted' => 1);
		$upd_ok = $GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values_upd);
		# 2. log-eintrag speichern
		
		$description = "loeschen";
		$table = 'tx_itaoshhoffers_domain_model_offerlog';
		$fields_values = array(
					'pid' => $this->tsvars['pid_offers'],
					'date' => time(),
					'tstamp' => time(),
					'crdate' => time(),
					'cruser_id' => $BE_USER->user['uid'],
					'action' => 4,
					'offer' => $offerid,
					'description' => $description
					);		
		$ins_ok = $GLOBALS['TYPO3_DB']->exec_INSERTquery($table,$fields_values);
		$redirect_link = $this->indexpath.'&communeid='.$this->piVars['communeid'].'&schoolid='.$this->piVars['schoolid'].'&smnr='.$this->piVars['smnr'].'&vorschlaege=1';
		header("Location: ".$redirect_link); 
		# und dann noch flash-message:
			$erg = "gel&ouml;scht" ;
			
			
		if ($upd_ok) {
			tx_itaoshhmanager_general::generateFlashMessage($LANG->getLL('offact_header_1'), $LANG->getLL('offact_text_1').$erg,1);
		} else {
			tx_itaoshhmanager_general::generateFlashMessage($LANG->getLL('offact_header_0'), $LANG->getLL('offact_text_0a').$erg.$LANG->getLL('offact_text_0b'),0);
		}
	}
	
	
	
	function getSupportsByOffer($offerid) {					
		$select = '*';
		$from = 'tx_itaoshhoffers_domain_model_promoter';
		$where = 'offer='.$offerid;	
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $promoter[$row['uid']] = $row;
		  }
		}
		return $promoter;
	}
	
	
	function getZwischenseite($pageuid) {						
		$select = '*';
		$from = 'pages';
		$where = 'pid='.$pageuid;	
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $zwischenseite_uid = $row['uid'];
		  }
		}
		return $zwischenseite_uid;
	}
	
	function checkNewCommunes() {
		global $LANG;
		$select = '*';
		$from = 'tx_itaoshhmanager_communes';
		$where = 'hidden=0 and deleted=0 and is_new=1';
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $tx_itaoshhmanager_communes[$row['uid']] = $row;
		    
		    
		    # Vorlageseite erstellen.
		    $vorlageNode = t3lib_tree_pagetree_Commands::getNode($this->tsvars['commune_model_pageid']);	
		    $newCommuneAfterThisPage = ($this->tsvars['newCommuneAfterThisPage']) ? ($this->tsvars['newCommuneAfterThisPage']) : -32;
		    	   
				$copied = t3lib_tree_pagetree_Commands::copyNode($vorlageNode,$newCommuneAfterThisPage);
				
		    /*# Vorlageseite für Vorschlags-Übersicht erstellen.
		    $vorlageNode2 = t3lib_tree_pagetree_Commands::getNode($this->tsvars['vorschlag_uebersicht_model_pageid']);		   
				$copied2 = t3lib_tree_pagetree_Commands::copyNode($vorlageNode2,1);
				*/
				/*# 0. neue Usergruppe anlegen:
				$table = 'fe_groups';
				$fields_values = array(
							'pid' => $this->tsvars['pid_feusers'],
							'tstamp' => time(),
							'crdate' => time(),
							'cruser_id' => $BE_USER->user['uid'],
							'title' => $row['titel'],
							'tx_itaoshhmanager_ssh_ref_commune' => $row['uid'],
							'felogin_redirectPid' => $copied
							);		
				$GLOBALS['TYPO3_DB']->exec_INSERTquery($table,$fields_values);
				*/
				# 1. Seitentitel ändern				
				$table = 'pages';				
				$where = 'uid = '.$copied;
				# für neue Struktur:
				$where .= ' OR uid = '.($copied+4);	
				$where .= ' OR uid = '.($copied+1);
				$fields_values = array('title' => $LANG->getLL('ll_startseite_komm').$row['titel'], 'nav_title' => $LANG->getLL('ll_startseite_komm_nav').$row['titel'], 'perms_userid' => 0, 'perms_groupid' => $this->tsvars['be_groupid_techadmin'], 'perms_user' => 31, 'perms_group' => 31, 'perms_everybody' => 19, 'nav_hide' => 0);
				$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
				
				# 1b - 2. Unterseite für Kommunenseite im Menü verbergen:
				$table = 'pages';				
				$where = 'uid = '.($copied+1);
				$fields_values = array('nav_hide' => 1);
				$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
				
				
				# 2. Commune-DS ändern
				$table = 'tx_itaoshhmanager_communes';				
				$where = 'uid = '.$row['uid'];	
				$fields_values = array('ref_communepage' => $copied,'is_new' => 0, 'pid' => $this->tsvars['pid_offers'] /*$copied*/);
				$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
				
				# 3. TS der Hauptseite; braucht die pageId der Zwischenseite # Update funzt nicht, weil der Redakteur nicht das Recht hat, TS zu bearbeiten.	
				$zwischenseite_uid = ($copied+2);		
				$table = 'sys_template';			
				$setup_code = "[usergroup=1]
lib.mainnav {
  special = directory
  special.value = ".$zwischenseite_uid."
}
[global]
";
				$fields_values = array('pid' => $zwischenseite_uid, 'deleted' => 0, 'tstamp' => time(),'crdate' => time(), 'title' => 'Navigation anpassen (Kommunenverwalter)', 'cruser_id' => $BE_USER->user['uid'],
																'config' => $setup_code);
				$GLOBALS['TYPO3_DB']->exec_INSERTquery($table,$fields_values);
				
		    
		  }
		}
	}
	
	
	function doCommentLogging($commentid, $offerid) {
		global $BE_USER;
		$table = 'tx_itaoshhoffers_domain_model_commentlog';
		$fields_values = array(
			'pid' => $this->tsvars['pid_offers'],
			'comment' => $commentid,
			'date' => time(),
			'tstamp' => time(),
			'crdate' => time(),
			'cruser_id' => $BE_USER->user['uid']
			);		
		$GLOBALS['TYPO3_DB']->exec_INSERTquery($table,$fields_values);
	}
	
	function getCommentLogsByComment($commentid) {
		$commlogs = array();
		$select = '*';
		$from = 'tx_itaoshhoffers_domain_model_commentlog';
		$where = 'comment='.$commentid;
		$where .= ' and deleted=0 and hidden=0 ';
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='crdate asc',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $commlogs[$row['uid']] = $row;
		  }
		}
		return $commlogs;
	}
	
	
	function getBeUserName($userid) {
		$select = '*';
		$from = 'be_users';
		$where = 'uid='.$userid;
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where);
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $beuser = $row;
		  }
		}
		
		$username = ($beuser['realName']!="") ? $beuser['realName'] : $beuser['username'];
		
		return $username;
	}
	
	function doCommentCreate($offerid) {		
		$select = '*';
		$from = 'tx_itaoshhoffers_domain_model_comment';
		$where = 'offer=0';
		$orderBy = 'crdate asc';
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,'',$orderBy,'');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $uid_comm = $row['uid'];
		    $theComm = $row;
		  }
		}
		# dadurch ist der letzte DS der richtige
		$table = 'tx_itaoshhoffers_domain_model_comment';						
		$fields_values = array(
			'offer' => $offerid,
			'fe_user' => 0
			);			
		$where = 'uid='.$uid_comm;			
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		
		
		return $uid_comm;
	}
	
	
	function switchPhase($neuePhase,$schoolid) {
		$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
		# Unterscheiden zwischen den Phasen:
		switch ($neuePhase) {
			#### Vorschlaege einreichen
			case 2:
				tx_itaoshhmanager_database::switchVisibilityPages($schooldata['ref_createoffer'], 0); # Vorschläge einstellen
				tx_itaoshhmanager_database::switchVisibilityPages($schooldata['ref_sortedoffers'], 0); # Vorschläge ansehen
				tx_itaoshhmanager_database::switchVisibilityPages($schooldata['ref_myoffers'], 0); # Meine Vorschläge 
				###tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+6), 0); # Übersicht 
###				tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+5), 0); # Übersicht - neue Struktur => bleibt auf hidden=1, weil lt. #3790 diese Seite nicht mehr sichtbar sein soll
				# => Vorschläge freigen nur freischalten, wenn die Vorschläge NICHT sofort nach Erstellen freigegeben werden.
				if ($schooldata['offer_automatically_approved']) {
					tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+4), 1); # Vorschläge freigeben
				} else {
					tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+4), 0); # Vorschläge freigeben
				}
				
				break;
			###### Abstimmung	
			case 3:
				tx_itaoshhmanager_database::switchVisibilityPages($schooldata['ref_createoffer'], 1); # Vorschläge einstellen
				###tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+13), 0); # Seite "Vorschlage der Schule" - Unterseite zu Hauptseite der Schule
				tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+9), 0); # Seite "Vorschlage der Schule" - Unterseite zu Hauptseite der Schule
				break;
			###### Ergebnis	
			case 5:
				tx_itaoshhmanager_database::switchVisibilityPages($schooldata['resultpage'], 0); # Ergebnisseite
				###tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+12), 0); # Ergebnisseite-ref - nicht eingeloggter Bereich
				###tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+5), 0); # Ergebnisseite-ref - eingeloggter Bereich
				#####tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+10), 0); # Seite "Vorschlage der Schule" - Unterseite zu Hauptseite der Schule
				tx_itaoshhmanager_database::switchVisibilityPages($schooldata['ref_sortedoffers'], 0); # Vorschläge ansehen
				tx_itaoshhmanager_database::switchVisibilityPages($schooldata['ref_myoffers'], 0); # Meine Vorschläge 
				###tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+6), 1); # Übersicht 
###				tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+5), 1); # Übersicht 
				tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+4), 1); # Vorschläge freigeben
				break;
		}
		
		$table = 'tx_itaoshhmanager_schools';						
		$fields_values = array(
			'ref_status' => $neuePhase
			);			
		$where = 'uid='.$schoolid;			
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
	}
	
	function switchPhaseBack($altePhase,$schoolid) {
		$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
		# Unterscheiden zwischen den Phasen:
		switch ($altePhase) {
			case 1:
				tx_itaoshhmanager_database::switchVisibilityPages($schooldata['resultpage'], 1); # Ergebnisseite
				###tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+12), 1); # Ergebnisseite-ref - nicht eingeloggter Bereich
				###tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+5), 1); # Ergebnisseite-ref - eingeloggter Bereich
				###tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+11), 1); # Seite "Vorschlage der Schule" - Unterseite zu Hauptseite der Schule
				tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+9), 1); # Seite "Vorschlage der Schule" - Unterseite zu Hauptseite der Schule
				tx_itaoshhmanager_database::switchVisibilityPages($schooldata['ref_createoffer'], 1); # Vorschläge einstellen
				tx_itaoshhmanager_database::switchVisibilityPages($schooldata['ref_sortedoffers'], 1); # Vorschläge ansehen
				tx_itaoshhmanager_database::switchVisibilityPages($schooldata['ref_myoffers'], 1); # Meine Vorschläge 
				###tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+6), 1); # Übersicht 
###				tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+5), 1); # Übersicht 
				tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+4), 1); # Vorschläge freigeben
				break;
			case 2:			
				tx_itaoshhmanager_database::switchVisibilityPages($schooldata['resultpage'], 1); # Ergebnisseite
				###tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+12), 1); # Ergebnisseite-ref - nicht eingeloggter Bereich
				###tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+5), 1); # Ergebnisseite-ref - eingeloggter Bereich
				###tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+11), 1); # Seite "Vorschlage der Schule" - Unterseite zu Hauptseite der Schule
				tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+9), 1); # Seite "Vorschlage der Schule" - Unterseite zu Hauptseite der Schule
				tx_itaoshhmanager_database::switchVisibilityPages($schooldata['ref_createoffer'], 0); # Vorschläge einstellen
				tx_itaoshhmanager_database::switchVisibilityPages($schooldata['ref_sortedoffers'], 0); # Vorschläge ansehen
				tx_itaoshhmanager_database::switchVisibilityPages($schooldata['ref_myoffers'], 0); # Meine Vorschläge 
				###tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+6), 0); # Übersicht 
###				tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+5), 0); # Übersicht 		
				if ($schooldata['offer_automatically_approved']) {
					tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+4), 1); # Vorschläge freigeben
				} else {
					tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+4), 0); # Vorschläge freigeben
				}
				break;
			case 3:
				tx_itaoshhmanager_database::switchVisibilityPages($schooldata['resultpage'], 1); # Ergebnisseite
				###tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+12), 1); # Ergebnisseite-ref - nicht eingeloggter Bereich
				###tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+5), 1); # Ergebnisseite-ref - eingeloggter Bereich
				#####tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+10), 1); # Seite "Vorschlage der Schule" - Unterseite zu Hauptseite der Schule
				###tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+11), 0); # Seite "Vorschlage der Schule" - Unterseite zu Hauptseite der Schule
				tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+9), 0); # Seite "Vorschlage der Schule" - Unterseite zu Hauptseite der Schule
				tx_itaoshhmanager_database::switchVisibilityPages($schooldata['ref_createoffer'], 1); # Vorschläge einstellen
				tx_itaoshhmanager_database::switchVisibilityPages($schooldata['ref_sortedoffers'], 0); # Vorschläge ansehen
				tx_itaoshhmanager_database::switchVisibilityPages($schooldata['ref_myoffers'], 0); # Meine Vorschläge 
				###tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+6), 0); # Übersicht 
###				tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+5), 0); # Übersicht 		
				if ($schooldata['offer_automatically_approved']) {
					tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+4), 1); # Vorschläge freigeben
				} else {
					tx_itaoshhmanager_database::switchVisibilityPages(($schooldata['ref_schoolpage']+4), 0); # Vorschläge freigeben
				}
				break;
			
		}
		
		$table = 'tx_itaoshhmanager_schools';						
		$fields_values = array(
			'ref_status' => $altePhase
			);			
		$where = 'uid='.$schoolid;			
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		
		#t3lib_utility_debug::debug("jetzt zurueck");
	}
	
	
	function switchVisibilityPages($pageId, $hide) {		
		$table = 'pages';						
		$fields_values = array(
			'hidden' => $hide
			);			
		$where = 'uid='.$pageId;			
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
	}
	
	
	function finishCommune($communeid, $action) {
		$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);
		$hauptseitecommune = $communedata['ref_communepage'];
		$newPid = ($action==1) ? $this->tsvars['finished_communes']: $this->tsvars['newCommuneAfterThisPage'];
		
		$table = 'tx_itaoshhmanager_communes';						
		$fields_values = array(
			'is_finished' => $action
			);			
		$where = 'uid='.$communeid;			
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		
		$table = 'pages';						
		$fields_values = array(
			'pid' => $newPid
			);			
		$where = 'uid='.$hauptseitecommune;			
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		
	}
	
	function saveVotes($votes_arr) {
		$table = 'tx_itaoshhoffers_domain_model_offer';		
		if (is_array($votes_arr)) {
			while (list ($key, $val) = each ($votes_arr)) {				
				$fields_values = array('votes' => $val);	
				$where='uid='.$key;			
				#t3lib_utility_debug::debug($fields_values);		
				$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
			}
		}
	}
	
	
	function getChildOffers($offerid,$int_or_uid=1, $order_by=1) {							
		$select = '*';
		$from = 'tx_itaoshhoffers_domain_model_offer';
		$where = 'parent_offer='.$offerid;	
		$orderArr[1] = $orderArr[0] = 'title asc';
		$orderArr[2] = 'internal_id asc';
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderArr[$order_by],$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		  	if ($int_or_uid == 2) { # wenn 2 dann uid, wenn 1 dann internal_id
		    	$offers[$row['uid']] = $row['uid'];
		    } else {
		    	$offers[$row['internal_id']] = $row['internal_id'];
		    }
		  }
		}
		
		return $offers;
	}
	
	function setParentOffer($childoffer, $parentoffer) {
		$offerdata_child = tx_itaoshhmanager_database::getOfferById($childoffer);
		$offerdata_parent = tx_itaoshhmanager_database::getOfferById($parentoffer);
		#im child die parentid setzen
		$table = "tx_itaoshhoffers_domain_model_offer";
		$where = 'uid='.$childoffer;
		$fields_values_child = array("parent_offer" => $parentoffer );
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values_child);
		# im Parent die anzahl der childs um 1 erhöhen:
		$where = 'uid='.$parentoffer;
		$anz_child_offers = intval($offerdata_parent['child_offers'])+1;
		$fields_values_parent = array("child_offers" => $anz_child_offers );
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values_parent);
	}
	
	
	function unchainOffer($parentoffer, $childoffer) {
		#t3lib_utility_debug::debug("child:".$childid."//parent:".$parentid);
		# 1. im child die Parentid rausnehmen
		$offerdata_child = tx_itaoshhmanager_database::getOfferById($childoffer);
		$offerdata_parent = tx_itaoshhmanager_database::getOfferById($parentoffer);
		#im child die parentid setzen
		$table = "tx_itaoshhoffers_domain_model_offer";
		$where = 'uid='.$childoffer;
		$fields_values_child = array("parent_offer" => 0 );
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values_child);
		# 2. im Parent die anzahl der childs um 1 runtersetzen
		$where = 'uid='.$parentoffer;
		$anz_child_offers = intval($offerdata_parent['child_offers'])-1;
		$fields_values_parent = array("child_offers" => $anz_child_offers );
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values_parent);
	}
	
	function checkHeader() {		
		$allCommunes = tx_itaoshhmanager_database::getAllCommunes();
		if (is_array($allCommunes)) {
			while (list ($key, $val) = each ($allCommunes)) {
				# für diese Kommune header ändern:
				$hauptseite = $val['ref_communepage'];
				$logo = $val['headerimage'];
				$table = 'pages';						
				$fields_values = array('media' => $logo);
				$where = 'uid='.$hauptseite;
				$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
				#t3lib_utility_debug::debug("check: commune//id:".$val['uid']." - title:".$val['titel']."//logo:".$logo."//seite:".$hauptseite);
				
				
				$allSchools = tx_itaoshhmanager_database::getAllSchoolsByCommune($val['uid']);
				if (is_array($allSchools)) {
					while (list ($key2, $val2) = each ($allSchools)) {
						$hauptseite2 = $val2['ref_schoolpage'];
						$logo2 = $val2['headerimage'];
						$table = 'pages';						
						$fields_values = array('media' => $logo2);
						$where = 'uid='.$hauptseite2;
						$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
						#t3lib_utility_debug::debug("check: schule//id:".$val2['uid']." - title:".$val2['title']."//logo:".$logo2."//seite:".$hauptseite2);
					}
				}
			}
		}
		
		/*
		
		if ($comm_or_school==1) { # dann kommune
			$objdata = tx_itaoshhmanager_database::getCommunesById($comm_schoolid);
			$hauptseite = $objdata['ref_communepage'];
		} else {
			$objdata = tx_itaoshhmanager_database::getSchoolById($comm_schoolid);
			$hauptseite = $objdata['ref_schoolpage'];
		}		
		$logo = $objdata['headerimage'];
		*/
		/*
		$select = 'media';
		$from = 'pages';
		$where = 'uid='.$mitLogoSeite;		
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $logo = $row['media'];
		  }
		}
		*/
		#t3lib_utility_debug::debug($_GET);
		#t3lib_utility_debug::debug("check:".$comm_or_school."//id:".$comm_schoolid."//logo:".$logo."//seite:".$hauptseite);
		/*
		$table = 'pages';						
		$fields_values = array('media' => $logo);
		$where = 'uid='.$hauptseite;
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
		*/
	}
	
	
	function getresanzid($schoolid, $all = 0) {
		$select = '*';
		$from = 'tx_itaoshhmanager_resultanz';
		$where = 'ref_schoolid='.$schoolid; # jetzt die erste Unterseite
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		  	if ($all==1) {
		  		$anzresid = $row;
		  	} else {
		    	$anzresid = $row['uid']; 
		    }
		    
		  }
		}
		return $anzresid;
	}
	
	function checkAnzResults($schoolid) {
		$anzresData = tx_itaoshhmanager_database::getresanzid($schoolid,1);
		$anzres = $anzresData['number_of_result_offers'];
		$table = 'tx_itaoshhmanager_schools';				
		$where = 'uid = '.$schoolid;	
		$fields_values = array('number_of_result_offers' => $anzres);
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
	}
	
	
		
	
	# prüft, ob bei einer Schule die Vorschläge gleich freigegeben werden
	# wenn ja, hat Gruppe Schüler KEINEN Zugriff auf "Neuen Vorschlag einstellen" und "Meine Vorschläge"
	# wenn nein, hat Gruppe Schüler Zugriff auf "Neuen Vorschlag einstellen" und "Meine Vorschläge"
	function checkFreigabe($communeid) {
		global $_SERVER;
		#t3lib_utility_debug::Debug($_SERVER);
		# in der dev sollen bei allen Schools geschaut werden, in der live nur ab > 43
		$valueBiggerThan = 0; #($_SERVER['HTTP_HOST'] == 'dev2.schuelerhaushalt.de' || $_SERVER['HTTP_HOST'] == 'dev.schuelerhaushalt.de') ? 0 : 43 ;
		
		$allSchools = tx_itaoshhmanager_database::getAllSchoolsByCommune($communeid);
		if (is_array($allSchools)) {
			while (list ($key, $val) = each ($allSchools)) {
				# das NUR machen, wenn es sich um neue Schulen handelt, weil bei den alten wäre das falsch
				
				if ($val['uid'] > $valueBiggerThan) {
					$freigabe = $val['offer_automatically_approved'];
					#$pageData_newOffer = tx_itaoshhmanager_database::getPageData($val['ref_createoffer']);
					#$pageData_myOffers = tx_itaoshhmanager_database::getPageData($val['ref_myoffers']);
					if ($freigabe) {
						# dann hat der Schüler KEINEN Zugriff drauf
						$fe_group = $this->tsvars['groupid_schuelervertretung']. ','.$this->tsvars['groupid_verw_schule']; # 3,2
					} else {
						$fe_group =  $this->tsvars['groupid_schuelervertretung']. ','.$this->tsvars['groupid_verw_schule'].','.$this->tsvars['groupid_schueler']; #'3,2,4';
						# dann hat der Schüler Zugriff auf diese Seiten
					}
					#t3lib_utility_debug::Debug("fe_group:".$fe_group."// newoofer:".$val['ref_createoffer']);
					tx_itaoshhmanager_database::updatePageData($val['ref_createoffer'], $fe_group);
					tx_itaoshhmanager_database::updatePageData($val['ref_myoffers'], $fe_group);
				}
			}
		}
		
	}
	
	/*function getPageData($pageUid) {
		$select = '*';
		$from = 'pages';
		$where = 'uid='.$pageUid;
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where);
		if ($res) {
		  while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
		    $pageData = $row;
		  }
		}
		
		return $pageData;	
	}*/
	
	
	
	function updatePageData($pageUid, $fe_group) {
		$table = 'pages';				
		$where = 'uid = '.$pageUid;	
		$fields_values = array('fe_group' => $fe_group);
		$GLOBALS['TYPO3_DB']->exec_UPDATEquery($table,$where,$fields_values);
	}
	
	
	
				
}

?>