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


$LANG->includeLLFile('EXT:itao_shh_manager/mod1/locallang.xml');

require_once(PATH_t3lib . 'class.t3lib_scbase.php');

require_once(t3lib_extMgm::extPath('itao_shh_manager') . '/lib/general.inc.php');
require_once(t3lib_extMgm::extPath('itao_shh_manager') . '/lib/navigation.inc.php');
require_once(t3lib_extMgm::extPath('itao_shh_manager') . '/lib/database.inc.php');
require_once(t3lib_extMgm::extPath('itao_shh_manager') . '/lib/mail.inc.php');
require_once(t3lib_extMgm::extPath('itao_shh_manager') . '/lib/pdf_generator.php');


require_once(PATH_t3lib .'mail/class.t3lib_mail_message.php');




/**
 * Module 'Library' for the 'itao_shh_manager' extension.
 *
 * @author	Edeltraud Gratzer <edeltraud.gratzer@itao.de>
 * @package	TYPO3
 * @subpackage	tx_itaozfadatamanager
 */
class  tx_itaoshhmanager_library extends  t3lib_SCbase {
	

/******************** Aktionen **************************************************/	

				
				function getSessionValue($ses_key) {
					$dieSessionVars = $GLOBALS["BE_USER"]->getSessionData($ses_key); #tx_myextension
					return $dieSessionVars;
				}
				
				function setSessionValue($ses_key, $ses_val) {
					$GLOBALS["BE_USER"]->setAndSaveSessionData ($ses_key, $ses_val);
				}
				
					
				function check_username($username) {			
					$select = '*';
					$from = 'fe_users';
					$where = 'deleted=0 ';# '1 '.$GLOBALS['TSFE']->sys_page->enableFields('fe_users');
					$where.=' and username="'.$username.'"';
					$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
					
					if($res && ($userData = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)))		{
						return 1;
					} else {
						return 0;
					}		
					
				}
				
				
					
				function check_beusername($username) {			
					$select = '*';
					$from = 'be_users';
					$where = 'deleted=0 ';# '1 '.$GLOBALS['TSFE']->sys_page->enableFields('fe_users');
					$where.=' and username="'.$username.'"';
					$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery($select,$from,$where,$groupBy='',$orderBy='',$limit='');
					
					if($res && ($userData = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)))		{
						return 1;
					} else {
						return 0;
					}		
					
				}
				
				
				
				function generateBeUserPrefix($is_school, $schooldata, $communedata) {
					# 1. schul-präfix generieren
					$shorty = ($communedata['c_short']!="") ? $communedata['c_short']:$communedata['titel'] ;
					$daprefix = substr(tx_itaoshhmanager_library::getEscapedSchoolName($shorty),0,11);
					if ($is_school) {
						$shortyc = ($schooldata['s_short']!="") ? $schooldata['s_short']:$schooldata['title'] ;
						$daprefix = substr(tx_itaoshhmanager_library::getEscapedSchoolName($shortyc),0,11);	
					} 							
					# 2. und dann schauen, obs das in DB schon gibt.
					#### TODO!!!!!!!!!!!!!!!!! hier müssen noch alle Schulen abgefangen werden, damit nicht gleiche schul-prefixe verwendet werden!!
					####$allSchools = tx_itaoshhmanager_database::getAllSchools();
					return $daprefix;
				}
				
				
				function generateSchoolprefix($schooldata, $groupid=0) {
					# 0. schauen, ob communenkuerzel oder schueln-kuerzel genommen wird.					
					$by_commune = array($this->tsvars['groupid_verw_kommune'], $this->tsvars['groupid_mod_kommune']);
					
					if (in_array($groupid, $by_commune)) {
						$communeid = $this->piVars['communeid']; #$schooldata['ref_commune'];
						$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);
						$sc_title = $communedata['c_short'];
						$sc_title = ($sc_title =="") ? $schooldata['s_short']: $sc_title;
					} else {
						$sc_title = $schooldata['s_short'];
					}
					
					# 1. schul-präfix generieren
					$schoolname_esc = tx_itaoshhmanager_library::getEscapedSchoolName($sc_title);	
					#$schoolname_esc = ($schoolname_esc=="") ? tx_itaoshhmanager_library::getEscapedSchoolName($schooldata['title']) : $schoolname_esc;									
					# 2. und dann schauen, obs das in DB schon gibt.
					#### TODO!!!!!!!!!!!!!!!!! hier müssen noch alle Schulen abgefangen werden, damit nicht gleiche schul-prefixe verwendet werden!!
					####$allSchools = tx_itaoshhmanager_database::getAllSchools();
					return substr($schoolname_esc,0,11);
				}
				
				function getEscapedSchoolName($schoolname) {
					$esc_schoolname = strtolower(utf8_decode($schoolname));
					$esc_schoolname = substr($esc_schoolname, 0, 20); 
					$esc_schoolname = str_replace("ä","ae",str_replace("ü","ue",str_replace("ö","oe",str_replace("ß","ss",$esc_schoolname))));
					 
					for ($ascii = 1; $ascii<=255; $ascii++){
						if ($ascii<=47) { # bis zahlen
							$esc_schoolname = str_replace(chr($ascii),"",$esc_schoolname);
						}
						if ($ascii >=58 && $ascii<=96) { # ab zahlen bis kleinbuchstaben
							$esc_schoolname = str_replace(chr($ascii),"",$esc_schoolname);
						}						
						if ($ascii >=123 && $ascii<=255) { # ab zahlen bis kleinbuchstaben							 
							$esc_schoolname = str_replace(chr($ascii),"",$esc_schoolname);							
						}
						
					}
					return $esc_schoolname;
				}
				
				function generateUsername($schulprefix,$i) {
					$username = $schulprefix.''.$i;
					
					if (tx_itaoshhmanager_library::check_username($username) == 0 ) {
						$username = $username;
					} else {
						for ($x=0; $x<=100; $x++) {
							#$newUsername = tx_itaoshhmanager_library::generatePassword();
							$newUsername.=$username.'_'.$x;
							if (tx_itaoshhmanager_library::check_username($newUsername) == 0) {
								$username = $newUsername;
								break;
							}
						}
					}
					return $username;
					
				}
				
				
				
				function generateBEUsername($daprefix,$i,$groupid) {
					$kuerzel[$this->tsvars['be_groupid_redadmin_kommune']] = 'rak';
					$kuerzel[$this->tsvars['be_groupid_redadmin_schule']] = 'ras';
					$kuerzel[$this->tsvars['be_groupid_mod_kommune']] = 'mk';
					$kuerzel[$this->tsvars['be_groupid_mod_schule']] = 'ms';
					$username = $daprefix.'_'.$kuerzel[$groupid].'_'.$i;
					
					if (tx_itaoshhmanager_library::check_beusername($username) == 0 ) {
						$username = $username;
					} else {
						for ($x=0; $x<=100; $x++) {
							#$newUsername = tx_itaoshhmanager_library::generatePassword();
							$newUsername.=$username.'_'.$x;
							if (tx_itaoshhmanager_library::check_username($newUsername) == 0) {
								$username = $newUsername;
								break;
							}
						}
					}
					return $username;
					
				}
				
				
			
				function generatePassword($pwlen=8) {     
					mt_srand();     
					$salt = "abcdefghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ23456789";    
					for($i=0;$i<$pwlen;$i++) {        
						$pw .= $salt[mt_rand(0, strlen($salt)-1)];     
					}    
					return $pw; 
				}
				
				function escape($s){
					$s2 = str_replace(';', ',', str_replace('"', '\'', $s));
					$s3 = str_replace("\n", "<br>",$s2);
					$s3 = str_replace(chr(10), "",$s3);
					$s3 = str_replace(chr(13), "",$s3);					
			    return $s3;
			  }
			  
			  function escape_alttext($text) {
			  	$text_n = str_replace('"', "'", $text);
			  	return $text_n;
			  }
							
				function my_hashPassword($password, $salt='') {
			    if (t3lib_extMgm::isLoaded('saltedpasswords')) {
			     if (tx_saltedpasswords_div::isUsageEnabled('FE')) {
	            $objSalt = tx_saltedpasswords_salts_factory::getSaltingInstance(NULL, 'BE');
	            if (is_object($objSalt)) {
	             $saltedPassword = $objSalt->getHashedPassword($password, $salt);
	            }
			     }
			    }
			    return $saltedPassword;
				} 
				
				
				function getUsedUsergroupsOptions($communeid,$schoolid,$allFoundUsers) {
					while (list ($key, $val) = each ($allFoundUsers)) {
						$usedGroups[$val['usergroup']] = $val['usergroup'];
					}
					reset($usedGroups);
					$allGroups = tx_itaoshhmanager_database::getAllUsergroups();
					while (list ($key1, $val1) = each ($usedGroups)) {
							#if ($val['usergroup']!="") {
		  					$row_groupsarr = explode(",", $val1);
		  					if (is_array($row_groupsarr)) {
									while (list ($keyu, $valu) = each ($row_groupsarr)) {
										if (intval($allGroups[$valu]['tx_itaoshhmanager_ssh_ref_school']) == 0) {
											$groupname = $allUsergroups[$valu]['title'];
											$groupsData[$valu] = $allGroups[$valu];
										}
									}
								}
							 #}
						
						
						
						#$groupsData[$val1] = $allGroups[$val1];
					}
					#t3lib_utility_debug::debug($groupsData);
					$presel = $GLOBALS["BE_USER"]->getSessionData("filter_usergroups");
					$html = tx_itaoshhmanager_library::makeOptions($groupsData, "title", $presel,0,0);
					return $html;
				}
				



/******************** HTML-Funktionen *****************************************************/	


				function makeOptions_withGroups($dataArr, $fieldtitle, $presel=0) {
					global $LANG;
					if (is_array($dataArr)) {
						while (list ($key, $val) = each ($dataArr)) {
							$selected = ($presel== $key) ? ' selected="selected"' : '';
							$optgroup = ($val['optgroup_b']!="")  ? '<optgroup label="'.$val['optgroup_b'].'">': '';
						  $options.=$optgroup.'
						   	<option value="'.$key.'" '.$selected.' title="'.$val[$fieldtitle].'">'.$val[$fieldtitle].'</option>';						   
							$optgroup_ende = ($val['optgroup_e']!="")  ? '</optgroup>': '';
							$options.=$optgroup_ende;
						}
					} else {
						$options = '<option value="0">'.$LANG->getLL('no_options').'</option>';
					}
					return $options;
				}



				function makeOptions($dataArr, $fieldtitle, $presel=0,$num=0, $abschneiden=0, $usedByJs=0) {
					global $LANG;					
					$i=1;
					$fragenr = "";
					if (is_array($dataArr)) {
						while (list ($key, $val) = each ($dataArr)) {
							#$nummer = ($num) ? $i.': ': '';
							if ($num && $usedByJs) {								
								$fragenr = " (Nr. ".$val['internal_id'] .")";
							}
							#if (!$val['check_fragenr']) {
							#	$nummer = "";
							#} else {
							#	$nummer = $nummer.' (Nr. '.$fragenr.') ';
							#}
							$selected = ($presel== $key) ? ' selected="selected"' : '';
							if ($abschneiden) {
								$titletext =  $val[$fieldtitle] ;
							} else {
								$titletext = (strlen($val[$fieldtitle]) > 120 ) ? substr($val[$fieldtitle],0,120).'...' : $val[$fieldtitle] ;
							}
							
							#$fragenr.
						  $options.='
						   	<option value="'.$key.'" '.$selected.' title="'.$val[$fieldtitle].$fragenr.'">'.$titletext.'</option>'; #$val[$fieldtitle]
						  $i++;
						}
					} else {
						$options = '<option value="0">'.$LANG->getLL('no_options').'</option>';
					}
					
					return $options;
				}
				
				

				function makeOptions2($dataArr, $fieldtitle, $presel=0) {
					global $LANG;					
					if (is_array($dataArr)) {
						while (list ($key, $val) = each ($dataArr)) {
							#t3lib_div::debug("presel=".$presel."//uid:".$val['uid']);
							$selected = ($presel== $val['uid']) ? ' selected="selected"' : '';
							$titletext = (strlen($val[$fieldtitle]) > 70 ) ? substr($val[$fieldtitle],0,70).'...' : $val[$fieldtitle] ;
						  $options.='
						   	<option value="'.$val['uid'].'" '.$selected.' title="'.$val[$fieldtitle].'">'.$titletext.'</option>';
						}
					} else {
						$options = '<option value="0">'.$LANG->getLL('no_options').'</option>';
					}
					
					return $options;
				}

				
	
/******************** DB-Funktionen *****************************************************/	
			
				function is_redakteur($beUserData) {				
#					$is_red = ($beUserData['usergroup'] == $this->tsvars['bstRed_groupid'] || $beUserData['admin']==1) ? 1 : 0;								
					return $is_red;
				}
				function is_pruefer($beUserData) {					
#					$is_pruefer = ($beUserData['usergroup'] == $this->tsvars['pruefer_groupid']) ? 1 : 0;								
					return $is_pruefer;
				}



				
						

/****************** EXPORT-Funktionen ******************************************************************/
	
		
		
		function header_schreiben($kundenname){
			$header.= 'Nr'.
				';'.'Benutzerkennung'.
				';'.'Passwort'.
				"\n";
			return $header;
		}
		
		
	
	
	
	
	
	function pagebrowser_ausgeben($maxItems, $anz_ds, $actPage) {	
/*		$html='';
		#t3lib_utility_Debug::debug("maxItems".$maxItems."//anz_ds".$anz_ds."//actPage".$actPage);
		$wie_oft = ceil($anz_ds / $maxItems);
		$paramArr = array();
		while (list ($key, $val) = each ($this->piVars)) {
			if (strpos($key,'earch') > 0) {
				$params.='&'.$key.'='.$val;
			}
		}
		reset($this->piVars);
		
		if ($actPage > 1 && $anz_ds > $maxItems) {
			$paramArr[$this->prefixId.'['.$actPage_param.']'] = ($actPage-1);
			$html .= '
				<span  class="pb_p">'.'
					<a href="'.$this->indexpath.$params.'&actPage=1&backedit=1">
						<img src="/typo3/sysext/t3skin/images/icons/actions/view-paging-first.png" alt="'.$GLOBALS['LANG']->getLL('nav_first', TRUE).'" title="'.$GLOBALS['LANG']->getLL('nav_first', TRUE).'" />
					</a>
					<a href="'.$this->indexpath.$params.'&actPage='.($actPage-1).'&backedit=1">
						<img src="/typo3/sysext/t3skin/images/icons/actions/view-paging-previous.png" alt="'.$GLOBALS['LANG']->getLL('nav_prev', TRUE).'" title="'.$GLOBALS['LANG']->getLL('nav_prev', TRUE).'" />
					</a>
				</span>';		#$this->pi_linkTP('&laquo; ',$paramArr).'	
		} else {
			$html.='
				<span  class="pb_p">'.'
						<img src="/typo3/sysext/t3skin/images/icons/actions/view-paging-first-disabled.png" alt="'.$GLOBALS['LANG']->getLL('nav_first', TRUE).'" title="'.$GLOBALS['LANG']->getLL('nav_first', TRUE).'" />
						<img src="/typo3/sysext/t3skin/images/icons/actions/view-paging-previous-disabled.png" alt="'.$GLOBALS['LANG']->getLL('nav_prev', TRUE).'" title="'.$GLOBALS['LANG']->getLL('nav_prev', TRUE).'"  />
				</span>';
		}
		
		$html.='<span class="pb_nav">';
		for ($i=1;$i<=($wie_oft);$i++) {
			$class=($i == $actPage) ? ' class="active"': '';
			$bis = (($i*$maxItems+$maxItems)> $anz_ds) ? $anz_ds : ($i*$maxItems+$maxItems);			
			$paramArr[$this->prefixId.'['.$actPage_param.']'] = (string)($i); 
			$html .= '<span '.$class.'>'.'<a href="'.$this->indexpath.$params.'&actPage='.($i).'&backedit=1">'.($i).'</a></span>';
		}
		$html.='</span>';
		
		if ($actPage != ($wie_oft) && $anz_ds > $maxItems) {#if ($actPage != ($wie_oft-1) && $anz_ds > $maxItems) {
			$paramArr[$this->prefixId.'['.$actPage_param.']'] = ($actPage+1); 
			$html .= '
			<span  class="pb_p">'.'
				<a href="'.$this->indexpath.$params.'&actPage='.($actPage+1).'&backedit=1">
					<img src="/typo3/sysext/t3skin/images/icons/actions/view-paging-next.png" alt="'.$GLOBALS['LANG']->getLL('nav_next', TRUE).'" title="'.$GLOBALS['LANG']->getLL('nav_next', TRUE).'"/>
				</a>';
			$html .= '
				<a href="'.$this->indexpath.$params.'&actPage='.($wie_oft).'&backedit=1">
					<img src="/typo3/sysext/t3skin/images/icons/actions/view-paging-last.png" alt="'.$GLOBALS['LANG']->getLL('nav_last', TRUE).'" title="'.$GLOBALS['LANG']->getLL('nav_last', TRUE).'" />
				</a>
			</span>';
		}	else {
			$html.='
				<span  class="pb_p">'.'
						<img src="/typo3/sysext/t3skin/images/icons/actions/view-paging-next-disabled.png" alt="'.$GLOBALS['LANG']->getLL('nav_next', TRUE).'" title="'.$GLOBALS['LANG']->getLL('nav_next', TRUE).'"/>
						<img src="/typo3/sysext/t3skin/images/icons/actions/view-paging-last-disabled.png" alt="'.$GLOBALS['LANG']->getLL('nav_last', TRUE).'" title="'.$GLOBALS['LANG']->getLL('nav_last', TRUE).'"/>
				</span>';
		}			

		return $html;
*/
	}
	


			
				
/* Template-Funktionen*/				


				
				function getMySubpart($content, $marker) {
					$start = strpos($content, $marker);
			
					if ($start === FALSE) {
						return '';
					}
			
					$start += strlen($marker);
					$stop = strpos($content, $marker, $start);
			
						// Q: What shall get returned if no stop marker is given
						// /*everything till the end*/ or nothing?
					if ($stop === FALSE) {
						return ''; /*substr($content, $start)*/
					}
			
					$content = substr($content, $start, $stop - $start);
			
					$matches = array();
					if (preg_match('/^([^\<]*\-\-\>)(.*)(\<\!\-\-[^\>]*)$/s', $content, $matches) === 1) {
						return $matches[2];
					}
			
					$matches = array(); // resetting $matches
					if (preg_match('/(.*)(\<\!\-\-[^\>]*)$/s', $content, $matches) === 1) {
						return $matches[1];
					}
			
					$matches = array(); // resetting $matches
					if (preg_match('/^([^\<]*\-\-\>)(.*)$/s', $content, $matches) === 1) {
						return $matches[2];
					}
			
					return $content;
				}
				

	
				
				
				function template_ausgeben($markerArray, $tempTeil, $templateFile="") {
					// mit unterdrückten meldungen
					$tempFile = ($templateFile!="") ? $templateFile : 'layout/be_template.html';
					$templateCode = implode(" ", @file(t3lib_extMgm::extPath("itao_shh_manager").$tempFile));#'mod1/be_template.html'));					
					$subpart=tx_itaoshhmanager_library::getMySubpart($templateCode,"###".$tempTeil."###");						
					$html= tx_itaoshhmanager_library::substituteMyMarkerArray($subpart, $markerArray);
					return $html;
				}		
	
				
				function template_ausgeben_mails($markerArray, $tempTeil) {
					global $_SERVER;
					if ($this->tsvars['pfad_mail_template'] !="" && is_file($_SERVER['DOCUMENT_ROOT']."/".$this->tsvars['pfad_mail_template'])) {
						$ts_pfad = $_SERVER['DOCUMENT_ROOT']."/".$this->tsvars['pfad_mail_template'];
					} else {
						$ts_pfad = t3lib_extMgm::extPath("itao_shh_manager")."lib/zertifizierung_mails.html";
					}		
					
					$templateCode = utf8_encode(implode("", @file($ts_pfad)));			
					$subpart=tx_itaoshhmanager_library::getMySubpart($templateCode,"###".$tempTeil."###");			
					$html.= tx_itaoshhmanager_library::substituteMyMarkerArray($subpart, $markerArray);
					return $html;
				}
				
				
	function substituteMyMarkerArray($content, $markContentArray, $wrap = '', $uppercase = 0, $deleteUnused = 0) {
		if (is_array($markContentArray)) {
			$wrapArr = t3lib_div::trimExplode('|', $wrap);

			foreach ($markContentArray as $marker => $markContent) {
				if ($uppercase) {
						// use strtr instead of strtoupper to avoid locale problems with Turkish
					$marker = strtr(
						$marker,
						'abcdefghijklmnopqrstuvwxyz',
						'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
					);
				}

				if (count($wrapArr) > 0) {
					$marker = $wrapArr[0] . $marker . $wrapArr[1];
				}

				$content = str_replace($marker, $markContent, $content);
			}

			if ($deleteUnused) {
				if (empty($wrap)) {
					$wrapArr = array('###', '###');
				}

				$content = preg_replace('/' . preg_quote($wrapArr[0]) . '([A-Z0-9_|\-]*)' . preg_quote($wrapArr[1]) . '/is', '', $content);
			}
		}

		return $content;
	}
				
				
				
				function js_fuer_ds_bearbeiten($parameter){
					$html.='
						<script type="text/javascript">
							/*<![CDATA[*/				
														
								function jumpToUrl(URL)	{	//
									window.location.href = URL;
									return false;
								}
								function jumpExt(URL,anchor)	{	//
									var anc = anchor?anchor:"";
									window.location.href = URL+(T3_THIS_LOCATION?"&returnUrl="+T3_THIS_LOCATION:"")+anc;
									return false;
								}
								function jumpSelf(URL)	{	//
									window.location.href = URL+(T3_RETURN_URL?"&returnUrl="+T3_RETURN_URL:"");
									return false;
								}
							
								function setHighlight(id)	{	//
									top.fsMod.recentIds["web"]=id;
									top.fsMod.navFrameHighlightedID["web"]="pages"+id+"_"+top.fsMod.currentBank;	// For highlighting
							
									if (top.content && top.content.nav_frame && top.content.nav_frame.refresh_nav)	{
										top.content.nav_frame.refresh_nav();
									}
								}
						'; 
						
						$html.="
							var T3_RETURN_URL = '';	
							";
						$locat = ($parameter=="") ? $this->indexpath: $parameter;
						$html.="
							var T3_THIS_LOCATION = '".$locat."';
											
							/*]]>*/
							</script>	
							
							";

							
							
							return $html;
						}	
				
/* ==================================== NEU FÜR KUNDEN-MODUL ****************************************************** */				
/*'"*/
	
		
		
		
		
				
				
				
				
		}

?>