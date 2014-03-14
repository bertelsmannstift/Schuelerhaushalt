<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_itaoshhoffers_domain_model_offer'] = array(
	'ctrl' => $TCA['tx_itaoshhoffers_domain_model_offer']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, description, costs_student, costs_edited, costs, images, idea_from, promoted_from,  status, likes, dislikes, likes_dislikes, comments, fe_user, school, commune, log,votes,parent_offer',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, description, costs_student,costs, images, idea_from, promoted_from, status, likes, dislikes, likes_dislikes, comments, fe_user, school, commune, log,votes,parent_offer,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_itaoshhoffers_domain_model_offer',
				'foreign_table_where' => 'AND tx_itaoshhoffers_domain_model_offer.pid=###CURRENT_PID### AND tx_itaoshhoffers_domain_model_offer.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'description' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer.description',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 5,
				'eval' => 'trim,required',
				/*
				'wizards' => array(
					'RTE' => array(
						'icon' => 'wizard_rte2.gif',
						'notNewRecords'=> 1,
						'RTEonly' => 1,
						'script' => 'wizard_rte.php',
						'title' => 'LLL:EXT:cms/locallang_ttc.xml:bodytext.W.RTE',
						'type' => 'script'
					)
				)*/
			),
			#'defaultExtras' => 'richtext[]',
		),
		'internal_id' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer.internal_id',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'trim,int,required'
			),
		),
		'costs_student' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer.costs_student',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'costs' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer.costs',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'edited' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer.edited',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'costs_edited' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer.costs_edited',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		
		'images' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer.images',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file',
				'uploadfolder' => 'uploads/tx_itaoshhoffers',
				'show_thumbs' => 1,
				'size' => 5,
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],
				'disallowed' => '',
				'maxitems' => 3,
			),
		),
		'idea_from' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer.idea_from',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_itaoshhoffers_domain_model_idea',
				'foreign_field' => 'offer',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapse' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'promoted_from' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer.promoted_from',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_itaoshhoffers_domain_model_promoter',
				'foreign_field' => 'offer',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapse' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'status' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer.status',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_itaoshhoffers_domain_model_status',
//				'foreign_table_where' => ' AND tx_itaoshhoffers_domain_model_status.deleted = 0 AND tx_itaoshhoffers_domain_model_status.hidden=0',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'likes_dislikes' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer.likes_dislikes',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_itaoshhoffers_domain_model_likedislike',
				'MM' => 'tx_itaoshhoffers_offer_likedislike_mm',
				'size' => 10,
				'autoSizeMax' => 30,
				'maxitems' => 9999,
				'multiple' => 0,
				'wizards' => array(
					'_PADDING' => 1,
					'_VERTICAL' => 1,
					'edit' => array(
						'type' => 'popup',
						'title' => 'Edit',
						'script' => 'wizard_edit.php',
						'icon' => 'edit2.gif',
						'popup_onlyOpenIfSelected' => 1,
						'JSopenParams' => 'height=350,width=580,status=0,menubar=0,scrollbars=1',
						),
					'add' => Array(
						'type' => 'script',
						'title' => 'Create new',
						'icon' => 'add.gif',
						'params' => array(
							'table' => 'tx_itaoshhoffers_domain_model_likedislike',
							'pid' => '###CURRENT_PID###',
							'setValue' => 'prepend'
							),
						'script' => 'wizard_add.php',
					),
				),
			),
		),
		'likes' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer.likes',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_itaoshhoffers_domain_model_like',
				'foreign_field' => 'offer',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapse' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		
		'dislikes' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer.dislikes',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_itaoshhoffers_domain_model_dislike',
				'foreign_field' => 'offer',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapse' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),	
		'comments' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer.comments',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_itaoshhoffers_domain_model_comment',
				'foreign_field' => 'offer',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapse' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'fe_user' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer.fe_user',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'fe_users',
//				'foreign_table_where' => ' AND deleted = 0 AND hidden=0',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'school' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer.school',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_itaoshhmanager_schools',
				'foreign_table_where' => ' ORDER BY title',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'commune' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer.commune',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_itaoshhmanager_communes',
				'foreign_table_where' => ' ORDER BY titel',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'log' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer.log',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_itaoshhoffers_domain_model_offerlog',
				'foreign_field' => 'offer',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapse' => 0,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
		'crdate' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'votes' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer.votes',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'trim,int'
			),
		),
		'child_offers' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer.child_offers',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_itaoshhoffers_domain_model_offer',
				'foreign_table_where' => ' ORDER BY tx_itaoshhoffers_domain_model_offer.title',
				'foreign_field' => 'parent_offer',
				'size' => 5,
				'items' => array(
					array('', 0)
				),
				'maxitems'      => 99999,
			),
		),
		'new_offer' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offer.new_offer',
			'config' => array(
				'type' => 'check',
			),
		),
		'offer' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
	),
);

?>