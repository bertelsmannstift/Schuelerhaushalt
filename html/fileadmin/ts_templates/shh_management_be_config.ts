#--------------------------------------------------------------------------------------------------------------------
# Konfiguration für das BE-Modul der SHH-Verwaltung 
#--------------------------------------------------------------------------------------------------------------------

plugin.tx_itaoshhmanager_pi1 {
	# pageid der Vorlage-Seite für Schule (ist die HAUPTSEITE, Rest wird gezogen)
	school_model_pageid = 386 #CHE wird nicht mehr gebraucht?
	school_model_pageid_newstructure = 553
	#92
	# pageid der Vorlage-Seite für Kommune
	commune_model_pageid = 565
	#ist die kommunenseite von rietberg - muss so gemacht werden wegen redakteurs-rechten
	pid_kommunen = 16
	#30
	pid_offers = 16
	pid_feusers = 17
	
	# Nach dieser Seite soll eine neue Kommunenseite angelegt werden:
	newCommuneAfterThisPage = 537
	
	# Hauptseite der "Abgeschlossenen Kommunen"
	finished_communes = 538
	
	#####fe-groups-uid
	groupid_verw_kommune = 1
	groupid_verw_schule = 2
	groupid_schuelervertretung = 3
	groupid_schueler = 4
	groupid_mod_kommune = 5
	groupid_mod_schule = 6	
	groupid_gast = 7	
	# fe_group - uid der Gruppe "Schule allgemein"
	groupid_school = 8	
	
	# pfad zum Ordner, wohin die Zugangsdaten-PDFS generiert werden
	accountpath = uploads/tx_itaoshhmanager/pdfs_accounts/
	beaccountpath = uploads/tx_itaoshhmanager/pdfs_beaccounts/
	offerimage_path = uploads/tx_itaoshhoffers/
	
	###### be-usergroup-ids:
	be_groupid_techadmin = 2
	be_groupid_redadmin_kommune = 3
	be_groupid_redadmin_schule = 4
	be_groupid_mod_kommune = 5
	be_groupid_mod_schule = 6
	
	##### fuer Generierung der Zugangsdaten fuer User:
	maindomain_pdf = www.shh-vorlage.de
	
	
}

plugin.tx_jpstaff_pi1 {
	subject_rec = [Schülerhaushalt.de] Nachricht über die Website
	mail_absender = info@schuelerhaushalt.de
}