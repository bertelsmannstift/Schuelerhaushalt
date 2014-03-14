
var ideaCounter = 1;

function createIdeaField(){
	ideaCounter++;
	var deleteLink = '<a href="#" onclick="deleteField(\'idea_' + ideaCounter + '\'); return false;" class="deleteField">Sch&uuml;ler entfernen</a>';
	var newField = '<div class="ideaFields fieldsInARow" id="idea_' + ideaCounter + '"><input type="text" name="tx_itaoshhoffers_offers[ideaFrom][name]" class="first jsRequired ideaFromName"><input type="text" name="tx_itaoshhoffers_offers[ideaFrom][class]" class="last jsRequired ideaFromClass">' + deleteLink + '</div>';
	
	jQuery('#ideaFrom .additionalFields').append(newField);
}
var promoterCounter = 5;
function createPromoterField(){
	promoterCounter++;
	var deleteLink = '<a href="#" onclick="deleteField(\'promoter_' + promoterCounter + '\'); return false;" class="deleteField">Sch&uuml;ler entfernen</a>';
	var newField = '<div class="promoterFields fieldsInARow" id="promoter_' + promoterCounter + '"><input type="text" name="tx_itaoshhoffers_offers[promotedFrom][name]" class="first promotedFromName"><input type="text" name="tx_itaoshhoffers_offers[promotedFrom][class]" class="last promotedFromClass">' + deleteLink + '</div>';
	
	jQuery('#promotedFrom .additionalFields').append(newField);
	jQuery('#savePromoter').show();
	
	showPromoterLabels();
}

function showPromoterLabels(){
	if(jQuery('.promoterFields input').length > 0) {
		jQuery('.promoterLabels').show();
	} else {
		jQuery('.promoterLabels').hide();
	}
}

var imageCounter = 1;
function createImageField(){
	imageCounter++;
	var deleteLink = ' <a href="#" onclick="deleteField(\'image_' + imageCounter + '\'); return false;" class="deleteField">Bild entfernen</a>';
	var newField = '<div id="image_' + imageCounter + '"><label for="tx_itaoshhoffers_offers[image][' + imageCounter + ']">Name</label><input class="imageUpload" type="file" name="tx_itaoshhoffers_offers[newOffer][image_' + imageCounter + ']">' + deleteLink + '</div>';
	
	jQuery('#images').append(newField);
	
	if(jQuery('.imageUpload').length >= 3){
		jQuery('#addImageField').hide();
	}
}
function deleteField(id){
	jQuery('#' + id).remove();
	
	if(jQuery('.imageUpload').length < 3){
		jQuery('#addImageField').show();
	}
	if(jQuery('#savePromoter').length > 0 && !jQuery('.promoterFields').html()){
		
		jQuery('#savePromoter').hide();
	}
	
	showPromoterLabels();
}

function newOfferSubmitHandler(){
	// ideas
	setIdeas();
	
	// promoter
	setPromoter();
	
	// images
	setImages();
	
	return false;
}	

jQuery('#newPromoter').submit(function(){
	
	// promoter
	setPromoter();
	
});

jQuery('#becomeChildOf').submit(function(){
	window.parent.changes = 1;
	childUid = jQuery('#parentSelect').val();
//	childNumber = jQuery('#offer_' + childUid).val();
//	offerNumber = jQuery('#offerInternalNumber').val();
	if(childUid) {
		var confirmMessage = jQuery('#offer_' + childUid).html();
		var check = confirm(confirmMessage);
		if (check == false){
			return false;
		} else {
			window.parent.jQuery.fancybox.close();
			return true;
		}
	} else {
		alert(unescape("Bitte einen Vorschlag ausw%E4hlen"));
		return false;
	}
	
});

function setIdeas(){
	var ideaNames = '';
	var ideaClasses = '';
	jQuery('#newOfferFormWrap .ideaFromName').each(function(){
		if(ideaNames != ''){
			ideaNames+=',';
		}
		ideaNames+= jQuery(this).val();
	});
	
	jQuery('#newOfferFormWrap .ideaFromClass').each(function(){
		if(ideaClasses != ''){
			ideaClasses+=',';
		}
		ideaClasses+= jQuery(this).val();
	});
	
	jQuery('#newOfferFormWrap #ideaFromNames').val(ideaNames);
	jQuery('#newOfferFormWrap #ideaFromClasses').val(ideaClasses);
}

function setPromoter(){
	var promoterNames = '';
	var promoterClasses = '';
	jQuery('.promotedFromName').each(function(){
		if(promoterNames != ''){
			promoterNames+=',';
		}
		promoterNames+= jQuery(this).val();
	});
	
	jQuery('.promotedFromClass').each(function(){
		if(promoterClasses != ''){
			promoterClasses+=',';
		}
		promoterClasses+= jQuery(this).val();
	});
	
	jQuery('#promotedFromNames').val(promoterNames);
	jQuery('#promotedFromClasses').val(promoterClasses);
}

function setImages(){
	var images = '';
	var imageSource = '';
	jQuery('#newOfferFormWrap .imageUpload').each(function(){
		imageSource = jQuery(this).val();
		if(imageSource){
			
			if(images != ''){
				images+=',';
			}
			images+= imageSource;
		}	
	});
	
	jQuery('#newOfferFormWrap #allImages').val(images);
}

function setFilter(id, value) {
	jQuery('#' + id).val(value);
//	addHashToForm();
	jQuery('#filterOffers').submit();
}

function markAsEdited(mark,offer) {
	jQuery('#markAsEdited_mark').val(mark);
	jQuery('#markAsEdited_offer').val(offer);
//	addHashToForm();
	jQuery('#filterOffers').submit();
}
