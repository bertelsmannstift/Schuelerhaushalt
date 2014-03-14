<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

	$GLOBALS['T3_VAR']['ext']['css_filelinks']['setup'] = unserialize($_EXTCONF);
	
	$icons='ai,ani,au,avi,bmp,cdr,css,csv,doc,dtd,eps,exe,fh3,flash,folder,gif,htm,html,ico,inc,java,jpg,js,max,mid,mov,mpeg,mpg,pcd,pcx,pdf,png,ps,psd,rtf,sgml,swf,sxc,sxw,tga,tif,ttf,txt,wav,wrl,xls,xml,xsl,zip';
	$icons_arr=t3lib_div::trimExplode(',',$icons);
	$iconPath = $GLOBALS['T3_VAR']['ext']['css_filelinks']['setup']['pathtoicons'];
	$iconPath = trim($iconPath);
	
	$iconPaths_test = ltrim($iconPath,'/');
	$iconPaths_test = ltrim($iconPath,'\\');
	if(!@is_file(PATH_site.$iconPaths_test.'default.gif')){
		$iconPath = 't3lib/gfx/fileicons/';
		if(!@is_file(PATH_site.$iconPath.'default.gif')){
			$iconPath='typo3/gfx/fileicons/';
		};
		$iconPath='/'.$iconPath;
	}
	$tempDefaultCss='plugin.tx_cssfilelist._CSS_DEFAULT_STYLE ( 
	.filelinks div{padding-left:25px; background:url(\''.$iconPath.'default.gif\') left top no-repeat; margin-bottom:10px;}
	.filelinks span{display:block;}
	.filelinks .filecount{display:block; margin-bottom:5px;} 
	.filelinks a{color:#000;text-decoration:none; }
	/* Icons begin */';
	foreach($icons_arr as $ic){
		$tempDefaultCss.='
	.filelinks .'.$ic.'{background-image:url(\''.$iconPath.$ic.'.gif\')!important;}';
	};
	$tempDefaultCss.='
	/* Icons end */
	.filelinks a:hover{text-decoration:underline;}
	)';
	if($GLOBALS['T3_VAR']['ext']['css_filelinks']['setup']['dont_default_css']){$tempDefaultCss='';};

	$tempAllowReadFromPath='';
	if($GLOBALS['T3_VAR']['ext']['css_filelinks']['setup']['allow_read_from_path']){$tempAllowReadFromPath='path.override.field=select_key
path.override.listNum=first
path.override.listNum.splitChar=|
override.filelist.field=select_key';};
	
	t3lib_extMgm::addTypoScript($_EXTKEY,'setup','
		includeLibs.tx_cssfilelinks = EXT:css_filelinks/class.tx_cssfilelinks.php
		'.$tempDefaultCss.'
		
		tt_content.uploads.20 >
		tt_content.uploads.20=USER
		tt_content.uploads.20{
			userFunc=tx_cssfilelinks->renderFileLinks
			fileList{
				field=media
				path=uploads/media/
				'.$tempAllowReadFromPath.'
			}
			title.trimExt=0
			
			description.field=imagecaption
			description_ifElementEmpty=
			additionalClass{
				image=bmp,gif,ico,jpg,png,tif,psd
				video=wmv,avi,asf,mpg,mov,mpeg
				audio=mp3,wav,mid
			}
			classes{
				addFirst=1
				addLast=1
				addOdd=1
				addEven=1
				ext.prefixIfFirstNumber=
			}
			layout{
				global=<div class="filelinks filelinks_layout_###LAYOUT###"><span class="filecount">There are ###FILECOUNT### files.</span>###FILE###</div>
				file=<div class="###CLASS###"><span><a href="###URL###">###TITLE###</a> ###FILESIZE### ###CRID### ###MYMARK###</span><span>###DESCRIPTION###</span></div>
				fileSize{
					layout=(###SIZE### ###SIZEFORMAT###)
					char=lower
					format=auto
					desc=b|kb|mb
					round=2
					decimalPoint=.
				}
				hideNotProcessedMarkers=1
			}
			linkProc {
				target = _blank
				jumpurl = {$styles.content.uploads.jumpurl} 
				jumpurl.secure = {$styles.content.uploads.jumpurl_secure}
		
				removePrependedNumbers = 1
				
				alternativeIconPath=
		
				iconCObject = IMAGE
				iconCObject.makeThumbs=0
				iconCObject.file.import.data = register : ICON_REL_PATH
				iconCObject.file.width = 150
			}
			stdWrap{
				editIcons = tt_content: media, layout, filelink_size
				editIcons.iconTitle.data=LLL:EXT:css_styled_content/pi1/locallang.php:eIcon.filelist
				prefixComment = 2 | File list:
			};
		}
	',43);
	
	$allow_the_read_from_path='';
	if(!$GLOBALS['T3_VAR']['ext']['css_filelinks']['setup']['allow_read_from_path']){$allow_the_read_from_path='TCEFORM.tt_content.select_key.types.uploads.disabled=1
';};

       t3lib_extMgm::addPageTSConfig('TCEFORM.tt_content.table_border.types.uploads.disabled=1
TCEFORM.tt_content.table_cellspacing.types.uploads.disabled=1
TCEFORM.tt_content.table_cellpadding.types.uploads.disabled=1
TCEFORM.tt_content.table_bgColor.types.uploads.disabled=1
'.$allow_the_read_from_path);
?>