
var changes = 0;
var changesNoCache = 0;
var redirect = 0;

jQuery(document).ready(function(){
	loadFancyBox();
	
	if(jQuery('.tabContent').length > 0){
		tabNavigation();
	}
	
	if(jQuery('#showFeedback').length > 0 ) {
		jQuery('#showFeedbackLink').click();
	}
	setEvents();
	fixHeightOfSidecontent();
	
	if(jQuery('#offerPreview').length > 0) {
		buildOfferPreview();
	}
	
	if(jQuery('.accordion').length > 0){
		initAccordion();
		var offerChildAccordionConf = {
			wrap					: '.accordion',
			elementContent			: '.accordionDetail',
			elementEntry			: '.accordionElement',
			eventElementClass		: '.clickHandler',	//the Element which handle the Event
			showFirstElement		: 0,
			duration				: 300
		}
		offerChildAccordion = new ItaoAccordion(offerChildAccordionConf);
	}
});

function setEvents(){
	// All function Links update the Lightbox-Dimensions
	jQuery('.iframeContent a').click(function(){
		window.parent.jQuery.fancybox.update();
	});
	jQuery('.setStatus .buttonLink').click(function(){
		window.parent.changes = 1;
		window.parent.jQuery.fancybox.close();
	});
	
	jQuery('#datamints_feuser_364_form').submit(function(){
		window.parent.changes = 1;
		window.parent.jQuery.fancybox.close();
		return true;
	});
	
	jQuery('.fancyCloseAndRedirect').click(function(){
		var redirectURL = jQuery(this).attr('href');
		window.parent.changes = 0;
		window.parent.redirect = "http://" + window.parent.location.hostname + "/" + redirectURL;
		window.parent.jQuery.fancybox.close();
	});
	
	jQuery('#datamints_feuser_365_form').submit(function(){
		var password = jQuery('#datamints_feuser_365_password').val();
		var passwordRep = jQuery('#datamints_feuser_365_password_rep').val()
		if( password == passwordRep && password.length > 6){
			window.parent.changes = 1;
			window.parent.jQuery.fancybox.close();
			return true;
		} else {
			return false;
		}
	});
	
	jQuery('.iframeContent form').submit(function(){
		window.parent.changes = 1;
	});

	jQuery('.iframeContent .jsChangesLink').click(function(){
		window.parent.changes = 1;
	});
	
	jQuery('.iframeContent .jsChangesNoCacheLink').click(function(){
		window.parent.changesNoCache = 1;
	});
	
	jQuery('.offerEntry .offerFunctionLink a').click(function(){
		jQuery(this).attr('href', jQuery(this).attr('href') + '&tx_itaoshhoffers_offers%5BactTab%5D=' + jQuery('#actTab').val());
	});
	
	jQuery('#newOffer').submit(function(){
		newOfferSubmitHandler();
	});
	
	// Validation on Submit for the Preview
	jQuery('#previewLink').click(function() {
		var validationForm = jQuery('.jsValidationForm');
		validationForm.find('.jsRequired').each(function(){
			requiredFieldValidation(jQuery(this));
		});
		
		if(jQuery('.errorRequired').val() == "" || jQuery('.emailError').html() || jQuery('.numberError').html()){
			return false;
		}
	});
}

function buildOfferPreview(){
	var form = jQuery('#newOfferFormWrap', parent.document);
	
	var title = form.find('input[name="tx_itaoshhoffers_offers[newOffer][title]"]').val();
	var description = form.find('textarea[name="tx_itaoshhoffers_offers[newOffer][description]"]').val();
	var costs = form.find('input[name="tx_itaoshhoffers_offers[newOffer][costs]"]').val();
	var school = form.find('input[name="tx_itaoshhoffers_offers[newOffer][school]"]').val();
	var imageUploads = form.find('#images').clone();
	
	if (costs.length > 0){
		jQuery('.costs .theCosts').html(costs + '&euro;');
		jQuery('.costs .theCosts').show();
	} else {
		jQuery('.costs .no_costs').show();
	}
	
	var ideaNames = '';
	var ideaClasses = '';
	var promoterNames = '';
	var promoterClasses = '';
	
	var ideaLIs = '';
	
	// ideas
	form.find('.ideaFields').each(function(){
		studentClass = jQuery(this).find('input[name="tx_itaoshhoffers_offers[ideaFrom][class]"]').val();
		studentName = jQuery(this).find('input[name="tx_itaoshhoffers_offers[ideaFrom][name]"]').val();
		if(studentName.length > 0){
			ideaLIs+='<li><span class="name">' + studentName + '</span><span class="class">' + studentClass + '</span></li>'	
			if(ideaNames != ''){
				ideaNames+=',';
			}
			ideaNames+= studentName;

			if(ideaClasses != ''){
				ideaClasses+=',';
			}
			ideaClasses+= studentClass;
		}
	});
	
	// promoters
	var promoterLIs = '';
	form.find('.promoterFields').each(function(){
		studentClass = jQuery(this).find('input[name="tx_itaoshhoffers_offers[promotedFrom][class]"]').val();
		studentName = jQuery(this).find('input[name="tx_itaoshhoffers_offers[promotedFrom][name]"]').val();
		if(studentName.length > 0){
			promoterLIs+='<li><span class="name">' + studentName + '</span><span class="class">' + studentClass + '</span></li>'
			if(promoterNames != ''){
				promoterNames+=',';
			}
			promoterNames+= studentName;

			if(promoterClasses != ''){
				promoterClasses+=',';
			}
			promoterClasses+= studentClass;
		}
	});
	
	// images
//	var images = '';
	var imageSource = '';
//	var filename;
	var indexCounter = 0;
	form.find('.imageUpload').each(function(){
		imageSource = jQuery(this).val();
		if(imageSource){
			//fix for IE --> IE takes the whole path..
//			filename = escape(imageSource).split("%5C");
//			filename = unescape(filename[filename.length-1]);
//			if(images != ''){
//				images+=',';
//			}
//			images+= filename;
			
			//show Dummyimages
			jQuery('.OfferImage:eq(' + indexCounter + ') .dummyImage').show();
			indexCounter++;
		}	
	});
	if( indexCounter <= 0 ) {
		jQuery('.offerImages').hide();
	}
	
//	jQuery('#newOfferFormWrap #allImages').val(images);
	
	jQuery('#offerPreview h1').html(title);
	
//	// Number
//	jQuery('#offerPreview .number').html(form.find('input[name="tx_itaoshhoffers_offers[newOffer][number]"]').val());
	
	// Description
//	var description = form.find('textarea[name="tx_itaoshhoffers_offers[newOffer][description]"]').val();
	jQuery('#offerPreview .offerDescription').html(description.replace(/\n/g,"<br>"));
//	jQuery('#newOffer textarea[name="tx_itaoshhoffers_offers[newOffer][description]"]').val(description.replace(/\n/g,"<br>"));
	
	// Costs
//	var costs = form.find('input[name="tx_itaoshhoffers_offers[newOffer][costs]"]').val();
	
	// Build Lists
	jQuery('#offerPreview .ideas .studentList').append(ideaLIs);
	
	if(promoterLIs.length > 0) {
		jQuery('#offerPreview .promoter').show();
		jQuery('#offerPreview .promoter .studentList').append(promoterLIs);
	}
	
	// Set Preview Values
//	jQuery('#prev_title').val(title);
//	jQuery('#prev_description').val(description);
//	jQuery('#prev_costs').val(costs);
//	jQuery('#prev_images').val(images);
//	jQuery('#imageUploads').append(imageUploads);
//	
//	jQuery('#prev_promotedClasses').val(promoterClasses);
//	jQuery('#prev_promotedNames').val(promoterNames);
//	jQuery('#prev_ideaClasses').val(ideaClasses);
//	jQuery('#prev_ideaNames').val(ideaNames);
//	jQuery('#prev_school').val(school);
	
}

function popup (url) {
	fenster = window.open(url, "Popupfenster", "width=800,height=740,scrollbars=yes");
	fenster.focus();
	return false;
}

function loadFancyBox(){
	$('.fancyBoxIframe').fancybox( {
		padding : 40,
		fitToView: 0,
		autoResize: 1,
		scrolling: 'no',
//		minHeight: 500,
		type: 'iframe',
		beforeShow: function() {
			jQuery('iframe').contents().find('body').addClass("lightboxBody");
		},
		afterClose: function() {
			if(changes == 1){	
				window.location.reload();
			}
			if(changesNoCache == 1) {
				window.location.reload(true);
			}
			if(redirect) {
				window.location = redirect;
			}
			jQuery('#showFeedback').remove();
		}
	} );
	
	$('.fancyPrintIFrame').fancybox( {
		padding : 40,
		width: 150,
		minHeight: 0,
		type: 'iframe'
	} );
	jQuery('.fancyBoxAjax').fancybox( {
		padding : 40,
		fitToView: 0,
		autoResize: 1,
		scrolling: 'no',
		type: 'ajax'
	} );
	
	jQuery('.fancy_gallery').fancybox({
		padding : 40,
		helpers	: {
			title	: {
				type: 'outside'
			},
			thumbs	: {
				width	: 100,
				height	: 100
			}
		}
	} );
}


	
function fixHeightOfSidecontent() {

	//set sideContent height to auto, to expand it to visible size
	//jQuery('#sideContent').height('auto');
	//jQuery('#mainContent').height('auto');
	//calculate mainContent and sideContent height
	//var mainContentOuterHeight = jQuery('#mainContent').outerHeight();	
	//var mainContentHeight = jQuery('#mainContent').height();	
	//var sideContentHeight = jQuery('#sideContent').height();
				
	//compare Heights and adjust the smaller ones height
	//if(sideContentHeight > mainContentHeight) {
		//var newMainContentHeight = sideContentHeight - (mainContentOuterHeight - mainContentHeight);  	
		//jQuery('#sideContent').height(sideContentHeight+51);
		//jQuery('#mainContent').height(newMainContentHeight);
	//}else{
		//set sideContent height back to window filling size if it is smaller than mainContent
	//	jQuery('#sideContent').height(jQuery('#mainContent').height() +72);	
    	
	//}
}

function tabNavigation() {
	var actTab = jQuery('#actTab').val();
	
	if(actTab){	
		jQuery('#' + actTab + '_tab').show();
		jQuery('#' + actTab + '_nav').addClass('active');
	} else {
		jQuery('.tabContent:first').show();
		jQuery('.tabNavigation li:first').addClass('active');
	}
	
	jQuery('.tabNavigation li').click(function(){
		jQuery('.tabContent').hide();
		jQuery('.tabNavigation li').removeClass('active');
		jQuery(this).addClass('active');
		var index = jQuery(this).index();
		jQuery('.tabContent:eq(' + index + ')').show();
		// post the act Tab - Set hiddenfield
		jQuery('#actTab').val('tab_' + index);
		fixHeightOfSidecontent();
		window.parent.jQuery.fancybox.update();
		var scrollPosition = jQuery(this).position();
		
		setTimeout(function(){window.parent.jQuery('.fancybox-overlay').scrollTop(scrollPosition.top);}, 10);
		
	});
}

// New Accordion-Script
function initAccordion (){
	ItaoAccordion = function(conf){
		var instances = new Array();
		// Konfiguration laden
		var configuration = conf;
		
		// instanzen erstellen
		var setInstances = function() {
			jQuery(configuration.wrap).each(function(){
				//set reference to this instance
				
				var references = {
					wrap: jQuery(this),
					accordionElements: jQuery(this).find(configuration.elementEntry),
					accordionContents: jQuery(this).find(configuration.elementContent),
					eventElements: jQuery(this).find(configuration.elementEntry).find(configuration.eventElementClass),
					overlay: jQuery(window.parent.jQuery('.fancybox-overlay'))
				}
				
				var methods = {
					accordion: function (handler) {
						references.accordionElements.each(function(){
							jQuery(references.accordionElements).removeClass('active');
							references.accordionContents.slideUp(configuration.duration, function(){
								methods.updateFancyboxSize();
								var pos = handler.position();
								references.overlay.animate({ scrollTop: pos.top }, "slow");
							});
							
						});
						handlerAccordionContent = handler.parents(configuration.elementEntry + ':first').find(configuration.elementContent);
						if(handlerAccordionContent.is(':hidden')){
							handler.parents(configuration.elementEntry + ":first").addClass('active');
							handlerAccordionContent.slideDown(configuration.duration, function(){
								methods.updateFancyboxSize();
							});
						}
						
					},
					updateFancyboxSize: function() {
						window.parent.jQuery.fancybox.update();
					},
					build: function () {
						if(configuration.showFirstElement){
							references.wrap.find(configuration.elementContent + ':first').show();
							references.wrap.find(configuration.eventElementClass + ':first').addClass('active');
						}
						references.eventElements.click(function(){
							methods.accordion(jQuery(this));
						});
					}
				}
				instances.push(
				{
					references: references,
					methods: methods
				}
				);
			});
		}
		// init Logic
		setInstances();
		
		if(instances){
			for(var i in instances) {
				if(/^\d*$/.test(i)){
					instances[i].methods.build();
				}
			}
		}	
	}
}