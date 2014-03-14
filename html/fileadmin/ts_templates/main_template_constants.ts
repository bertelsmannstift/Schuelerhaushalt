###########################################################
#	BaseURL
###########################################################
config.baseURL = http://sv.schuelerhaushalt.de/

###########################################################
#	Project Configuration
###########################################################
project.homepageLink = 1
project.homepageLinkTitle = zur Startseite
project.logoLink = 32

#project.serviceNavigation = 4
project.footerNavigation = 5
project.sitemapNavigation = 1
project.sitemapLink = 10
project.contactLink = 9

project.fileadminFolder = 
project.extension_templates = fileadmin/templates/extensions



project.searchPid = 8
###########################################################
#	General Configuration
###########################################################

config.languages.default.language = de
config.languages.default.locale_all = de_DE


###########################################################
#  Content Configuration
###########################################################

content.defaultHeaderType = 3
content.RTE_compliant = 1
styles.content {
	imgtext {
		maxW = 490
		# 3col template needs images to be 191 to fit
		maxWInText = 310
		linkWrap.width = 1000
		linkWrap.height = 1000
	}
	media {
		defaultVideoWidth = 310	
	}
	loginform.pid = 0
}



###########################################################
#  Plugin Configuration
###########################################################
#----------------------------------------------------------
#  E Tracker Configuration
#----------------------------------------------------------
plugin.etracker {
	rootpage = 1
	ssl = 0
	securitycode = EB9YKx
}

###########################################################
#  Vorschläge
###########################################################

plugin.tx_itaoshhoffers {
	persistence {
		storagePid = 16,19,444
	}

	groups {
		guest = 7
		studentRepresentation = 3
		localManagement = 1
		student = 4
		teacher = 6
	}
	detailPage = 97
	printPage.sheet = 378
	printPage.list = 385
}