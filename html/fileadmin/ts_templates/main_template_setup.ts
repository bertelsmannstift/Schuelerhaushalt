###########################################################
#  Page Configuration
###########################################################

page = PAGE
page {
	10 = USER
	10.userFunc = tx_templavoila_pi1->main_page	
	meta.keywords.field=keywords
	meta.description.field=description
	meta.abstract.field=abstract
	meta.author.field=author
	meta.email.field=email
	shortcutIcon = fileadmin/templates/img/favicon.png	
}

###########################################################
#  E-Tracker Integration
###########################################################
#lib.etracker <  plugin.etracker

###########################################################
#  LessPHP Integration
###########################################################
#includeLibs.lessPHP = fileadmin/templates/lessphp/compiledLess.php

# Temp CSS 
#temp.css = USER
#temp.css{
#  userFunc = user_compiledLess->makeCSS
#  styleRoot = TEXT
#  styleRoot = fileadmin/templates/css/
#  lessFileName = TEXT
#  lessFileName = style.less
#}

#page.headerData.6 = USER
#page.headerData.6 < temp.css  
page.headerData.5 = TEXT
page.headerData.5.value = <link href='fileadmin/templates/css/style.css' rel='stylesheet' type='text/css'>
page.headerData.6 = TEXT
page.headerData.6.value = <link href='fileadmin/templates/css/print.css' rel='stylesheet' type='text/css' media='print'>

# Printpreview für all Offers
[globalVar = GP:tx_itaoshhoffers_print|action == printSheet]
page.headerData.8 = TEXT
page.headerData.8.value = <link href='fileadmin/templates/css/print.css' rel='stylesheet' type='text/css'>
[global]

page.headerData.7 = TEXT
page.headerData.7.value = <script src="fileadmin/templates/js/vendor/modernizr-2.6.1.min.js" type="text/javascript"></script>

###########################################################
#  Additional General Configuration
###########################################################

config {
	simulateStaticDocuments = 0
	tx_realurl_enable = 1
	extTarget = {$styles.content.links.extTarget}
	fileTarget = _blank
	index_enable = 1
	index_externals = 1
	spamProtectEmailAddresses = 1
	index_metatags = 0
    prefixLocalAnchors = all
    #config.pageTitleFirst = 1
	admPanel = 0 
	doctype = html5
	xhtml_cleaning = all	
	metaCharset = utf-8
	#renderCharset = utf-8
	additionalHeaders = Content-Type:text/html;charset=utf-8
}
page.config.index_enable = 1

#Browserweiche andere Browser
config.htmlTag_setParams = class="no-js"

#Browserweiche < IE7
[browser = msie] && [version= <7]
config.htmlTag_setParams = class="no-js ie6 oldie"
[global]

#Browserweiche IE7
[browser = msie] && [version=7]
config.htmlTag_setParams = class="no-js ie7 oldie"
[global]

#Browserweiche IE8
[browser = msie] && [version=8]
config.htmlTag_setParams = class="no-js ie8 oldie"
[global]

#Browserweiche IE9
[browser = msie] && [version=9]
config.htmlTag_setParams = class="no-js ie9"
[global]

#Browserweiche > IE9
[browser = msie] && [version= >9]
config.htmlTag_setParams = class="no-js"
[global]

[browser = netscape]
config.htmlTag_setParams = class="no-js ff"
[global]

###########################################################
#  Language Configuration
###########################################################
config {
	linkVars = L
	sys_language_uid = 0
	language = de
	locale_all = de_DE
	htmlTag_langKey = de
	sys_language_mode = strict
	sys_language_overlay = hideNonTranslated	
	baseURL = {$config.baseURL}
}

###########################################################
#  Navigation Configuration
###########################################################

#----------------------------------------------------------
#  Dummy Navigation Configuration
#----------------------------------------------------------
temp.navigations.dummies.standard = HMENU
temp.navigations.dummies.standard {
    
    1 = TMENU
    1 {
        expAll = 0
        wrap = <ul>|</ul>
        NO {
            wrapItemAndSub = <li class="first">|</li> |*| <li class="middle">|</li> |*| <li class="last">|</li>
        }
    }
}

temp.navigations.dummies.directory < temp.navigations.dummies.standard
temp.navigations.dummies.directory {
    special = directory
}

temp.navigations.dummies.list < temp.navigations.dummies.standard
temp.navigations.dummies.list {
    special = list
}



#----------------------------------------------------------
#  Home link
#----------------------------------------------------------
lib.homelink = HTML
lib.homelink {
  value = <img src="fileadmin/templates/img/home-logo.png" alt="{glob:TSFE:tmpl:setup:sitetitle}" />
  value {
    typolink {
      parameter = {$project.homepageLink}
      #ATagParams = id="home-link" 
      title = {$project.homeLinkTitle}
    }
    insertData = 1
  }
}

#----------------------------------------------------------
#  Logo link
#----------------------------------------------------------
lib.logolink = HTML
lib.logolink {
	value =	<img alt="Deine Schule. Deine Entscheidung." src="fileadmin/templates/img/your_choice_icon.png">
	#value = <img src="fileadmin/templates/img/logo.png" alt="{glob:TSFE:tmpl:setup:sitetitle}" />
	value {
		typolink {
			parameter = {$project.logoLink}
			#ATagParams = id="home-link" 			
		}
		insertData = 1
	}
}


#----------------------------------------------------------
#  Main Navigation
#----------------------------------------------------------
lib.mainnav < temp.navigations.dummies.standard
lib.mainnav {
  entryLevel = 0
  excludeUidList = 688
  1 = TMENU
  1 {
    expAll = 1
    noBlur = 1
    wrap = <ul class="level-1">|</ul>
    
    NO {
		wrapItemAndSub = <li class="first">|</li> |*| <li>|</li> |*| <li class="last">|</li>
		wrapItemAndSub.insertData = 1
		stdWrap.dataWrap = <span>|</span>
		ATagParams = class="first" |*| |*| class="last"
    }
    
    CUR = 1
    CUR {
		wrapItemAndSub= <li class="first current">|</li> |*| <li class="current">|</li> |*| <li class="current last">|</li>
		wrapItemAndSub.insertData = 1
		stdWrap.dataWrap = <span>|</span>
		ATagParams = class="first current" |*| class="current" |*| class="last current"
    }
    
    ACT = 1
    ACT {
      wrapItemAndSub = <li class="first active">|</li> |*| <li class="active">|</li> |*| <li class="last active">|</li>
      wrapItemAndSub.insertData = 1
      stdWrap.dataWrap = <span>|</span>
      ATagParams = class="first active" |*| class="active" |*| class="last active"
    }
       
    IFSUB < .NO
    IFSUB {
		wrapItemAndSub = <li class="first hasSub">|</li> |*| <li class="hasSub">|</li> |*| <li class="last hasSub">|</li>
		wrapItemAndSub.insertData = 1
    	ATagParams = class="first hasSub" |*| class="hasSub" |*| class="last hasSub"
		stdWrap.dataWrap = <span>|</span>
    }   
    IFSUB = 1
 
    ACTIFSUB < .ACT
    ACTIFSUB {
		wrapItemAndSub = <li class="first hasSub active">|</li> |*| <li class="hasSub active">|</li> |*| <li class="last hasSub active">|</li>
		wrapItemAndSub.insertData = 1   	
    	ATagParams = class="first hasSub active" |*| class="hasSub active" |*| class="last hasSub active"
		stdWrap.dataWrap = <span>|</span>
    }
    ACTIFSUB = 1
     
    CURIFSUB < .CUR
    CURIFSUB {
		wrapItemAndSub = <li class="first hasSub current">|</li> |*| <li class="hasSub current">|</li> |*| <li class="last hasSub current">|</li>
		wrapItemAndSub.insertData = 1
    	ATagParams = class="first hasSub current" |*| class="hasSub current" |*| class="last hasSub current"
		stdWrap.dataWrap = <span>|</span>
    }   
    CURIFSUB = 1
  }
  
  2 < .1  
  2.wrap = <ul class="level-2">|</ul>
  #3 < .2
  #3.wrap = <ul class="level-3">|</ul> 
}
#------------------------------------
# Responsive Navigation
#------------------------------------
  
lib.responsivenavi = HMENU
lib.responsivenavi {
wrap = <form action=""> <select onchange="window.location=this.options[this.selectedIndex].value">|</select></form>
 1 = TMENU
 1 {
   expAll = 1
   NO {
     doNotLinkIt = 1 
     stdWrap.cObject = COA
     stdWrap.cObject {
       10 = TEXT
       10 {
         wrap = <option value="{getIndpEnv:TYPO3_SITE_URL}|">
         insertData = 1
         typolink {
           parameter.field = uid
           returnLast = url
         }
       }
       20 = TEXT
       20 {
          field = title
          wrap =  |</option>
       }
     }
   }
   ACT <.NO
   ACT = 1
   ACT.stdWrap.cObject.10.wrap = <option selected="selected" value="{getIndpEnv:TYPO3_SITE_URL}|">
 }
 2 < .1
 2.NO.stdWrap.cObject.20.wrap = --|</option>
 3 < .1
 3.NO.stdWrap.cObject.20.wrap = ----|</option>
 4 < .1
 4.NO.stdWrap.cObject.20.wrap = ------|</option>
 5 < .1
 5.NO.stdWrap.cObject.20.wrap = --------|</option>
}
  
#----------------------------------------------------------
#  Service Navigation Top
#----------------------------------------------------------

lib.servicenavtop < temp.navigations.dummies.directory
lib.servicenavtop {
  special.value = {$project.serviceNavigation}  
  excludeUidList =  
  
  1 = TMENU
  1 {
    expAll = 1
    wrap = <ul>|</ul>
    noBlur = 1
    NO {
      wrapItemAndSub = <li class="first">|</li> |*| <li class="">|</li> |*| <li class="last">|</li>
      stdWrap.dataWrap= <span>|</span>
	  ATagParams.dataWrap = class="fancyBoxIframe" 
    }
    
    CUR = 1
    CUR {
      wrapItemAndSub = <li class="current">|</li>
      stdWrap.dataWrap= <span>|</span>
    }
    
    ACT = 1
    ACT {
      wrapItemAndSub = <li class="active">|</li>
      stdWrap.dataWrap= <span>|</span>
    }
  }
}

#----------------------------------------------------------
#  Service Navigation Bottom
#----------------------------------------------------------

lib.servicenavbottom < lib.servicenavtop 
lib.servicenavbottom {
  special.value = {$project.footerNavigation}  
}

#----------------------------------------------------------
#  CopyRight
#----------------------------------------------------------
lib.copyright = TEXT
lib.copyright {
	data = date : U
   	strftime = %Y
   	noTrimWrap = |Copyright | by Bertelsmann Stiftung|	
}

#----------------------------------------------------------
#    Sitemap Configuration
#----------------------------------------------------------
temp.navigations.sitemap = HMENU
temp.navigations.sitemap {
  wrap = <nav class="sitemap"><div class="sitemap">|</div></nav>
  1 =TMENU 
  1 {
    expAll = 1    
    wrap = <ul class="level-1">|</ul>
    NO{
		expAll = 1
		#wrapItemAndSub = <li>|</li>
		wrapItemAndSub = <li>|</li>
		wrapItemAndSub.insertData = 1
    }
    IFSUB = 1
    IFSUB{
		ATagParams.dataWrap = class="has-sub" 
		wrapItemAndSub = <li>|</li>
		wrapItemAndSub.insertData = 1
    } 
  }
  
  2 < .1
  2.wrap = <ul class="level-2">|</ul>
  #3 < .2
  #3.wrap = <ul class="level-3">|</ul>
}

tt_content.menu.20.2 >
tt_content.menu.20.2 = COA
tt_content.menu.20.2.10 < temp.navigations.sitemap


#----------------------------------------------------------
#  Pageteaser w/ Sitemap Content Element
#----------------------------------------------------------
### Menu of subpages of selected pages
#tt_content.menu.20.1 {
#	wrap = <div class="tabNavigation"><div class="tabs"> | </div><div class="clearer">&nbsp;</div></div>
#	1 {
#		NO.wrapItemAndSub = <div class="tabTitle"><h4> | </h4></div>
#		CUR < .NO
#		CUR = 1
#		CUR.wrapItemAndSub = <div class="tabTitle active"><h4> | </h4></div>
#	}
#}
#
#temp.contentGrap < tt_content.menu.20.3
#temp.contentGrap {
#	select {
#		pidInList.override.field = uid
#	}
#	renderObj {
#		field = bodytext
#		wrap = <p>|</p>		
#		typolink >
#		crop = 400 | ... | 1
#		stripHtml = 1
#		htmlSpecialChars = 1
#		htmlSpecialChars.preserveEntities = 1
#	}
#	wrap >
#	stdWrap.crop < temp.contentGrap.renderObj.crop
#}
#
#tt_content.menu.20.default {
#	wrap >
#	1.NO {
#		wrapItemAndSub = <div class="pageteaser">|</div>
#		stdWrap.field = title // nav_title
#		allWrap >
#		ATagParams = class="hiddenlink"
#		linkWrap = <h3>|</h3>
#		#after > 
#		#after {
#		#	data = field:abstract // field:subtitle
#		#	wrap = <p>|</p>
#		#	htmlSpecialChars = 1
#		#	required = 1
#		#}
#		
#		#media already used for header image
#		#afterImg {
#		#	import = uploads/media/
#		#	import.field = media
#		#	import.listNum = 0
#		#	width = 100c
#		#	height = 75c
#		#	typolink.parameter = http://www.test.de
#		#}
#		#afterImgTagParams = class="teaserimage"
#		#afterImgLink = 1
#		
#		allStdWrap {
#			postCObject = COA
#			postCObject {
#				10 = USER
#				10 < temp.contentGrap
#				20 = TEXT
#				20 {
#				 	field = nav_title // title
#					typolink {
#						parameter.data = field:uid
#						ATagBeforeWrap = 1
#						wrap = <span class="moreLink button">Mehr &gt;&gt;<span class="hidden">|</span></span>
#					}
#				}
#			}
#		}
#	}
#}

#----------------------------------------------------------
#    Footer-Sitemap Configuration
#----------------------------------------------------------
lib.footersitemap = HMENU
lib.footersitemap {
	special = directory
	special.value = {$project.sitemapNavigation}
	excludeUidList = 28,29,688
	1 =TMENU 
	1 {
	  expAll = 1
	  wrap = <ul class="level-1">|</ul>
	  NO{
	    expAll = 1
		wrapItemAndSub = <li>|</li>
		wrapItemAndSub.insertData = 1
	  }
	  IFSUB = 1
	  IFSUB{
	    #ATagParams.dataWrap = class="has-sub"
		wrapItemAndSub = <li>|</li>
		wrapItemAndSub.insertData = 1
	  } 
	}
	2 < .1
	2.wrap = <ul class="level-2">|</ul>
	#2.NO.wrapItemAndSub = <li><span>|</span></li>
	#2.IFSUB.wrapItemAndSub = <li><span>|</span></li>
	3 >
	4 >
}

#----------------------------------------------------------
#  Breadcrumb
#----------------------------------------------------------
lib.breadcrumb = HMENU
lib.breadcrumb {
  special = rootline
  special.range= 0 | -1
  1 = TMENU
  1 {
    expAll = 0
    noBlur = 1
    wrap = <ul><li>Sie befinden sich hier:&nbsp;</li>|</ul>
    NO {
      doNotLinkIt = 0 |*| 0 |*| 1  
      ATagParams = |*| |*| class="current" 
      wrapItemAndSub = <li class="first">|&nbsp;&nbsp;&#124;</li> |*| <li>|&nbsp;&nbsp;&#124;</li> |*| <li class="last">|</li>
      wrapItemAndSub.insertData = 1
    }
  }
}

#----------------------------------------------------------
#    Contact-Link
#----------------------------------------------------------
lib.contactlink = TEXT
lib.contactlink {
	typolink {
		parameter = {$project.contactLink}
		ATagParams.insertData = 1
		ATagParams = id="contactLink" class="fancyBoxIframe"
		ATagBeforeWrap = 1
	}
	if.isTrue = {$project.contactLink}
}

#----------------------------------------------------------
#    Contact-Link
#----------------------------------------------------------
lib.sitemaplink = TEXT
lib.sitemaplink {
	typolink {
		parameter = {$project.sitemapLink}
		ATagParams.insertData = 1
		ATagParams = id="sitemapLink"
		ATagBeforeWrap = 1
	}
	if.isTrue = {$project.sitemapLink}
}


###########################################################
#  Plugin Configuration
###########################################################

#----------------------------------------------------------
#    indexed_search
#----------------------------------------------------------
plugin.tx_indexedsearch {
    templateFile = fileadmin/templates/extensions/indexed_search.html
  _CSS_DEFAULT_STYLE >

  show.rules = 0
  show.alwaysShowPageLinks = 1

  specConfs.1.pageIcon = fileadmin/templates/css/images/file16/page_white.png
  specConfs.1.CSSsuffix = page

  ## Diese dokumentierte Einstellung fÃ¼r "EintrÃ¤ge pro Seite" funktioniert nicht!
  # search.page_links = 1
  ## Diese Einstellung funktioniert aber:
  _DEFAULT_PI_VARS.results = 10

  _LOCAL_LANG.de {
    # Ausgabe von "Seite" im Seitenbrowser unterbinden
    pi_list_browseresults_page =
    #kein Advanced Search Link
    link_advancedSearch = 
  }
  _LOCAL_LANG.en {
    # Ausgabe von "Seite" im Seitenbrowser unterbinden
    pi_list_browseresults_page =
    #kein Advanced Search Link
    link_advancedSearch = 
  }  
  	show.L1sections = 0
	show.mediaList = 0
	blind.lang = -1
	blind.extResume = -1

}

#----------------------------------------------------------
#    macina_searchbox
#----------------------------------------------------------

plugin.tx_macinasearchbox_pi1 {
  templateFile = fileadmin/templates/extensions/macina_searchbox.html
  pidSearchpage = {$project.searchPid}
}

lib.search < plugin.tx_macinasearchbox_pi1

###########################################################
#  Content Configuration
###########################################################

#----------------------------------------------------------
#  Add standard header to page title and subtitle
#----------------------------------------------------------
lib.pagetitle = TEXT
lib.pagetitle {
  value = {page:title}
  insertData = 1
  wrap = <h1>|</h1>
    
}

lib.pagesubtitle = TEXT
lib.pagesubtitle {
  value = 
  override.cObject = TEXT
  override.cObject{
    required = 1
    data = page:subtitle
    insertData = 1
    dataWrap = <h2>|</h2>
  }    
}

config.pageTitleFirst = 1
config.noPageTitle = 0

[globalVar = GP:tx_ttnews|tt_news > 0]
	#remove normal pagetitle for news single page
	lib.pagetitle >
	lib.pagesubtitle > 
	
	#use keywords and subheader from news for meta tags
	page.meta.description >
	page.meta.description = TEXT
	page.meta.description.data = register:newsSubheader
	page.meta.keywords >
	page.meta.keywords = TEXT
	page.meta.keywords.data = register:newsKeywords
[global]

#----------------------------------------------------------
#  Add standard header to flexible content elements
#----------------------------------------------------------
#do not activate, the greybox fce renders the header automatically in the correct field. if activated we have a duplicated header
#tt_content.templavoila_pi1.10 =< lib.stdheader
lib.fceHeadline = COA
lib.fceHeadline {
	10 = TEXT
	10.data = register:tx_templavoila_pi1.parentRec.header
}
lib.mailto_name = COA 
lib.mailto_name {
	10 = TEXT
	10.data.field = field_email
}

includeLibs.downloadCssClass = fileadmin/user_downloadFCE.php
lib.dl_class = USER
lib.dl_class{
	userFunc = user_downloadFCE->main
	mode = fileEnd
	stdWrap.field = field_dl_data
	# No Trim Wrap ist hier zwingend erforderlich
	stdWrap.noTrimWrap = 
}

lib.filesize = USER
lib.filesize {
	userFunc = user_downloadFCE->main
	mode = fileSize
	stdWrap.field = field_dl_data
	# No Trim Wrap ist hier zwingend erforderlich
	stdWrap.noTrimWrap = 
}

#----------------------------------------------------------
#    Highslide for Images
#----------------------------------------------------------
tt_content.image.20.1 {
	imageLinkWrap{
		enable{
			#only if image_zoom enabled and image_link empty
			field = image_zoom
			ifEmpty.typolink {
				parameter {
					field = image_link
					listNum.stdWrap.data = register : IMAGE_NUM_CURRENT
					listNum.splitChar = 10
				}
				returnLast = url
			}
		}
		typolink {
			#include image
	    	parameter.stdWrap {
	    		cObject = IMG_RESOURCE
		    	cObject {
		        	file.import.data = TSFE:lastImageInfo|origFile
		        	file.maxW = 1000
		    	}
		    	 #if image_link is not empty overwrite the parameter
				override {
			    	field = image_link
			    	listNum.stdWrap.data = register : IMAGE_NUM_CURRENT
			    	if.isTrue.field = image_link
			    	listNum.splitChar = 10	
				}
		    }		    			    
	   	 	ATagParams {
	   	 		override (
	    			onclick="return hs.expand(this)"
	    		)
		    	insertData = 1
		    	if.isTrue.field = image_zoom
	   	 	}
		}		
	}
	
	#use imagecaptions for image alt tags (used as highslide caption)
	altText.field = imagecaption
}

#----------------------------------------------------------
#    CSS Styled Content
#----------------------------------------------------------
#plugin.tx_cssstyledcontent._CSS_DEFAULT_STYLE >

Highslide License Key in Header
page.headerData.567 = TEXT
#page.headerData.567.value = <script type="text/javascript"><!-- Highslide -->df4b27be28001866282fe7a4f46071be</script>

#Include Javascript in footer
page.includeJS  {
	file1 = fileadmin/templates/js/vendor/jquery-1.8.0.min.js
	fancybox = fileadmin/templates/js/vendor/fancybox.js
	thumbnailHelper = fileadmin/templates/js/vendor/jquery.fancybox-thumbs.js
}
page.includeJSFooter  {
#	jQuery und Fancybox müssen im Header geladen werden - ansonsten kann es sein das script.js früher geladen wird und Fehler verursacht
#	file1 = fileadmin/templates/js/vendor/jquery-1.8.0.min.js
#	fancybox = fileadmin/templates/js/vendor/fancybox.js
	file4 = fileadmin/templates/js/script.js
	formValidation = fileadmin/templates/js/vendor/formValidation.js
	shhScript = EXT:itao_shh_offers/Resources/Public/Js/script.js
}

page.includeCSS {  
	file1 = fileadmin/templates/css/fancybox.css
}

#----------------------------------------------------------
#  WEBLINKS
#----------------------------------------------------------

plugin.tx_jpweblinks_pi1 {
     templateFile = fileadmin/templates/extensions/weblinks.html
}

#----------------------------------------------------------
#    jp_staff
#----------------------------------------------------------
plugin.tx_jpstaff_pi1 {
  	templateFile = fileadmin/templates/extensions/jp_staff.html
	memberDetailsPage = 23	
  	_CSS_DEFAULT_STYLE >
	_LOCAL_LANG.de {
		contact_member = E-Mail
		field_required = Die mit einem <span>*</span> gekennzeichneten Felder mÃ¼ssen ausgefÃ¼llt werden.
		sender-name = Nachname
		member_telephone_label = Telefonnummer
  	}
  	marker {
	    MEMBER_IMAGE {
	   		maxDetailWidth >
	   		detailWidth = 150
	   		
	   		maxContactWidth >
	   		contactWith = 93
	   		contactHeight = 137c
	   		
	   		maxListWidth >
	   		listWidth = 93
	   		listHeight = 137c
	    }
  	} 
}

#----------------------------------------------------------
#    Offers
#----------------------------------------------------------

plugin.tx_itaoshhoffers {
		
	schoolName = USER
	schoolName {
		userFunc = tx_extbase_core_bootstrap->run
		pluginName = SchoolData
		extensionName = ItaoShhOffers
		controller = Offer
		action = schoolData
		switchableControllerActions {
			Offer {
				1 = schoolData
			}
		}

		settings =< plugin.tx_indicatorentry.settings
		settings.schoolData = nameOfSchool
		persistence =< plugin.tx_indicatorentry.persistence
		view =< plugin.tx_indicatorentry.view
	}

}

lib.field_schoolname < plugin.tx_itaoshhoffers.schoolName

#----------------------------------------------------------
#    Registrierung
#----------------------------------------------------------
# Basic Konfiguration
# First Login
plugin.tx_datamintsfeuser_pi1 {
	_LOCAL_LANG.de {
		at_best = Anmeldung best&auml;tigen
		edit_success = <h3>Ihre Daten wurde erfolgreich ge&auml;ndert!</h3>Sie werden in wenigen Sekunden weitergeleitet!
		edit_default = Hier kannst du dir ein Profil erstellen. Besonders wichtig ist, dass du dir ein neues Passwort ausdenkst, welches du dir gut merken kannst!
	}
	register {
		emailtemplate = fileadmin/templates/extensions/datamints_feuser_mail.html
		doubleoptin = 1
		sendermail = info@schuelerhaushalt.de
		userfolder = 17
	}

	showtype = register
	usedfields = password, --separator--, first_name, last_name, tx_itaoshhmanager_shh_classname, --separator--, email, tx_itaoshhmanager_shh_terms, --submit--
	requiredfields = password, first_name, last_name, tx_itaoshhmanager_shh_terms
	uniquefields = 

#	edit {
#		mailtype = html
#	}

	validate {
		password.type = password
		password.length = 6
	}

	captcha {
		use = captcha
	}

	format {
		date = %d.%m.%Y
		datetime = %H:%M %d.%m.%Y
	}

	_LOCAL_LANG.de.edit_error_no_login = Bitte melden Sie sich an, um ihre pers&ouml;nlichen Daten zu &auml;ndern. Eine Anmeldung ist erst ab der Phase "Vorschl&auml;ge einreichen" m&ouml;glich.
}

[globalVar = TSFE:id=35]
# Guest Register
plugin.tx_datamintsfeuser_pi1 {
	usedfields = tx_itaoshhmanager_ssh_ref_school, password, --separator--, first_name, last_name, --separator--, email, tx_itaoshhmanager_shh_terms, --submit--
	requiredfields = email, password, first_name, last_name, tx_itaoshhmanager_shh_terms
}
[global]
[globalVar = TSFE:id=291]
# Change Passwort
plugin.tx_datamintsfeuser_pi1 {
	usedfields = password, --submit--
	requiredfields = password
	uniquefields = 
}
[global]
[globalVar = TSFE:id=292]
# Change Profile
plugin.tx_datamintsfeuser_pi1 {
	usedfields = first_name, last_name, tx_itaoshhmanager_shh_classname, --separator--, email, --submit--
	requiredfields = first_name, last_name
}
[global]

#----------------------------------------------------------
#    Login und Logout auf jeder Seite
#----------------------------------------------------------



plugin.tx_felogin_pi1 {
	welcomeHeader_stdWrap.wrap = <h3 class="display_none">|</h3>
	welcomeMessage_stdWrap.wrap = <div class="display_none">|</div>
	successHeader_stdWrap.wrap = <h3 class="display_none">|</h3>
	successMessage_stdWrap.wrap = <div class="display_none">|</div>
	logoutHeader_stdWrap.wrap = <h3 class="display_none">|</h3>
	logoutMessage_stdWrap.wrap = <div class="display_none">|</div>
	errorHeader_stdWrap.wrap = <h3 class="errorHeader">|</h3>
	errorMessage_stdWrap.wrap = <div class="errorMessage">|</div>
	#forgotHeader_stdWrap.wrap = <h3 class="display_none">|</h3>
	#forgotMessage_stdWrap.wrap = <div class="display_none">|</div>
	#forgotErrorMessage_stdWrap.wrap = <div class="display_none">|</div>
	forgotResetMessageEmailSentMessage_stdWrap.wrap = <div class="display_none">|</div>
	
	email_from = info@schuelerhaushalt.de
	email_fromName = Schuelerhaushalt
	replyTo = info@schuelerhaushalt.de

	_LOCAL_LANG.de {
		ll_forgot_reset_message_emailSent = 
		ll_enter_your_data = Benutzerkennung:
		#ll_forgot_reset_message = Bitte gib deine Benutzerkennung ein, um dein Kennwort zur&uuml;ckzusetzen. Du erh&auml;lst dann umgehend Anweisungen zum Zur&uuml;cksetzen des Passworts zugesandt. Wenn du bei der Anmeldung keine E-Mail-Adresse angegeben hast, wende Dich bitte an deinen Lehrer.
		ll_forgot_validate_reset_password_subject = Ihr neues Passwort
#		ll_forgot_validate_reset_password (
#Hallo %s,
#
#Sie erhalten diese Nachricht, da Sie Ihr Passwort zurücksetzen lassen wollen. Zur Bestätigung bitte nachstehenden Link aufrufen:
#%s
#
#Aus Sicherheitsgründen ist dieser Link nur bis %s aktiv. Falls Sie den Link nicht bis dahin aufgerufen haben, müssen Sie die Schritte zum Zurücksetzen des Passworts wiederholen.
#
#Ihr Schülerhaushalt-Team
#)
	}
	forgotResetMessageEmailSentMessage_stdWrap.wrap = Sie erhalten in K&uuml;rze eine E-Mail zur Zur&uuml;cksetzung ihres Passworts zugeschickt. Sollte Sie keine E-Mail erhalten, wenden Sie sich bitten an den <a class="fancyBoxIframe" href="service/kontakt/"><span>|Administrator</span></a>.

}




plugin.tx_felogin_pi1 {
#redirect
 redirectMode = userLogin,groupLogin,login,logout
#  redirectMode = groupLogin,login
  redirectFirstMethod = 0
#  redirectPageLogin = 31
  redirectPageLogout = 32  
  redirectDisable = 0
  showLogoutFormAfterLogin = 0
 }


[loginUser = *]
	lib.logout >
	lib.logout = COA
	lib.logout {
		20 = COA
		20 {
			10 = COA
			10.10 = TEXT
			10.10.data = TSFE:fe_user|user|first_name
			10.10.dataWrap = | &nbsp;
			10.20 = TEXT
			10.20.data = TSFE:fe_user|user|last_name

			10.wrap = <span class="user">Hallo&nbsp;|!&nbsp;</span>
			10.required = 1
#			stdWrap {
#				ifEmpty.data = TSFE:fe_user|user|username
#				wrap = <span class="user">|</span>
#				required = 1
#			}
		}
		30 = TEXT
		30 {
			value = Mein Profil
			typolink {
				parameter = 292
				ATagParams = class="myProfileLink fancyBoxIframe"
			}
			wrap = |&nbsp;<span class="greenPipe">&#448;</span>&nbsp; 
		}
		40 = TEXT
		40 {
			value = Ausloggen
			typolink {
				parameter = 1
			    ATagParams = class="logoutlink"
				additionalParams = &logintype=logout
			}
		}
		wrap = <div id="logout"><em>|</em></div>
	}	

[else]
	plugin.tx_felogin_pi1 {
		storagePid = 17
		templateFile = fileadmin/templates/extensions/felogin.html
		showForgotPasswordLink = 1
		#showPermaLogin = 1
		  redirectMode = groupLogin,login
  redirectFirstMethod = 0
#  redirectPageLogin = 31
#  redirectPageLogout = 32  
  redirectDisable = 0
  showLogoutFormAfterLogin = 0
	}
	temp.login = COA
	temp.login.10 < plugin.tx_felogin_pi1
	temp.login.20 = TEXT 
	temp.login.20 {
		value = Wenn du keine E-Mail-Adresse angegeben hast, wende dich an deinen Lehrer.
		wrap = <p>|</p>
	}
	
#	temp.login.30 = TEXT 
#	temp.login.30 {
#		value = als Gast einloggen
#		typolink {
#			parameter = 35
#			ATagParams = class="login"
#		}
#		wrap = <p>Hier k&ouml;nnen Sie sich&nbsp;|</p>
#	}
	
	lib.login < temp.login
[global]

#----------------------------------------------------------
#    Redirect - Erstmalige Anmeldung
#----------------------------------------------------------

[loginUser = *]
	config.no_cache = 0
[else]
	config.no_cache = 1 
[end]

#[globalVar = TSFE:id=34, TSFE:id=35]
#[globalVar = TSFE:id=34] || [globalVar = TSFE:id=35]
[globalVar = TSFE:id=34]
	#do nothing
[else]
	includeLibs.user_loginHandling = typo3conf/ext/itao_zfalogin/user_func/user_loginHandling.php 

	temp.forcePwChange = USER 
	temp.forcePwChange { 
	userFunc =user_loginHandling->checkForcedPasswordChange 

	passwordChangePageUid = TEXT 
	passwordChangePageUid.value = 34

	} 
	page.796<temp.forcePwChange 
	
	# diesen nachfolgenden Flag (config.no_cache=1) UNBEDINGT DRIN LASSEN, TROTZ INDEXED_SEARCH!!!!
	# wenn das NICHT gesetzt ist, führt es zu vielen Fehlern im geschützten Bereich, 
	# z.B. dazu: man loggt sich als User 1 ein; 
	# loggt sich aus; 
	# loggt sich als User 2 ein - 
	# geht auf z.B. Vorschlag anschauen => dann ist man wieder User 1!!!! 
	# So passiert am 12.11.2012 in Gymnasium Nepomucenum!
	config.no_cache = 1 
	# CHE: Cache wird nun nur im ausgeloggten Zustand deaktiveirt. 
	# Der oben beschriebene Fehler tritt dann nicht auf!

	plugin.tx_datamintsfeuser_pi1 { 
		fieldconfig.password.config.eval = password  
	} 
	plugin.tx_felogin_pi1.logoutHeader_stdWrap.wrap = | 
	plugin.tx_felogin_pi1._LOCAL_LANG.de.username = Benutzerkennung: 
	plugin.tx_felogin_pi1._LOCAL_LANG.de.ll_error_header = Anmeldung fehlgeschlagen
	

	#page.includeCSS {  
	#file1 = fileadmin/templates/css/fb_css.css  
	#}
[global]

#----------------------------------------------------------
# Banner Image Top
#----------------------------------------------------------

lib.headerimage = COA
lib.headerimage { 
	10 = IMAGE 
	10.file { 
		XY = 1280,195 
		format = jpg 
		import = uploads/tx_templavoila/ 
		import.postUserFunc = tx_kbtvcontslide_pi1->main 
		import.postUserFunc.field = field_headerimage 
		maxW = 1280 
		minW = 1280 
		maxH = 195 
		minH = 195 
	} 
}