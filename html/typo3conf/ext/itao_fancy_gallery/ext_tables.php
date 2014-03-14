<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$tempColumns = Array (
	"itao_fancy_gallery" => Array (		
		"exclude" => 1,		
		"label" => "LLL:EXT:itao_fancy_gallery/locallang_db.xml:tt_content.gallery",		
		"config" => Array (
			"type" => "check",
		)
	)
);


t3lib_div::loadTCA("tt_content");
t3lib_extMgm::addTCAcolumns("tt_content",$tempColumns,1);
t3lib_extMgm::addStaticFile($_EXTKEY,'static/', 'Perfect Lightbox');

$GLOBALS['TCA']['tt_content']['palettes']['7']['showitem'] .= ', itao_fancy_gallery';
# BEN: Quickfix for TYPO3 4.5
$GLOBALS['TCA']['tt_content']['palettes']['imagelinks']['showitem'] .= ', itao_fancy_gallery';
?>