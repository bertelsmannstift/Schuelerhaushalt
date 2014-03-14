<?php

/**
  * Lib for Navigation
  */

$LANG->includeLLFile('EXT:itao_shh_manager/mod1/locallang.xml');
require_once(PATH_t3lib . 'class.t3lib_scbase.php');



/**
 * Navigation-Library for the 'itao_shh_manager' extension.
 * Function for Navigation
 *
 * @author	Edeltraud Gratzer <edeltraud.gratzer@itao.de>
 * @package	TYPO3
 * @subpackage	txitaoshhmanager
 */
class  tx_itaoshhmanager_navigation extends  t3lib_SCbase {	
					
				
	function breadcrumb_ausgeben($func_bez = "") {
		global $LANG;
		if ($func_bez!="") {
			$html.='<a href="'.$this->indexpath.'">'.$func_bez.'</a>';
		} else {
			$html.='<a href="'.$this->indexpath.'">&Uuml;bersicht</a>';
		}
/*		
		#1. Ebene Kundenübersicht:
		if ($this->piVars['kundenid']) {
			$kundendata = tx_itaozfadatamanager_database::getKundeData($this->piVars['kundenid']);
			$kundenname = (strlen($kundendata['tx_itaozfaregister_companyname']) > 25) ? substr($kundendata['tx_itaozfaregister_companyname'],0,25).'...' : $kundendata['tx_itaozfaregister_companyname'];
			$html.=' / <a href="'.$this->indexpath.'&kundenid='.$this->piVars['kundenid'].'">'.$kundenname.'</a>';
			if ($this->piVars['smnr']) {
				$html.=' / <a href="'.$this->indexpath.'&kundenid='.$this->piVars['kundenid'].'&smnr='.$this->piVars['smnr'].'">'.$LANG->getLL('kv_sm'.$this->piVars['smnr']).'</a>';
			} else {
				if ($this->piVars['M'] == 'txitaozfadatamanagerM0_txitaozfadatamanagerM1') {
					$ber_bez = $LANG->getLL('kv_smUnt0');
				} else {
					$ber_bez = $LANG->getLL('kv_sm0');
				}
				$html.=' / <a href="'.$this->indexpath.'&kundenid='.$this->piVars['kundenid'].'&smnr=0">'.$ber_bez.'</a>';
			}
		}
		
		# 2. Ebene - Evaluation - Bereichsdetail:
		if ($this->piVars['detailFbBereich']) {
			$allBereiche = tx_itaozfadatamanager_library::getAlleBereiche();
			while (list ($key, $val) = each ($allBereiche[1]['sorted'])) {
				if ($val['uid'] == $this->piVars['detailFbBereich']) {
					$this->bereichsnr = $bereichsnr = $key+1;								
					$bereichstitle = $val['title'];
				}
			}
			$html.='<a href="'.$this->indexpath.'&kundenid='.$this->piVars['kundenid'].'&smnr='.$this->piVars['smnr'].'&detailFbBereich='.$this->piVars['detailFbBereich'].'"> Unternehmen / Bereich '.$bereichsnr.': '.$bereichstitle.'</a>';
		}
		
		# Ebene Mitarbeiter:		
		if ($this->piVars['ma_bereichDetail']) {
			$allBereiche = tx_itaozfadatamanager_library::getAlleBereiche();
			reset($allBereiche);
			while (list ($key, $val) = each ($allBereiche[2]['sorted'])) {
				if ($val['uid'] == $this->piVars['ma_bereichDetail']) {
					$this->bereichsnr = $bereichsnr = $key+1;								
					$bereichstitle = $val['title'];
				}
			}
			$html.='<a href="'.$this->indexpath.'&kundenid='.$this->piVars['kundenid'].'&smnr='.$this->piVars['smnr'].'&ma_bereichDetail='.$this->piVars['ma_bereichDetail'].'"> Mitarbeiter / Bereich'.$bereichsnr.': '.$bereichstitle.'</a>';
		}
		
		# Ebene Alle Antworten aller Mitarbeiter		
		if ($this->piVars['ma_fbDetail']) {					
			$html.='<a href="'.$this->indexpath.'&kundenid='.$this->piVars['kundenid'].'&smnr='.$this->piVars['smnr'].'&ma_fbDetail='.$this->piVars['ma_fbDetail'].'"> Mitarbeiter-Frageb&ouml;gen im Detail</a>';
		}
		
		# Ebene Gegenüberstellung Untern / MA					
		if ($this->piVars['gegenueberst']) {					
			$html.='<a href="'.$this->indexpath.'&kundenid='.$this->piVars['kundenid'].'&smnr='.$this->piVars['smnr'].'&gegenueberst='.$this->piVars['gegenueberst'].'"> Gegen&uuml;berstellung Unternehmer- und Mitarbeiter-Frageb&ouml;gen</a>';
		}
		
		
		# Neue Email erstellen				
		if ($this->piVars['newMail']) {					
			$html.='<a href="'.$this->indexpath.'&newMail=1&kundenid='.$this->piVars['kundenid'].'&smnr='.$this->piVars['smnr'].'"> > Neue E-Mail erstellen</a>';
		}
		# Email bearbeiten				
		if ($this->piVars['edit_mail']) {					
			$html.='<a href="'.$this->indexpath.'&edit_mail=1&mail_id='.$this->piVars['mail_id'].'&kundenid='.$this->piVars['kundenid'].'&smnr='.$this->piVars['smnr'].'"> / E-Mail bearbeiten</a>';
		}
		# Email ansehen				
		if ($this->piVars['view_mail']) {					
			$html.='<a href="'.$this->indexpath.'&view_mail=1&mail_id='.$this->piVars['mail_id'].'&kundenid='.$this->piVars['kundenid'].'&smnr='.$this->piVars['smnr'].'"> E-Mail ansehen</a>';
		}
		
		if ($this->piVars['bereichDetails'] && $this->piVars['smnr']==9) { #dann Fragenüersicht eines Bereichs					
			$html.='<a href="'.$this->indexpath.'&bereichDetails='.$this->piVars['bereichDetails'].'&smnr='.$this->piVars['smnr'].'"> / Unternehmer-Frageb&ouml;gen im Detail</a>';
		}
		
		if ($this->piVars['bereichDetails'] && $this->piVars['smnr']==10) { #dann Fragenüersicht eines Bereichs					
			$html.='<a href="'.$this->indexpath.'&bereichDetails='.$this->piVars['bereichDetails'].'&smnr='.$this->piVars['smnr'].'"> / Mitarbeiter-Frageb&ouml;gen im Detail</a>';
		}
*/		
		return $html;
		
	}
	
	
	
	
	/* $submoduls = array mit strings
		$active = integer des aktiven tabs von 0 bis 2
		$content = der html-inhalt
	*/				
	function getSubmodulNavi($submoduls, $active=0, $content,$class_spec="", $modulenr=1) {
		global $BE_USER;
		$colspan = 0;
		
		$html .= '
		<div class="typo3-dyntabmenu-tabs">
			<table cellpadding="0" cellspacing="0" border="0" class="typo3-dyntabmenu">
				<tr>';
		$anz_submods = count($submoduls);
		while (list ($key, $val) = each ($submoduls)) {
			$x++;
			$navclass = ($key==$active) ? 'tabact': 'tab';		
			$kundenidparam = ($this->piVars['communeid']) ? '&communeid='.$this->piVars['communeid'] : '';
			
			# x kann nciht groesser sein bei red.adm. schule!
			$xgroesser_al = (tx_itaoshhmanager_general::hasRights(1,1) || tx_itaoshhmanager_general::hasRights(2,1)) ? 1 : 0;
			if ($anz_submods > 1 && $x > $xgroesser_al /*|| $modulenr == 5*/) {#1) {
				#t3lib_utility_debug::debug("x=".$x."//anz mod:".$anz_submods);
				$kundenidparam .= ($this->piVars['schoolid']) ? '&schoolid='.$this->piVars['schoolid'] : '';		
			}
			
			$rechte_ist_arr = ($BE_USER->user['usergroup']!="" ) ? explode(",", $BE_USER->user['usergroup']) : array();
			
			if (in_array($this->tsvars['be_groupid_mod_schule'],$rechte_ist_arr ) || $this->myModule == "mod3" || ($this->myModule == "mod2" && $key!=0)) { 
				if (!$this->piVars['schoolid']) {
					$this->piVars['schoolid'] = $BE_USER->user['ref_school'];
				}
				$kundenidparam .= ($this->piVars['schoolid']) ? '&schoolid='.$this->piVars['schoolid'] : '';
			}
			if (in_array($this->tsvars['be_groupid_redadmin_schule'],$rechte_ist_arr )) { 
				if (!$this->piVars['schoolid']) {
					$this->piVars['schoolid'] = $BE_USER->user['ref_school'];
				}
				$kundenidparam .= ($this->piVars['schoolid']) ? '&schoolid='.$this->piVars['schoolid'] : '';
			}
			
			
			#$this->myModule
			#t3lib_utility_debug::debug("key=".$key."//anz mod:".$this->piVars['schoolid']);
			
			$vorschlaege = '&vorschlaege=1';		#($this->piVars['vorschlaege'] ) ?  : ''
			if ($this->piVars['edit_all_stimmen']) {
				$vorschlaege.='&edit_all_stimmen=1';
			}
			$benutzer = '&benutzer=1';
			$benutzer_school = '&benutzer_school=1';
			$benutzeredit = '&benutzeredit=1';
			$offer_detail = '&offerid='.$this->piVars['offerid'];	#($this->piVars['benutzer'] ) ?  : ''
			if ($this->piVars['childingme']) {
				$childingme='&childingme=1';
			}
			$beuser_detail = '&beuser=1';
			$beuser_detail_school = '&beuser_school=1';
#			$bereichDetails = ($this->piVars['bereichDetails'] ) ? '&bereichDetails='.$this->piVars['bereichDetails'] : '';		
			
/*			if (($this->kundenstatus == 1 ||$this->kundenstatus == 3 || $this->kundenstatus == 2) && ($key > 0 )) {	
				$navclass = "disabled";		
				$html.='<td class="'.$navclass.'">';				
				$html.='<span title="Erst nach Freischalten des Fragebogens wird dieser Bereich aktiv geschaltet">'.$val.' (inaktiv)</span>';
			} else {		
*/				
				#t3lib_utility_debug::debug($key."//mymod:".$this->myModule."//");
				$html.='<td class="'.$navclass.'" nowrap="nowrap">';		
				if ($key==3)	{				
					$html.='<a href="'.$this->indexpath.'&smnr='.$key.$kundenidparam.$vorschlaege.'">'.$val.'</a>';
				} elseif ($key==2)	{				
					$html.='<a href="'.$this->indexpath.'&smnr='.$key.$kundenidparam.$benutzer.'">'.$val.'</a>';
				} elseif ($key==22)	{				
					$html.='<a href="'.$this->indexpath.'&smnr='.$key.$kundenidparam.$benutzer_school.'">'.$val.'</a>';
				} elseif ($key==4)	{				
					$html.='<a href="'.$this->indexpath.'&smnr='.$key.$kundenidparam.$offer_detail.'">'.$val.'</a>';
				} elseif ($key==5)	{				
					$html.='<a href="'.$this->indexpath.'&smnr='.$key.$kundenidparam.$beuser_detail.'">'.$val.'</a>';
				} elseif ($key==25)	{		
					$html.='<a href="'.$this->indexpath.'&smnr='.$key.$kundenidparam.$beuser_detail_school.'">'.$val.'</a>';
				} elseif ($key==8)	{				
					$html.='<a href="'.$this->indexpath.'&smnr='.$key.$kundenidparam.$benutzeredit.'">'.$val.'</a>';
				} elseif ($key==15)	{				
					$html.='<a href="'.$this->indexpath.'&smnr='.$key.$kundenidparam.$offer_detail.$childingme.'">'.$val.'</a>';
				} else {
					if (($this->piVars['beuser_school'] ||$this->piVars['benutzer_school'] ||$this->piVars['beuser'] || $this->piVars['benutzeredit'] ) && $key==0  ) {						
						$kundenidparam = ($this->piVars['communeid']) ? '&communeid='.$this->piVars['communeid'] : '';	
					}		
					
					#if ($this->myModule == "mod4" && in_array($this->tsvars['be_groupid_redadmin_schule'],$rechte_ist_arr ) && $key ==1) {
					#	$kundenidparam.='&benutzer_school=1';
					#}
											
					$html.='<a href="'.$this->indexpath.'&smnr='.$key.$kundenidparam.'">'.$val.'</a>';
				}
/*			}*/
			$html.='</td>';						
		}
		$html.='
				</tr>	
			</table>
		</div>';
		#t3lib_utility_debug::debug($this->piVars);
		$vorschl = ($this->piVars['vorschlaege']) ? 'vorschlaege': ''; 
		$html.='
			<div class="typo3-dyntabmenu-divs '.$vorschl.'">
				<div style=" padding: 10px;" id="DTM-xxx-1-DIV" class="c-tablayer">
					'.$content.'
				</div>							
			</div>';
		
		return $html; 
		
	}
	
	
					
							
				
				
				function breadcrumb_fragen_ausgeben() {
/*					global $LANG;
					$zg_bereiche[0] = $LANG->getLL('l_unt_fb');#'Unternehmer-Fragebogen';
					$zg_bereiche[1] = $LANG->getLL('l_ma_fb');#'Mitarbeiter-Fragebogen';
					$this->piVars['smnr'] = ($this->piVars['smnr']) ? $this->piVars['smnr'] : 0 ;
					$html = '<div class="breadcrumb_subm">';
					$html .= '<span class="bg_sp">Sie befinden sich hier: ';
					$html.='<a href="'.$this->indexpath.'&smnr='.$this->piVars['smnr'].'">&Uuml;bersicht '.$zg_bereiche[$this->piVars['smnr']].'</a>';
					
					#1. Ebene Kundenübersicht:
					if ($this->piVars['bereichDetails']) {
						$bereichsdata = tx_itaozfadatamanager_library::getBereich($this->piVars['bereichDetails']);
						$bereichsname = (strlen($bereichsdata['title']) > 25) ? substr($bereichsdata['title'],0,25).'...' : $bereichsdata['title'];
						$html.=' > <a href="'.$this->indexpath.'&smnr='.$this->piVars['smnr'].'&bereichDetails='.$this->piVars['bereichDetails'].'">'.$bereichsname.'</a>';
						
					}
					
					$html.='</span></div>';
					return $html;
*/
				}
	
				
				
}

?>