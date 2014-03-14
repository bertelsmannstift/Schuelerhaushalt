<?php

$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tstemplate.php']['linkData-PostProc']['tx_realurl'] = 'EXT:realurl/class.tx_realurl.php:&tx_realurl->encodeSpURL'; 
$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/class.tslib_fe.php']['checkAlternativeIdMethods-PostProc']['tx_realurl'] = 'EXT:realurl/class.tx_realurl.php:&tx_realurl->decodeSpURL'; 
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearPageCacheEval']['tx_realurl'] = 'EXT:realurl/class.tx_realurl.php:&tx_realurl->clearPageCacheMgm'; 
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['clearAllCache_additionalTables']['tx_realurl_urlencodecache'] = 'tx_realurl_urlencodecache'; 

$TYPO3_CONF_VARS['FE']['addRootLineFields'].= ',tx_realurl_pathsegment';
$TYPO3_CONF_VARS['EXTCONF']['realurl']['_DEFAULT'] = array (
	'init' => array(
		'enableCHashCache' => 'TRUE',
		'respectSimulateStaticURLs' => 'TRUE',
		'appendMissingSlash' => 'ifNotFile',
		'enableUrlDecodeCache' => 'FALSE',
		'enableUrlEncodeCache' => 'FALSE',
		'emptyUrlReturnValue' => '/',
	),
	'pagePath' => array(
		'type' => 'user',
		'userFunc' => 'EXT:realurl/class.tx_realurl_advanced.php:&tx_realurl_advanced->main',
		'spaceCharacter' => '-',
		'expireDays' => 30,
		'segTitleFieldList' => 'tx_realurl_pathsegment,nav_title,title,alias',
		'rootpage_id' => 1
	),	
	'fileName' => array (
		'defaultToHTMLsuffixOnPrev' => '0',
		'index' => array(
			'drucken.nc' => array(
				'keyValues' => array (
					'no_cache' => 1,
					'print' => 1,
				),
			),
			'drucken' => array(
				'keyValues' => array (
					'print' => 1,
				),
			),
			'index.nc' => array(
				'keyValues' => array (
					'no_cache' => 1,
				),
			),
			'_DEFAULT' => array(
				'keyValues' => array()
			),
		),
	),	
	'preVars' => array(
		array(
			'GETvar' => 'L',
			'valueMap' => array(
				'en' => 1,
			),
			'noMatch' => 'bypass'
		)
	),
	'redirects' => array(),	
	'postVarSets' => array(
		'_DEFAULT' => array(

			'ansprechpartner' => array(
				 		array(
				 			'GETvar' => 'tx_jpstaff_pi1[showMemberUid]',
				 			'lookUpTable' => array(
				 				'table' => 'tx_jpstaff_members',
				 				'id_field' => 'uid',
				 				'alias_field' => 'CONCAT(first_name,last_name)',
				 				'addWhereClause' => ' AND NOT deleted',
				 				'useUniqueCache' => 1,
				 				'useUniqueCache_conf' => array(
				 					'strtolower' => 1,
				 					'spaceCharacter' => '-',
				 				),
				 			),
				 		),
				 	),
			
			'artikel' => array(
		 		array(
		 			'GETvar' => 'tx_ttnews[tt_news]',
		 			'lookUpTable' => array(
		 				'table' => 'tt_news',
		 				'id_field' => 'uid',
		 				'alias_field' => 'title',
		 				'addWhereClause' => ' AND NOT deleted',
		 				'useUniqueCache' => 1,
		 				'useUniqueCache_conf' => array(
		 					'strtolower' => 1,
		 					'spaceCharacter' => '-',
		 				),
		 			),
		 		),
				array(
					'GETvar' => 'tx_ttnews[backPid]',
                ),	 		
		 	),
			// Vorschläge
			'vorschlaege' => array(
				
//				array(
//					'GETvar' =>	'tx_itaoshhoffers_offers[controller]',
//					'valueMap' => array(
//						'verwaltung' => 'Offer',
//					),
//				),
//				array(
//					'GETvar' =>	'tx_itaoshhoffers_offers[feedback]',
//					'valueMap' => array(
//					),
//				),
//				array(
//					'GETvar' =>	'tx_itaoshhoffers_offers[action]',
//					'valueMap' => array(
//						'neu' => 'new',
//					),
//				),
//
//				array(
//					'GETvar' => 'tx_itaoshhoffers_offers[school]',
//					'lookUpTable' => array(
//						'table' => 'tx_itaoshhmanager_schools',
//						'id_field' => 'uid',
//						'alias_field' => 'title',
//						'addWhereClause' => ' AND NOT deleted',
//						'useUniqueCache' => 1,
//						'useUniqueCache_conf' => array(
//							'strtolower' => 1,
//							'spaceCharacter' => '-',
//						),
//					),
//				),
			),
		),
		
	),
	'fixedPostVars' => array(
		
	),
);
?>