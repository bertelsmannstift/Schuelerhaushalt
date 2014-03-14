<?php

/**
  * Lib for Mailing
  */

$LANG->includeLLFile('EXT:itao_shh_manager/mod1/locallang.xml');
require_once(PATH_t3lib . 'class.t3lib_scbase.php');


require_once(PATH_t3lib .'mail/class.t3lib_mail_message.php');

/**
 * Library for the 'itao_shh_manager' extension.
 * Function for Mailing
 *
 * @author	Edeltraud Gratzer <edeltraud.gratzer@itao.de>
 * @package	TYPO3
 * @subpackage	tx_itaozfadatamanager
 */
class  tx_itaoshhmanager_mail extends  t3lib_SCbase {			
				
				
	function sendMyMail($userid) {
/*		global $LANG; global $BE_USER;		

			$header = 'From: '.$this->tsvars['mailname_absender_accounts'].'<'.$this->tsvars['mail_absender_accounts'].">\n";
			$header .= "MIME-Version: 1.0\n";
			$header .= "Content-type: text/plain; charset=utf-8\n";
			$header .= "Content-Transfer-Encoding: quoted-printable\n";
			
			
			$empfaenger_arr[0] = $kundendata['email'];
			$empfaenger_arr[1] = $BE_USER->user['email'];
			
			##### NEUUUU
			$mailArr['###ANSPRECHPARTNER_FIRSTNAME###'] = $kundendata['first_name'];
			$mailArr['###ANSPRECHPARTNER_LASTNAME###'] = $kundendata['last_name'];

			
			$subject1 = tx_itaozfadatamanager_library::template_ausgeben_mails(array(), "EMAIL_STATISTIK_BETREFF");
			$subject =  "=?ISO-8859-15?Q?".imap_8bit($subject1)."?=\r\n";	
			$subject =  "".$subject1."\r\n";	
			$message = tx_itaozfadatamanager_library::template_ausgeben_mails($mailArr, "EMAIL_STATISTIK_TEXT");

			$message.=$this->emailsignatur;
			##### NEUUUU ENDE
			
			
			
			while (list ($key, $val) = each ($empfaenger_arr)) {
				mail($val, $subject, $message, $header);
			}

		return "";
		*/
	}
	
	
		
		function getMailMessage_initial_off($kundendata) {			
		/*	global $BE_USER, $LANG;
			$mailArr['###ANSPRECHPARTNER_OFF###'] = $this->tsvars['ap_off'];		
			$nachricht = 	tx_itaozfadatamanager_library::template_ausgeben_mails($mailArr, "EMAIL_STARTDATENERHEBUNG_OFF_NACHRICHT_EINL");
			$nachricht .= 	tx_itaozfadatamanager_library::template_ausgeben_mails($mailArr, "EMAIL_STARTDATENERHEBUNG_OFF_NACHRICHT_INFO");
			$nachricht .= 	tx_itaozfadatamanager_library::template_ausgeben_mails($mailArr, "EMAIL_STARTDATENERHEBUNG_OFF_NACHRICHT_INFO2");
			$nachricht.= $this->emailsignatur;	
			*/
			return $nachricht;
		}
				
				
}

?>