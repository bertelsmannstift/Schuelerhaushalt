<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Offers',
	array(
		'Offer' => 'newOffers, show, new, create, update, sortedOffers, myOffers, createOffer,approveOffers, sort, addOfferData, schoolData, printAll, communeOffers, markAsEdited, preview, topOffers, setOfferStatus, becomeChildOf',
	),
	// non-cacheable actions
	array(
		'Offer' => 'show, new, create, update, sortedOffers, myOffers, communeOffers, createOffer, sort, addOfferData, schoolData, printAll, markAsEdited, approveOffers, setOfferStatus, becomeChildOf, preview',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(			
	$_EXTKEY,
	'CommuneList',
	array(
		'Commune' => 'communeList',
	),
	// non-cacheable actions
	array(
		'Commune' => '',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(			
	$_EXTKEY,
	'SchoolData',
	array(
		'Offer' => 'schoolData,schools,schoolsStatusBox,linkedSchoolsStatusBox,directEntry',
	),
	// non-cacheable actions
	array(
		'Offer' => 'schoolData,schools',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(			
	$_EXTKEY,
	'OfferStatus',
	array(
		'Offer' => 'myOffersStatus',
	),
	// non-cacheable actions
	array(
		'Offer' => 'myOffersStatus',
	)
);

Tx_Extbase_Utility_Extension::configurePlugin(			
	$_EXTKEY,
	'Print',
	array(
		'Offer' => 'printButton, printSheet',
		
	),
	// non-cacheable actions
	array(
		'Offer' => 'printSheet',
	)
);	

Tx_Extbase_Utility_Extension::configurePlugin(			
	$_EXTKEY,
	'SortAndFilter',
	array(
		'Offer' => 'sortAndFilter',
	),
	// non-cacheable actions
	array(
		'Offer' => '',
	)
);	

Tx_Extbase_Utility_Extension::configurePlugin(			
	$_EXTKEY,
	'RedirectToCommunePage',
	array(
		'Offer' => 'redirectToCommunePage',
	),
	// non-cacheable actions
	array(
		'Offer' => 'redirectToCommunePage',
	)
);	
//
//Tx_Extbase_Utility_Extension::configurePlugin(			
//	$_EXTKEY,
//	'PhaseBox',
//	array(
//		'Offer' => 'phaseBox',
//	),
//	// non-cacheable actions
//	array(
//		'Offer' => '',
//	)
//);	

?>