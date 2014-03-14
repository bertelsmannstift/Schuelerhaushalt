jQuery(document).ready(function(){
	jsFormValidation();
});

/*
 * FormValidation via JS  #begin
 */

function jsFormValidation(){
	//Validation-Message on FocusOut
	jQuery('.jsValidationForm .jsRequired').focusout(function(){
		requiredFieldValidation(jQuery(this));		//call validation-Function with the required Input-Object
	});
	
	jQuery('.jsValidationForm .numberValidation').focusout(function(){
		var numberField=jQuery('.jsValidationForm .numberValidation');
		if(numberField.val() != ''){
			requiredFieldValidation(numberField);		//call validation-Function with the required Input-Object
			//background-Color change
		}
	});
	
	//Validation on Submit
	jQuery('.jsValidationForm').submit(function(){
		jQuery(this).find('.jsRequired').each(function(){
			requiredFieldValidation(jQuery(this));
		});
		if(jQuery('.errorRequired').val() == "" || jQuery('.emailError').html() || jQuery('.numberError').html()){
			return false;
		}
	});
}

/*
 * validate the Input-Field
 * call the email-Validation
 * 
 * param object --> The fireing Input-Field
 */
function requiredFieldValidation(fieldObject){
	var errorMessage = '<p>Dies ist ein Pflichtfeld</p>';		//errorMessage for empty required Fields
	var emailInvalidMessage = '<div class="validationError emailError" style="display:none"><p>Die angegebene E-Mailadresse ist nicht valide. Eine valide Adresse muss das folgende Muster aufweisen: max.mustermann@web.de</p></div>';		//errorMessage for failed emailValidation
	var numberInvalidMessage = '<div class="numberValidationError numberError" style="display:none">Der angegebene Wert muss ein Nummern-Format haben!</div>';		//errorMessage for failed emailValidation
	
	//check for an empty Value of the given Input-Object
	if(fieldObject.val() == ""){
		if(!fieldObject.hasClass('errorRequired')){
			//absolute Position-Vars for the errorMessage
			var thisTop = fieldObject.offset().top - 37;
			var thisLeft = fieldObject.offset().left + fieldObject.width() - 20;
			
			errorId = 'jsError_' + fieldObject.index();
			jQuery('body').append('<div id="' + errorId + '" class="error" style="position: absolute;top:' + (thisTop)+ 'px;left:' + (thisLeft)  + 'px">' + errorMessage + '</div>');
		}
		//add error-class
		fieldObject.addClass('errorRequired');
	}else{	//delete error-messages and remove error-class
		if(fieldObject.hasClass('errorRequired')){
			errorId = 'jsError_' + fieldObject.index();
			jQuery('#' + errorId).remove();
			//fieldObject.next('.error').remove();
		}
		//check for email-field
		if(fieldObject.attr('type') == 'email' || fieldObject.hasClass('emailValidation')){
			if(validateEmail(fieldObject.val())){
				jQuery('.validationError').slideUp('300', function(){
					jQuery(this).remove();
				});
				
				fieldObject.removeClass('errorRequired');
				errorId = 'jsError_' + fieldObject.index();
				jQuery('#' + errorId).remove();
				//background-Color change
			}else{
				if(fieldObject.hasClass('errorRequired') && !jQuery('.emailError').html()){
					//add emailvalidation messages
					fieldObject.after(emailInvalidMessage);
					jQuery('.validationError').slideDown('300');
					fieldObject.addClass('errorRequired');
				}
				
			}
		} else if(fieldObject.hasClass('numberValidation')) {
			if(validateNumber(fieldObject.val())){
				jQuery('.numberValidationError').slideUp('300', function(){
					jQuery(this).remove();
				});
				
				fieldObject.removeClass('errorRequired');
				errorId = 'jsError_' + fieldObject.index();
				jQuery('#' + errorId).remove();
			}else{
				if(!jQuery('.numberError').html()){
					//add emailvalidation messages
					fieldObject.after(numberInvalidMessage);
					jQuery('.numberValidationError').slideDown('300');
					fieldObject.addClass('errorRequired');
				}
			}
		} else {
			fieldObject.removeClass('errorRequired');
		}
	}
}

/*
 * E-Mail validation
 * 
 * param string - the E-Mail-Address
 */
function validateEmail(email){
	var theRegEx_isValid = new RegExp("^.+\@[a-zA-Z0-9\-\.]+[\.]+([a-zA-Z]{2,4}|[0-9]{1,3})$", "");
	if (theRegEx_isValid.test(email)) {
		return true;
	}else{
		return false;
	}
}
/*
 * Number validation
 * 
 * param string - the E-Mail-Address
 */
function validateNumber(value){
//	var theRegEx_isValid = new RegExp("^[0-9\.\,]{0,10}$");
	var theRegEx_isValid = new RegExp("^[0-9]{0,20}$");
	if (theRegEx_isValid.test(value)) {
		return true;
	}else{
		return false;
	}
}
//FormValidation via JS  #end