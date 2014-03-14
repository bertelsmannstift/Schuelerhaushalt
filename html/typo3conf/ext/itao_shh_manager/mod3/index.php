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


$LANG->includeLLFile('EXT:itao_shh_manager/mod3/locallang.xml');
require_once(PATH_t3lib . 'class.t3lib_scbase.php');
$BE_USER->modAccess($MCONF,1);	// This checks permissions and exits if the users has no permission for entry.
	// DEFAULT initialization of a module [END]
require_once(t3lib_extMgm::extPath('itao_shh_manager') . '/lib/general.inc.php');
require_once(t3lib_extMgm::extPath('itao_shh_manager') . '/lib/navigation.inc.php');
require_once(t3lib_extMgm::extPath('itao_shh_manager') . '/lib/database.inc.php');
require_once(t3lib_extMgm::extPath('itao_shh_manager') . '/lib/mail.inc.php');

require_once(t3lib_extMgm::extPath('itao_shh_manager') . '/lib/datamanager_library.inc.php');	
	



/**
 * Module 'SHH Verwaltung' for the 'itao_shh_manager' extension.
 *
 * @author	Edeltraud Gratzer <edeltraud.gratzer@itao.de>
 * @package	TYPO3
 * @subpackage	tx_itaoshhmanager
 */
class  tx_itaoshhmanager_module3 extends t3lib_SCbase {
				var $pageinfo;

				/**
				 * Initializes the Module
				 * @return	void
				 */
				function init()	{
					global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;

					parent::init();

					/*
					if (t3lib_div::_GP('clear_all_cache'))	{
						$this->include_once[] = PATH_t3lib.'class.t3lib_tcemain.php';
					}
					*/
				}

				/**
				 * Adds items to the ->MOD_MENU array. Used for the function menu selector.
				 *
				 * @return	void
				 */
				function menuConfig()	{
					global $LANG;
					$this->MOD_MENU = Array (
						'function' => Array (
							'1' => $LANG->getLL('function1'),
							'2' => $LANG->getLL('function2'),
							'3' => $LANG->getLL('function3'),
						)
					);
					parent::menuConfig();
				}

				/**
				 * Main function of the module. Write the content to $this->content
				 * If you chose "web" as main module, you will need to consider the $this->id parameter which will contain the uid-number of the page clicked in the page tree
				 *
				 * @return	[type]		...
				 */
				function main()	{
					global $BE_USER,$LANG,$BACK_PATH,$TCA_DESCR,$TCA,$CLIENT,$TYPO3_CONF_VARS;

					// Access check!
					// The page will show only if there is a valid page and if this page may be viewed by the user
					$this->pageinfo = t3lib_BEfunc::readPageAccess($this->id,$this->perms_clause);
					$access = is_array($this->pageinfo) ? 1 : 0;
				
						// initialize doc
					$this->doc = t3lib_div::makeInstance('template');
					$this->doc->setModuleTemplate(t3lib_extMgm::extPath('itao_shh_manager') . 'mod3/mod_template.html');
					$this->doc->backPath = $BACK_PATH;
					$docHeaderButtons = $this->getButtons();

#					if (($this->id && $access) || ($BE_USER->user['admin'] && !$this->id))	{

							// Draw the form
						$this->doc->form = '<form action="" method="post" enctype="multipart/form-data">';

							// JavaScript
						$this->doc->JScode = '
							<script language="javascript" type="text/javascript">
								script_ended = 0;
								function jumpToUrl(URL)	{
									document.location = URL;
								}
							</script>
						';
						$this->doc->postCode='
							<script language="javascript" type="text/javascript">
								script_ended = 1;
								if (top.fsMod) top.fsMod.recentIds["web"] = 0;
							</script>
						';
							// Render content: 
							#'
						$this->moduleContent();
/*					} else {
							// If no access or if ID == zero
						$docHeaderButtons['save'] = '';
						$this->content.=$this->doc->spacer(10);
					}
*/
						// compile document
					$markers['FUNC_MENU'] = t3lib_BEfunc::getFuncMenu(0, 'SET[function]', $this->MOD_SETTINGS['function'], $this->MOD_MENU['function']);
					
					/*
                    $kundenid = ($this->piVars['kundenid']) ? $this->piVars['kundenid'] : $_GET['kundenid'];#($_GET['kundenid']) ? $_GET['kundenid'] : $_POST['kundenid'];
                    #t3lib_div::debug("kuid".$kundenid);
                    if (!$kundenid) {
                    	$has_pruefer_rights = 1;
                    } else {
          						$has_pruefer_rights = tx_itaoshhmanager_library::hasRightsPruefer($kundenid);       
          					}
          */
          $has_pruefer_rights = 1;
          					if ($has_pruefer_rights) {   
                    	$markers['BREADCRUMB'] = tx_itaoshhmanager_navigation::breadcrumb_ausgeben($this->MOD_MENU['function'][1]);
                    } else {
                    	$markers['BREADCRUMB'] = '';
                    }
                    $markers['BACK_TO_OVERVIEW_TOP'] = $this->getBackLink($this->MOD_MENU['function'][1]); #"";#
					
					
					$markers['CONTENT'] = $this->content;

							// Build the <body> for the module
					$this->content = $this->doc->startPage($LANG->getLL('title'));
					$this->content.= $this->doc->moduleBody($this->pageinfo, $docHeaderButtons, $markers);
					$this->content.= $this->doc->endPage();
					$this->content = $this->doc->insertStylesAndJS($this->content);
				
				}
				
				
				function getBackLink($func_nr) {
					global $LANG;
					if ($this->piVars['communeid']) {
						$backlink = '
							<a href="/typo3/mod.php?M=txitaoshhmanagerM0_txitaoshhmanagerM3">
								<span class="back_to_overview"> zur&uuml;ck</span>
							</a>';
					} else {
						$backlink = '';
					}				
					return $backlink;					
				}
				
				
				

				/**
				 * Prints out the module HTML
				 *
				 * @return	void
				 */
				function printContent()	{

					$this->content.=$this->doc->endPage();
					echo $this->content;
				}
/*'*/
				/**
				 * Generates the module content
				 *
				 * @return	void
				 */
				function moduleContent()	{
					global $LANG, $BE_USER; #, $_SERVER
					global $_SERVER;							
					
					/*if ($BE_USER->user['admin']) {
						$this->doPageCopyTests();
					}
					*/
					tx_itaoshhmanager_general::loadTypoScriptForBEModule("tx_itaoshhmanager_pi1");
					tx_itaoshhmanager_general::loadTypoScriptForBEModule("tx_itaoshhoffers",1);					
					tx_itaoshhmanager_database::checkNewCommunes();					
					tx_itaoshhmanager_database::checkSchoolsForUsergroups();
					
					$this->indexpath = "/typo3/mod.php?M=txitaoshhmanagerM0_txitaoshhmanagerM3";		
					$this->imagepath = '/typo3/sysext/t3skin/icons/gfx/';	
					$this->imagepath2 = t3lib_extMgm::extRelPath('itao_shh_manager').'layout/images/';
					tx_itaoshhmanager_general::getPiVars();
					
					#CSS includieren
					$this->doc->getPageRenderer()->addCssFile(t3lib_extMgm::extRelPath('itao_shh_manager').'layout/style_be.css');
					$this->doc->getPageRenderer()->addCssFile(t3lib_extMgm::extRelPath('itao_shh_manager').'layout/extra.css'); #von Fabian  
					
					
					### Test für Rechte:
					
					
					switch((string)$this->MOD_SETTINGS['function'])	{
						case 1:
							$this->myModule="mod3";
							#tx_itaoshhmanager_general::hasRights(1,1);
							tx_itaoshhmanager_general::checkRightsStartseite();
							
							# Vorschlaege freigeben abfangen:
							if ($this->piVars['activate'] && $this->piVars['offerid']) {
								tx_itaoshhmanager_database::updateOffer($this->piVars['offerid'],2);
							}
							# Vorschlaege  abweisen abfangen:
							if ($this->piVars['deact'] && $this->piVars['offerid']) {
								tx_itaoshhmanager_database::updateOffer($this->piVars['offerid'],3);
							}
							# Vorschlaege  abweisen abfangen:
							if ($this->piVars['delete_offer'] ) {
								tx_itaoshhmanager_database::deleteOffer($this->piVars['offerid']);
							}
							
							# FE-Benutzer aktivieren/deaktivieren abfangen:
							if ($this->piVars['userdeact'] || $this->piVars['useract']) {
								tx_itaoshhmanager_database::doUserAct($this->piVars['userdeact'],$this->piVars['useract']);
							}
							
							# FE-Benutzer Passwort zurücksetzen:
							if ($this->piVars['pw_original']) {
								tx_itaoshhmanager_database::doPasswordBack($this->piVars['pw_original']);
							}
							
							if ($this->piVars['save_parentoffer']) {
								tx_itaoshhmanager_database::setParentOffer($this->piVars['offerid'], $this->piVars['parentoffer']);
							}
							
							if ($this->piVars['unchainoffer']) {
								tx_itaoshhmanager_database::unchainOffer($this->piVars['offerid'], $this->piVars['unchainoffer']);
							}
							
							
							
						
						
							if ($this->piVars['childingme']) {
								$content=$this->getChildingpage($this->piVars['schoolid'],$this->piVars['offerid']);
							} elseif ($this->piVars['offerid']) {
								$content=$this->getOfferDetailPage($this->piVars['schoolid'],$this->piVars['offerid']);
							} elseif ($this->piVars['edit_all_stimmen']) {
								$content=$this->getOffersPage_stimmenedit($this->piVars['schoolid']);
							} elseif ($this->piVars['vorschlaege']) {
								$content=$this->getOffersPage($this->piVars['schoolid']);
							} elseif ($this->piVars['benutzer']) {
								$content=$this->getBenutzerPage($this->piVars['schoolid']);
							} elseif ($this->piVars['benutzeredit']) {
								$content=$this->getBenutzerEditPage($this->piVars['communeid'],$this->piVars['schoolid']);
							} elseif ($this->piVars['beuser']) {
								$content=$this->getBeUserPage($this->piVars['communeid'],$this->piVars['schoolid']);
							} elseif ($this->piVars['schoolid']) {								
								$content=$this->getSchoolDetailsPage($this->piVars['schoolid']);
							} elseif ($this->piVars['communeid']) {
								$content=$this->getCommuneDetailsPage($this->piVars['communeid']);
							} else {
								$content=$this->getCommunePage();
							}
							
							$this->content.=$this->doc->section('',$content,0,1);
						break;
						case 2:
							$content='<div align=center><strong>Menu item #2...</strong></div>';
							$this->content.=$this->doc->section('Message #2:',$content,0,1);
						break;
						case 3:
							$content='<div align=center><strong>Menu item #3...</strong></div>';
							$this->content.=$this->doc->section('Message #3:',$content,0,1);
						break;
					}
				}
				
				/**
				  * 1. Ebene - oberer Teil
				  * Hier wird die Startseite zusammengesetzt und ausgegeben: Übersicht aller eingetragenen Kommunen
				  */
				function getCommunePage() {
					global $LANG, $BE_USER;					
					$markerArray_th['###CLASS_DISPLAY###'] = (tx_itaoshhmanager_general::hasRights(1,3)) ? '' : 'display_none';
					$markerArray['###TH_HEADER###'] = tx_itaoshhmanager_library::template_ausgeben($markerArray_th, 'TEMPLATE_TABLEHEADER', 'layout/be_template_mod3.html');		
					$markerArray['###IMAGEPATH###'] = $this->imagepath;	
					$markerArray['###INDEXPATH###'] = $this->indexpath;
					#$locat = $this->indexpath;
					$locat = urlencode('mod.php?M=txitaoshhmanagerM0_txitaoshhmanagerM3');
					$markerArray['###JS_EDIT###'] = tx_itaoshhmanager_library::js_fuer_ds_bearbeiten($locat);
					
					/* fuer NEU_link:*/			
					# db_mountpoints
					$newCommPageUid = $this->tsvars['pid_kommunen'];
					if (!$BE_USER->user['admin']) {
						$seitenrechte = $BE_USER->user['db_mountpoints'];
						$sr_arr = explode(",",$seitenrechte); 
						
						$newCommPageUid = ($sr_arr[0] > 0) ? $sr_arr[0] : $this->tsvars['pid_kommunen'];
					}
					#$newCommPageUid = $communedata['ref_communepage'];
					$markerArray['###NEW_COMM_LINK###'] = tx_itaoshhmanager_general::getNewLink($LANG->getLL('l_newKunde'), 'tx_itaoshhmanager_communes', $newCommPageUid ,array(), array(),1);
					
					$markerArray['###COMMUNES_ROWS###'] = $this->getCommunesOverviewTable();
					
					$html = utf8_encode(tx_itaoshhmanager_library::template_ausgeben($markerArray, 'TEMPLATE_COMMUNE_STARTPAGE', 'layout/be_template_mod3.html'));
					return $html;
				}
				
				
				
				/**
				  * 1. Ebene - unterer Teil
				  * Hier wird die Übersichtstabelle der Kommunen generiert (für Startseite Kommunen)
				  */
				function getCommunesOverviewTable() {
					global $LANG;
					$allCommunes = tx_itaoshhmanager_database::getAllCommunes();
					
					while (list ($key, $val) = each ($allCommunes)) {
						$markerArray_td['###COMMUNEID###'] = $val['uid'];						
						$markerArray_td['###INDEXPATH###'] = $this->indexpath;
						$markerArray_td['###COMMUNE_NAME###'] = utf8_decode($val['titel']);						
						
						$allSchools = tx_itaoshhmanager_database::getAllSchoolsByCommune($val['uid']);
						$markerArray_td['###REFED_SCHOOLS###'] = '';
						if (is_array($allSchools)) {
							while (list ($key2, $val2) = each ($allSchools)) {
								$ma_schools['###SC_TITLE###'] = $val2['title'];
								$ma_schools['###SC_ORT###'] = ($val2['city']!="") ? ' ('.$val2['city'].')': '';
								$ma_schools['###INDEXPATH###'] = $this->indexpath;
								$ma_schools['###COMMUNEID###'] = $val['uid'];
								$ma_schools['###SCHOOLID###'] = $val2['uid'];
								
								
								if (tx_itaoshhmanager_general::hasRights(2,1)) {
									$markerArray_td['###REFED_SCHOOLS###'] .= utf8_decode(tx_itaoshhmanager_library::template_ausgeben($ma_schools, 'TEMPLATE_REFED_SCHOOLS', 'layout/be_template_mod3.html'));
								} else {
									$markerArray_td['###REFED_SCHOOLS###'] .= utf8_decode(tx_itaoshhmanager_library::template_ausgeben($ma_schools, 'TEMPLATE_REFED_SCHOOLS_NORIGHTS', 'layout/be_template_mod3.html'));
								}
							}
						} else {
							$markerArray_td['###REFED_SCHOOLS###'] = '';
						}
						
						#$markerArray_td['###EDIT_COMMUNE_LINK###'] = tx_itaoshhmanager_general::getEditLink($LANG->getLL('l_editCommune'), 'tx_itaoshhmanager_communes', $val['uid'],array(), array(),1);	
						
					
						$markerArray_td['###CLASS_DISPLAY###'] = (tx_itaoshhmanager_general::hasRights(1,3)) ? '' : 'display_none';
											
						$html.= tx_itaoshhmanager_library::template_ausgeben($markerArray_td, 'TEMPLATE_TABLEROWS_COMMUNES', 'layout/be_template_mod3.html');
					}
					return $html;
				}
				
				
				
				
				/**
				  * 2. Ebene - oberer Teil
				  * Hier wird die Detailseite der ausgewaehlten Kommune zusammengesetzt / generiert
				  */
				function getCommuneDetailsPage($communeid) {
					global $LANG, $BE_USER;
					$GLOBALS["BE_USER"]->setAndSaveSessionData ('search_value', "");
					$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);
					$ma['###COMMUNE_TITLE###'] = $communedata['titel'];
					# BL, Impressum, contactperson, infotext, headerimage, welcome-text, donwload, youtubelink downloadurl
					
					# Komm.-Details und dann die Schulen = 
					# neu-Link:
					$tca_params = array("communeid" => $communeid);
					$back_params = $tca_params;
					#t3lib_utility_debug::debug($this->id);
					$ma_det_sc['###DISPLAY_CLASS_NEW_SCHOOL###'] = (tx_itaoshhmanager_general::hasRights(2,2)) ? '' : 'display_none';
					
					/*if (!$BE_USER->user['admin']) {
						$seitenrechte = $BE_USER->user['db_mountpoints'];
						$sr_arr = explode(",",$seitenrechte); 
						#t3lib_utility_debug::debug($sr_arr );
						$newCommPageUid = $sr_arr[0];
					} else {
						$newCommPageUid = $this->tsvars['pid_kommunen'];
					}*/
					$newCommPageUid = $communedata['ref_communepage'];
					$ma_det_sc['###NEW_SCHOOL_LINK###'] = tx_itaoshhmanager_general::getNewLink($LANG->getLL('l_newSchool'), 'tx_itaoshhmanager_schools', $newCommPageUid,$tca_params, $back_params,1);
					#t3lib_utility_debug::debug("has rights:".tx_itaoshhmanager_general::hasRights(2,2)."//display: ".$ma_det_sc['###DISPLAY_CLASS_NEW_SCHOOL###']);
					$locat = urlencode('mod.php?M=txitaoshhmanagerM0_txitaoshhmanagerM3');
					$ma_det_sc['###JS_EDIT###'] = tx_itaoshhmanager_library::js_fuer_ds_bearbeiten($locat);
					$markerArray_th['###CLASS_DISPLAY###'] = (tx_itaoshhmanager_general::hasRights(2,3)) ? '' : 'display_none';
					$ma_det_sc['###TH_HEADER_SCHOOLS###'] = tx_itaoshhmanager_library::template_ausgeben($markerArray_th, 'TEMPLATE_TABLEHEADER_SC', 'layout/be_template_mod3.html');	
					$ma_det_sc['###SCHOOLS_ROWS###'] = $this->getSchoolOverviewTable($communeid);			
					$ma_det_sc['###IMAGEPATH###'] = $this->imagepath;	
					$ma_det_sc['###NEW_SCHOOL_LABEL###'] = $LANG->getLL('l_newSchool');		
					
					### Rechtecheck:
					if (tx_itaoshhmanager_general::hasRights(1,3)) {
						$ma_det_sc['###EDIT_COMMUNE_LINK###'] = tx_itaoshhmanager_general::getEditLink($LANG->getLL('l_editCommune'), 'tx_itaoshhmanager_communes', $communeid,array(), $back_params,1,$LANG->getLL('l_editCommune'));	
					} else {
						$ma_det_sc['###EDIT_COMMUNE_LINK###'] = '';
					}					
						
					$html = tx_itaoshhmanager_library::template_ausgeben($ma_det_sc, 'TEMPLATE_SCHOOL_OVERVIEWTABLE', 'layout/be_template_mod3.html');	
					
					
					$html_oben =  tx_itaoshhmanager_library::template_ausgeben($ma, 'TEMPLATE_COMMUNE_DETAILPAGE', 'layout/be_template_mod3.html');
					/*
					$submoduls = array mit strings
					$active = integer des gerade aktiven tabs von 0 bis 2
					$content = der html-inhalt*/
					
					$submoduls[0] = "Auswahl Schule";#$LANG->getLL('submodule_commune');#'Allgemeines zur Kommune';	
/*					if (tx_itaoshhmanager_general::hasRights(4,2)) {
						$submoduls[2] = $LANG->getLL('submodule_school_user');
						
						# neu: für FE-User bearbeiten 
#						$submoduls[8] = $LANG->getLL('submodule_school_editfeuser');
					}	
					if (tx_itaoshhmanager_general::hasRights(5,2)) {
						$submoduls[5] = $LANG->getLL('submodule_school_beuser');
					}
*/					
					$active = 0;
					$html = $html_oben .$breadcrumb. tx_itaoshhmanager_navigation::getSubmodulNavi($submoduls,$active, $html, 'long');
					return $html;
				}
				
				
				/**
				  * 2. Ebene - unterer Teil
				  * Hier wird die Übersichtstabelle der Schulen generiert, die der ausgewaehlten Kommune zugeordnet sind
				  */
				function getSchoolOverviewTable($communeid) {
					global $LANG;
					$allSchools = tx_itaoshhmanager_database::getAllSchoolsByCommune($communeid);
					$allPhasenSchool = tx_itaoshhmanager_database::getAllPhasen();
					if (is_array($allSchools)) {
						while (list ($key, $val) = each ($allSchools)) {
							$allOffers = tx_itaoshhmanager_database::getAllOffersBySchool($val['uid']);
							$allOffersByState = tx_itaoshhmanager_database::getAllOffersBySchool($val['uid'],1);
							$markerArray_td['###SCHOOLID###'] = $val['uid'];
							#$markerArray_td['###COMMUNEID###'] = $communeid;							
							#$markerArray_td['###INDEXPATH###'] = $this->indexpath;
							
							#$markerArray_td['###CLASS_DISPLAY###'] = (tx_itaoshhmanager_general::hasRights(2,3)) ? '' : 'display_none';
							if (tx_itaoshhmanager_general::hasRights(2,3) || tx_itaoshhmanager_general::hasRights(2,1)) {
								$markerArray_td['###SCHOOL_NAME###'] = '<a href="'.$this->indexpath.'&communeid='.$communeid.'&schoolid='.$val['uid'].'&vorschlaege=1" title="zu den Details der Schule">';
								$markerArray_td['###SCHOOL_NAME###'] .= $val['title'].'</a>';
							} else {
								$markerArray_td['###SCHOOL_NAME###'] = $val['title'];
							}
							#$markerArray_td['###SCHOOL_NAME###'] = $val['title'];
							$markerArray_td['###STATUS_LABEL###'] = $allPhasenSchool[$val['ref_status']]['title'];
							$markerArray_td['###STATUS_IMAGE###'] = $allPhasenSchool[$val['ref_status']]['st_image'];
							
							$markerArray_td['###ANZ_ARTIKEL_GESAMT###'] = count($allOffers);
							$markerArray_td['###ANZ_NEUE_ART###'] = count($allOffersByState[1]);
							
							$markerArray_td['###ANZ_USER_GES###'] = tx_itaoshhmanager_database::getAnzAccountBySchool($val['uid']);
							$markerArray_td['###REG_USERANZ###'] = tx_itaoshhmanager_database::getAnzAccountBySchool($val['uid'],1);
													
							
							$back_params = array("communeid" => $communeid);
							$markerArray_td['###EDIT_SCHOOL_LINK###'] = tx_itaoshhmanager_general::getEditLink($LANG->getLL('l_editSchool'), 'tx_itaoshhmanager_schools', $val['uid'],array(), $back_params,1);
							
							$markerArray_td['###CLASS_DISPLAY###'] = (tx_itaoshhmanager_general::hasRights(2,3)) ? '' : 'display_none';
							$html.= tx_itaoshhmanager_library::template_ausgeben($markerArray_td, 'TEMPLATE_TABLEROWS_SCHOOLS', 'layout/be_template_mod3.html');
						}
					} else {
						$html = utf8_encode(tx_itaoshhmanager_library::template_ausgeben($markerArray_td, 'TEMPLATE_NO_SCHOOLS_TABLE', 'layout/be_template_mod3.html'));
					}
					return $html;
				}
				
				
				/**
				  * 3. Ebene
				  * Hier werden Detailseite für die ausgewählte Schule, die Artikel- und die Nutzerseite zusammengesetzt / generiert
				  */
				function getSchoolDetailsPage($schoolid) {
					global $LANG, $BE_USER;
					$GLOBALS["BE_USER"]->setAndSaveSessionData ('search_value', "");
					$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
					$communeid = $schooldata['ref_commune'];
					$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);
					$allPhasenSchool = tx_itaoshhmanager_database::getAllPhasen();
					#$html = ;
					$ma['###SCHOOL_TITLE###'] = $schooldata['title'];
					$ma['###SC_ORT###'] = ($schooldata['city']!="") ? '('.$schooldata['city'].')' : '';
					
					$ma_det_sc['###SCHOOL_TITLE###'] = $schooldata['title'];
					$ma_det_sc['###SC_ZIP###'] = $schooldata['zip'];
					$ma_det_sc['###SC_CITY###'] = $schooldata['city'];
					$ma_det_sc['###SC_WELCOMETEXT###'] = $schooldata['welcometext'];
					$ma_det_sc['###SC_CONTACT###'] = $schooldata['ref_contactperson'];
					$ma_det_sc['###SC_RESULT###'] = $schooldata['resultpage'];
					$ma_det_sc['###SC_STATUS###'] = $schooldata['ref_status'];
					$ma_det_sc['###STATUS_LABEL###'] = $allPhasenSchool[$schooldata['ref_status']]['title'];
					$ma_det_sc['###STATUS_IMAGE###'] = $allPhasenSchool[$schooldata['ref_status']]['st_image'];
					
					$ma_det_sc['###BOX_VORBEREITUNG###'] = $this->getBoxBaseVorbereitung($schoolid);
					$ma_det_sc['###BOX_ONLINE###'] = $this->getBoxBaseOnline($schoolid);
					$ma_det_sc['###BOX_ERGEBNIS###'] = $this->getBoxBaseErgebnis($schoolid);
					$ma_det_sc['###SIDEBOX###'] = $this->getSidebox($schoolid);
					
					$html = tx_itaoshhmanager_library::template_ausgeben($ma_det_sc, 'TEMPLATE_SCHOOL_DETAIL_CONTENT', 'layout/be_template_mod3.html');	
					
					
					
					$ma['###COMMUNE_TITLE###'] = $communedata['titel'];
					$locat = urlencode('mod.php?M=txitaoshhmanagerM0_txitaoshhmanagerM3');
					$ma['###JS_EDIT###'] = tx_itaoshhmanager_library::js_fuer_ds_bearbeiten($locat);
					$html_oben =  tx_itaoshhmanager_library::template_ausgeben($ma, 'TEMPLATE_SCHOOL_DETAILPAGE', 'layout/be_template_mod3.html');
					/*
					$submoduls = array mit strings
					$active = integer des gerade aktiven tabs von 0 bis 2
					$content = der html-inhalt*/
					
					$xmod = 0;
					if (tx_itaoshhmanager_general::hasRights(1,1)) { # wenn jemand die Komune ansehen darf
						$submoduls[0] = $LANG->getLL('submodule_commune');#
						$xmod++;
					}
					$submoduls[1] = $LANG->getLL('submodule_school');
					#if ((!tx_itaoshhmanager_general::isInBeUserGroup($BE_USER->user['usergroup'], $this->tsvars['be_groupid_redadmin_kommune']) || $BE_USER->user['admin']) && $schoolid > 0) {
					if (tx_itaoshhmanager_general::hasRights(4,2) ) {
						$submoduls[2] = $LANG->getLL('submodule_school_user');
						
						# neu: für FE-User bearbeiten 
#						$submoduls[8] = $LANG->getLL('submodule_school_editfeuser');
					}
					# für Red.Admin kommune NICHT anzeigen, wenn in Schule
					if ((tx_itaoshhmanager_general::isInBeUserGroup($BE_USER->user['usergroup'], $this->tsvars['be_groupid_redadmin_kommune'])) && $schoolid > 0 && !$BE_USER->user['admin']) {
						unset($submoduls[2]);
					}
					
					if (tx_itaoshhmanager_general::hasRights(3,4)) {
						$submoduls[3] = $LANG->getLL('submodule_school_article');
					}
					
					if (tx_itaoshhmanager_general::hasRights(5,2)  || tx_itaoshhmanager_general::hasRights(6,2)) {
						$submoduls[5] = $LANG->getLL('submodule_school_beuser');
					}
					
					if (tx_itaoshhmanager_general::hasRights(7,3)) {
#!#!#						$submoduls[8] = $LANG->getLL('submodule_school_editfeuser');
					}
					$active = 1; 
					$html = $html_oben .$breadcrumb. tx_itaoshhmanager_navigation::getSubmodulNavi($submoduls,$active, $html, 'long');
					return $html;
				}
				
				
				
	
				function getBoxBaseVorbereitung($schoolid) {
					global $LANG;
					$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
					$schulstatus = $schooldata['ref_status'];
					$markerArray['###BOXTOPIC###'] = 'vorbereitung';
					$markerArray['###BOXHEADER###'] = $LANG->getLL('l_vorbereitung');	 #'Vorbereitung';
					$markerArray['###ACTIVITY###'] = ($schulstatus==1) ? '' : 'inaktivschl';
					$markerArray['###BOXCONTENT_CLASS###'] = ($schulstatus==1) ? 'boxcontent' : 'content_zu';					
					$markerArray['###EDITHEADER###'] = '';		
							
					$markerArray['###STATUS_BEZ###'] = ($schulstatus == 1) ? $LANG->getLL('l_status_running'):  $LANG->getLL('l_status_finished');					
					$markerArray['###STATUS_ERH_CLASS###'] .= ($schulstatus == 1) ? 'actstateclass_2' : 'actstateclass_4';		
					#$disable_stoppen = ($schulstatus == 1) ? '' : ' disabled="disabled" ';
					$markerArray['###BOXBODY###'] = $this->getBoxBodyVorbereitung($schoolid);
					
					$html = tx_itaoshhmanager_library::template_ausgeben($markerArray, 'BOX_BASIC', 'layout/be_template_mod3.html');
					
					return $html;
				}
				
				function getBoxBodyVorbereitung($schoolid) {
					$html = tx_itaoshhmanager_library::template_ausgeben($markerArray, 'BOX_BODY_VORBEREITUNG', 'layout/be_template_mod3.html');
					#$html .= tx_itaoshhmanager_library::template_ausgeben($markerArray, 'BOX_JS', 'layout/be_template_mod3.html');
					return $html;
				}
				
				function getBoxBaseOnline($schoolid) {
					global $LANG;
					$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
					$schulstatus = $schooldata['ref_status'];
					$markerArray['###BOXTOPIC###'] = 'online';
					$markerArray['###BOXHEADER###'] = $LANG->getLL('l_online');	 #'Vorbereitung';
					$markerArray['###ACTIVITY###'] = ($schulstatus==2) ? '' : 'inaktivschl';
					$markerArray['###BOXCONTENT_CLASS###'] = ($schulstatus==2) ? 'boxcontent' : 'content_zu';					
					$markerArray['###EDITHEADER###'] = '';		
							
					$markerArray['###STATUS_BEZ###'] = ($schulstatus < 2) ? $LANG->getLL('l_status_notstarted'):  $LANG->getLL('l_status_running');	
					$markerArray['###STATUS_BEZ###'] = ($schulstatus > 2) ? $LANG->getLL('l_status_finished'):  $markerArray['###STATUS_BEZ###'];					
					$markerArray['###STATUS_ERH_CLASS###'] = ($schulstatus < 2) ? 'actstateclass_1' : 'actstateclass_2';				
					$markerArray['###STATUS_ERH_CLASS###'] = ($schulstatus > 2) ? 'actstateclass_4' : $markerArray['###STATUS_ERH_CLASS###'];		
					#$disable_stoppen = ($schulstatus == 1) ? '' : ' disabled="disabled" ';
					$markerArray['###BOXBODY###'] = $this->getBoxBodyOnline($schoolid);
					
					$html = tx_itaoshhmanager_library::template_ausgeben($markerArray, 'BOX_BASIC', 'layout/be_template_mod3.html');
					
					return $html;
				}
				
				function getBoxBodyOnline($schoolid) {
					$html = tx_itaoshhmanager_library::template_ausgeben($markerArray, 'BOX_BODY_ONLINE', 'layout/be_template_mod3.html');
					#$html .= tx_itaoshhmanager_library::template_ausgeben($markerArray, 'BOX_JS', 'layout/be_template_mod3.html');
					return $html;
				}
				
				
				
				function getBoxBaseErgebnis($schoolid) {
					global $LANG;
					$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
					$schulstatus = $schooldata['ref_status'];
					$markerArray['###BOXTOPIC###'] = 'ergebnis';
					$markerArray['###BOXHEADER###'] = $LANG->getLL('l_ergebnis');	 #'Vorbereitung';
					$markerArray['###ACTIVITY###'] = ($schulstatus==3) ? '' : 'inaktivschl';
					$markerArray['###BOXCONTENT_CLASS###'] = ($schulstatus==3) ? 'boxcontent' : 'content_zu';					
					$markerArray['###EDITHEADER###'] = '';		
							
					$markerArray['###STATUS_BEZ###'] = ($schulstatus < 3) ? $LANG->getLL('l_status_notstarted'):  $LANG->getLL('l_status_running');	
					$markerArray['###STATUS_BEZ###'] = ($schulstatus > 3) ? $LANG->getLL('l_status_finished'):  $markerArray['###STATUS_BEZ###'];									
					$markerArray['###STATUS_ERH_CLASS###'] = ($schulstatus < 3) ? 'actstateclass_1' : 'actstateclass_2';									
					$markerArray['###STATUS_ERH_CLASS###'] = ($schulstatus > 3) ? 'actstateclass_4' : $markerArray['###STATUS_ERH_CLASS###'];			
					#$disable_stoppen = ($schulstatus == 1) ? '' : ' disabled="disabled" ';
					$markerArray['###BOXBODY###'] = $this->getBoxBodyErgebnis($schoolid);
					
					$html = tx_itaoshhmanager_library::template_ausgeben($markerArray, 'BOX_BASIC', 'layout/be_template_mod3.html');
					
					return $html;
				}
				
				
				function getBoxBodyErgebnis($schoolid) {
					$html = tx_itaoshhmanager_library::template_ausgeben($markerArray, 'BOX_BODY_ERGEBNIS', 'layout/be_template_mod3.html');
					$html .= tx_itaoshhmanager_library::template_ausgeben($markerArray, 'BOX_JS', 'layout/be_template_mod3.html');
					return $html;
				}
				
				
				function getSidebox($schoolid) {
					global $LANG;
					$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
					$communeid = $schooldata['ref_commune'];
					$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);
					$allPhasenSchool = tx_itaoshhmanager_database::getAllPhasen();
					
					$ma_det_sc['###SCHOOL_TITLE###'] = $schooldata['title'];
					$ma_det_sc['###SC_ZIP###'] = $schooldata['zip'];
					$ma_det_sc['###SC_CITY###'] = $schooldata['city'];
					$ma_det_sc['###SC_WELCOMETEXT###'] = $schooldata['welcometext'];
					$ma_det_sc['###SC_CONTACT###'] = $schooldata['ref_contactperson'];
					$ma_det_sc['###SC_RESULT###'] = $schooldata['resultpage'];
					$back_params = array("communeid" => $communeid, "schoolid" => $schoolid);
					$ma_det_sc['###EDITLINK###'] = tx_itaoshhmanager_general::getEditLink("".$LANG->getLL('l_editSchool'), 'tx_itaoshhmanager_schools', $schoolid,array(), $back_params,1,$LANG->getLL('l_edit'));
					$html .= tx_itaoshhmanager_library::template_ausgeben($ma_det_sc, 'SIDEBOX_SCHOOL', 'layout/be_template_mod3.html');
					return $html;
				}
				
				
				
				
				
				/**
				  * 4. Ebene
				  * Hier wird eine Oberfläche generiert, auf der man für die ausgewählte Schule FE-Benutzer anlegen kann
				  */
				function getBenutzerPage($schoolid) {
					global $LANG, $BE_USER;
					$GLOBALS["BE_USER"]->setAndSaveSessionData ('search_value', "");
					$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
					$communeid = $this->piVars['communeid']; #$schooldata['ref_commune'];
					$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);
					
					# Content über Tabs:
					#$ma['###SCHOOL_TITLE###'] = $schooldata['title'];
					#$ma['###SC_ORT###'] = ($schooldata['city']!="") ? '('.$schooldata['city'].')' : '';
					$ma['###SCHOOL_TITLE###'] = ($schooldata['title']=="" ) ? $communedata['titel'] : $schooldata['title'];
					$ma['###SC_ORT###'] = ($schooldata['city']!="") ? '('.$schooldata['city'].')' : '';
					$locat = urlencode('mod.php?M=txitaoshhmanagerM0_txitaoshhmanagerM3');
					$ma['###JS_EDIT###'] = tx_itaoshhmanager_library::js_fuer_ds_bearbeiten($locat);
					$html_oben =  tx_itaoshhmanager_library::template_ausgeben($ma, 'TEMPLATE_USER_DETAILPAGE', 'layout/be_template_mod3.html');

					# Content im Tab
					
					#t3lib_utility_debug::debug($BE_USER->user['usergroup']."//".$this->tsvars['be_groupid_techadmin']);
					if ((tx_itaoshhmanager_general::isInBeUserGroup($BE_USER->user['usergroup'], $this->tsvars['be_groupid_techadmin']) || 
							tx_itaoshhmanager_general::isInBeUserGroup($BE_USER->user['usergroup'], $this->tsvars['be_groupid_redadmin_kommune'])) 
							&& $schoolid == 0) {
						$ma_det_sc['###BOX_VERWALTUNG_KOMMUNE###'] = $this->getBoxBaseVerwKommune($schoolid,$this->tsvars['groupid_verw_kommune'],$communeid);
						$ma_det_sc['###BOX_MODERATION_KOMMUNE###'] = $this->getBoxBaseVerwKommune($schoolid,$this->tsvars['groupid_mod_kommune'],$communeid);
					} else {
						$ma_det_sc['###BOX_VERWALTUNG_KOMMUNE###'] = "";
						$ma_det_sc['###BOX_MODERATION_KOMMUNE###'] = "";
					}
					if ((!tx_itaoshhmanager_general::isInBeUserGroup($BE_USER->user['usergroup'], $this->tsvars['be_groupid_redadmin_kommune']) || $BE_USER->user['admin']) && $schoolid > 0) {
						$ma_det_sc['###BOX_VERWALTUNG_SCHULE###'] = $this->getBoxBaseVerwKommune($schoolid,$this->tsvars['groupid_verw_schule']);
						$ma_det_sc['###BOX_SCHUELERVERTRETUNG###'] = $this->getBoxBaseVerwKommune($schoolid,$this->tsvars['groupid_schuelervertretung']);
						$ma_det_sc['###BOX_SCHUELER###'] = $this->getBoxBaseVerwKommune($schoolid,$this->tsvars['groupid_schueler']);
						$ma_det_sc['###BOX_MODERATION_SCHULE###'] = $this->getBoxBaseVerwKommune($schoolid,$this->tsvars['groupid_mod_schule']);
					} else {
						$ma_det_sc['###BOX_VERWALTUNG_SCHULE###'] = "";
						$ma_det_sc['###BOX_SCHUELERVERTRETUNG###'] = "";
						$ma_det_sc['###BOX_SCHUELER###'] = "";
						$ma_det_sc['###BOX_MODERATION_SCHULE###'] = "";
					}
					#$ma_det_sc['###BOX_MODERATION_GAST###'] = $this->getBoxBaseVerwKommune($schoolid,$this->tsvars['groupid_gast']);
					$ma_det_sc['###SIDEBOX###'] = $this->getSideboxUser($schoolid);
					
					$html = tx_itaoshhmanager_library::template_ausgeben($ma_det_sc, 'TEMPLATE_USER_DETAIL_CONTENT', 'layout/be_template_mod3.html');	
					
					
					
					# fuer Tabs
					
					if (tx_itaoshhmanager_general::hasRights(1,1)) { # wenn jemand die Komune ansehen darf
						$submoduls[0] = $LANG->getLL('submodule_commune');
					}
					if ($schoolid > 0) {
						$submoduls[1] = $LANG->getLL('submodule_school');
					}
					$submoduls[2] = $LANG->getLL('submodule_school_user');
						
					if (tx_itaoshhmanager_general::hasRights(3,4) && $schoolid > 0) {
						$submoduls[3] = $LANG->getLL('submodule_school_article');
					}
					if (tx_itaoshhmanager_general::hasRights(5,2)  || tx_itaoshhmanager_general::hasRights(6,2)) {
						$submoduls[5] = $LANG->getLL('submodule_school_beuser');
					}
					
					# neu: für FE-User bearbeiten 
					if (tx_itaoshhmanager_general::hasRights(7,3) && $schoolid > 0) {
#!#!#						$submoduls[8] = $LANG->getLL('submodule_school_editfeuser');
					}
					$active = 2;
					$html = $html_oben .$breadcrumb. tx_itaoshhmanager_navigation::getSubmodulNavi($submoduls,$active, $html, 'long');
					$html .= tx_itaoshhmanager_library::template_ausgeben($markerArray, 'BOX_JS', 'layout/be_template_mod3.html');
					return $html;
				}
				
				
				
				function getBoxBaseVerwKommune($schoolid, $groupid,$communeid = 0) {					
					global $LANG;
					#t3lib_utility_debug::debug($communeid);
					$allGroups = tx_itaoshhmanager_database::getAllUsergroups();
					$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
					$schulstatus = $schooldata['ref_status'];
					$topics[$this->tsvars['groupid_verw_kommune']] = 'verwkommune';
					$topics[$this->tsvars['groupid_verw_schule']] = 'verwschule';
					$topics[$this->tsvars['groupid_schuelervertretung']] = 'schuelervertretung';
					$topics[$this->tsvars['groupid_schueler']] = 'schueler';
					$topics[$this->tsvars['groupid_mod_kommune']] = 'modkommune';
					$topics[$this->tsvars['groupid_mod_schule']] = 'modschule';
					$topics[$this->tsvars['groupid_gast']] = 'gast';
					$markerArray['###BOXTOPIC###'] = $topics[$groupid]; #'verwkommune';
					$markerArray['###BOXHEADER###'] = $LANG->getLL('l_rolle');	
					$markerArray['###ACTIVITY###'] = '';
					$markerArray['###BOXCONTENT_CLASS###'] = 'boxcontent';			
					$markerArray['###EDITHEADER###'] = '';									
					$markerArray['###STATUS_BEZ###'] = $allGroups[$groupid]['title'];	
					$markerArray['###STATUS_ERH_CLASS###'] .= 'actstateclass_2' ;		
					$markerArray['###BOXBODY###'] = $this->getBoxBodyVerwKommune($schoolid,$groupid,$communeid);					
					$html = tx_itaoshhmanager_library::template_ausgeben($markerArray, 'BOX_BASIC', 'layout/be_template_mod3.html');					
					return $html;
				}
				
				function getBoxBodyVerwKommune($schoolid,$groupid,$communeid2 = 0) {
					global $LANG; global $_SERVER;
					$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
					$communeid = ($communeid2 > 0) ? $communeid2 : $schooldata['ref_commune'];
					$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);
					
					# Accounts generieren
					if ($_POST['anz_acc_'.$groupid]) {
						$success_genacc = tx_itaoshhmanager_database::generateAccounts($groupid,$_POST['anz_acc_'.$groupid],$schoolid,$schooldata);
						if ($success_genacc) {
							tx_itaoshhmanager_general::generateFlashMessage($LANG->getLL('account_header_1'), $LANG->getLL('account_text_1a').$_POST['anz_acc_1'].$LANG->getLL('account_text_1b'),1);
						} else {
							tx_itaoshhmanager_general::generateFlashMessage($LANG->getLL('account_header_0'), $LANG->getLL('account_text_0'),0);
						}
					}	
					
					# Accounts (PDF) updaten
					if ($_GET['anz_acc_upd_'.$groupid]) {						
						$pdf_generated = tx_itaoshhmanager_pdfgenerator::generateUserPDF($groupid, $schoolid,$schooldata);
						tx_itaoshhmanager_general::generateFlashMessage($LANG->getLL('account_upd_header_1'), $LANG->getLL('account_upd_text_1'),1);						
					}	
					$templPart = 'BOX_BODY_VERW_KOMMUNE';
					$ma['###GROUPID###'] = $groupid;
					$markerArray['###GENERATE_ACCOUNTS###'] = tx_itaoshhmanager_library::template_ausgeben($ma, 'TEMPL_GENERATE_ACCOUNTS', 'layout/be_template_mod3.html');									
					$markerArray['###FORM_ACTION_GENACC###'] = $this->indexpath.'&communeid='.$communeid.'&schoolid='.$schoolid.'&benutzer=1';
					
					$allUsers[$groupid] = tx_itaoshhmanager_database::getAllUsersBySchool($schoolid, $groupid,0);
					$markerArray['###ANZ_VERWKOMMUNE###'] = count($allUsers[$groupid]);
					$allUsersReg[$groupid] = tx_itaoshhmanager_database::getAllUsersBySchool($schoolid, $groupid,1);
					$markerArray['###ANZ_VERWKOMMUNE_REG###'] = count($allUsersReg[$groupid]);
					
					# Download-Link:
					if ($groupid!= $this->tsvars['groupid_verw_kommune'] && $groupid!= $this->tsvars['groupid_mod_kommune'] ) {
						$pdfdateiname = "zugangsdaten_s".$schoolid."-".$groupid.".pdf";	
					} else {
						$pdfdateiname = "zugangsdaten_c".$communeid."-".$groupid.".pdf";	
					}
					if (is_file($_SERVER['DOCUMENT_ROOT']."/".$this->tsvars['accountpath'].$pdfdateiname)) {
						$ma_dl['###PFAD_DOWNLOAD###'] = 'http://'.$_SERVER['HTTP_HOST']."/".$this->tsvars['accountpath'].$pdfdateiname;
						$markerArray['###DOWNLOAD_ACCOUNTS###'] = tx_itaoshhmanager_library::template_ausgeben($ma_dl,'TEMP_DOWNLOAD_ACCOUNTS','layout/be_template_mod3.html');
						
						$ma_upd['###PFAD_UPDATE_FEACCOUNTS###'] = $this->indexpath.'&communeid='.$communeid.'&schoolid='.$schoolid.'&benutzer=1&anz_acc_upd_'.$groupid.'=1';
						$markerArray['###UPDATE_ACCOUNTS###'] = tx_itaoshhmanager_library::template_ausgeben($ma_upd,'TEMP_UPDATE_ACCOUNTS','layout/be_template_mod3.html');
					} else {						
						$markerArray['###DOWNLOAD_ACCOUNTS###'] = "";#" [noch kein PDF vorhanden]";
						$markerArray['###UPDATE_ACCOUNTS###'] = "";
					}
					
					$html = tx_itaoshhmanager_library::template_ausgeben($markerArray,$templPart , 'layout/be_template_mod3.html');
					#$html .= tx_itaoshhmanager_library::template_ausgeben($markerArray, 'BOX_JS', 'layout/be_template_mod3.html');
					return $html;
				}
				
				
				function getSideboxUser($schoolid) {
					global $LANG;
					$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
					$communeid = $this->piVars['communeid']; #$schooldata['ref_commune'];
					$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);
					$allPhasenSchool = tx_itaoshhmanager_database::getAllPhasen();
					$markerArray['###ANZ_ACCOUNTS_GESAMT###'] = tx_itaoshhmanager_database::getAnzAccountBySchool($schoolid,0,1);
					$html .= tx_itaoshhmanager_library::template_ausgeben($markerArray, 'SIDEBOX_USER', 'layout/be_template_mod3.html');
					return $html;
				}

				/**
				  * 4. Ebene (Parallel zu Benutzer)
				  * Hier wird eine Oberfläche generiert, auf der man für die ausgewählte Schule Vorschläge einsehen und bearbeiten kann
				  */
				function getOffersPage($schoolid) {
					global $LANG, $BE_USER;
					if ($this->piVars['save_stimmen']) { 
						tx_itaoshhmanager_database::saveVotes($this->piVars['stimmen']);						
					}
					
					if ($this->piVars['search_reset']!="") {
						$this->piVars['search_value'] = "";
						$GLOBALS["BE_USER"]->setAndSaveSessionData ('search_value', "");
					}
					$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
					$communeid = $schooldata['ref_commune'];
					$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);
					/* FÜR SORTIERUNG*/
							$ses_col = $GLOBALS["BE_USER"]->getSessionData("sortcol");
							$ses_dir = $GLOBALS["BE_USER"]->getSessionData("sortdir");
							$search_value = $GLOBALS["BE_USER"]->getSessionData("search_value");
							# angezeigt wird das gegenteil
							$sort_nach = ($this->piVars['sortcol']) ? $this->piVars['sortcol'] : $ses_col; 
							$sort_dir = ($this->piVars['sortdir']) ? $this->piVars['sortdir'] : $ses_dir; 
							$search_value = ($this->piVars['search_value']) ? $this->piVars['search_value'] : $search_value; 
							
							if ($sort_nach == 0) {
								$sort_nach = 1;
							}
							if ($this->piVars['sortcol']) {								
								$GLOBALS["BE_USER"]->setAndSaveSessionData ('sortcol', $this->piVars['sortcol']);
							} 					
							
							if ($this->piVars['sortdir']) {								
								$GLOBALS["BE_USER"]->setAndSaveSessionData ('sortdir', $this->piVars['sortdir']);
							}
							
							if ($this->piVars['search_value']) {								
								$GLOBALS["BE_USER"]->setAndSaveSessionData ('search_value', $this->piVars['search_value']);
							} 						
							
							$sortArr = array();
							$sortArr[1]['title'] = 'title';						
							$sortArr[2]['title'] = 'submitted';					
							$sortArr[3]['title'] = 'date';						
							$sortArr[4]['title'] = 'status';				
							$sortArr[9]['title'] = 'classidea';						
							$sortArr[5]['title'] = 'commented';						
//							$sortArr[6]['title'] = 'help';				
							$sortArr[7]['title'] = 'likes';				
							$sortArr[8]['title'] = 'dislikes';			
							$sortArr[10]['title'] = 'internal_id';	
							$sortArr[11]['title'] = 'votes';		
							$opp_other = 'desc';
							while (list ($key, $val) = each ($sortArr)) {
								if ($key == $sort_nach) {
									$opp_dir = ($sort_dir == 'desc') ? 'asc' : 'desc';
								} else {
									if ($key == 7 || $key == 8 || $key == 6 || $key == 3 || $key == 11) {
										$opp_dir = 'desc';
									} else {
										$opp_dir = 'asc';
									}
								}								
								$cssClass = ($key == $sort_nach) ? 'sorted_'.$opp_dir: '';
								$ma_det_sc['###SORT_CLASS_'.strtoupper($val['title']).'###'] = $cssClass;
								$ma_det_sc['###SORTPATH_'.strtoupper($val['title']).'###'] = $this->indexpath.'&sortcol='.$key.'&sortdir='.$opp_dir.'&vorschlaege=1&smnr='.$this->piVars['smnr'].'&communeid='.$communeid.'&schoolid='.$schoolid;
							}
					
					# für Suche
					$ma_det_sc['###SEARCH_VALUE_STD###'] = $LANG->getLL('std_searchinput', TRUE);
					$ma_det_sc['###FORMACTION###'] = $this->indexpath.'&sortcol='.$key.'&sortdir='.$opp_dir.'&vorschlaege=1&smnr='.$this->piVars['smnr'].'&communeid='.$communeid.'&schoolid='.$schoolid;
					$ma_det_sc['###SEARCH_VALUE###'] =  ($search_value!="") ? $search_value : $LANG->getLL('std_searchinput', TRUE);#($this->piVars['search_value']!="") ? $this->piVars['search_value'] : $LANG->getLL('std_searchinput', TRUE);
					
					# Content über Tabs:
					$ma['###SCHOOL_TITLE###'] = $schooldata['title'];
					$ma['###SC_ORT###'] = ($schooldata['city']!="") ? '('.$schooldata['city'].')' : '';$locat = urlencode('mod.php?M=txitaoshhmanagerM0_txitaoshhmanagerM3');
					$ma['###JS_EDIT###'] = tx_itaoshhmanager_library::js_fuer_ds_bearbeiten($locat);
					$html_oben =  tx_itaoshhmanager_library::template_ausgeben($ma, 'TEMPLATE_OFFERS_DETAILPAGE', 'layout/be_template_mod3.html');

					# Content im Tab
					$this->anz_ergebnisse = 0;
					$ma_det_sc['###TABLEROWS_OFFERS###'] = $this->getOffersTableRows($schoolid,$sort_nach, $sort_dir);
					$ma_det_sc['###SIDEBOX###'] = $this->getSideboxOffers($schoolid);
					$ma_det_sc['###ANZ_ERGEBNISSE###'] = $this->anz_ergebnisse;
					
					#if ($BE_USER->user['admin'] || tx_itaoshhmanager_general::isInBeUserGroup($BE_USER->user['usergroup'], $this->tsvars['be_groupid_techadmin'])) {
						if ($this->piVars['update_wahldoc']) {
							tx_itaoshhmanager_general::generateWahlzettel($communeid,$schoolid,$this->allOffersForDoc);
						}
						if ($this->piVars['update_wahlpdf']) {
							tx_itaoshhmanager_general::generateWahlzettel($communeid,$schoolid,$this->allOffersForDoc,1);
						}
						
						######
						$ma_doc['###DISPLAY_WAHLZETTEL###'] = $ma_det_sc['###DISPLAY_WAHLZETTEL###'] =  ($this->anz_ergebnisse > 0 ) ? '' : 'display_none';
						$ma_doc['###LINK_DOWNLOAD_DOC###'] = "http://".$_SERVER['HTTP_HOST'].'/uploads/tx_itaoshhmanager/pdfs_wahlzettel/'.$schoolid.'_wahlzettel.doc';
						$ma_doc['###LINK_UPDATE_DOC###'] = $this->indexpath.'&communeid='.$communeid.'&schoolid='.$schoolid.'&vorschlaege=1&update_wahldoc=1';
						$ma_doc['###LINK_UPDATE_PDF###'] = $this->indexpath.'&communeid='.$communeid.'&schoolid='.$schoolid.'&vorschlaege=1&update_wahlpdf=1';
						$ma_det_sc['###LINK_DOC_GEN###'] = tx_itaoshhmanager_library::template_ausgeben($ma_doc, 'T_GENERATE_DOC', 'layout/be_template_mod3.html');	
						
					#} else {
					#	$ma_det_sc['###LINK_DOC_GEN###'] = '';
					#}
					
					
					$ma_det_sc['###DISPLAY_CLASS_SEARCH###'] = 	($search_value!="") ? '': 'display_none';	
					
					# zum Eingeben der Stimmen:
					$ma_det_sc['###EDIT_ALL_STIMMEN_LINK###'] =  $this->indexpath.'&smnr=3&communeid='.$communeid.'&schoolid='.$schoolid.'&vorschlaege=1&edit_stimmen=1';
						
					if ((tx_itaoshhmanager_general::isInBeUserGroup($BE_USER->user['usergroup'], $this->tsvars['be_groupid_techadmin']) || 
						tx_itaoshhmanager_general::isInBeUserGroup($BE_USER->user['usergroup'], $this->tsvars['be_groupid_redadmin_schule'])) || 
						$BE_USER->user['admin']) {						
							$ma_det_sc['###DISPLAY_VOTES###'] =  '';					
					}	else {
						$ma_det_sc['###DISPLAY_VOTES###'] =  'display_none';
					}	
					
					
					
					$html = tx_itaoshhmanager_library::template_ausgeben($ma_det_sc, 'TEMPLATE_OFFERS_DETAIL_CONTENT', 'layout/be_template_mod3.html');	
					
					
					# fuer Tabs
					$rechte_ist_arr = ($BE_USER->user['usergroup']!="" ) ? explode(",", $BE_USER->user['usergroup']) : array();					
/*					if (!in_array($this->tsvars['be_groupid_mod_schule'],$rechte_ist_arr ) && !in_array($this->tsvars['be_groupid_redadmin_schule'],$rechte_ist_arr )) { 
						$submoduls[0] = $LANG->getLL('submodule_commune');#
					}
*/					
/*					if (tx_itaoshhmanager_general::hasRights(2,2)) {
						$submoduls[1] = $LANG->getLL('submodule_school');
						$submoduls[2] = $LANG->getLL('submodule_school_user');
						
						# neu: für FE-User bearbeiten 
					}
*/
/*					
					# für Red.Admin kommune NICHT anzeigen, wenn in Schule
					if ((tx_itaoshhmanager_general::isInBeUserGroup($BE_USER->user['usergroup'], $this->tsvars['be_groupid_redadmin_kommune'])) && $schoolid > 0 && !$BE_USER->user['admin']) {
						unset($submoduls[2]);
					}
	*/				
					
					$submoduls[3] = $LANG->getLL('submodule_school_article');
/*					if (tx_itaoshhmanager_general::hasRights(5,2)  || tx_itaoshhmanager_general::hasRights(6,2)) {
						$submoduls[5] = $LANG->getLL('submodule_school_beuser');
					}
					
					if (tx_itaoshhmanager_general::hasRights(7,3)) {
#!#!#						$submoduls[8] = $LANG->getLL('submodule_school_editfeuser');
					}
*/					
					
					$active = 3;
					$this->myModule = 'mod3';
					$html = $html_oben .$breadcrumb. tx_itaoshhmanager_navigation::getSubmodulNavi($submoduls,$active, $html, 'long');
					$html .= tx_itaoshhmanager_library::template_ausgeben($markerArray, 'BOX_JS', 'layout/be_template_mod3.html');
					return $html;
				}
				
				
				function getSideboxOffers($schoolid) {
					global $LANG, $BE_USER;
					$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
					$communeid = $schooldata['ref_commune'];
					$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);
					$allOffers = tx_itaoshhmanager_database::getAllOffersBySchool($schoolid,0,1, '',1);
					$allOffersByState = tx_itaoshhmanager_database::getAllOffersBySchool($schoolid,1,1, '',1);
					$markerArray['###ANZ_OFFERS_GESAMT###'] = count($allOffers);
					$markerArray['###ANZ_OFFERS_SUBMITTED###'] = count($allOffersByState[1]);
					$markerArray['###ANZ_OFFERS_RELEASED###'] =  count($allOffersByState[2]);
					$markerArray['###ANZ_OFFERS_DISMISSED###'] =  count($allOffersByState[3]);
					
					# zum Eingeben der Stimmen:
					$markerArray['###EDIT_ALL_STIMMEN_LINK###'] =  $this->indexpath.'&smnr=3&communeid='.$communeid.'&schoolid='.$schoolid.'&vorschlaege=1&edit_stimmen=1';
						
					if ((tx_itaoshhmanager_general::isInBeUserGroup($BE_USER->user['usergroup'], $this->tsvars['be_groupid_techadmin']) || 
						tx_itaoshhmanager_general::isInBeUserGroup($BE_USER->user['usergroup'], $this->tsvars['be_groupid_redadmin_schule'])) || 
						$BE_USER->user['admin']) {						
							$markerArray['###DISPLAY_VOTES###'] =  '';					
					}	else {
						$markerArray['###DISPLAY_VOTES###'] =  'display_none';
					}			
					
					$html .= tx_itaoshhmanager_library::template_ausgeben($markerArray, 'SIDEBOX_OFFERS', 'layout/be_template_mod3.html');
					return $html;
				}
				
				
				function getOffersTableRows($schoolid,$sort_nach = 1, $sort_dir="asc") {
					global $LANG;
					$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
					$communeid = $schooldata['ref_commune'];
					$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);
					
					if ($this->piVars['search_reset']!="") {
						$this->piVars['search_value'] = "";
						$GLOBALS["BE_USER"]->setAndSaveSessionData ('search_value', "");
					}
							
					if ($this->piVars['search_value']== $LANG->getLL('std_searchinput', TRUE)) {
						$this->piVars['search_value'] = "";
						$GLOBALS["BE_USER"]->setAndSaveSessionData ('search_value', "");
					} 
					
								
					$allOffers = tx_itaoshhmanager_database::getAllOffersBySchool($schoolid,0,$sort_nach, $sort_dir,0,0,1);
					$allOffStati = tx_itaoshhmanager_database::getAllStatiOffer();
					
					if (is_array($allOffers)) {
						$this->anz_ergebnisse = count($allOffers);
						$this->allOffersForDoc = $allOffers;
						while (list ($key, $val) = each ($allOffers)) {
							$markerArray['###OFFERID###'] 	= $val['internal_id'];
							$markerArray['###OFFERUID###'] 	= $val['uid'];
							$back_params = array("communeid" => $communeid, "schoolid" => $schoolid, "vorschlaege" => 1);
							$markerArray['###DETAIL_OFFER_LINK###'] = $this->indexpath.'&communeid='.$communeid.'&schoolid='.$schoolid.'&offerid='.$val['uid'];
							
							#$markerArray['###EDIT_OFFER_LINK###'] 	= tx_itaoshhmanager_general::getEditLink($LANG->getLL('l_editOffer'), 'tx_itaoshhoffers_domain_model_offer', $val['uid'],array(), $back_params,1);
							$markerArray['###OFFER_TITLE###'] 	= $val['title'];
							$username = ($val['name']!="") ? $val['name'] : $val['first_name']." ".$val['last_name'];
							$username = (trim($username)=="") ? $val['username'] : $username;
							$markerArray['###SUBMITTED_BY###'] 	= $username;
							$markerArray['###DATE###'] 	= date("d.m.Y", $val['crdate']);
							$the_n = ($val['status']==3) ? 'n' : '';
							$markerArray['###STATUS_IMAGE###'] 	= 'state_offer_'.$val['status'].$the_n.'.png';
							$markerArray['###STATUS_LABEL###'] 	= strtolower($allOffStati[$val['status']]['title']); 
							$markerArray['###ASSIGNED_TO###'] 	= '[ASSIGNED_TO]';
							$markerArray['###ANZ_VOTES###'] 	= $val['votes'];
							
							$markerArray['###CHILDOFFERS###'] 	= '';
							$childoffers = tx_itaoshhmanager_database::getChildOffers($val['uid'],1,2); # die 2 steht für uid
							if (is_array($childoffers)) {
								$markerArray['###CHILDOFFERS###'] 	= implode(", ", $childoffers);
							} 
							$comments = tx_itaoshhmanager_database::getCommentsByOffer($val['uid']);
							$comuser = array();
							$commented = '';
							if (is_array($comments)) {
								while (list ($key_c, $val_c) = each ($comments)) {
									
									$cuser_data = tx_itaoshhmanager_database::getUserData($val_c['fe_user']);
							#t3lib_utility_debug::debug($cuser_data);
									$cusername = ($cuser_data['name']!="") ? $cuser_data['name'] : $cuser_data['first_name']." ".$cuser_data['last_name'];
									$cusername = (trim($cusername)=="") ? $cuser_data['username'] : $cusername;									
									if ($val_c['fe_user'] == 0) {
										$cusername = tx_itaoshhmanager_database::getBeUserName($val_c['cruser_id']);
									}
									$comuser[] = $cusername;
								}
								#$name_commenter = 
								$commented = 'von '.implode(",", $comuser);
							} else {
								$commented = '<span class="listgrey">---</span>';
							}
							$allIdeas = tx_itaoshhmanager_database::getIdeaByOffer($val['uid']);
							$xyz = 0;
							$markerArray['###CLASSIDEA###'] = "";
							while (list ($keyid, $valid) = each ($allIdeas)) {
								$markerArray['###CLASSIDEA###'].= ($xyz==0) ? $valid['class'] : '';
								$xyz++;
							}
							$markerArray['###COMMENTED###'] 	= $commented;
//							$markerArray['###HELP_WANTED###'] 	=  ($val['costs_help']) ? 'ja' : 'nein';
							
							$all_dis_likes = tx_itaoshhmanager_database::getLikesDislikesPerOffer($val['uid']);
							$allLikes 	= (is_array($all_dis_likes)) ? count($all_dis_likes[1]) : 0 ;
							$allDislikes  	= (is_array($all_dis_likes)) ? count($all_dis_likes[2]) : 0 ;
							
							#$costs = ($val['costs_fixed']!="")? $val['costs_fixed'] : $val['costs']; 
							$costs = ($val['costs']!="")? $val['costs'] : $val['costs_student']; 
							$markerArray['###COSTS###'] = ($costs!="") ? $costs.'&nbsp;&euro;' : '&nbsp;';
							if ($allLikes==0 && $allDislikes==0) {
								$markerArray['###DIS_LIKES###'] =  '<span class="listgrey" title="noch keine Wertungen">---</span>';
							} else {
								$markerArray['###DIS_LIKES###'] =  '<span class="statusGreen" title="gef&auml;llt">'.$allLikes.'</span> / <span class="statusRed" title="gef&auml;llt nicht">'.$allDislikes.'</span>';
							}
							#$markerArray['###DIS_LIKES###'] .= '//'.$val['likes_dislikes'];
							
							$html .= tx_itaoshhmanager_library::template_ausgeben($markerArray, 'TEMPLATE_TABLEROWS_OFFERS', 'layout/be_template_mod3.html');
						}
					} else {
						$html .=tx_itaoshhmanager_library::template_ausgeben($markerArray, 'TEMPLATE_NO_OFFERS', 'layout/be_template_mod3.html');
					}
					
					return $html;
				}
				
				
				
				function getOffersTableRows_stimmeneingabe($schoolid,$sort_nach = 1, $sort_dir="asc") {
					global $LANG;
					$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
					$communeid = $schooldata['ref_commune'];
					$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);					
								
					$allOffers = tx_itaoshhmanager_database::getAllOffersBySchool($schoolid,0,$sort_nach, $sort_dir,0,1,1);
					
					if (is_array($allOffers)) {
						$this->anz_ergebnisse = count($allOffers);
						$this->allOffersForDoc = $allOffers;
						while (list ($key, $val) = each ($allOffers)) {
							$markerArray['###OFFERID###'] 	= $val['internal_id'];
							$markerArray['###OFFER_TITLE###'] 	= $val['title'];
							$markerArray['###OFFERUID###'] 	= $val['uid'];
							$markerArray['###STIMME_VALUE###'] 	= $val['votes'];
							
							$html .= tx_itaoshhmanager_library::template_ausgeben($markerArray, 'TEMPLATE_TABLEROWS_OFFERS_STIMMENEINGABE', 'layout/be_template_mod3.html');
						}
					} else {
						$html .=tx_itaoshhmanager_library::template_ausgeben($markerArray, 'TEMPLATE_NO_OFFERS', 'layout/be_template_mod3.html');
					}
					
					return $html;
				}
				
				
				
				/**
				  * 4. Ebene - Eingabe der Stimmen
				  */
								
				function getOffersPage_stimmenedit($schoolid) {
					global $LANG, $BE_USER;
					$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
					$communeid = $schooldata['ref_commune'];
					$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);
					/* FÜR SORTIERUNG*/
							$ses_col = $GLOBALS["BE_USER"]->getSessionData("sortcol");
							$ses_dir = $GLOBALS["BE_USER"]->getSessionData("sortdir");
							$search_value = $GLOBALS["BE_USER"]->getSessionData("search_value");
							# angezeigt wird das gegenteil
							$sort_nach = ($this->piVars['sortcol']) ? $this->piVars['sortcol'] : $ses_col; 
							$sort_dir = ($this->piVars['sortdir']) ? $this->piVars['sortdir'] : $ses_dir; 
							
							if ($sort_nach == 0) {
								$sort_nach = 1;
							}
							if ($this->piVars['sortcol']) {								
								$GLOBALS["BE_USER"]->setAndSaveSessionData ('sortcol', $this->piVars['sortcol']);
							} 					
							
							if ($this->piVars['sortdir']) {								
								$GLOBALS["BE_USER"]->setAndSaveSessionData ('sortdir', $this->piVars['sortdir']);
							}					
							
							$sortArr = array();
							$sortArr[1]['title'] = 'title';	
							$sortArr[10]['title'] = 'internal_id';	
							$sortArr[11]['title'] = 'votes';						
							$opp_other = 'desc';
							while (list ($key, $val) = each ($sortArr)) {
								if ($key == $sort_nach) {
									$opp_dir = ($sort_dir == 'desc') ? 'asc' : 'desc';
								} else {
									if ($key == 7 || $key == 8 || $key == 6 || $key == 3 || $key == 11) {
										$opp_dir = 'desc';
									} else {
										$opp_dir = 'asc';
									}
								}								
								$cssClass = ($key == $sort_nach) ? 'sorted_'.$opp_dir: '';
								$ma_det_sc['###SORT_CLASS_'.strtoupper($val['title']).'###'] = $cssClass;
								$ma_det_sc['###SORTPATH_'.strtoupper($val['title']).'###'] = $this->indexpath.'&sortcol='.$key.'&sortdir='.$opp_dir.'&vorschlaege=1&edit_all_stimmen=1&smnr='.$this->piVars['smnr'].'&communeid='.$communeid.'&schoolid='.$schoolid;
							}
										
					# Content über Tabs:
					$ma['###SCHOOL_TITLE###'] = $schooldata['title'];
					$ma['###SC_ORT###'] = ($schooldata['city']!="") ? '('.$schooldata['city'].')' : '';$locat = urlencode('mod.php?M=txitaoshhmanagerM0_txitaoshhmanagerM3');
					$ma['###JS_EDIT###'] = tx_itaoshhmanager_library::js_fuer_ds_bearbeiten($locat);
					
					
					$html_oben =  tx_itaoshhmanager_library::template_ausgeben($ma, 'TEMPLATE_OFFERS_DETAILPAGE', 'layout/be_template_mod3.html');

					# Content im Tab
					$this->anz_ergebnisse = 0;
					$ma_det_sc['###TABLEROWS_OFFERS###'] = $this->getOffersTableRows_stimmeneingabe($schoolid,$sort_nach, $sort_dir);
					$ma_det_sc['###FORMURL###'] = $this->indexpath.'&smnr='.$this->piVars['smnr'].'&communeid='.$communeid.'&schoolid='.$schoolid.'&vorschlaege=1';
															
					$html = tx_itaoshhmanager_library::template_ausgeben($ma_det_sc, 'TEMPLATE_OFFERS_EDIT_STIMMEN', 'layout/be_template_mod3.html');						
					
					# fuer Tabs
					$rechte_ist_arr = ($BE_USER->user['usergroup']!="" ) ? explode(",", $BE_USER->user['usergroup']) : array();								
					$submoduls[3] = "Stimmeneingabe";#$LANG->getLL('submodule_school_article');					
					$active = 3;
					$this->myModule = 'mod3';
					$html = $html_oben .$breadcrumb. tx_itaoshhmanager_navigation::getSubmodulNavi($submoduls,$active, $html, 'long');
					$html .= tx_itaoshhmanager_library::template_ausgeben($markerArray, 'BOX_JS', 'layout/be_template_mod3.html');
					return $html;
				}
				
				
				
				
				
				/**
				  * 5. Ebene 
				  * Hier wird ein Vorschlag im Detail ausgegeben
				  */
				function getOfferDetailPage($schoolid, $offerid) {
					global $LANG, $BE_USER; global $_SERVER;
					$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
					$communeid = $schooldata['ref_commune'];
					$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);
					$offerData = tx_itaoshhmanager_database::getOfferById($offerid);	
					
					# hier abfangen, ob Comment im BE verändert wurde; wenn ja, dann Comment-Logging-DS erstellen
					if ($this->piVars['comment_edited']) {
						tx_itaoshhmanager_database::doCommentLogging($this->piVars['comment_edited'], $offerid);
					}
					# hier abfangen, ob Comment im BE verändert wurde; wenn ja, dann Comment-Logging-DS erstellen
					if ($this->piVars['comment_new_created']) {
						$newCommUid = tx_itaoshhmanager_database::doCommentCreate($offerid);						
						#tx_itaoshhmanager_database::doCommentLogging($newCommUid, $offerid);
					}
					
					
					
					$comments = tx_itaoshhmanager_database::getCommentsByOffer($offerid);	
					#t3lib_utility_debug::debug($LANG->getLL('offact_freigegeben'));
					# Content über Tabs:
					$ma['###SCHOOL_TITLE###'] = $schooldata['title'];					
					$ma['###OFFER_INTID###'] = $offerData['internal_id'];
					$ma['###SC_ORT###'] = ($schooldata['city']!="") ? '('.$schooldata['city'].')' : '';$locat = urlencode('mod.php?M=txitaoshhmanagerM0_txitaoshhmanagerM3');
					$ma['###JS_EDIT###'] = tx_itaoshhmanager_library::js_fuer_ds_bearbeiten($locat);
					$html_oben =  tx_itaoshhmanager_library::template_ausgeben($ma, 'TEMPLATE_OFFER_VIEW', 'layout/be_template_mod3.html');

					# Content im Tab
					# Funktionsleiste zum Abweisen und freischalten
					$off_funcs['###OFFER_FUNCPATH###'] = $this->indexpath.'&communeid='.$communeid.'&schoolid='.$schoolid.'&offerid='.$offerid;
					
					$back_params = array("communeid" => $communeid, "schoolid" => $schoolid, "vorschlaege" => 1, "offerid" => $offerid);
					$off_funcs['###EDIT_OFFER_LINK###'] 	= tx_itaoshhmanager_general::getEditLink($LANG->getLL('l_editOffer'), 'tx_itaoshhoffers_domain_model_offer', $offerid,array(), $back_params,1,$LANG->getLL('l_edit'),0);
					$back_link = $this->indexpath.'&vorschlaege=1&smnr='.$this->piVars['smnr'].'&communeid='.$communeid.'&schoolid='.$schoolid;
					$ma_off_det['###BACKLINK###'] = '<span class="listgrey">&laquo; <u><a href="'.$back_link .'">zur&uuml;ck zur Vorschlags&uuml;bersicht</a></u></span><br /><br />';
					#$ma_off_det['###FUNKTIONSLEISTE###'] = ($offerData['status'] > 1) ? '' : tx_itaoshhmanager_library::template_ausgeben($off_funcs, 'OFFER_FUNCTIONS', 'layout/be_template_mod3.html');
					
					$off_funcs['###DISPLAY_FUNC_1###'] 	= ($offerData['status']==1 || $offerData['status']==3) ? '' : 'display_none'; 
					$off_funcs['###DISPLAY_FUNC_2###'] 	= ($offerData['status']==1 || $offerData['status']==2) ? '' : 'display_none'; 
					$ma_off_det['###FUNKTIONSLEISTE###'] = tx_itaoshhmanager_library::template_ausgeben($off_funcs, 'OFFER_FUNCTIONS', 'layout/be_template_mod3.html');
					$ma_off_det['###KOSTEN_BEARBEITEN_LINK###'] = "";
					if ((tx_itaoshhmanager_general::isInBeUserGroup($BE_USER->user['usergroup'], $this->tsvars['be_groupid_redadmin_kommune']) || 
						tx_itaoshhmanager_general::isInBeUserGroup($BE_USER->user['usergroup'], $this->tsvars['groupid_mod_kommune'])) && !$BE_USER->user['admin']) {
						$ma_off_det['###FUNKTIONSLEISTE###'] = "";
						
					}
						
						$back_params5 = array("communeid" => $communeid, "schoolid" => $schoolid, "vorschlaege" => 1, "offerid" => $offerid);
						#$thecommlink5 = str_replace("]=edit","]=edit&amp;columnsOnly=costs_fixed",tx_itaoshhmanager_general::getEditLink($LANG->getLL('l_editcosts'), 'tx_itaoshhoffers_domain_model_offer',  $offerid,array(), $back_params5,1,$LANG->getLL('l_editcosts'),0));
						$thecommlink5 = str_replace("]=edit","]=edit&amp;columnsOnly=costs",tx_itaoshhmanager_general::getEditLink($LANG->getLL('l_editcosts'), 'tx_itaoshhoffers_domain_model_offer',  $offerid,array(), $back_params5,1,$LANG->getLL('l_editcosts'),0));
						$ma_off_det['###KOSTEN_BEARBEITEN_LINK###'] = $thecommlink5 ;

					$ma_off_det['###OFF_TITLE###'] = $offerData['title'];
					$ma_off_det['###OFF_DESCRIPTION###'] = nl2br($offerData['description']);
					#$ma_off_det['###OFF_COSTS###'] = ($offerData['costs']) ? $offerData['costs']." &euro;" : '<span class="listgrey">[k.A.]</span>';
					$ma_off_det['###OFF_COSTS###'] = ($offerData['costs_student']) ? $offerData['costs_student']." &euro;" : '<span class="listgrey">[k.A.]</span>';
//					$ma_off_det['###OFF_HELP###'] = ($offerData['costs_help']) ? '' : 'keine ';				
					#$ma_off_det['###COSTS_VERWALTUNG###'] = ($offerData['costs_fixed']) ? $offerData['costs_fixed']." &euro;" : '<span class="listgrey">[k.A.]</span>';	
					$ma_off_det['###COSTS_VERWALTUNG###'] = ($offerData['costs']) ? $offerData['costs']." &euro;" : '<span class="listgrey">[k.A.]</span>';					
					
					if (is_array($comments)) { #$offerData['idea_from'] && 
						while (list ($key, $val) = each ($comments)) {
							
							$commentlogs = tx_itaoshhmanager_database::getCommentLogsByComment($val['uid']);	
							$userdata = tx_itaoshhmanager_database::getUserData($val['fe_user']);
							$username = ($userdata['name']!="") ? $userdata['name'] : $userdata['first_name']." ".$userdata['last_name'];
							$username = (trim($username)=="") ? $userdata['username'] : $username;
							if ($val['fe_user'] == 0) {
								$username = tx_itaoshhmanager_database::getBeUserName($val['cruser_id']);
							}
							
							$ma_off_det['###OFF_COMMENTS###'] .= '"<i>'.nl2br($val['text']).'</i>"';
							$ma_off_det['###OFF_COMMENTS###'] .= '<br /><span class="listgrey">Erstellt von '.$username.' am '.date("d.m.Y, H:i",$val['crdate']).' Uhr</span>';
							
							if (is_array($commentlogs)) {
								if (count($commentlogs) > 0) {
									while (list ($key_log, $val_log) = each ($commentlogs)) {
										$be_user_edit = tx_itaoshhmanager_database::getBeUserName($val_log['cruser_id']);
										$ma_off_det['###OFF_COMMENTS###'] .= '<br /><span class="listgrey">Editiert von '.$be_user_edit.' am '.date("d.m.Y, H:i",$val_log['crdate']).' Uhr</span>';
									}
								}
							} 
							
							$ma_off_det['###OFF_COMMENTS###'] .= '<br />';
							$ma_off_det['###OFF_COMMENTS###'] .= '<br />';
							$back_params = array("communeid" => $communeid, "schoolid" => $schoolid, "vorschlaege" => 1, "offerid" => $offerid, "comment_edited" => $val['uid']);
							$ma_off_det['###OFF_COMMENTS###'] .= '<span class="listgrey2">';
							$thecommlink = str_replace("]=edit","]=edit&amp;columnsOnly=text",tx_itaoshhmanager_general::getEditLink($LANG->getLL('l_editComment'), 'tx_itaoshhoffers_domain_model_comment', $val['uid'],array(), $back_params,1,$LANG->getLL('l_editComment'),0));
							$ma_off_det['###OFF_COMMENTS###'] .= $thecommlink;
							$ma_off_det['###OFF_COMMENTS###'] .= '</span>';
							$ma_off_det['###OFF_COMMENTS###'] .= '<br />';
							#$ma_off_det['###EDIT_COMMENT_LINK###'] = '<br />';
						}
					} else {
						$ma_off_det['###OFF_COMMENTS###'] = '<span class="listgrey">[nicht kommentiert]</span><br /><br />';
						
						$back_params = array("smnr" => 4, "communeid" => $communeid, "schoolid" => $schoolid, "vorschlaege" => 1, "offerid" => $offerid, "comment_new_created" => 1); #, "comment_edited" => $val['uid']
																
						$newlink = tx_itaoshhmanager_general::getNewLink($LANG->getLL('l_createComment'), 'tx_itaoshhoffers_domain_model_comment', $this->tsvars['pid_offers'] ,array(), $back_params,3);		
						$imgsrc = '<img src="'.$this->imagepath.'new_el.gif" alt="'.$LANG->getLL('l_createComment').'" title="'.$LANG->getLL('l_createComment').'"> ';
						$newlink = str_replace('<span class', $imgsrc.'<span class',$newlink);  							
						$newlink = str_replace("]=new", "]=new&amp;columnsOnly=text",$newlink);
						$ma_off_det['###OFF_COMMENTS###'] .= 	$newlink;																																	
					}
					
					if ($offerData['images']!="") {
						$imageArr = explode(",", $offerData['images']);
						while (list ($key, $val) = each ($imageArr)) {
							$ma_off_det['###OFF_IMAGES###'] .= '<a href="/'.$this->tsvars['offerimage_path'].$val.'" target="_blank">';
							$ma_off_det['###OFF_IMAGES###'] .=  t3lib_befunc::getThumbnail('../t3lib/thumbs.php',$_SERVER['DOCUMENT_ROOT'].'/'.$this->tsvars['offerimage_path'].$val, '', '100x100');
							$ma_off_det['###OFF_IMAGES###'] .= '</a><br />';
						}
					} else {
						$ma_off_det['###OFF_IMAGES###'] = "";
					}	
					
					$ma_off_det['###SIDEBOX###'] = $this->getSideboxOffersDetail($schoolid, $offerid);
					
					$html = tx_itaoshhmanager_library::template_ausgeben($ma_off_det, 'TEMPLATE_OFFER_VIEW_CONTENT', 'layout/be_template_mod3.html');	
					
					
					
					# fuer Tabs
					$rechte_ist_arr = ($BE_USER->user['usergroup']!="" ) ? explode(",", $BE_USER->user['usergroup']) : array();					
/*					if (!in_array($this->tsvars['be_groupid_mod_schule'],$rechte_ist_arr ) && !in_array($this->tsvars['be_groupid_redadmin_schule'],$rechte_ist_arr )) { 
						$submoduls[0] = $LANG->getLL('submodule_commune');#
					}
					if (tx_itaoshhmanager_general::hasRights(2,2)) {
						$submoduls[1] = $LANG->getLL('submodule_school');
						$submoduls[2] = $LANG->getLL('submodule_school_user');
						
						# neu: für FE-User bearbeiten 
#						$submoduls[8] = $LANG->getLL('submodule_school_editfeuser');
					}
					
					# für Red.Admin kommune NICHT anzeigen, wenn in Schule
					if ((tx_itaoshhmanager_general::isInBeUserGroup($BE_USER->user['usergroup'], $this->tsvars['be_groupid_redadmin_kommune'])) && $schoolid > 0 && !$BE_USER->user['admin']) {
						unset($submoduls[2]);
					}
*/					
					$submoduls[3] = $LANG->getLL('submodule_school_article');
					$submoduls[4] = $LANG->getLL('submodule_offer_detail');
					$active = 4;
/*					if (tx_itaoshhmanager_general::hasRights(5,2)  || tx_itaoshhmanager_general::hasRights(6,2)) {
						$submoduls[5] = $LANG->getLL('submodule_school_beuser');
					}
					
					if (tx_itaoshhmanager_general::hasRights(7,3)) {
#!#!#						$submoduls[8] = $LANG->getLL('submodule_school_editfeuser');
					}
*/					
					$this->myModule = 'mod3';
					$html = $html_oben .$breadcrumb. tx_itaoshhmanager_navigation::getSubmodulNavi($submoduls,$active, $html, 'long');
					$html .= tx_itaoshhmanager_library::template_ausgeben($markerArray, 'BOX_JS', 'layout/be_template_mod3.html');
					return $html;
				}
				
				function getSideboxOffersDetail($schoolid, $offerid) {
					global $LANG, $BE_USER;
					$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
					$communeid = $schooldata['ref_commune'];
					#$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);
					$offerData = tx_itaoshhmanager_database::getOfferById($offerid);	
					$allOffStati = tx_itaoshhmanager_database::getAllStatiOffer();
					$ideas = tx_itaoshhmanager_database::getIdeaByOffer($offerid);
					$supports = tx_itaoshhmanager_database::getSupportsByOffer($offerid);
					#$allOffers = tx_itaoshhmanager_database::getAllOffersBySchool($schoolid);
					#$allOffersByState = tx_itaoshhmanager_database::getAllOffersBySchool($schoolid,1);
					
					if ($offerData['status']==3) {
						$ma_off_det['###STATUS_IMAGE###'] 	= 'state_offer_'.$offerData['status'].'n.png';
					} else {
						$ma_off_det['###STATUS_IMAGE###'] 	= 'state_offer_'.$offerData['status'].'.png';
					}
					$ma_off_det['###STATUS_LABEL###'] 	= strtolower($allOffStati[$offerData['status']]['title']);
					
					$ma_off_det['###OFF_DATE###'] = date("d.m.Y, H:i",$offerData['crdate']).' Uhr';
					$username = ($offerData['name']!="") ? $offerData['name'] : $offerData['first_name']." ".$offerData['last_name'];
					$username = (trim($username)=="") ? $offerData['username'] : $username;
					$ma_off_det['###OFF_USER###'] = $username;
					
					if (is_array($ideas)) { #$offerData['idea_from'] && 
						while (list ($key, $val) = each ($ideas)) {
							$ma_off_det['###OFF_IDEAFROM###'] .= $val['name'];
							$ma_off_det['###OFF_IDEAFROM###'] .= ($val['class']!="") ? ', Klasse '.$val['class'] : '';
							$ma_off_det['###OFF_IDEAFROM###'] .= '<br />';
						}
					} else {
						$ma_off_det['###OFF_IDEAFROM###'] = '<span class="listgrey">[k.A.]</span>';
					}
					
					# Unterstützung:
					if (is_array($supports)) { #$offerData['idea_from'] && 
						while (list ($key, $val) = each ($supports)) {
							if ($val['name']!="") {
								$ma_off_det['###OFF_SUPPORTS###'] .= $val['name'];
								$ma_off_det['###OFF_SUPPORTS###'] .= ($val['class']!="") ? ', Klasse '.$val['class'] : '';
								$ma_off_det['###OFF_SUPPORTS###'] .= '<br />';
							}
						}
					} else {
						$ma_off_det['###OFF_SUPPORTS###'] = '<span class="listgrey">[k.A.]</span>';
					}					
					
					$all_dis_likes = tx_itaoshhmanager_database::getLikesDislikesPerOffer($offerid);
					$ma_off_det['###OFF_LIKES###'] = (is_array($all_dis_likes)) ? count($all_dis_likes[1]) : 0 ;
					#t3lib_utility_debug::debug($all_dis_likes);
					$ma_off_det['###OFF_DISLIKES###'] = (is_array($all_dis_likes)) ? count($all_dis_likes[2]) : 0 ;
					$ma_off_det['###VOTES###'] = $offerData['votes'];
					$childArr = tx_itaoshhmanager_database::getChildOffers($offerid,2);
					
					$ma_off_det['###DISPLAY_CLASS_CHILDING###'] = ($offerData['status']!=2) ? 'display_none': '';
					
					$ma_off_det['###LABEL_CHILDING###'] = 'Untergeordnet';
					if (is_array($childArr)) {
						while (list ($key, $val) = each ($childArr)) {
							$childofferData = tx_itaoshhmanager_database::getOfferById($key);
							$ma_off_det['###CHILD_OFFERS###'].=$childofferData['title'].' (Nr. '.$childofferData['internal_id'].')<br />';
						}
						if ((tx_itaoshhmanager_general::isInBeUserGroup($BE_USER->user['usergroup'], $this->tsvars['be_groupid_techadmin']) || 
							tx_itaoshhmanager_general::isInBeUserGroup($BE_USER->user['usergroup'], $this->tsvars['be_groupid_redadmin_schule'])) || 
							$BE_USER->user['admin']) {
								$ma_off_det['###CHILD_OFFERS###'].='<br /><a href="'.$this->indexpath.'&smnr='.$this->piVars['smnr'].'&communeid='.$communeid.'&schoolid='.$schoolid.'&offerid='.$offerid.'&childingme=1"><u>Zuordnung bearbeiten &raquo;</u></a>';								
							}
					} else {
						
						if ($offerData['parent_offer']==0) {
							$ma_off_det['###CHILD_OFFERS###'] = '<a href="'.$this->indexpath.'&smnr='.$this->piVars['smnr'].'&communeid='.$communeid.'&schoolid='.$schoolid.'&offerid='.$offerid.'&childingme=1"><u>Diesen Vorschlag zuordnen &raquo;</u></a>';
							
						
							if ((tx_itaoshhmanager_general::isInBeUserGroup($BE_USER->user['usergroup'], $this->tsvars['be_groupid_techadmin']) || 
							tx_itaoshhmanager_general::isInBeUserGroup($BE_USER->user['usergroup'], $this->tsvars['be_groupid_redadmin_schule'])) || 
							$BE_USER->user['admin']) {
							} else {
								$ma_off_det['###CHILD_OFFERS###'] = '&ndash;';
							}
							
						} else {
							
							$ma_off_det['###LABEL_CHILDING###'] = 'Zuordnung';
							$parentofferData = tx_itaoshhmanager_database::getOfferById($offerData['parent_offer']);
							$ma_off_det['###CHILD_OFFERS###'] = 'Ist dem Vorschlag "'.$parentofferData['title'].' (Nr. '.$parentofferData['internal_id'].')" untergeordnet<br /><br />';
							$parentofferdata = tx_itaoshhmanager_database::getOfferById($offerData['parent_offer']);	
							$ma_off_det['###CHILD_OFFERS###'] .= '<a href="'.$this->indexpath.'&smnr='.$this->piVars['smnr'].'&communeid='.$communeid.'&schoolid='.$schoolid.'&offerid='.$offerData['parent_offer'].'">
							<u>zum &uuml;bergeordneten Vorschlag &raquo;</u></a>';#'[hat bereits Parent ('.$parentofferdata['title'].')]';
						}
					}
					
					
					$html .= tx_itaoshhmanager_library::template_ausgeben($ma_off_det, 'SIDEBOX_OFFER_DETAIL', 'layout/be_template_mod3.html');
					return $html;
				}
				
				
				/**
				  * Neue 6.Ebene: BE-User
				  * Hier wird eine Oberfläche generiert, auf der man für die ausgewählte Schule BE-Redakteure anlegen kann - Nur für technischen Admin!
				  */
				function getBeUserPage($communeid, $schoolid) {					
					global $LANG, $BE_USER;
					$GLOBALS["BE_USER"]->setAndSaveSessionData ('search_value', "");
					#t3lib_utility_debug::debug(tx_itaoshhmanager_library::my_hashPassword("abcdefg"));
					$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
					#$communeid = $schooldata['ref_commune'];
					$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);
					
					# Content über Tabs:
					$ma['###SCHOOL_TITLE###'] = ($schooldata['title']=="" ) ? $communedata['titel'] : $schooldata['title'];
					$ma['###SC_ORT###'] = ($schooldata['city']!="") ? '('.$schooldata['city'].')' : '';
					
					$locat = urlencode('mod.php?M=txitaoshhmanagerM0_txitaoshhmanagerM3');
					$ma['###JS_EDIT###'] = tx_itaoshhmanager_library::js_fuer_ds_bearbeiten($locat);
					$html_oben =  tx_itaoshhmanager_library::template_ausgeben($ma, 'TEMPLATE_BEUSER_DETAILPAGE', 'layout/be_template_mod3.html');

					# Content im Tab
					if (tx_itaoshhmanager_general::hasRights(5,2) && $schoolid == 0) {
						$ma_det_sc['###BOX_BE_REDADMIN_KOMMUNE###'] = $this->getBoxBaseBeUser($communeid, $schoolid,$this->tsvars['be_groupid_redadmin_kommune']);
						$ma_det_sc['###BOX_BE_MOD_KOMMUNE###'] = $this->getBoxBaseBeUser($communeid, $schoolid,$this->tsvars['be_groupid_mod_kommune']);
					} else {
						$ma_det_sc['###BOX_BE_REDADMIN_KOMMUNE###'] = '';
						$ma_det_sc['###BOX_BE_MOD_KOMMUNE###'] = '';
					}
					if ($schoolid > 0) {
						$ma_det_sc['###BOX_BE_REDADMIN_SCHULE###'] = $this->getBoxBaseBeUser($communeid, $schoolid,$this->tsvars['be_groupid_redadmin_schule']);
						if (tx_itaoshhmanager_general::isInBeUserGroup($BE_USER->user['usergroup'], $this->tsvars['be_groupid_redadmin_kommune']) && !$BE_USER->user['admin']) {
							$ma_det_sc['###BOX_BE_MOD_SCHULE###'] = "";
						} else {
							$ma_det_sc['###BOX_BE_MOD_SCHULE###'] = $this->getBoxBaseBeUser($communeid, $schoolid,$this->tsvars['be_groupid_mod_schule']);
						}
					} else {
						$ma_det_sc['###BOX_BE_REDADMIN_SCHULE###'] =$ma_det_sc['###BOX_BE_MOD_SCHULE###'] = "";
					}
					$ma_det_sc['###SIDEBOX###'] = $this->getSideboxBeUser($communeid, $schoolid);
					
					$html = tx_itaoshhmanager_library::template_ausgeben($ma_det_sc, 'TEMPLATE_BEUSER_DETAIL_CONTENT', 'layout/be_template_mod3.html');	
					
					
					
					# fuer Tabs
					
					if (tx_itaoshhmanager_general::hasRights(1,1)) { # wenn jemand die Komune ansehen darf
						$submoduls[0] = $LANG->getLL('submodule_commune');
					}
					if ($schoolid > 0 ) {
						$submoduls[1] = $LANG->getLL('submodule_school');
					}

/*					if (tx_itaoshhmanager_general::hasRights(4,2)) {
						if (tx_itaoshhmanager_general::isInBeUserGroup($BE_USER->user['usergroup'], $this->tsvars['be_groupid_redadmin_kommune'])) {
							if ($schoolid == 0) {
								$submoduls[2] = $LANG->getLL('submodule_school_user');
							}
						} else {
							$submoduls[2] = $LANG->getLL('submodule_school_user');
						}
						#if (!tx_itaoshhmanager_general::isInBeUserGroup($BE_USER->user['usergroup'], $this->tsvars['be_groupid_redadmin_kommune']) || $BE_USER->user['admin']) {
						#	$submoduls[2] = $LANG->getLL('submodule_school_user');
						#}
						
						# neu: für FE-User bearbeiten 
#						$submoduls[8] = $LANG->getLL('submodule_school_editfeuser');
					}					
*/					
					if ($schoolid > 0 ) {
						if (tx_itaoshhmanager_general::hasRights(3,4)) {
							$submoduls[3] = $LANG->getLL('submodule_school_article');
						}
					}
/*					if (tx_itaoshhmanager_general::hasRights(5,2) || tx_itaoshhmanager_general::hasRights(6,2) ) {
						$submoduls[5] = $LANG->getLL('submodule_school_beuser');
						$active = 5;
					}
*/					
					
					if (tx_itaoshhmanager_general::hasRights(7,3) && $schoolid > 0) {
#!#!#						$submoduls[8] = $LANG->getLL('submodule_school_editfeuser');
					}
					reset($submoduls);
					$html = $html_oben .$breadcrumb. tx_itaoshhmanager_navigation::getSubmodulNavi($submoduls,$active, $html, 'long');
					$html .= tx_itaoshhmanager_library::template_ausgeben($markerArray, 'BOX_JS', 'layout/be_template_mod3.html');
					return $html;
				}
				
				
				
				
				
				function getBoxBaseBeUser($communeid, $schoolid, $groupid) {					
					global $LANG;
					$allGroups = tx_itaoshhmanager_database::getAllBEUsergroups();
					$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
					$schulstatus = $schooldata['ref_status'];
					$topics[$this->tsvars['be_groupid_redadmin_kommune']] = 'redadminkommune';
					$topics[$this->tsvars['be_groupid_mod_kommune']] = 'bemodkommune';
					$topics[$this->tsvars['be_groupid_redadmin_schule']] = 'redadminschule';
					$topics[$this->tsvars['be_groupid_mod_schule']] = 'bemodschule';
					
					$markerArray['###BOXTOPIC###'] = $topics[$groupid]; 
					$markerArray['###BOXHEADER###'] = $LANG->getLL('l_rolle');	
					$markerArray['###ACTIVITY###'] = '';
					$markerArray['###BOXCONTENT_CLASS###'] = 'boxcontent';			
					$markerArray['###EDITHEADER###'] = '';									
					$markerArray['###STATUS_BEZ###'] = $allGroups[$groupid]['title'];	
					$markerArray['###STATUS_ERH_CLASS###'] .= 'actstateclass_2' ;		
					$markerArray['###BOXBODY###'] = $this->getBoxBodyBeUser($communeid,$schoolid,$groupid);					
					$html = tx_itaoshhmanager_library::template_ausgeben($markerArray, 'BOX_BASIC', 'layout/be_template_mod3.html');					
					return $html;
				}
				
				function getBoxBodyBeUser($communeid,$schoolid,$groupid) {
					global $LANG; global $_SERVER;
					$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
					#$communeid = $schooldata['ref_commune'];
					$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);
					
					# Accounts generieren
					if ($_POST['anz_beacc_'.$groupid]) {
						$success_genacc = tx_itaoshhmanager_database::generateBEAccounts($groupid,$_POST['anz_beacc_'.$groupid],$schoolid,$schooldata,$communeid,$communedata );
						if ($success_genacc) {
							tx_itaoshhmanager_general::generateFlashMessage($LANG->getLL('account_header_1'), $LANG->getLL('account_text_1a').$_POST['anz_acc_1'].$LANG->getLL('account_text_1b'),1);
						} else {
							tx_itaoshhmanager_general::generateFlashMessage($LANG->getLL('account_header_0'), $LANG->getLL('account_text_0'),0);
						}
					}	
					
					# Accounts (PDF) updaten
					if ($_GET['anz_beacc_upd_'.$groupid]) {						
						#$pdf_generated = tx_itaoshhmanager_pdfgenerator::generateUserPDF($groupid, $schoolid,$schooldata);
						$pdf_generated = tx_itaoshhmanager_pdfgenerator::generateBEUserPDF($groupid, $schoolid,$schooldata,$communeid,$communedata );
						tx_itaoshhmanager_general::generateFlashMessage($LANG->getLL('account_upd_header_1'), $LANG->getLL('account_upd_text_1'),1);						
					}	
					
					$ma['###GROUPID###'] = $groupid;
					$markerArray['###GENERATE_ACCOUNTS###'] = tx_itaoshhmanager_library::template_ausgeben($ma, 'TEMPL_GENERATE_BEACCOUNTS', 'layout/be_template_mod3.html');									
					$markerArray['###FORM_ACTION_GENACC###'] = $this->indexpath.'&communeid='.$communeid.'&schoolid='.$schoolid.'&beuser=1';
					
					if (in_array($groupid, array($this->tsvars['be_groupid_redadmin_kommune'],$this->tsvars['be_groupid_mod_kommune'] ))) {
						$allUsers_commune[$groupid] = tx_itaoshhmanager_database::getAllBeUsersBySchool($communeid, $schoolid, $groupid,1);
						$markerArray['###ANZ_VERWKOMMUNE###'] = count($allUsers_commune[$groupid]);
					} else {
						$allUsers_school[$groupid] = tx_itaoshhmanager_database::getAllBeUsersBySchool($communeid, $schoolid, $groupid,0);
						$markerArray['###ANZ_VERWKOMMUNE###'] = count($allUsers_school[$groupid]);
					}
					
					# Download-Link:
					$by_commune[$this->tsvars['be_groupid_redadmin_kommune']] = 1;
					$by_commune[$this->tsvars['be_groupid_mod_kommune']] = 1;
					$by_commune[$this->tsvars['be_groupid_redadmin_schule']] = 0;
					$by_commune[$this->tsvars['be_groupid_mod_schule']] = 0;
		
					$pref[$this->tsvars['be_groupid_redadmin_kommune']] = 'rak';
					$pref[$this->tsvars['be_groupid_mod_kommune']] = 'modk';
					$pref[$this->tsvars['be_groupid_redadmin_schule']] = 'ras';
					$pref[$this->tsvars['be_groupid_mod_schule']] = 'mods';
		
					$uid_sk = ($by_commune[$groupid]) ? $communeid:$schoolid ;
					$pdfdateiname = "red_zugangsdaten_".$pref[$groupid]."_".$uid_sk."-".$groupid.".pdf";
					#$pdfdateiname = "zugangsdaten_".$schoolid."-".$groupid.".pdf";	
					if (is_file($_SERVER['DOCUMENT_ROOT']."/".$this->tsvars['beaccountpath'].$pdfdateiname)) {
						$ma_dl['###PFAD_DOWNLOAD###'] = 'http://'.$_SERVER['HTTP_HOST']."/".$this->tsvars['beaccountpath'].$pdfdateiname;
						$markerArray['###DOWNLOAD_ACCOUNTS###'] = tx_itaoshhmanager_library::template_ausgeben($ma_dl,'TEMP_DOWNLOAD_BEACCOUNTS','layout/be_template_mod3.html');
						
						$ma_upd['###PFAD_UPDATE_BEACCOUNTS###'] = $this->indexpath.'&communeid='.$communeid.'&schoolid='.$schoolid.'&beuser=1&anz_beacc_upd_'.$groupid.'=1';
						$markerArray['###UPDATE_ACCOUNTS###'] = tx_itaoshhmanager_library::template_ausgeben($ma_upd,'TEMP_UPDATE_BEACCOUNTS','layout/be_template_mod3.html');
					} else {						
						$markerArray['###DOWNLOAD_ACCOUNTS###'] = "";#" [noch kein PDF vorhanden]";
						$markerArray['###UPDATE_ACCOUNTS###'] = "";
					}
					
					$templPart = 'BOX_BODY_BEUSER';					
					$html = tx_itaoshhmanager_library::template_ausgeben($markerArray,$templPart , 'layout/be_template_mod3.html');
					#$html .= tx_itaoshhmanager_library::template_ausgeben($markerArray, 'BOX_JS', 'layout/be_template_mod3.html');
					return $html;
				}
				
				
				function getSideboxBeUser($communeid, $schoolid) {
					global $LANG;
					$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
					$communeid = ($communeid > 0) ? $communeid: $schooldata['ref_commune'];
					$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);
					$allPhasenSchool = tx_itaoshhmanager_database::getAllPhasen();
					$allBeUserGroups[1]['uid'] = $this->tsvars['be_groupid_redadmin_kommune'];
					$allBeUserGroups[1]['is_school'] = 0;
					$allBeUserGroups[2]['uid'] = $this->tsvars['be_groupid_redadmin_schule'];
					$allBeUserGroups[2]['is_school'] = 1;
					$allBeUserGroups[3]['uid'] = $this->tsvars['be_groupid_mod_kommune'];
					$allBeUserGroups[3]['is_school'] = 0;
					$allBeUserGroups[4]['uid'] = $this->tsvars['be_groupid_mod_schule'];
					$allBeUserGroups[4]['is_school'] = 1;
					while (list ($key, $val) = each ($allBeUserGroups)) {
						$is_school = $val['is_school'];
						$anz+=tx_itaoshhmanager_database::getAnzBeAccountBySchool($communeid,$schoolid,$is_school,$val['uid']);
						$anzs[$val['uid']]=tx_itaoshhmanager_database::getAnzBeAccountBySchool($communeid,$schoolid,$is_school,$val['uid']);
						#t3lib_utility_debug::debug("anz ".tx_itaoshhmanager_database::getAnzBeAccountBySchool($communeid,$schoolid,$is_school,$val['uid']));
					}
					#t3lib_utility_debug::debug($anzs);
					$markerArray['###ANZ_ACCOUNTS_GESAMT###'] = $anz;#tx_itaoshhmanager_database::getAnzBeAccountBySchool($communeid,$schoolid,$is_school,$groupid);
					$html .= tx_itaoshhmanager_library::template_ausgeben($markerArray, 'SIDEBOX_USER', 'layout/be_template_mod3.html');
					return $html;
				}
				
				
				function getBenutzerEditPage($communeid,$schoolid) {
					global $LANG, $BE_USER;
					
					if ($this->piVars['search_reset']!="") {
						$this->piVars['search_valueuser'] = "";
						$this->piVars['filter_state'] = "";
						$this->piVars['filter_usergroups'] = "";
						$GLOBALS["BE_USER"]->setAndSaveSessionData ('search_valueuser', "");
						$GLOBALS["BE_USER"]->setAndSaveSessionData ('filter_state', "");
						$GLOBALS["BE_USER"]->setAndSaveSessionData ('filter_usergroups', "");
					}
					$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
					$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);
					/* FÜR SORTIERUNG*/
							$ses_col = $GLOBALS["BE_USER"]->getSessionData("sortcol");
							$ses_dir = $GLOBALS["BE_USER"]->getSessionData("sortdir");
							$search_value = $GLOBALS["BE_USER"]->getSessionData("search_valueuser");
							$search_value_state = $GLOBALS["BE_USER"]->getSessionData("filter_state");
							$search_value_group = $GLOBALS["BE_USER"]->getSessionData("filter_usergroups");
							# angezeigt wird das gegenteil
							$sort_nach = ($this->piVars['sortcol']) ? $this->piVars['sortcol'] : $ses_col; 
							$sort_dir = ($this->piVars['sortdir']) ? $this->piVars['sortdir'] : $ses_dir; 
							$search_value = ($this->piVars['search_valueuser']) ? $this->piVars['search_valueuser'] : $search_value;
							$search_value_state = ($this->piVars['filter_state']) ? $this->piVars['filter_state'] : $search_value_state;
							$search_value_group = ($this->piVars['filter_usergroups']) ? $this->piVars['filter_usergroups'] : $search_value_group; 
							
							if ($sort_nach == 0) {
								$sort_nach = 1;
							}
							if ($this->piVars['sortcol']) {								
								$GLOBALS["BE_USER"]->setAndSaveSessionData ('sortcol', $this->piVars['sortcol']);
							} 					
							
							if ($this->piVars['sortdir']) {								
								$GLOBALS["BE_USER"]->setAndSaveSessionData ('sortdir', $this->piVars['sortdir']);
							}
							
							if ($this->piVars['search_valueuser']) {								
								$GLOBALS["BE_USER"]->setAndSaveSessionData ('search_valueuser', $this->piVars['search_valueuser']);
							}
							
							if ($this->piVars['filter_state']) {								
								$GLOBALS["BE_USER"]->setAndSaveSessionData ('filter_state', $this->piVars['filter_state']);
							}  else {
								$GLOBALS["BE_USER"]->setAndSaveSessionData ('filter_state', "");
								unset($this->piVars['filter_state']);
								$search_value_state = 0;
							}
							
							if ($this->piVars['filter_usergroups']) {								
								$GLOBALS["BE_USER"]->setAndSaveSessionData ('filter_usergroups', $this->piVars['filter_usergroups']);
							} else {
								$GLOBALS["BE_USER"]->setAndSaveSessionData ('filter_usergroups', "");
								unset($this->piVars['filter_usergroups']);
								$search_value_group = 0;
							}	
												
							
							$sortArr = array();
							$sortArr[1]['title'] = 'firstname';						
							$sortArr[2]['title'] = 'lastname';					
							$sortArr[3]['title'] = 'username';						
							$sortArr[4]['title'] = 'usergroup';	
							$opp_other = 'desc';
							while (list ($key, $val) = each ($sortArr)) {
								if ($key == $sort_nach) {
									$opp_dir = ($sort_dir == 'desc') ? 'asc' : 'desc';
								} else {
									#if ($key == 7 || $key == 8 || $key == 6 || $key == 3) {
									#	$opp_dir = 'desc';
									#} else {
										$opp_dir = 'asc';
									#}
								}								
								$cssClass = ($key == $sort_nach) ? 'sorted_'.$opp_dir: '';
								$ma_det_sc['###SORT_CLASS_'.strtoupper($val['title']).'###'] = $cssClass;
								$ma_det_sc['###SORTPATH_'.strtoupper($val['title']).'###'] = $this->indexpath.'&sortcol='.$key.'&sortdir='.$opp_dir.'&benutzeredit=1&smnr='.$this->piVars['smnr'].'&communeid='.$communeid.'&schoolid='.$schoolid;
							}
					
					# für Suche
					$ma_det_sc['###SEARCH_VALUE_STD###'] = $LANG->getLL('std_searchinput_edituser', TRUE);
					$ma_det_sc['###FORMACTION###'] = $this->indexpath.'&sortcol='.$key.'&sortdir='.$opp_dir.'&benutzeredit=1&smnr='.$this->piVars['smnr'].'&communeid='.$communeid.'&schoolid='.$schoolid;
					$ma_det_sc['###SEARCH_VALUE###'] =  ($search_value!="") ? $search_value : $LANG->getLL('std_searchinput_edituser', TRUE);
					
					if ($GLOBALS["BE_USER"]->getSessionData("search_valueuser") == $LANG->getLL('std_searchinput_edituser', TRUE)) {
						$search_value = "";
						$GLOBALS["BE_USER"]->setAndSaveSessionData ('search_valueuser', "");
						$this->piVars['search_valueuser'] ="";						
					}
					# Content über Tabs:
					$ma['###SCHOOL_TITLE###'] = $schooldata['title'];
					$ma['###SC_ORT###'] = ($schooldata['city']!="") ? '('.$schooldata['city'].')' : '';$locat = urlencode('mod.php?M=txitaoshhmanagerM0_txitaoshhmanagerM3');
					$ma['###JS_EDIT###'] = tx_itaoshhmanager_library::js_fuer_ds_bearbeiten($locat);
					$html_oben =  tx_itaoshhmanager_library::template_ausgeben($ma, 'TEMPLATE_FEUSER_EDITPAGE', 'layout/be_template_mod3.html');

					# Content im Tab
					$this->anz_ergebnisse = 0;
					$ma_det_sc['###TABLEROWS_FEUSEREDIT###'] = $this->getFEUserTableRows($communeid,$schoolid,$sort_nach, $sort_dir);
					$ma_det_sc['###SIDEBOX###'] = '';#$this->getSideboxOffers($schoolid);
					$ma_det_sc['###ANZ_ERGEBNISSE###'] = $this->anz_ergebnisse;
					
					$ma_det_sc['###OPTIONS_USERGROUPS###'] = tx_itaoshhmanager_library::getUsedUsergroupsOptions($communeid,$schoolid,$this->allFoundUsers);
					#$search_value_state
					for ($xi = 0; $xi<=2; $xi++) {
						$ma_det_sc['###PRESEL_'.$xi.'###'] = ($search_value_state == $xi) ? ' selected="selected" ': '';
					}
					
					$ma_det_sc['###DISPLAY_CLASS_SEARCH###'] = 	($search_value!=""|| $search_value_state > 0 || $search_value_group > 0) ? '': 'display_none';	
					
				#			t3lib_utility_debug::debug( "search_value_state:".$search_value_state);
				#			t3lib_utility_debug::debug( "search_value_group:".$search_value_group); 
				#			$search_value_state = $GLOBALS["BE_USER"]->getSessionData("filter_state");
				#			$search_value_group = $GLOBALS["BE_USER"]->getSessionData("filter_usergroups");
					
					$html = tx_itaoshhmanager_library::template_ausgeben($ma_det_sc, 'TEMPLATE_FEUSER_EDIT_CONTENT', 'layout/be_template_mod3.html');	
					
					
					# fuer Tabs
					$rechte_ist_arr = ($BE_USER->user['usergroup']!="" ) ? explode(",", $BE_USER->user['usergroup']) : array();					
					if (!in_array($this->tsvars['be_groupid_mod_schule'],$rechte_ist_arr ) && !in_array($this->tsvars['be_groupid_redadmin_schule'],$rechte_ist_arr )) { 
						$submoduls[0] = $LANG->getLL('submodule_commune');#
					}
					if (tx_itaoshhmanager_general::hasRights(2,2)) {
						$submoduls[1] = $LANG->getLL('submodule_school');
						$submoduls[2] = $LANG->getLL('submodule_school_user');
						
						# neu: für FE-User bearbeiten 
						#$submoduls[8] = $LANG->getLL('submodule_school_editfeuser');
					}
					
					# für Red.Admin kommune NICHT anzeigen, wenn in Schule
					if ((tx_itaoshhmanager_general::isInBeUserGroup($BE_USER->user['usergroup'], $this->tsvars['be_groupid_redadmin_kommune'])) && $schoolid > 0 && !$BE_USER->user['admin']) {
						unset($submoduls[2]);
					}
					
					
					$submoduls[3] = $LANG->getLL('submodule_school_article');
					if (tx_itaoshhmanager_general::hasRights(5,2)  || tx_itaoshhmanager_general::hasRights(6,2)) {
						$submoduls[5] = $LANG->getLL('submodule_school_beuser');
					}
					
					if (tx_itaoshhmanager_general::hasRights(7,3)) {
#!#!#						$submoduls[8] = $LANG->getLL('submodule_school_editfeuser');
					}
					
					
					$active = 8;
					$html = $html_oben .$breadcrumb. tx_itaoshhmanager_navigation::getSubmodulNavi($submoduls,$active, $html, 'long');
					$html .= tx_itaoshhmanager_library::template_ausgeben($markerArray, 'BOX_JS', 'layout/be_template_mod3.html');
					return $html;
				}
				
				
				
				function getFEUserTableRows($communeid,$schoolid,$sort_nach = 1, $sort_dir="asc") {
					global $LANG;
					$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
					#$communeid = $schooldata['ref_commune'];
					$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);
					
					if ($this->piVars['search_reset']!="") {
						$this->piVars['search_valueuser'] = "";
						$GLOBALS["BE_USER"]->setAndSaveSessionData ('search_valueuser', "");
					}
							
					if ($this->piVars['search_valueuser']== $LANG->getLL('std_searchinput', TRUE)) {
						$this->piVars['search_valueuser'] = "";
						$GLOBALS["BE_USER"]->setAndSaveSessionData ('search_valueuser', "");
					} 
							
							if ($this->piVars['filter_state']) {								
								$GLOBALS["BE_USER"]->setAndSaveSessionData ('filter_state', $this->piVars['filter_state']);
							} 
							
							if ($this->piVars['filter_usergroups']) {								
								$GLOBALS["BE_USER"]->setAndSaveSessionData ('filter_state', $this->piVars['filter_state']);
							}  
					
								
					$allOffers = tx_itaoshhmanager_database::getAllUsersBySchool($schoolid, $groupid, 1,$sort_nach, $sort_dir,1);#getAllOffersBySchool($communeid,$schoolid,0,$sort_nach, $sort_dir);
					$allUsergroups = tx_itaoshhmanager_database::getAllUsergroups();
					#getAllUsersBySchool($schoolid, $groupid, $registered=0)
					$this->allFoundUsers = $allOffers; 
					
					if (is_array($allOffers)) {
						$this->anz_ergebnisse = count($allOffers);
						while (list ($key, $val) = each ($allOffers)) {
							$markerArray['###USERID###'] 	= $val['uid'];
							$markerArray['###FIRSTNAME###'] = $val['first_name'];
							$markerArray['###LASTNAME###'] = $val['last_name'];
							$markerArray['###USERNAME###'] = $val['username'];
							$markerArray['###SCHOOLCLASS###'] = ($val['tx_itaoshhmanager_shh_classname']!="") ? $val['tx_itaoshhmanager_shh_classname'] : '<span class="listgrey">&mdash;</span>';
							
							# 1. die Usergroup für die Schule rausfiltern
							# 2. oder für die Kommune
							
							# 3. nur die Rolle ausgeben
							if ($val['usergroup']!="") {
		  					$row_groupsarr = explode(",", $val['usergroup']);
		  					if (is_array($row_groupsarr)) {
									while (list ($keyu, $valu) = each ($row_groupsarr)) {
										if (intval($allUsergroups[$valu]['tx_itaoshhmanager_ssh_ref_school']) == 0) {
											$groupname = $allUsergroups[$valu]['title'];
										}
									}
								}
							 }	
							
							$markerArray['###USERGROUP###'] = $groupname;
							#$markerArray['###USER_STATUS###'] = (!$val['disable']) ? '<span class="statusGreen">aktiv<span>' : '<span class="statusRed">gesperrt</span>';
							#if ($val['disable']) { # dann geblockt
							#} else {
							#	$markerArray['###STATUS_IMAGE###'] = 
								
							#}
							$markerArray['###STATUS_IMAGE###'] = $val['disable'];
							$markerArray['###STATUS_TITLE###'] = (!$val['disable']) ? 'aktiv' : 'gesperrt';
							$markerArray['###USER_STATUS_LABEL###'] = "";(!$val['disable']) ? '<span class="statusGreen">aktiv<span>' : '<span class="statusRed">gesperrt</span>';
							
							$link_to_module = $this->indexpath.'&sortcol='.$sort_nach.'&sortdir='.$sort_dir.'&benutzeredit=1&smnr='.$this->piVars['smnr'].'&communeid='.$communeid.'&schoolid='.$schoolid;
							$markerArray['###LINK_DE_ACT_USER###'] = $link_to_module;
							$markerArray['###LINK_DE_ACT_USER###'].= ($val['disable']) ? '&useract='.$val['uid'] : '&userdeact='.$val['uid'] ;
							$markerArray['###USERACTION_LABEL###']= ($val['disable']) ? 'freischalten' : 'sperren' ;
							
							$markerArray['###LINK_PW_ORIGINAL###']=$link_to_module.'&pw_original='.$val['uid'];
							
							$changed = tx_itaoshhmanager_database::getAllPwLoggingsByUser($val['uid']);
							if (count($changed) > 0) {
								$xyz = 0;
								while (list ($keych, $valch) = each ($changed)) {
									$xyz++;
									$beuserdata = tx_itaoshhmanager_database::getBeUserName($valch['ref_beuser']);
									$ergaenzung="\n".$xyz.'.: '.date("d.m.Y, H:i",$keych).' Uhr von '.$beuserdata;
									#$markerArray['###ZURUECKGESETZT###'].='<span title="'.$ergaenzung.'">- '.date("d.m.Y",$keych).'</span><br />';
								}
								
								$markerArray['###ZURUECKGESETZT###']= '<span title="'.$ergaenzung.'">'.count($changed).' Mal'."</span>";
							} else {
								$markerArray['###ZURUECKGESETZT###'] = '<span class="listgrey">&mdash;</span>';
							}
								
							
							
							
							
							
							
							
							#$markerArray['###EDIT_OFFER_LINK###'] 	= tx_itaoshhmanager_general::getEditLink($LANG->getLL('l_editOffer'), 'tx_itaoshhoffers_domain_model_offer', $val['uid'],array(), $back_params,1);
							#$markerArray['###OFFER_TITLE###'] 	= $val['title'];
							#$username = ($val['name']!="") ? $val['name'] : $val['first_name']." ".$val['last_name'];
							#$username = (trim($username)=="") ? $val['username'] : $username;
							#$markerArray['###SUBMITTED_BY###'] 	= $username;
							#$markerArray['###DATE###'] 	= date("d.m.Y", $val['crdate']);
							#$markerArray['###STATUS_IMAGE###'] 	= 'state_offer_'.$val['status'].'.png';
							#$markerArray['###STATUS_LABEL###'] 	= strtolower($allOffStati[$val['status']]['title']); 
							#$markerArray['###ASSIGNED_TO###'] 	= '[ASSIGNED_TO]';
							#$comments = tx_itaoshhmanager_database::getCommentsByOffer($val['uid']);
							#$comuser = array();
							#$commented = '';
							/*if (is_array($comments)) {
								while (list ($key_c, $val_c) = each ($comments)) {
									$cuser_data = tx_itaoshhmanager_database::getUserData($val_c['fe_user']);
							#t3lib_utility_debug::debug($cuser_data);
									$cusername = ($cuser_data['name']!="") ? $cuser_data['name'] : $cuser_data['first_name']." ".$cuser_data['last_name'];
									$cusername = (trim($cusername)=="") ? $cuser_data['username'] : $cusername;									
									$comuser[] = $cusername;
								}
								#$name_commenter = 
								$commented = 'von '.implode(",", $comuser);
							} else {
								$commented = '<span class="listgrey">---</span>';
							}
							$markerArray['###COMMENTED###'] 	= $commented;
							$markerArray['###HELP_WANTED###'] 	=  ($val['costs_help']) ? 'ja' : 'nein';
							
							$all_dis_likes = tx_itaoshhmanager_database::getLikesDislikesPerOffer($val['uid']);
							*/
							
							$html .= tx_itaoshhmanager_library::template_ausgeben($markerArray, 'TEMPLATE_TABLEROWS_USERSEDIT', 'layout/be_template_mod3.html');
						}
					} else {
						$html .=tx_itaoshhmanager_library::template_ausgeben($markerArray, 'TEMPLATE_NO_USERSEDIT', 'layout/be_template_mod3.html');
					}
					
					return $html;
				}
				
				function getChildingpage($schoolid, $offerid) {
					global $LANG, $BE_USER; global $_SERVER;
					$schooldata = tx_itaoshhmanager_database::getSchoolById($schoolid);
					$communeid = $schooldata['ref_commune'];
					$communedata = tx_itaoshhmanager_database::getCommunesById($communeid);
					$offerData = tx_itaoshhmanager_database::getOfferById($offerid);			
					# Content über Tabs:
					$ma['###SCHOOL_TITLE###'] = $schooldata['title'];					
					$ma['###OFFER_INTID###'] = $offerData['internal_id'];
					$ma['###SC_ORT###'] = ($schooldata['city']!="") ? '('.$schooldata['city'].')' : '';$locat = urlencode('mod.php?M=txitaoshhmanagerM0_txitaoshhmanagerM3');
					$ma['###JS_EDIT###'] = tx_itaoshhmanager_library::js_fuer_ds_bearbeiten($locat);
					$html_oben =  tx_itaoshhmanager_library::template_ausgeben($ma, 'TEMPLATE_OFFER_VIEW', 'layout/be_template_mod3.html');
					
					$childoffers = tx_itaoshhmanager_database::getChildOffers($offerid,2,1);
					$anz_childoffers = count($childoffers);
					# Content im Tab
					/*if ($offerData['parent_offer'] == 0 && $offerData['child_offers'] > 0) {*/
					if ($offerData['parent_offer'] == 0 && $anz_childoffers > 0) {
						$ma_off_det['###OFFER_TITLE###'] = $offerData['title'];
						
						if (is_array($childoffers)) {
							while (list ($key, $val) = each ($childoffers)) {
								$offerDataChild = tx_itaoshhmanager_database::getOfferById($key);	
								$ma_off_det['###CHILD_OFFERS###'].='
									<li>
										<div class="unlinkOrder_single">
											<a href="'.$this->indexpath.'&communeid='.$communeid.'&schoolid='.$schoolid.'&offerid='.$key.'&is_chained=1" title="Wechseln zur Detailansicht dieses Vorschlags">
											<u>'.$offerDataChild['title'].' (Nr. '.$offerDataChild['internal_id'].')</u></a>
										</div> 
										<span class="unchain_offer">
											<img src="/typo3conf/ext/itao_shh_manager/layout/images/unlink.png" />
											<a href="'.$this->indexpath.'&smnr='.$this->piVars['smnr'].'&communeid='.$communeid.'&schoolid='.$schoolid.'&offerid='.$offerid.'&childingme=1&unchainoffer='.$key.'"
											onclick="return confirm(\'Wollen Sie die Zuordnung dieses Vorschlags wirklich l\xF6sen?\');">
											<u>Vom Vorschlag l&ouml;sen</u></a>
										</span>
									</li>';
								# 1. Daten herausk
							}
						} else {
							$ma_off_det['###CHILD_OFFERS###'] = 'Keine Zuordnungen vorhanden';
						}
						#$ma_off_det['###CHILD_OFFERS###'] = $offerData['title'];
						$html = tx_itaoshhmanager_library::template_ausgeben($ma_off_det, 'TEMPLATE_OFFER_PARENTING', 'layout/be_template_mod3.html');	
					} else {
						$offersarr = tx_itaoshhmanager_database::getAllOffersBySchool($schoolid, 0,1,"asc",0, 1,1,$offerid);
						$ma_off_det['###OFFER_TITLE###'] = $offerData['title'];
						$ma_off_det['###OFFERID###'] = $offerData['internal_id'];
						$ma_off_det['###FORMURL###'] = $this->indexpath.'&smnr='.$this->piVars['smnr'].'&communeid='.$communeid.'&schoolid='.$schoolid.'&offerid='.$offerid;					
						$ma_off_det['###OPTIONS_PARENTS###'] = tx_itaoshhmanager_library::makeOptions($offersarr, "title", $offerData['parent_offer'],1, 0, 1);
						
						$html = tx_itaoshhmanager_library::template_ausgeben($ma_off_det, 'TEMPLATE_OFFER_CHILDING', 'layout/be_template_mod3.html');	
					}
					
					# fuer Tabs
					$rechte_ist_arr = ($BE_USER->user['usergroup']!="" ) ? explode(",", $BE_USER->user['usergroup']) : array();					
			
					$submoduls[3] = $LANG->getLL('submodule_school_article');
					$submoduls[4] = $LANG->getLL('submodule_offer_detail');
					$active = 15;
					$submoduls[15] = "Zuordnung des Vorschlags";#
				
					$this->myModule = 'mod3';
					$html = $html_oben .$breadcrumb. tx_itaoshhmanager_navigation::getSubmodulNavi($submoduls,$active, $html, 'long');
					$html .= tx_itaoshhmanager_library::template_ausgeben($markerArray, 'BOX_JS', 'layout/be_template_mod3.html');
					return $html;
				}
				
				
				
				
				

				/**
				 * Create the panel of buttons for submitting the form or otherwise perform operations.
				 *
				 * @return	array	all available buttons as an assoc. array
				 */
				protected function getButtons()	{

					$buttons = array(
						'csh' => '',
						'shortcut' => '',
						'save' => ''
					);
						// CSH
					$buttons['csh'] = t3lib_BEfunc::cshItem('_MOD_web_func', '', $GLOBALS['BACK_PATH']);

						// SAVE button
					$buttons['save'] = '<input type="image" class="c-inputButton" name="submit" value="Update"' . t3lib_iconWorks::skinImg($GLOBALS['BACK_PATH'], 'gfx/savedok.gif', '') . ' title="' . $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.php:rm.saveDoc', 1) . '" />';


						// Shortcut
					if ($GLOBALS['BE_USER']->mayMakeShortcut())	{
						$buttons['shortcut'] = $this->doc->makeShortcutIcon('', 'function', $this->MCONF['name']);
					}

					return $buttons;
				}
				
				
				
				
				
				
				
				
				
				
				
				
		}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/itao_shh_manager/mod3/index.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/itao_shh_manager/mod3/index.php']);
}




// Make instance:
$SOBE = t3lib_div::makeInstance('tx_itaoshhmanager_module3');
$SOBE->init();

// Include files?
foreach($SOBE->include_once as $INC_FILE)	include_once($INC_FILE);

$SOBE->main();
$SOBE->printContent();

?>