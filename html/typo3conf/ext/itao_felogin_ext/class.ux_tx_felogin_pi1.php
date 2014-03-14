<?php

class ux_tx_felogin_pi1 extends tx_felogin_pi1 {

	/**
	  * Shows the forgot password form
	  *
	  * @return	string		content
	  */
	 protected function showForgot() {
		$subpart = $this->cObj->getSubpart($this->template, '###TEMPLATE_FORGOT###');
		$subpartArray = $linkpartArray = array();
		$postData =  t3lib_div::_POST($this->prefixId);

		if ($postData['forgot_email']) {

				// get hashes for compare
			$postedHash = $postData['forgot_hash'];
			$hashData = $GLOBALS['TSFE']->fe_user->getKey('ses', 'forgot_hash');


			if ($postedHash === $hashData['forgot_hash']) {
				$row = FALSE;

					// look for user record
				$data = $GLOBALS['TYPO3_DB']->fullQuoteStr($this->piVars['forgot_email'], 'fe_users');
				$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
					'uid, username, password, email',
					'fe_users',
					'username=' . $data . ' AND pid IN ('.$GLOBALS['TYPO3_DB']->cleanIntList($this->spid).') '.$this->cObj->enableFields('fe_users')
				);

				if ($GLOBALS['TYPO3_DB']->sql_num_rows($res)) {
					$row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res);
				}

				$error = NULL;
				if ($row) {
						// generate an email with the hashed link
					$error = $this->generateAndSendHash($row);
				} elseif ($this->conf['exposeNonexistentUserInForgotPasswordDialog']) {
					$error = $this->pi_getLL('ll_forgot_reset_message_error');
				}

					// generate message
				if ($error) {
					$markerArray['###STATUS_MESSAGE###'] = $this->cObj->stdWrap($error, $this->conf['forgotErrorMessage_stdWrap.']);
				} else {
					$markerArray['###STATUS_MESSAGE###'] = $this->cObj->stdWrap($this->pi_getLL('ll_forgot_reset_message_emailSent', '', 1), $this->conf['forgotResetMessageEmailSentMessage_stdWrap.']);
				}
				$subpartArray['###FORGOT_FORM###'] = '';


			} else {
					//wrong email
				$markerArray['###STATUS_MESSAGE###'] = $this->getDisplayText('forgot_reset_message', $this->conf['forgotMessage_stdWrap.']);
				$markerArray['###BACKLINK_LOGIN###'] = '';
			}
		} else {
			$markerArray['###STATUS_MESSAGE###'] = $this->getDisplayText('forgot_reset_message', $this->conf['forgotMessage_stdWrap.']);
			$markerArray['###BACKLINK_LOGIN###'] = '';
		}

		$markerArray['###BACKLINK_LOGIN###'] = $this->getPageLink($this->pi_getLL('ll_forgot_header_backToLogin', '', 1), array());
		$markerArray['###STATUS_HEADER###'] = $this->getDisplayText('forgot_header', $this->conf['forgotHeader_stdWrap.']);

		$markerArray['###LEGEND###'] = $this->pi_getLL('legend', $this->pi_getLL('reset_password', '', 1), 1);
		$markerArray['###ACTION_URI###'] = $this->getPageLink('', array($this->prefixId . '[forgot]'=>1), TRUE);
		$markerArray['###EMAIL_LABEL###'] = $this->pi_getLL('your_email', '', 1);
		$markerArray['###FORGOT_PASSWORD_ENTEREMAIL###'] = $this->pi_getLL('forgot_password_enterEmail', '', 1);
		$markerArray['###FORGOT_EMAIL###'] = $this->prefixId.'[forgot_email]';
		$markerArray['###SEND_PASSWORD###'] = $this->pi_getLL('reset_password', '', 1);

		$markerArray['###DATA_LABEL###'] = $this->pi_getLL('ll_enter_your_data', '', 1);



		$markerArray = array_merge($markerArray, $this->getUserFieldMarkers());

			// generate hash
		$hash = md5($this->generatePassword(3));
		$markerArray['###FORGOTHASH###'] = $hash;
			// set hash in feuser session
		$GLOBALS['TSFE']->fe_user->setKey('ses', 'forgot_hash', array('forgot_hash' => $hash));


		return $this->cObj->substituteMarkerArrayCached($subpart, $markerArray, $subpartArray, $linkpartArray);
	}
	
	/**
	 * generates a hashed link and send it with email
	 *
	 * @param	array		$user   contains user data
	 * @return	string		Empty string with success, error message with no success
	 */
	protected function generateAndSendHash($user) {
		$hours = intval($this->conf['forgotLinkHashValidTime']) > 0 ? intval($this->conf['forgotLinkHashValidTime']) : 24;
		$validEnd = time() + 3600 * $hours;
		$validEndString = date($this->conf['dateFormat'], $validEnd);

		$hash = md5(t3lib_div::generateRandomBytes(64));
		$randHash = $validEnd . '|' . $hash;
		$randHashDB = $validEnd . '|' . md5($hash);

		//write hash to DB
		$res = $GLOBALS['TYPO3_DB']->exec_UPDATEquery('fe_users', 'uid=' . $user['uid'], array('felogin_forgotHash' => $randHashDB));

		// send hashlink to user
		$this->conf['linkPrefix'] = -1;
		$isAbsRelPrefix = !empty($GLOBALS['TSFE']->absRefPrefix);
		$isBaseURL = !empty($GLOBALS['TSFE']->baseUrl);
		$isFeloginBaseURL = !empty($this->conf['feloginBaseURL']);

		$link = $this->pi_getPageLink($GLOBALS['TSFE']->id, '', array(
			$this->prefixId . '[user]' => $user['uid'],
			$this->prefixId . '[forgothash]' => $randHash
		));

		// Prefix link if necessary
		if ($isFeloginBaseURL) {
			// First priority, use specific base URL
			// "absRefPrefix" must be removed first, otherwise URL will be prepended twice
			if (!empty($GLOBALS['TSFE']->absRefPrefix)) {
				$link = substr($link, strlen($GLOBALS['TSFE']->absRefPrefix));
			}
			$link = $this->conf['feloginBaseURL'] . $link;
		} elseif ($isAbsRelPrefix) {
			// Second priority
			// absRefPrefix must not necessarily contain a hostname and URL scheme, so add it if needed
			$link = t3lib_div::locationHeaderUrl($link);
		} elseif ($isBaseURL) {
			// Third priority
			// Add the global base URL to the link
			$link = $GLOBALS['TSFE']->baseUrlWrap($link);
		} else {
			// no prefix is set, return the error
			return $this->pi_getLL('ll_change_password_nolinkprefix_message');
		}

		$msg = sprintf($this->pi_getLL('ll_forgot_validate_reset_password', '', 0), $user['username'], $link, $validEndString);

		// Add hook for extra processing of mail message
		if (isset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['forgotPasswordMail']) &&
				is_array($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['forgotPasswordMail'])
		) {
			$params = array(
				'message' => &$msg,
				'user' => &$user,
			);

			foreach ($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['felogin']['forgotPasswordMail'] as $reference) {
				if ($reference) {
					t3lib_div::callUserFunction($reference, $params, $this);
				}
			}
		}

		// no RDCT - Links for security reasons
		$oldSetting = $GLOBALS['TSFE']->config['config']['notification_email_urlmode'];
		$GLOBALS['TSFE']->config['config']['notification_email_urlmode'] = 0;
		// send the email
		// CHE CHANGE FUNCTION
//		$this->cObj->sendNotifyEmail($msg, $user['email'], '', $this->conf['email_from'], $this->conf['email_fromName'], $this->conf['replyTo']);
		
		$this->sendEmail($user, $msg);
		// restore settings
		$GLOBALS['TSFE']->config['config']['notification_email_urlmode'] = $oldSetting;

		return '';
	}
	
	/**
     * Sends an email to the user.
     *
     * @param array $user            The record set of the user.
     * @param string $emailText        The text for the email.
     * @return boolean
     */
    function sendEmail($user,$emailText) {
		
		$mailTextArray = explode("\n", $emailText);
		$subject = $mailTextArray[0];
		unset($mailTextArray[0]);
		$emailText = implode("\n", $mailTextArray);
		
        $header = 'From: ' .  $this->conf['email_from'] . "\r\n";
        $header .= 'Reply-To: ' . $user['email'] . "\r\n";
        $header .= 'Return-Path: ' . $user['email'] . "\r\n";
        $header .= 'Errors-To: ' . $user['email'] . "\r\n";
        $header .= 'X-Sender: ' . $user['email'] . "\r\n";
        $header .= 'X-Mailer: PHP/' .phpversion();
       
        return mail($user['email'], $subject, $emailText, $header, " -f ". $user['email'])==1 ? TRUE : FALSE;
    }

}

?>