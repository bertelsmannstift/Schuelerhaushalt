<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_itaoshhoffers_domain_model_offerlog'] = array(
	'ctrl' => $TCA['tx_itaoshhoffers_domain_model_offerlog']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, date, description, fe_user, action',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, date, description, fe_user, action,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,starttime, endtime'),
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
				'foreign_table' => 'tx_itaoshhoffers_domain_model_offerlog',
				'foreign_table_where' => 'AND tx_itaoshhoffers_domain_model_offerlog.pid=###CURRENT_PID### AND tx_itaoshhoffers_domain_model_offerlog.sys_language_uid IN (-1,0)',
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
		'date' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offerlog.date',
			'config' => array(
				'type' => 'input',
				'size' => 10,
				'eval' => 'datetime',
				'checkbox' => 1,
				'default' => time()
			),
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offerlog.description',
			'config' => array(
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			),
		),
		'fe_user' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offerlog.fe_user',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'fe_users',
//				'foreign_table_where' => ' AND deleted = 0 AND hidden=0',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'cruser_id' => array(
		'exclude' => 0,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offerlog.be_user',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'be_users',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'action' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:itao_shh_offers/Resources/Private/Language/locallang_db.xml:tx_itaoshhoffers_domain_model_offerlog.action',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_itaoshhoffers_domain_model_action',
//				'foreign_table_where' => ' AND tx_itaoshhoffers_domain_model_action.deleted = 0 AND tx_itaoshhoffers_domain_model_action.hidden=0',
				'minitems' => 0,
				'maxitems' => 1,
			),
		),
		'offer' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		'school' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		'commune' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		'fe_groups' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
	),
);

?>