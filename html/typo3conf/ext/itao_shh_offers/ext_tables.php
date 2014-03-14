<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Offers',
	'Vorschläge'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'SchoolData',
	'Schuldaten'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'OfferStatus',
	'Status meiner Vorschläge'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Print',
	'Vorschläge Drucken'
);
	
Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Feedback',
	'Feedback'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'SortAndFilter',
	'Box: Vorschläge sortieren und filtern'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'RedirectToCommunePage',
	'Weiterleitung auf Kommunenseite (Kommunenverwalter)'
);

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'CommuneList',
	'Liste der Kommunen'
);


$extensionName = t3lib_div::underscoredToUpperCamelCase($_EXTKEY);

// Flexform Offers
$pluginSignature = strtolower($extensionName) . '_offers';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForms/offers_flexform.xml');

// Flexform School
$pluginSignature = strtolower($extensionName) . '_schooldata';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForms/schooldata_flexform.xml');

// Flexform Print
$pluginSignature = strtolower($extensionName) . '_print';
$TCA['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:'.$_EXTKEY.'/Configuration/FlexForms/print_flexform.xml');


t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Vorschläge');

			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_offer', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_offer.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_offer');
			$TCA['tx_itaoshhoffers_domain_model_offer'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer',
					'label' => 'title',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Offer.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/offer.gif',
					'default_sortby' => 'title',
					'foreign_default_sortby' => 'title',
					'searchFields' => 'title'
				),
			);


			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_idea', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_idea.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_idea');
			$TCA['tx_itaoshhoffers_domain_model_idea'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_idea',
					'label' => 'name',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Idea.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/idea.gif'
				),
			);
			
			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_promoter', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_promoter.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_promoter');
			$TCA['tx_itaoshhoffers_domain_model_promoter'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_promoter',
					'label' => 'name',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Promoter.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/promoter.gif'
				),
			);

			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_status', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_status.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_status');
			$TCA['tx_itaoshhoffers_domain_model_status'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_status',
					'label' => 'title',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Status.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/status.gif'
				),
			);
			
			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_action', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_action.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_action');
			$TCA['tx_itaoshhoffers_domain_model_action'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_action',
					'label' => 'title',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Action.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/status.gif',
					'default_sortby' => 'tstamp',
					'searchFields' => 'title'
				),
			);

//			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_likedislike', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_likedislike.xml');
//			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_likedislike');
//			$TCA['tx_itaoshhoffers_domain_model_likedislike'] = array(
//				'ctrl' => array(
//					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_likedislike',
//					'label' => 'status',
//					'tstamp' => 'tstamp',
//					'crdate' => 'crdate',
//					'cruser_id' => 'cruser_id',
//					'dividers2tabs' => TRUE,
//					'versioningWS' => 2,
//					'versioning_followPages' => TRUE,
//					'origUid' => 't3_origuid',
//					'languageField' => 'sys_language_uid',
//					'transOrigPointerField' => 'l10n_parent',
//					'transOrigDiffSourceField' => 'l10n_diffsource',
//					'delete' => 'deleted',
//					'enablecolumns' => array(
//						'disabled' => 'hidden',
//						'starttime' => 'starttime',
//						'endtime' => 'endtime',
//					),
//					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/LikeDislike.php',
//					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/like.gif'
//				),
//			);
			
			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_dislike', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_dislike.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_dislike');
			$TCA['tx_itaoshhoffers_domain_model_dislike'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_dislike',
					'label' => 'fe_user',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Dislike.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/like.gif'
				),
			);

			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_like', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_like.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_like');
			$TCA['tx_itaoshhoffers_domain_model_like'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_like',
					'label' => 'fe_user',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Like.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/like.gif'
				),
			);

			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_comment', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_comment.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_comment');
			$TCA['tx_itaoshhoffers_domain_model_comment'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_comment',
					'label' => 'text',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Comment.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/comment.gif'
				),
			);

			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_commentlog', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_commentlog.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_commentlog');
			$TCA['tx_itaoshhoffers_domain_model_commentlog'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_commentlog',
					'label' => 'date',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/CommentLog.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/log.gif'
				),
			);
			
			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_filter', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_filter.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_filter');
			$TCA['tx_itaoshhoffers_domain_model_filter'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_filter',
					'label' => 'title',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Filter.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/filter.gif'
				),
			);
			
			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_filteroption', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_filteroption.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_filteroption');
			$TCA['tx_itaoshhoffers_domain_model_filteroption'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_filteroption',
					'label' => 'title',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/FilterOption.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/option.gif',
					'default_sortby' => 'sorting'
				),
			);
			
			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_sort', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_sort.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_sort');
			$TCA['tx_itaoshhoffers_domain_model_sort'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_sort',
					'label' => 'title',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Sort.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/sort.gif'
				),
			);
			
			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_sortoption', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_sortoption.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_sortoption');
			$TCA['tx_itaoshhoffers_domain_model_sortoption'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_sortoption',
					'label' => 'title',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/SortOption.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/option.gif',
					'default_sortby' => 'sorting'
				),
			);

$tmp_itao_shh_offers_columns = array(

);

t3lib_extMgm::addTCAcolumns('fe_users',$tmp_itao_shh_offers_columns);

$TCA['fe_users']['columns'][$TCA['fe_users']['ctrl']['type']]['config']['items'][] = array('LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:fe_users.tx_extbase_type.Tx_ItaoShhOffers_FeUser','Tx_ItaoShhOffers_FeUser');

$TCA['fe_users']['types']['Tx_ItaoShhOffers_FeUser']['showitem'] = $TCA['fe_users']['types']['1']['showitem'];
$TCA['fe_users']['types']['Tx_ItaoShhOffers_FeUser']['showitem'] .= ',--div--;LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_feuser,';
$TCA['fe_users']['types']['Tx_ItaoShhOffers_FeUser']['showitem'] .= '';

			t3lib_extMgm::addLLrefForTCAdescr('tx_itaoshhoffers_domain_model_offerlog', 'EXT:itao_shh_offers/Resources/Private/Language/locallang_csh_tx_itaoshhoffers_domain_model_offerlog.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_itaoshhoffers_domain_model_offerlog');
			$TCA['tx_itaoshhoffers_domain_model_offerlog'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offerlog',
					'label' => 'date',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/OfferLog.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/log.gif',
					'default_sortby' => 'date'
				),
			);

?>