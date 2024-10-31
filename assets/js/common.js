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

jQuery.fn.donetyping = function(callback) {
	var _this = jQuery(this);
	var x_timer;
	_this.keyup(function() {
		clearTimeout(x_timer);
		x_timer = setTimeout(clear_timer, 1000);
	});

	function clear_timer() {
		clearTimeout(x_timer);
		callback.call(_this);
	}
};

jQuery.fn.btnLoading = function($loading = false){
	$this = jQuery(this);
	$this[($loading === true) ? 'addClass' : 'removeClass']('Polaris-Button--disabled Polaris-Button--loading').prop('disabled', $loading);

	if($loading === true)
		$this.find('.Polaris-Button__Content').prepend('<span class="Polaris-Button__Spinner"><span class="Polaris-Spinner Polaris-Spinner--colorInkLightest Polaris-Spinner--sizeSmall"><svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M7.229 1.173a9.25 9.25 0 1011.655 11.412 1.25 1.25 0 10-2.4-.698 6.75 6.75 0 11-8.506-8.329 1.25 1.25 0 10-.75-2.385z"></path></svg></span></span>');
	else
		$this.find('.Polaris-Button__Content .Polaris-Button__Spinner').remove();
	return $this;
};

jQuery(document).ready(function(){
	jQuery(document).on('click', '.Image-Preview', function(){
		var imageType = jQuery(this).find('img').attr('image_type');
		var fileType = jQuery(this).find('img').attr('file_type');
		var expire = jQuery(this).find('img').attr('expire');
		var afterImageUrl = jQuery(this).find('img').attr('src');
		
		jQuery('.Polaris-Image-Preview-Modal .img-comp-container').prev('img').attr('src', afterImageUrl);
		jQuery('.Polaris-Image-Preview-Modal .Polaris-Modal-Header__Title .Polaris-DisplayText').text(jQuery(this).parent().next().text());
		beforeImageUrl = afterImageUrl;
		jQuery('.Polaris-Image-Preview-Modal .img-comp-slider').hide();
		jQuery('.Polaris-Image-Preview-Modal .img-comp-img').addClass('not-optimized');
			
		if(imageType == 3){
			beforeImageUrl = jQuery(this).find('img').attr('original-image');
			jQuery('.Polaris-Image-Preview-Modal .img-comp-slider').show();
			jQuery('.Polaris-Image-Preview-Modal .img-comp-img').removeClass('not-optimized');
		}
		if(beforeImageUrl == '' ) beforeImageUrl = afterImageUrl;
		jQuery('.Polaris-Image-Preview-Modal .Polaris-Spinner__Container').addClass('Spinner_Show');
		if(imageType == 3){
			jQuery('.Polaris-Image-Preview-Modal .img-comp-img img').attr('src', fileType != 'manual' ? afterImageUrl : beforeImageUrl);
			jQuery('.Polaris-Image-Preview-Modal .img-comp-img.img-comp-overlay img').on('load', function(){
				jQuery('.Polaris-Image-Preview-Modal .Polaris-Spinner__Container').removeClass('Spinner_Show');
			}).attr('src', fileType != 'manual' ? beforeImageUrl : afterImageUrl);
		}else{
			jQuery('.Polaris-Image-Preview-Modal .img-comp-img img').not('.img-comp-overlay').on('load', function(){
				jQuery('.Polaris-Image-Preview-Modal .Polaris-Spinner__Container').removeClass('Spinner_Show');
			}).attr('src', afterImageUrl);
			jQuery('.Polaris-Image-Preview-Modal .img-comp-img.img-comp-overlay img').attr('src', beforeImageUrl);
		}
		jQuery('.Polaris-Image-Preview-Modal').modalShow();
	});

	jQuery('#image-content,#image-status').change(function(){
		jQuery(this).parent().find('.Polaris-Select__SelectedOption').text(jQuery(this).find('option:selected').text());
		imageList.draw();
	});

	jQuery(document).on('click','.Polaris-Modal-CloseButton,.Close',function(){
		var _this = jQuery(this);
		jQuery('.Polaris-Modal-Dialog__Container').modalClose(function(){
			if(_this.parents('.Polaris-Imgs-Modal').length == 1){
				jQuery('#image-optimize-automatic').prop('checked', false);
			}
			var loaderHTML = '<div class="Polaris-Spinner__Container Spinner_Show" id="model-loader"><div class="Polaris-Spinner__Content"><span class="Polaris-Spinner Polaris-Spinner--colorTeal Polaris-Spinner--sizeLarge"><svg viewBox="0 0 44 44" xmlns="http://www.w3.org/2000/svg"><path d="M15.542 1.487A21.507 21.507 0 00.5 22c0 11.874 9.626 21.5 21.5 21.5 9.847 0 18.364-6.675 20.809-16.072a1.5 1.5 0 00-2.904-.756C37.803 34.755 30.473 40.5 22 40.5 11.783 40.5 3.5 32.217 3.5 22c0-8.137 5.3-15.247 12.942-17.65a1.5 1.5 0 10-.9-2.863z"></path></svg></span><h2 class="Polaris-Spinner__Title">Waiting</h2></div></div>'
			jQuery('.Polaris-Image-Modal').find('.Polaris-Modal__BodyWrapper').html(loaderHTML);
		});
	});

	jQuery(document).on('click','#API-save',function(){
        var _this = jQuery(this);
        var dataObj = {};
        dataObj.api_key = jQuery('[name=pics_api_key]').val();
        dataObj.action = 'pics_authSettings';
        
        jQuery.ajax({
            url: PicsAjax,
            method: 'post',
            dataType: 'json',
            data: dataObj,
            beforeSend : function(){
                _this.btnLoading(true);
            },
            success: function(response){
            	if(response.status == 200)
                	ToastShowHide(response.message, 'success');
                else 
                	ToastShowHide(response.message, 'error');
            },
            complete:function(){
                _this.btnLoading(false);
            }
        });
    })  
});

/* Error and success message using toast */
function ToastShowHide(text,toastType) {
	var toast = '';
	if(toastType == "error") toast = "Polaris-Frame-Toast--error";
	    
	jQuery(document).find(".Polaris-Frame-Toast").removeClass('Polaris-Frame-Toast--error');

	if(jQuery(".Polaris-Frame-ToastManager").hasClass("toast-error-show1")){

	  	jQuery(".Polaris-Frame-ToastManager").removeClass("toast-error-show1").addClass("toast-error-show2");
	  	setTimeout(function(){
	    	jQuery(".Polaris-Frame-ToastManager").removeClass("toast-error-show2");
	  	}, 3000);

	} else if(jQuery(".Polaris-Frame-ToastManager").hasClass("toast-error-show2")) {

	  	jQuery(".Polaris-Frame-ToastManager").removeClass("toast-error-show2").addClass("toast-error-show1");
	  
	  	setTimeout(function(){
	    	jQuery(".Polaris-Frame-ToastManager").removeClass("toast-error-show1");
	  	}, 3000);
	} else if(!jQuery(".Polaris-Frame-ToastManager").hasClass("toast-error-show1")) {

	  	jQuery(".Polaris-Frame-ToastManager").addClass("toast-error-show1");
	  	jQuery(".Polaris-Frame-ToastManager").find(".toast_title").html(text);

	  	setTimeout(function(){
	    	jQuery(".Polaris-Frame-ToastManager").removeClass("toast-error-show1");
	  	}, 3000);
	}

	jQuery(document).find(".Polaris-Frame-Toast").addClass(toast); 
}

function GetFilename(url){
	if (url){
		var m = url.toString().match(/.*\/(.+?)\./);
		if (m && m.length > 1){return m[1];}
	}
	return "";
}

function dropFileUpload(options){
	var dropImages = [];
	jQuery(document).on('dragenter', function(event){

		event.preventDefault();
		var container = jQuery(options.element);

		options.onDragIn(container);
		if(!container.is(event.target) && container.has(event.target).length === 0)
			options.onDragOut(container);
	});

	jQuery(options.element).on('dragover', function(event) {
		event.preventDefault();
	});

	jQuery(options.element).on('drop', function(event){

		container = jQuery(this);
		event.preventDefault();
		fileAdded(event.originalEvent.dataTransfer.files);
	});

	function setFileReader(file, callback){

		var reader;
		reader = new FileReader();
		reader.onload = function(event){
			callback(event.target.result, url2filname(reader.name));
		}
		reader.name = file.name;
		reader.readAsDataURL(file);
	};

	function url2filname(url){
		return url.match(/([^\/]+)(?=\.\w+$)/)[0];
	}; 

	function fileAdded(files){
		jQuery.each(files, function(index, file){

			if(jQuery.inArray(file.type, ['image/png', 'image/jpg', 'image/jpeg', 'image/gif']) == -1){

				options.onDragOut(jQuery(options.element));
				ToastShowHide(Only_images_allowed, 'error');
				return false;
			}

			setFileReader(file, function(src, name){
				dropImages.push(file);
				options.onDrop(jQuery(options.element), src, name);
			});
		});
	};

	return {
		get: function(){
			return dropImages;
		},
		add: function(files){
			fileAdded(files);
		},
		remove: function(index){
			dropImages.splice(index, 1);
			if(!dropImages.length)
				options.onDropClear(jQuery(options.element));	
		},
		clear: function(){
			dropImages = [];
			options.onDropClear(jQuery(options.element));
		}
	}
};

function px2per(newVal, maxVal){
	return (newVal * 100) / maxVal;
}

function maxVal(val, itsmax) {
	if(val <= itsmax && val >= 0) 
		return val;
	else if (val < 0)
		return 0;
	else 
		return itsmax;
}