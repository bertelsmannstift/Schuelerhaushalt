<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2005 Juraj Sulek (juraj@sulek.sk)
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
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * Plugin css_filelinks.
 *
 * $Id: class.tx_cssfilelinks.php,v 0.1.0 2005/28/12 20:02:15 typo3 Exp $
 *
 * @author	Juraj Sulek <juraj@sulek.sk>
 */
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 *
 *
 *   60: class tx_cssfilelinks extends tslib_pibase
 *   70:     function fetchFileList ($content, $conf)
 *   84:     function getAdditionalClass($confAdditionalClass)
 *  111:     function FileSizeFormat($fileSize,$conf)
 *  176:     function fillFileMarkers($fileFileMarkers,$fileLayout,$file,$fileCount,$fileext)
 *  220:     function fillGlobalMarkers($fileGlobalMarkers,$globalLayout,$fileCount)
 *  257:     function getFileUrl($url,$conf,$record)
 *  279:     function getFilesForCssUploads($conf)
 *  347:     function getIcon($fileExt,$conf,$theFile)
 *  414:     function renderFileLinks($content,$conf)
 *  553:     function &hookRequest($functionName)
 *  573:     function hookRequestMore($functionName)
 *
 * TOTAL FUNCTIONS: 11
 * (This index is automatically created/updated by the extension "extdeveval")
 *
 */


	require_once(PATH_tslib."class.tslib_pibase.php");

	class tx_cssfilelinks extends tslib_pibase {


	/**
	 * Return files from dam reference field (this is used for generating filelist field which TCA was overriden by CSS MULTIMEDIA)
	 *
	 * @param	mixed		$content: ...
	 * @param	array		$conf: ...
	 * @return	string		comma list of files with path
	 */
		function fetchFileList ($content, $conf) {
			$refField = trim($this->cObj->stdWrap($conf['refField'],$conf['refField.']));
			$damFiles = tx_dam_db::getReferencedFiles('tt_content', $this->cObj->data['uid'], $refField);
			return implode(',',$damFiles['files']);
		}

	/**
	 * Return a array of fileextensions with additional class:
	 * from: array('class1'=>ext1,ext2...., 'class2'=>'ext10...',...)
	 * return it: array('ext1'=>'class1,class2...','ext2'=>'class2...',...)
	 *
	 * @param	array		$confAdditionalClass: An array obtained from 'additionalClass.' (see abowe)
	 * @return	array		New array where the ext are used as key (see abowe)
	 */
		function getAdditionalClass($confAdditionalClass){
			if ($hookObj = &$this->hookRequest('getAdditionalClass'))	{
				return $hookObj->getAdditionalClass($confAdditionalClass);
			} else {
				$additionalClass=array();
				if(count($confAdditionalClass)>0){
					while(list($key,$val)=each($confAdditionalClass)){
						$val=trim($val,',');
						if($val!=''){
							$fileExts=t3lib_div::trimExplode(',',$val);
							foreach($fileExts as $classes){
								$additionalClass[$classes].=' '.$key;
							};
						};
					};
				};
				return $additionalClass;
			};
		}

	/**
	 * Return filesize and filesizeformat depending on the $conf:
	 *
	 * @param	int		$fileSize: file size
	 * @param	array		$conf: 'tt_content.uploads.20.layout.fileSize.' this array contain the formating options for filesize
	 * @return	array		Returns a array('size'=>file size,'sizeformat'=>file size format e.g. kb)
	 */
		function FileSizeFormat($fileSize,$conf){
			if ($hookObj = &$this->hookRequest('FileSizeFormat'))	{
				return $hookObj->FileSizeFormat($fileSize,$conf);
			} else {
				/* get the conf begin */
					$fileSizeChar=trim($conf['char']);
					if($fileSizeChar==''){$fileSizeChar='lower';};
					$fileSizeFormat=trim($conf['format']);
					if($fileSizeFormat==''){$fileSizeFormat='auto';};
					$fileSizeDesc=trim($conf['desc']);
					if($fileSizeDesc==''){$fileSizeDesc='b|kb|mb';};
					$fileSizeDesc=t3lib_div::trimExplode('|',$fileSizeDesc);
					$fileSizeRound=trim($conf['round']);
					if($fileSizeRound==''){$fileSizeRound=2;};
				/* get the conf end */
				$fileSizeFormatOut=$fileSizeDesc[0];
				if(($fileSizeFormat=='kb')||($fileSizeFormat=='mb')){$fileSize=$fileSize/1024;$fileSizeFormatOut=$fileSizeDesc[1];};
				if($fileSizeFormat=='mb'){$fileSize=$fileSize/1024;$fileSizeFormatOut=$fileSizeDesc[2];};
				if($fileSizeFormat=='auto'){
					$fileSizeOut=$fileSize;
					$fileSizeFormatOut=$fileSizeDesc[0];
					if(intval($fileSizeOut/1024)>0){
						$fileSizeOut=($fileSizeOut/1024);
						$fileSizeFormatOut=$fileSizeDesc[1];
						if(intval($fileSizeOut/1024)>0){
							$fileSizeOut=($fileSizeOut/1024);
							$fileSizeFormatOut=$fileSizeDesc[2];
						};
					};
					$fileSize=$fileSizeOut;
				};
				if($fileSizeChar!='none'){
					$fileSizeFormatOut=strtolower($fileSizeFormatOut);
					if($fileSizeChar=='upper'){
						$fileSizeFormatOut=strtoupper($fileSizeFormatOut);
					};
					if($fileSizeChar=='firstUpper'){
						$fileSizeFormatOut[0]=strtoupper($fileSizeFormatOut[0]);
					};
					if($fileSizeChar=='firstLower'){
						$fileSizeFormatOut=strtoupper($fileSizeFormatOut);
						$fileSizeFormatOut[0]=strtolower($fileSizeFormatOut[0]);
					};
				};
				$return_fileSize['size']=round($fileSize,$fileSizeRound);
				$return_fileSize['sizeformat']=$fileSizeFormatOut;

				/* make the decimal point */
				if($conf['decimalPoint']!=''){
					$return_fileSize=str_replace('.',$conf['decimalPoint'],$return_fileSize);
				}
				return $return_fileSize;
			};
		}

	/**
	 * return layout with filled file markers
	 *
	 * @param	array		$fileFileMarkers: TypoScript configuration for 'layout.userMarker.'
	 * @param	string		$fileLayout: Layout with markers
	 * @param	array		$file: array width files
	 * @param	array		$fileCount: filecounter
	 * @param	array		$fileext: file extension
	 * @return	strin		layout with filled file markers
	 */
		function fillFileMarkers($fileFileMarkers,$fileLayout,$file,$fileCount,$fileext){
			if ($hookObj = &$this->hookRequest('fillFileMarkers'))	{
				return $hookObj->fillFileMarkers($fileFileMarkers,$fileLayout,$file,$fileCount,$fileext);
			} else {
				$_fileFileMarkers=$fileFileMarkers['file.'];
				if(count($_fileFileMarkers)>0){
					while(list($key,$val)=each($_fileFileMarkers)){
						if(is_array($val)){
							$_fileFileMarkers[$key]['markerData.']['dam']=intval($file['dam']);
							$_fileFileMarkers[$key]['markerData.']['fileUrl']=$file['url'];
							$_fileFileMarkers[$key]['markerData.']['fileName']=$file['filename'];
							$_fileFileMarkers[$key]['markerData.']['fileTitle']=$file['title'];
							$_fileFileMarkers[$key]['markerData.']['fileSize']=$file['size'];
							$_fileFileMarkers[$key]['markerData.']['fileExt']=$fileext;
							$_fileFileMarkers[$key]['markerData.']['fileCount']=$fileCount;
							$_fileFileMarkers[$key]['markerData.']['fileLayout']=$this->cObj->data['layout'];
						};
					};
					reset($_fileFileMarkers);
					while(list($key,$val)=each($_fileFileMarkers)){
							if(!is_array($val)){
							$fileLayout=str_replace('###'.$key.'###',$this->cObj->cObjGetSingle($_fileFileMarkers[$key],$_fileFileMarkers[$key.'.'],$key),$fileLayout);
						};
					};
				};
				$hookObjs=$this->hookRequestMore('fillFileMarkers');
				if((is_array($hookObjs))&&(count($hookObjs)>0)){
					foreach($hookObjs as $hObjs){
						$fileLayout=$hObjs->fillFileMarkers($fileFileMarkers,$fileLayout,$file,$fileCount,$fileext);
					}
				};
				return $fileLayout;
			};
		}


	/**
	 * return layout with filled global markers
	 *
	 * @param	array		$fileFileMarkers: TypoScript configuration for 'layout.userMarker.file.'
	 * @param	string		$fileLayout: Layout with markers
	 * @param	array		$fileCount: filecounter
	 * @return	strin		layout with willed file markers
	 */
		function fillGlobalMarkers($fileGlobalMarkers,$globalLayout,$fileCount){
			if ($hookObj = &$this->hookRequest('fillGlobalMarkers'))	{
				return $hookObj->fillGlobalMarkers($fileGlobalMarkers,$globalLayout,$fileCount);
			} else {
				if(count($fileGlobalMarkers)>0){
					while(list($key,$val)=each($fileGlobalMarkers)){
						if(is_array($val)){
							$fileGlobalMarkers[$key]['markerData.']['fileCount']=$fileCount;
							$fileGlobalMarkers[$key]['markerData.']['fileLayout']=$this->cObj->data['layout'];
						};
					};
					reset($fileGlobalMarkers);
					while(list($key,$val)=each($fileGlobalMarkers)){
						if(!is_array($val)){
							$globalLayout=str_replace('###'.$key.'###',$this->cObj->cObjGetSingle($fileGlobalMarkers[$key],$fileGlobalMarkers[$key.'.'],$key),$globalLayout);
						};
					};
				};
				$hookObjs=$this->hookRequestMore('fillGlobalMarkers');
				if((is_array($hookObjs))&&(count($hookObjs)>0)){
					foreach($hookObjs as $hObjs){
						$globalLayout=$hObjs->fillGlobalMarkers($fileGlobalMarkers,$globalLayout,$fileCount);
					}
				};
				return $globalLayout;
			};
		}


	/**
	 * return url from file
	 *
	 * @param	string		$url: file url
	 * @param	array		$conf: typoscript configuration
	 * @param	array		$record: record with all informations about the file
	 * @return	string		url
	 */
	function getFileUrl($url,$conf,$record){
		if ($hookObj = &$this->hookRequest('getFileUrl'))	{
				return $hookObj->getFileUrl($url,$conf,$record);
		} else {
			$output = '';
			$initP = '?id='.$GLOBALS['TSFE']->id.'&type='.$GLOBALS['TSFE']->type;
			if (@is_file($url))	{
				$urlEnc = str_replace('%2F', '/', rawurlencode($url));
				$locDataAdd = $conf['jumpurl.']['secure'] ? $this->cObj->locDataJU($urlEnc,$conf['jumpurl.']['secure.']) : '';
				$retUrl = ($conf['jumpurl']) ? $GLOBALS['TSFE']->config['mainScript'].$initP.'&jumpurl='.rawurlencode($urlEnc).$locDataAdd.$GLOBALS['TSFE']->getMethodUrlIdToken : $urlEnc;		// && $GLOBALS['TSFE']->config['config']['jumpurl_enable']
				return htmlspecialchars($GLOBALS['TSFE']->absRefPrefix.$retUrl);
			};
			return '';
		};
	}

	/**
	 * return files from standard field
	 *
	 * @param	array		TypoScript configuration
	 * @return	string		HTML output.
	 */
	function getFilesForCssUploads($conf){
		if ($hookObj = &$this->hookRequest('getFilesForCssUploads'))	{
				return $hookObj->getFilesForCssUploads($conf);
		} else {
			/* get the standard field begin */
			$path=$this->cObj->stdWrap($conf['fileList.']['path'],$conf['fileList.']['path.']);
			$files_get = trim($this->cObj->stdWrap($conf['fileList'],$conf['fileList.']),',');
			$separatePathFromFile=false;
			if(strpos($files_get,"\\")!==false || strpos($files_get,"/")!==false){
				$separatePathFromFile=true;
			};
			/* get the standard field end */
			/* If the css_multimedia is installet it turns the media field to dam field.
			 * Therefore i must check if this is the case and if yes then i must return the DAM reference */
				if($GLOBALS['T3_VAR']['ext']['css_filelinks']['setup']['default_dam']==1 && t3lib_extMgm::isLoaded('dam') && t3lib_extMgm::isLoaded('css_styled_multimedia')){
					$files_get=$this->fetchFileList('',array('refField'=>'media'));
					if(is_array($conf['fileList.']['override.'])){
						$files_get2=$this->cObj->stdWrap($files_get,array('override.'=>$conf['fileList.']['override.']));
					};
					$separatePathFromFile=true;
					//if the overide has get some ressults
					if($files_get!=$files_get2){
						$separatePathFromFile=false;
						$files_get=$files_get2;
					};
				};
			/* dam reference end */
			$files_arr=t3lib_div::trimExplode(",",$files_get);
			$descriptionField = $this->cObj->stdWrap($conf['description'],$conf['description.']);
			$descriptionIfEmpty=$this->cObj->stdWrap($conf['description_ifElementEmpty'],$conf['description_ifElementEmpty.']);
			if($descriptionField!=''){
				$descriptionArray=t3lib_div::trimExplode(chr(10),htmlspecialchars($descriptionField));
			}else{
				$descriptionArray=array();
			};
			$i=0;
			if(count($files_arr)!=0){
				foreach($files_arr as $filetemp){
					if($separatePathFromFile){
						$file=str_replace("\\","/",$filetemp);
						$lastPos=strrpos($filetemp,"/");
						if($lastPos!==false){
							$path=substr($file,0,$lastPos+1);
							$file=substr($file,$lastPos+1);
						};
					}else{
						$file=$filetemp;
					};
					if(@is_file(trim($path).trim($file))){
						if ($conf['linkProc.']['removePrependedNumbers']){$title=preg_replace('/_[0-9][0-9](\.[[:alnum:]]*)$/','\1',$file);}else{$title=$file;}
						$description=$descriptionArray[$i]!=''?$descriptionArray[$i]:$descriptionIfEmpty;
						$files_all[]=array('url'=>trim($path).trim($file),'title'=>trim($title),'size'=>filesize(trim($path).trim($file)),'filename'=>trim($file),'description'=>$description);
						$i++;
					};
				};
			};
		};
		return $files_all;
	}

	/**
	 * return icon for file
	 *
	 * @param	string		$fileExt: file extension
	 * @param	array		$conf: TypoScript configuration
	 * @param	[type]		$theFile: ...
	 * @return	string		HTML output image.
	 */
	function getIcon($fileExt,$conf,$theFile){
		if ($hookObj = &$this->hookRequest('getIcon'))	{
				return $hookObj->getIcon($fileExt,$conf,$theFile);
		} else {
			$altIconP = $conf['alternativeIconPath'];
			$iconP = 't3lib/gfx/fileicons/';
			if(!@is_file($iconP.'default.gif')){
				$iconP='typo3/gfx/fileicons/';
			};

			if (!empty($altIconP)){
				if (@is_file($altIconP.$fileExt.'.gif')) {
					$icon = $altIconP.$fileExt.'.gif';
				} elseif (@is_file($altIconP.'default.gif')){
					$icon = $altIconP.'default.gif';
				} else {
					$icon =@is_file($iconP.$fileExt.'.gif') ? $iconP.$fileExt.'.gif' : $iconP.'default.gif';
				}
			} else {
				$icon = @is_file($iconP.$fileExt.'.gif') ? $iconP.$fileExt.'.gif' : $iconP.'default.gif';
			}
			$imgSize = @getImageSize(PATH_site.$icon);

			$icon_return = '<img src="'.htmlspecialchars($GLOBALS['TSFE']->absRefPrefix.$icon).'" width="'.$imgSize[0].'" height="'.$imgSize[1].'" alt="'.$fileExt.'" />';


			if($this->cObj->stdWrap($conf['iconCObject.']['makeThumbs'],$conf['iconCObject.']['makeThumbs.'])==1){

				// Checking for images: If image, then return link to thumbnail.
				if($conf['icon_image_ext_list']||$conf['icon_image_ext_list.']){
					$IEList = $this->cObj->stdWrap($conf['icon_image_ext_list'],$conf['icon_image_ext_list.']);
				}else{
					$IEList = $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'];
				}


				$image_ext_list = str_replace(' ','',strtolower($IEList));
				if ($fileExt && t3lib_div::inList($image_ext_list,$fileExt)){
					if ($conf['iconCObject'])	{
						$icon_return = $this->cObj->cObjGetSingle($conf['iconCObject'],$conf['iconCObject.'],'iconCObject');
					} else {
						if ($GLOBALS['TYPO3_CONF_VARS']['GFX']['thumbnails'])	{
							$thumbSize = '';
							if ($conf['icon_thumbSize'] || $conf['icon_thumbSize.'])	{ $thumbSize = '&size='.$this->cObj->stdWrap($conf['icon_thumbSize'], $conf['icon_thumbSize.']); }
							//$icon = 't3lib/thumbs.php?&dummy='.$GLOBALS['EXEC_TIME'].'&file='.rawurlencode('../'.$theFile).$thumbSize;
							$md5 = basename($theFile).':'.filemtime(PATH_site.$theFile).':'.$GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey'];
							$md5_real = t3lib_div::shortMD5($md5);
							$icon = 't3lib/thumbs.php?&dummy='.$GLOBALS['EXEC_TIME'].'&file='.rawurlencode(PATH_site.$theFile).'&md5sum='.$md5_real;
						} else {
							$icon = 't3lib/gfx/notfound_thumb.gif';
						}
						$icon_return = '<img src="'.htmlspecialchars($GLOBALS['TSFE']->absRefPrefix.$icon).'" alt="" />';
					}
				};
			};

			return $icon_return;
		};
	}

	/**
	 * Rendering the "Filelinks" type content element, called from TypoScript (tt_content.uploads.20)
	 *
	 * @param	string		Content input. Not used, ignore.
	 * @param	array		TypoScript configuration
	 * @return	string		HTML output.
	 */
		function renderFileLinks($content,$conf){
			if ($hookObj = &$this->hookRequest('renderFileLinks'))	{
				return $hookObj->renderFileLinks($content,$conf);
			} else {
				$files_all=$this->getFilesForCssUploads($conf);
				$additionalClass=$this->getAdditionalClass($conf['additionalClass.']);
				/* layout from conf and default BEGIN */
					$fileLinksLayout=$this->cObj->data['layout'];
					$globalLayout=$this->cObj->stdWrap($conf['layout.']['global'],$conf['layout.']['global.']);
					if($globalLayout==''){$globalLayout='<div class="filelinks filelinks_layout_###LAYOUT###"><span class="filecount">There are ###FILECOUNT### files.</span>###FILE###</div>';};
					$fileLayout=$this->cObj->stdWrap($conf['layout.']['file'],$conf['layout.']['file.']);
					if($fileLayout==''){$fileLayout='<div class="###CLASS###"><span><a href="###URL###" ###TARGET###>###TITLE###</a> ###FILESIZE###</span><span>###DESCRIPTION###</span></div>';};
					$fileSizeLayout=$this->cObj->stdWrap($conf['layout.']['fileSize.']['layout'],$conf['layout.']['fileSize.']['layout']);
					if($fileSizeLayout==''){$fileSizeLayout='(###SIZE### ###SIZEFORMAT###)';};
				/* layout from conf and default END */
				$fileCount=count($files_all);
				if(strpos($fileLayout,'###ICON###')!==false){$useIcon=true;}else{$useIcon=false;}
				$return_files=array();
				$search['target']='###TARGET###';
				$search['fileext']='###FILEEXT###';
				$search['additionalclass']='###ADDITIONALCLASS###';
				$search['firstlastoddeven']='###FIRSTLASTODDEVEN###';
				$search['class']='###CLASS###';
				if($useIcon){$search['icon']='###ICON###';}
				$search['url']='###URL###';
				$search['title']='###TITLE###';
				$search['counter']='###COUNTER###';
				$search['size']='###SIZE###';
				$search['sizeformat']='###SIZEFORMAT###';
				$search['filename']='###FILENAME###';
				if(intval($this->cObj->data['filelink_size'])>0){
					$fileLayout=str_replace('###FILESIZE###',$fileSizeLayout,$fileLayout);
				}else{
					$fileLayout=str_replace('###FILESIZE###','',$fileLayout);
				};

				$fileCounter=1;
				if(!@is_array($files_all)){
					$files_all=array();
				};
				reset($files_all);
				$odd=true;
				foreach($files_all as $file){
					$fileLayouTemp=$fileLayout;
					$replace['target']=$conf['linkProc.']['target']?' target="'.$conf['linkProc.']['target'].'"':'';
					/* class begin */
					$fileinfo = t3lib_div::split_fileref($file['filename']);
					/* fileExt begin */
					$fileExt=trim($fileinfo['fileext']);
					if(t3lib_div::testInt(substr($fileExt,0,1))&&$conf['classes.']['ext.']['prefixIfFirstNumber']!=''){
						$fileExt=$conf['classes.']['ext.']['prefixIfFirstNumber'].$fileExt;
					};
					$replace['fileext']=$fileExt;
					/* fileExt end */
					/* fileExt config begin */
                    $extFileLayout=$this->cObj->stdWrap($conf['layout.']['filetype.'][strtolower($fileExt)],$conf['layout.']['filetype.'][strtolower($fileExt).'.']);
                    if($extFileLayout!=''){
                        if(strpos($extFileLayout,'###ICON###')!==false){$useIcon=true;}else{$useIcon=false;}
                        if($useIcon){$search['icon']='###ICON###';}
                        if(intval($this->cObj->data['filelink_size'])>0){
                            $extFileLayout=str_replace('###FILESIZE###',$fileSizeLayout,$extFileLayout);
                        }else{
                            $extFileLayout=str_replace('###FILESIZE###','',$extFileLayout);
                        };
                        $fileLayouTemp=$extFileLayout;
                    }
                    /* fileExt config end */
                    $fileLayouTemp=str_replace('###DESCRIPTION###',$file['description'],$fileLayouTemp);// aby som mohol zamenit description
					/* additionalClass begin */
						$replace['additionalclass']=trim($additionalClass[trim($fileinfo['fileext'])]);
					/* additional class end */
					/* firstlastoddeven begin */
						$firstlastoddeven='';
						if((intval($conf['classes.']['addFirst'])==1)&&($fileCounter==1)){$firstlastoddeven.=' first';};
						if((intval($conf['classes.']['addOdd'])==1)&&($odd)){
							$firstlastoddeven.=' odd';
							$odd=false;
						}else{
							if(intval($conf['classes.']['addEven'])==1){
								$firstlastoddeven.=' even';
								$odd=true;
							};
						};
						if((intval($conf['classes.']['addLast'])==1)&&($fileCounter==$fileCount)){$firstlastoddeven.=' last';};
						$replace['firstlastoddeven']=trim($firstlastoddeven);
					/* firstlastoddeven end */
						$class=$fileExt;
						if($additionalClassOut!=''){$class.=' '.$additionalClassOut;};
						if(trim($firstlastoddeven)!=''){$class.=' '.trim($firstlastoddeven);};
						$replace['class']=$class;
					/* class end */
					if($useIcon){
						$GLOBALS['TSFE']->register['ICON_REL_PATH'] = $file['url'];
						//$replace['icon']=$this->getIcon($replace['fileext'],$conf['linkProc.']);
						$replace['icon']=$this->getIcon($replace['fileext'],$conf['linkProc.'],$file['url']);
					}
					$replace['url']=$this->getFileUrl($file['url'],$conf['linkProc.'],$file);
					$replace['title']=trim($file['title']);
					if($conf['title.']['trimExt']){
						$replace['title']=substr($replace['title'],0,-(strlen($replace['fileext'])+1));
					}
					$replace['counter']=$fileCounter;

					$fileSizeFormat=$this->FileSizeFormat(trim($file['size']),$conf['layout.']['fileSize.']);
					$replace['size']=$fileSizeFormat['size'];
					$replace['sizeformat']=$fileSizeFormat['sizeformat'];
					$replace['filename']=$file['filename'];

					$fileLayouTemp=$this->fillFileMarkers($conf['layout.']['userMarker.'],$fileLayouTemp,$file,$fileCount,$fileExt);
					$return_files[]=str_replace($search,$replace,$fileLayouTemp);
					$fileCounter++;
				};
				/* global markers BEGIN */
				$globalLayout=$this->fillGlobalMarkers($conf['layout.']['userMarker.']['global.'],$globalLayout,$fileCount);
				$return_content=str_replace('###FILE###',implode(' ',$return_files),$globalLayout);
				$return_content=str_replace('###FILECOUNT###',$fileCount,$return_content);
				$return_content=str_replace('###LAYOUT###',$fileLinksLayout,$return_content);
				/* global markers END */
				/* hide not processed markers begin */
				if(intval($conf['layout.']['hideNotProcessedMarkers'])==1){
					$return_content=preg_replace('/###([a-zA-Z0-9_-]*)###/','',$return_content);
				};
				/* hide not processed markers end */
				/* editicon begin */
				if ($conf['stdWrap.']) {
					$return_content = $this->cObj->stdWrap($return_content, $conf['stdWrap.']);
				}
				/* editicons end */

				return $return_content;
			};
		}

		/**
 * Returns an object reference to the hook object if any
 *
 * @param	string		Name of the function you want to call / hook key
 * @return	object		Hook object, if any. Otherwise null.
 */
		function &hookRequest($functionName)	{
			global $TYPO3_CONF_VARS;

				// Hook: menuConfig_preProcessModMenu
			if ($TYPO3_CONF_VARS['EXTCONF']['css_filelinks']['pi1_hooks'][$functionName]) {
				$hookObj = &t3lib_div::getUserObj($TYPO3_CONF_VARS['EXTCONF']['css_filelinks']['pi1_hooks'][$functionName]);
				if (method_exists ($hookObj, $functionName)) {
					$hookObj->pObj = &$this;
					return $hookObj;
				}
			}
		}


		/**
 * Returns an array of object reference to the hook object if any
 *
 * @param	string		Name of the function you want to call / hook key
 * @return	array		Array of Hook objects or empty array.
 */
		function hookRequestMore($functionName)	{
			global $TYPO3_CONF_VARS;

			$hookObjectsArr=array();
			$i=0;
			if (is_array($TYPO3_CONF_VARS['EXTCONF']['css_filelinks']['pi1_hooks_more'][$functionName])){
				foreach ($TYPO3_CONF_VARS['EXTCONF']['css_filelinks']['pi1_hooks_more'][$functionName] as $classRef){
	        		$hookObjectsArr[$i] = &t3lib_div::getUserObj($classRef);
	        		$hookObjectsArr[$i]->pObj = &$this;
	        		$i++;
	    		}
	    		return $hookObjectsArr;
			}
		}

	}

	if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/css_filelinks/class.tx_cssfilelinks.php'])	{
		include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/css_filelinks/class.tx_cssfilelinks.php']);
	}
?>