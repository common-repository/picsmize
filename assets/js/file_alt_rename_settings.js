jQuery(document).ready(function(){
	imageNamePreview();
	arrangeableInit();
	jQuery(document).on('click','.Property-Button',function(){
		var _this = jQuery(this);
		var value = _this.prop('value');
		if(jQuery('#Added-Property-Section .Polaris-ButtonGroup .Polaris-Card__Header').length > 0){
			jQuery('#Added-Property-Section .Polaris-ButtonGroup .Polaris-Card__Header').remove();
		}

		var title = _this.prop('title');
		var frontTitle = _this.attr('front-title');
		_this.parent().remove();
		var addPropertyButtonHTML = `<div class="Polaris-ButtonGroup__Item"><div style="color: var(--p-action-primary);"><button front-title='${frontTitle}' title='${title}' value='${value}' class="Polaris-Button Polaris-Button--outline Polaris-Button--monochrome Added-Property-Button" type="button"><span class="Polaris-Button__Icon"><div class="button-action"><span class="Polaris-Icon remove"><svg class="minus" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M15 9H5a1 1 0 100 2h10a1 1 0 100-2z" fill="rgb(0, 128, 96)"/></svg></span><span class="Polaris-Icon drag"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M11 18c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm-2-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm6 4c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg></span><span class="Polaris-Icon check"><svg class="plus" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7 18a.997.997 0 01-.707-.293l-6-6a1 1 0 011.414-1.414l5.236 5.236 11.298-13.18a1 1 0 011.518 1.3l-12 14a1.001 1.001 0 01-.721.35H7" fill="rgb(0, 128, 96)"/></svg></span></div></span><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">${title}</span></span></button></div></div>`;
		jQuery('#Added-Property-Section .Polaris-ButtonGroup').append(addPropertyButtonHTML);
		var propertyArray = {type : 'product' , value : value,title : frontTitle};
		propertyTags.push(propertyArray);
		
		isSetup = '1';
		imageNamePreview();
		arrangeableInit();
	});

	jQuery(document).on('click','.Added-Property-Button .remove',function(){
		var _this = jQuery(this);
		var title = _this.parents('button').prop('title');
		var frontTitle = _this.parents('button').attr('front-title');
		var value = _this.parents('button').prop('value');
		_this.parents('.Polaris-ButtonGroup__Item').remove();

		if(!_this.hasClass('custom')){
			var propertyButtonHTML = `<div class="Polaris-ButtonGroup__Item"><button class="Polaris-Button Polaris-Button--outline Polaris-Button--textAlignRight Polaris-Button--fullWidth Property-Button" type="button" front-title="${frontTitle}" title="${title}" value="${value}"><span class="Polaris-Button__Icon"><div class=""><span class="Polaris-Icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M17 9h-6V3a1 1 0 00-2 0v6H3a1 1 0 000 2h6v6a1 1 0 102 0v-6h6a1 1 0 000-2z" fill="#5C5F62"/></svg></span></div></span><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">${title}</span></span></button></div>`;
			jQuery('#Property-Section .Polaris-ButtonGroup').append(propertyButtonHTML);
		}
		
		if(jQuery('#Added-Property-Section .Polaris-ButtonGroup .Polaris-ButtonGroup__Item').length == 0){
			propertyButtonHTML = `<div class="Polaris-Card__Header"><h2 class="Polaris-Heading">${NoPropertyDescription}</h2></div>`;
			jQuery('#Added-Property-Section .Polaris-ButtonGroup').append(propertyButtonHTML);
		}
		propertyTags.forEach(function(val,index){
			if(val.value == value){
				propertyTags.splice(index,1);
			}
		});
		
		if(propertyTags.length == '0')
			isSetup = '0';

		imageNamePreview();
		arrangeableInit();
	});

	jQuery(document).on('click','#custom-property',function(){
		jQuery('.Custom-Tag-Modal').modalShow();
	});

	jQuery(document).on('keyup','#custom-property-input',function(){
		var _this = jQuery(this);
		countChar(_this);
	});

	jQuery(document).on('click','.Polaris-Modal-CloseButton',function(){
		jQuery(this).parents('.Polaris-Modal-Dialog__Container').modalClose();
	})

	jQuery(document).on('click','#add-custom',function(){
		var customText = jQuery('#custom-property-input').val();
		var expr = /^[a-zA-Z0-9-_]*$/;
		if(!expr.test(customText) || customText == '' || customText == null){
			jQuery('#custom-property-input').parent().addClass('Polaris-TextField--error');
			return false;
		}
		else{
			jQuery('#custom-property-input').parent().removeClass('Polaris-TextField--error');
			if(jQuery('#Added-Property-Section .Polaris-ButtonGroup .Polaris-Card__Header').length > 0){
				jQuery('#Added-Property-Section .Polaris-ButtonGroup .Polaris-Card__Header').remove();
			}
			var addPropertyButtonHTML = `<div class="Polaris-ButtonGroup__Item"><div style="color: var(--p-action-primary);"><button title='${customText}' value='${customText}' class="Polaris-Button Polaris-Button--outline Polaris-Button--monochrome Added-Property-Button customTag" type="button"><span class="Polaris-Button__Icon"><div class="button-action"><span class="Polaris-Icon remove custom"><svg class="minus" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M15 9H5a1 1 0 100 2h10a1 1 0 100-2z" fill="rgb(0, 128, 96)"/></svg></span><span class="Polaris-Icon drag"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M11 18c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm-2-8c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0-6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm6 4c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/></svg></span><span class="Polaris-Icon check"><svg class="plus" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M7 18a.997.997 0 01-.707-.293l-6-6a1 1 0 011.414-1.414l5.236 5.236 11.298-13.18a1 1 0 011.518 1.3l-12 14a1.001 1.001 0 01-.721.35H7" fill="rgb(0, 128, 96)"/></svg></span></div></span><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">${customText}</span></span></button></div></div>`;
			jQuery('#Added-Property-Section .Polaris-ButtonGroup').append(addPropertyButtonHTML);
			var customPropertyArray = {type : 'custom' , value : customText,title : customText};
			propertyTags.push(customPropertyArray);
			imageNamePreview();
			arrangeableInit();
			jQuery('.Custom-Tag-Modal').modalClose(function(){
				jQuery('#custom-property-input').val('').trigger('keyup');
			});
			isSetup = '1';
		}
	});

	jQuery(document).on('click','#nextBtn',function(){
		imageDetailsAjax(jQuery(this),'next'); 		
	});
	jQuery(document).on('click','#previousBtn',function(){
		imageDetailsAjax(jQuery(this),'previous');
	});

	jQuery(document).on('mouseenter touchstart','.Added-Property-Button',function(){
		jQuery('#New-Image-Name').addClass('active');
		var value = jQuery(this).prop('value');
		jQuery('.preview-ele').each(function(){
			if(jQuery(this).data('value') == value){
				jQuery(this).addClass('highlight');
			}
		});
	});

	jQuery(document).on('mouseleave touchend','.Added-Property-Button',function(){
		jQuery('#New-Image-Name').removeClass('active');
		var value = jQuery(this).prop('value');
		jQuery('.preview-ele').each(function(){
			if(jQuery(this).data('value') == value){
				jQuery(this).removeClass('highlight');
			}
		});
	});

	jQuery(document).on('click','#alt-settings-save',function(){
		if(isSetup == '0'){
			 jQuery('html, body').animate({
		        scrollTop: jQuery("#Property-Section").offset().top
		    }, 1000);
			ToastShowHide(AtleastOneProMsg, 'error');
			return false;
		}

		var _this = jQuery(this);
		var dataObj = {};
		var alt_mode = 0;
		if(jQuery('[name=alt_mode]').is(':checked')) alt_mode = 1;

		dataObj.alt_auto = alt_mode;
		dataObj.rules = JSON.stringify(propertyTags);
		dataObj.action = 'PicsSaveALTRules';
		
		jQuery.ajax({
			url: PicsAjax,
			method: 'post',
			dataType: 'json',
			data: dataObj,
			beforeSend : function(){
				_this.btnLoading(true);
			},
			success: function(response){
				ToastShowHide('Settings saved successfully!', 'success');
			},
			complete:function(){
				_this.btnLoading(false);
			}
		});
	})	

	jQuery(document).on('click','#settings-save',function(){
		if(isSetup == '0'){
			 jQuery('html, body').animate({
		        scrollTop: jQuery("#Property-Section").offset().top
		    }, 1000);
			ToastShowHide(AtleastOneProMsg, 'error');
			
			return false;
		}

		var _this = jQuery(this);
		var dataObj = {};
		var auto_mode = 0;
		if(jQuery('[name=auto_mode]').is(':checked')) auto_mode = 1;
		dataObj.auto_mode = auto_mode;
		dataObj.rules = JSON.stringify(propertyTags);
		dataObj.action = 'PicsSaveRenameRules';
		
		jQuery.ajax({
			url: PicsAjax,
			method: 'post',
			dataType: 'json',
			data: dataObj,
			beforeSend : function(){
				_this.btnLoading(true);
			},
			success: function(response){
				ToastShowHide('Settings saved successfully!', 'success');
			},
			complete:function(){
				_this.btnLoading(false);
			}
		});
	})
});

function imageDetailsAjax(_this,type){
	var dataObj = {};
	dataObj.offset = _this.data('token');
	dataObj.action = 'PicsImgRename';
	
	jQuery.ajax({
		url: PicsAjax,
		method: 'post',
		dataType: 'json',
		data: dataObj,
		beforeSend : function(){
			jQuery('#preview-loader').addClass('Spinner_Show');
		},
		success: function(response){
			imageDetails = response
			
			jQuery('#Product-Title').text(response.post_title);
			jQuery('#Image-Name').text(response.image_name);
			
			if(type == 'next'){
				jQuery('#previousBtn').data('token',parseInt(_this.data('token'))-1);
				_this.data('token',parseInt(_this.data('token'))+1);
				
				jQuery('#previousBtn').removeClass('Polaris-Button--disabled').prop('disabled',false);
			}
			else{
				jQuery('#nextBtn').data('token',_this.data('token'));
				_this.data('token',parseInt(_this.data('token'))-1);
				if(_this.data('token') < 0){
					_this.addClass('Polaris-Button--disabled').prop('disabled',true);
				}
			}
			imageNamePreview();
		},
		complete:function(){
			jQuery('#preview-loader').removeClass('Spinner_Show');	
		}
	});
}

function imageNamePreview(){
	var file_name = '';
	if(propertyTags.length > 0){
		propertyTags.forEach(function(val,index){
			if(val.type == 'product'){
				
				if(imageDetails[val.value] != '' && typeof imageDetails[val.value] != 'undefined' && imageDetails[val.value] != null)
					file_name += `<span class='preview-ele' data-value='${val.value}'>${modifyString(imageDetails[val.value])}-</span>`;
			}else{
				file_name += `<span class='preview-ele' data-value='${val.value}'>${modifyString(val.value)}-</span>`;
			}
		});
		
		file_name += `<span>${imageDetails['image_id']}.${imageDetails['image_name'].substr((imageDetails['image_name'].lastIndexOf('.') +1))}</<span>`
	}else{
		file_name += AtleastOnePro;
	}

	jQuery('#New-Image-Name').html(file_name);
}

jQuery.fn.modalShow = function(modalOpened = new Function){
	var modalContainer = jQuery(this);
	jQuery(document).find('.Polaris-Backdrop').remove();
	jQuery('body').addClass('modal-drop').append('<div class="Polaris-Backdrop"></div>');
	modalContainer.css({display: 'flex'}).addClass('Polaris-Modal-Dialog--animateFadeUp Polaris-Modal-Dialog--entering');

	setTimeout(function(){

		modalContainer.addClass('Polaris-Modal-Dialog--entered');
		setTimeout(function(){
			modalContainer.removeClass('Polaris-Modal-Dialog--animateFadeUp Polaris-Modal-Dialog--entering Polaris-Modal-Dialog--entered');
			modalOpened();
		}, 200);
	}, 50);
};

jQuery.fn.modalClose = function(modalClosed = new Function){
	var modalContainer = jQuery(this);
	modalContainer.addClass('Polaris-Modal-Dialog--animateFadeUp Polaris-Modal-Dialog--exited');
	setTimeout(function(){
		jQuery('body').removeClass('modal-drop').find('.Polaris-Backdrop').remove();
		modalContainer.removeClass('Polaris-Modal-Dialog--animateFadeUp Polaris-Modal-Dialog--exited').hide();
		modalClosed();
	}, 200);
};

jQuery.fn.btnLoading = function($loading = false){
    $this = jQuery(this);
    $this[($loading === true) ? 'addClass' : 'removeClass']('Polaris-Button--disabled Polaris-Button--loading').prop('disabled', $loading);

    if($loading === true)
        $this.find('.Polaris-Button__Content').prepend('<span class="Polaris-Button__Spinner"><span class="Polaris-Spinner Polaris-Spinner--colorInkLightest Polaris-Spinner--sizeSmall"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7.229 1.173a9.25 9.25 0 1011.655 11.412 1.25 1.25 0 10-2.4-.698 6.75 6.75 0 11-8.506-8.329 1.25 1.25 0 10-.75-2.385z"></path></svg></span></span>');
    else
        $this.find('.Polaris-Button__Content .Polaris-Button__Spinner').remove();
}

function modifyString(str){
	return  (typeof str != 'undefined' && str != null) ? str.replace(/([~!@#$%^&*()+=`{}\[\]\|\\:;'<>,.\/? ])+/g, '-').replace(/^(-)+|(-)+$/g,'').toLowerCase() : '';
}

function countChar(_this) {
	var len = _this.val().length;
	if (len > 30) {
	  _this.val(_this.val().substring(0, 30));
	} else {

		var strLen = '';
		jQuery.each((0 + len).toFixed(0).split(''), function(index, value){
			strLen += parseInt([value]);
		});
	  jQuery('.Polaris-TextField__CharacterCount').text(`${strLen}/${parseInt([3])}${parseInt([0])}`);
	}
};

function arrangeableInit(){
	jQuery('#draggable .Polaris-ButtonGroup__Item').arrangeable({dragSelector: '.drag'},function(){
		propertyTags = [];
		jQuery('#Added-Property-Section .Polaris-ButtonGroup__Item').each(function(){
		    var button = jQuery(this).find('button');
		    var type = button.hasClass('customTag') ? 'custom' : 'product';
		    var propertyArray = {type : type , value : button.prop('value'),title : button.attr('front-title')};
			propertyTags.push(propertyArray);
		})
		imageNamePreview();
	});
}