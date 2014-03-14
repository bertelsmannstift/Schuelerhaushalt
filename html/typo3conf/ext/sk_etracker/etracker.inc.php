<?php
/**
 * $RCSfile: etracker.inc.php,v $
 * 
 * This material may not be reproduced, displayed, modified or distributed
 * without the express prior written permission of the copyright holder.
 * 
 * Copyright (c) 2000 - 2008 etracker GmbH. All Rights Reserved
 * 
 * \package 	etracker.config
 * \author 		$Author: ae $ last change: $Date: 2008/12/23 10:51:47 $
 * \version		$Revision: 1.32 $
 */

/**
 * Defines
 */
define('ET_CODE_VERSION',	'3.0');
define('ET_TAGHOST',		defined('ET_CODE_HOST') ? ET_CODE_HOST : 'code.etracker.com');
define('ET_CNTHOST',		defined('ET_SERVERHOST') ? ET_SERVERHOST : 'www.etracker.de');

/**
 * \brief 	Get code
 * 
 * \param	string 	\a $cryptId
 * \param	boolean \a $easy [false]	kein pagename, ermittels aus ref
 * \param	boolean \a $ssl [false]		
 * \param	string 	\a $pagename ['']	
 * \param	string 	\a $areas ['']		bereiche übergeben, mehrere möglich
 * \param	integer \a $ilevel [0]		interesse level, int
 * \param	string 	\a $targets ['']	ziele
 * \param	float 	\a $tval ['']		umsatz
 * \param	integer \a $tsale [0]		0 oder 1 lead oder sale
 * \param	string 	\a $tonr ['']		target order nr
 * \param	integer \a $lpage [0]		landing page
 * \param	string 	\a $trigger ['']	Liste von kommaseparierten Kanal-Ids der konfigurierten Trigger
 * \param	integer \a $customer [0]	bestandskunde [1] oder neukunde [0]
 * \param	string 	\a $basket ['']		warenkorb
 * \param	integer \a $se [0]			automatischer suchmaschinenkanal
 * \param	boolean \a $free [false]	free accounts
 * \param	string 	\a $url ['']		url der seite
 * \param	string 	\a $tag ['']		
 * \param	string 	\a $organisation ['']
 * \param	string 	\a $demographic ['']
 * \return	string
 * \public
 */
function getCode( $cryptId,
				  $easy			= true,
				  $ssl			= false,
				  $pagename		= '',
				  $areas		= '',
				  $ilevel		= 0,
				  $targets		= '',
				  $tval			= '',
				  $tsale		= 0,
				  $tonr			= 0,
				  $lpage		= 0,
				  $trigger		= 0,
				  $customer		= 0,
				  $basket 		= '',
				  $se 			= 0,
				  $plugins		= false,
				  $url			= '',
				  $overlay		= false,
				  $tag			= '',
				  $organisation = '',
				  $demographic  = '',
				  $free 		= false,
				  $showAll		= false,
				  $noScript		= false
				)
{
	if(!preg_match("/^[0-9a-zA-Z]+$/", $cryptId))
		return '';

	// parameter check
	$easy			= $easy ? 1 : 0;
	$ssl			= $ssl ? 1 : 0;
	$pagename		= rawurlencode( $pagename );
	$areas			= rawurlencode( $areas );
	$ilevel			= $ilevel ? $ilevel : 0;
	$targets		= rawurlencode( $targets );
	$tval 			= str_replace(',', '.', $tval);
	$tval 			= is_numeric($tval) ? $tval : 0;
	$tsale			= $tsale ? 1 : 0;
	$tonr 			= str_replace('"', '', $tonr);
	$lpage 			= is_numeric($lpage) ? $lpage : 0;
	// trigger
	$trigger		= preg_replace("/\s{1,}/", '', $trigger); // remove all \s*
	$trigger		= preg_match("/^[0-9,]+$/", $trigger) ? $trigger : ''; // comma separated list of integers
	$customer		= $customer ? 1 : 0;
	$basket			= rawurlencode( $basket );
	$se				= is_numeric($se) ? $se : 0;
	$url			= str_replace('"', '', $url);
	$tag			= str_replace('"', '', $tag);
	$organisation 	= rawurlencode($organisation);
	$demographic  	= rawurlencode($demographic);
	$noScript		= $noScript ? true : false;	

	$code  = "<!-- Copyright (c) 2000-".date("Y")." etracker GmbH. All rights reserved. -->\n";
	$code .= "<!-- This material may not be reproduced, displayed, modified or distributed -->\n";
	$code .= "<!-- without the express prior written permission of the copyright holder. -->\n\n";
	$code .= "<!-- BEGIN etracker code ETRC ".ET_CODE_VERSION." -->\n";
	$code .= "<script type=\"text/javascript\">document.write(String.fromCharCode(60)+\"script type=\\\"text/javascript\\\" src=\\\"http\"+(\"https:\"==document.location.protocol?\"s\":\"\")+\"://".ET_TAGHOST."/t.js?et=".$cryptId."\\\">\"+String.fromCharCode(60)+\"/script>\");</script>\n";
	//$code .= "<p style=\"display:none;\" id=\"et_count\"></p>";
	$code .= getParameters( $showAll, $easy, $pagename, $areas, $ilevel,
							$targets, $tval, $tsale, $tonr, $lpage, $trigger,
							$customer, $basket, $free, $se, $url, $tag,
							$organisation,  $demographic );

	$code .= "<script type=\"text/javascript\">_etc();</script>\n";
	$code .= "<noscript><p><a href=\"http://www.etracker.com\"><img style=\"border:0px;\" alt=\"\" src=\"http://www.etracker.com/nscnt.php?et=".$cryptId."\" /></a></p></noscript>\n";

	if($noScript)
		$code .= getNoScriptTag( $cryptId, $easy, $ssl, $pagename, $areas, $ilevel,
								 $targets, $tval, $tsale, $tonr, $lpage, $trigger,
								 $customer, $basket, $free, $se, $url, $tag,
								 $organisation,  $demographic );

	$code .= "<!-- etracker CODE END -->\n\n";

	
	return $code;
}
/***********************************************************
 * Note: private function below
 * use only main function 'getCode()'
/***********************************************************/

/**
 * \brief Get parameters
 * gives back the parameter code block
 * 
 * \param	boolean \a $easy [false]
 * \param	boolean \a $ssl [false]
 * \param	string 	\a $pagename ['']
 * \param	string 	\a $areas ['']
 * \param	integer \a $ilevel [0]
 * \param	string 	\a $targets ['']
 * \param	float 	\a $tval ['']
 * \param	integer \a $tsale [0]
 * \param	string 	\a $tonr ['']
 * \param	integer \a $lpage [0]
 * \param	string 	\a $trigger ['']
 * \param	integer \a $customer [0]
 * \param	string 	\a $basket ['']
 * \param	boolean \a $free [false]
 * \param	integer \a $se [0]
 * \param	string 	\a $url ['']
 * \return	string
 * \private
 */
function getParameters(	$showAll 		= false,
						$easy 			= 0,
						$pagename 		= '',
						$areas 			= '',
						$ilevel 		= 0,
						$targets 		= '',
						$tval 			= '',
						$tsale 			= 0,
						$tonr 			= 0,
						$lpage 			= 0,
						$trigger 		= 0,
						$customer		= 0,
						$basket 		= '',
						$free 			= false,
						$se 			= 0,
						$url			= '',
						$tag			= '',
						$organisation 	= '',
						$demographic  	= ''
					  )
{
	$code = '';	

	if($easy)
		$code .= "var et_easy         = $easy;\n";
	if($pagename || $showAll)
		$code .= "var et_pagename     = \"$pagename\";\n";
	if($areas || $showAll)
		$code .= "var et_areas        = \"$areas\";\n";
	if($ilevel || $showAll)
		$code .= "var et_ilevel       = ".$ilevel.";\n";
	if($url || $showAll)
		$code .= "var et_url          = \"$url\";\n";
	if($tag || $showAll)
		$code .= "var et_tag          = \"$tag\";\n";
	if($organisation)
		$code .= "var et_organisation = \"$organisation\";\n";
	if($demographic)
		$code .= "var et_demographic  = \"$demographic\";\n";
	if($targets || $showAll)
		$code .= "var et_target       = \"$targets\";\n";
	if($tval || $showAll)
		$code .= "var et_tval         = \"$tval\";\n";
	if($tonr || $showAll)
		$code .= "var et_tonr         = \"$tonr\";\n";
	if($tsale || $showAll)
		$code .= "var et_tsale        = $tsale;\n";
	if($customer || $showAll)
		$code .= "var et_cust         = $customer;\n";
	if($basket || $showAll)
		$code .= "var et_basket       = \"$basket\";\n";
	if($lpage || $showAll)
		$code .= "var et_lpage        = \"$lpage\";\n";
	if($trigger || $showAll)
		$code .= "var et_trig         = \"$trigger\";\n";
	if($se || $showAll)
		$code .= "var et_se           = \"$se\";\n";

	$ret = '';
	if($code)
	{
		$ret .= "\n<!-- etracker PARAMETER ".ET_CODE_VERSION." -->\n";
		$ret .= "<script type=\"text/javascript\">\n";
		$ret .= $code;
		$ret .= "</script>\n";
		$ret .= "<!-- etracker PARAMETER END -->\n\n";
	}
	return $ret;
}

/**
 * \brief Get noscript block
 * gives back the noscript image tag
 * 
 * \param	string 	\a $cryptId
 * \param	boolean \a $easy [false]
 * \param	boolean \a $ssl [false]
 * \param	string 	\a $pagename ['']
 * \param	string 	\a $areas ['']
 * \param	integer \a $ilevel [0]
 * \param	string 	\a $targets ['']
 * \param	float 	\a $tval ['']
 * \param	integer \a $tsale [0]
 * \param	string 	\a $tonr ['']
 * \param	integer \a $lpage [0]
 * \param	string 	\a $trigger ['']
 * \param	integer \a $customer [0]
 * \param	string 	\a $basket ['']
 * \param	boolean \a $free [false]
 * \param	integer \a $se [0]
 * \param	string 	\a $url ['']
 * \return	string
 * \private
 */
function getNoScriptTag($cryptId,
						$easy 			= false,
						$ssl 			= false,
						$pagename 		= '',
						$areas 			= '',
						$ilevel 		= 0,
						$targets 		= '',
						$tval 			= '',
						$tsale 			= 0,
						$tonr 			= 0,
						$lpage 			= 0,
						$trigger 		= 0,
						$customer		= 0,
						$basket 		= '',
						$free 			= false,
						$se 			= 0,
						$url			= '',
						$tag			= '',
						$organisation 	= '',
						$demographic  	= '')
{
	$script 		= $free ? 'fcnt' : 'cnt';
	
	$code .= "<!-- etracker CODE NOSCRIPT ".ET_CODE_VERSION." -->\n";
	$code .= "<noscript>\n";
	$code .= "<p><a href='http://".ET_CNTHOST."/app?et=$cryptId'>\n";
	$code .= "<img style='border:0px;' alt='' src='";
	if($ssl==1) $code .= "https"; else $code .= "http";
	$code .= "://".ET_CNTHOST."/$script.php?\n";
	$code .= "et=$cryptId&amp;v=".ET_CODE_VERSION."&amp;java=n&amp;et_easy=$easy\n";
	$code .= "&amp;et_pagename=$pagename\n";
	$code .= "&amp;et_areas=$areas&amp;et_ilevel=$ilevel&amp;et_target=$targets,$tval,$tonr,$tsale\n";
	$code .= "&amp;et_lpage=$lpage&amp;et_trig=$trigger&amp;et_se=$se&amp;et_cust=$customer\n";
	$code .= "&amp;et_basket=$basket&amp;et_url=&amp;et_tag=".$tag."\n";
	$code .= "&amp;et_organisation=".$organisation."&amp;et_demographic=".$demographic."' /></a></p>\n";
	$code .= "</noscript>\n";
	$code .= "<!-- etracker CODE NOSCRIPT END-->\n\n";
	return $code;
}

/**
 * \brief Get base code
 * gives back the base code block
 * 
 * \param	string 	\a $cryptId
 * \param	boolean \a $easy [false]
 * \param	boolean \a $ssl [false]
 * \param	string 	\a $pagename ['']
 * \param	string 	\a $areas ['']
 * \param	integer \a $ilevel [0]
 * \param	string 	\a $targets ['']
 * \param	float 	\a $tval ['']
 * \param	integer \a $tsale [0]
 * \param	string 	\a $tonr ['']
 * \param	integer \a $lpage [0]
 * \param	string 	\a $trigger ['']
 * \param	integer \a $customer [0]
 * \param	string 	\a $basket ['']
 * \param	boolean \a $free [false]
 * \param	integer \a $se [0]
 * \param	string 	\a $url ['']
 * \return	string
 * \private
 */
function getBaseCode( $cryptId,
					  $easy 		= false,
					  $ssl 			= false,
					  $pagename 	= '',
					  $areas 		= '',
					  $ilevel 		= 0,
					  $targets 		= '',
					  $tval 		= '',
					  $tsale 		= 0,
					  $tonr 		= 0,
					  $lpage 		= 0,
					  $trigger 		= 0,
					  $customer		= 0,
				  	  $basket 		= '',
					  $free 		= false,
					  $se 			= 0,
					  $url			= '',
					  $tag			= '',
					  $organisation = '',
					  $demographic  = ''
)
{
	return getCode( $cryptId,
					$easy,
					$ssl,
					$pagename,
					$areas,
					$ilevel,
					$targets,
					$tval,
					$tsale,
					$tonr,
					$lpage,
					$trigger,
					$customer,
					$basket,
					$se,
					true,
					$url,
					true,
					$tag,
					$organisation,
					$demographic,
					$free,
					true,
					true
				);
}


?>