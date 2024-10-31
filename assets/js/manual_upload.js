var one_image_required = 'At least one image required';
var image_upload_success = 'All images have been uploaded successfully';
var Previous_lang = 'Previous';
var Next_lang = 'Next';
var First_lang = 'First';
var Last_lang = 'Last';
var Not_Optimized_lang = 'Not Compressed';
var Queued_lang = 'Queued';
var Optimizing_lang = 'Compressing';
var Optimized_lang = '';
var Already_Optimized = 'Already Compressed';
var Failed_lang = 'Failed';
var Download_lang = 'Download';
var Only_images_allowed = 'Only images are allowed';
var Optimize_lang = 'Compress';
var No_records_found = 'No records found';
var Upload_limit_alert = 'You can upload maximum {{NUMBER}} images at a time';
var dataTableLoader = true;
var imageList;
jQuery(document).ready(function(){
	/* DATATABLE OF IMAGES INITIALIZE START*/
	imageList = loadImageList();
	/* DATATABLE OF IMAGES INITIALIZE END*/
	jQuery('#search-image').donetyping(function(callback) {
		imageList.draw();
	});
	var dropUpload = dropFileUpload({
		element: '.Polaris-DropZone',
		onDragIn: function(element){
			element.addClass('Polaris-DropZone--isDragging');
		},
		onDragOut: function(element){
			element.removeClass('Polaris-DropZone--isDragging');
		},
		onDrop: function(element, src, name){
			element.parents('.Polaris-Card').find('.Polaris-ButtonGroup').removeClass('hide');
			element.removeClass('Polaris-DropZone--isDragging').addClass('Polaris-DropZone-FileAdded').find('.Polaris-DropZone-FileUpload .upload-pre-images').append(`<div class="upload-pre-img"><a href="javascript:void(0)" class="close-i-icon"></a><div><img src="${src}" data-index="0"></div><span>${name}</span></div>`);
		},
		onDropClear: function(element){
			element.removeClass('Polaris-DropZone--isDragging Polaris-DropZone-FileAdded').find('.Polaris-DropZone-FileUpload .upload-pre-images').empty();
			if(jQuery('.upload-pre-img').length == 0){
				element.parents('.Polaris-Card').find('.Polaris-ButtonGroup').addClass('hide');	
			}
		}
	});
	jQuery(document).on('change', '#Polaris-File-Input', function(e){
		dropUpload.add(e.target.files);
	});
	jQuery(document).on('click', '.upload-pre-img .close-i-icon', function(){
		dropUpload.remove(jQuery(this).parents('.upload-pre-img'));
		jQuery(this).parents('.upload-pre-img').remove();
	});	
	jQuery(document).on('click', '#manully_remove_all', function(){
		dropUpload.clear();
	});
	jQuery(document).on('click', '#manully_upload_all', function(){
		var formData = new FormData();
		var allManullyImages = dropUpload.get();
		if(!allManullyImages.length){
			ToastShowHide('At least one image required', 'error');
			
			return false;
		}
		jQuery.each(allManullyImages, function(index, file){
			formData.append("images[]", file);
		});
		formData.append("action", "PicsUploadManualFile");
		
		jQuery.ajax({
			url: PicsAjax,
			method: 'post',
			dataType: 'json',
			data: formData,
			processData: false,
			contentType: false,
			beforeSend : function(){
				jQuery('#DropZone-loader').addClass('Spinner_Show');
				jQuery('#manully_remove_all, #manully_upload_all').addClass('Polaris-Button--disabled').prop('disabled', true);
			},
			success: function(response){
				dropUpload.clear();
				jQuery('#csrf').val(response.token);
				imageList.draw();
				ToastShowHide('All images have been uploaded successfully', 'success');
				jQuery('#DropZone-loader').removeClass('Spinner_Show');
				jQuery('#manully_remove_all, #manully_upload_all').removeClass('Polaris-Button--disabled').prop('disabled', false);
			}
		});
	});
	jQuery(document).on('click','.optimize',function(){
		var _this = jQuery(this);
		actionAjax("compress",_this);
	});
	jQuery(document).on('click','.download',function(){
		var _this = jQuery(this);
		var href = _this.attr('href');
		window.open(PicsAjax+'?action=PicsDownloadFile&download='+href, "_self");
	});
	jQuery(".img-comp-overlay").each(function (){
		var slider = jQuery(this).parents(".img-comp-container").find(".divider"), img = jQuery(this).find("img");
		var slidef = function () {
			var e = window.event, x = img.offset().left;
			var maxWidth = jQuery(".img-comp-img").width();
			img.parent().width(px2per(maxVal(e.pageX - x, maxWidth), maxWidth) + "%");
			slider.css("left", px2per(maxVal(e.pageX - x, maxWidth), maxWidth) + "%");
		}
		// Mouse was pressed
		slider.mousedown(function (e) {
			e.preventDefault();jQuery(window).on("mousemove.slideev", this, slidef);
		});
		jQuery(window).mouseup(function (e) {
			e.preventDefault();jQuery(window).off("mousemove.slideev");
		});
		// Finger is swiping
		slider.on("touchmove", function (e) {
			e.preventDefault();
			var t = e.touches[0], x = img.offset().left;
			var maxWidth = jQuery(".img-comp-img").width();
			img.parent().width(px2per(maxVal(t.pageX - x, maxWidth), maxWidth) + "%");
			slider.css("left", px2per(maxVal(t.pageX - x, maxWidth), maxWidth) + "%");
		})
	});
})
/* GET ALL MANUAL IMAGE WITH DATATABLE LOAD FUNCTION START*/
function loadImageList(){
	var table = jQuery('#image-listing').DataTable({
		serverSide: true,
		processing: false,
		autoWidth: false,
		responsive: false,
		lengthChange: false,
		bInfo : false,
		searching: false,
		order: [[ 0, "desc" ]],
		columnDefs: [
			{
				"targets": [ 0 ],
				"visible": false,
			},{
				"targets": [ 0,1,2,3],
				"orderable" : false
			}
		],
		pagingType: "full_numbers",
		columns: [
		{"data" : "ID"},
		{"data": "image",width: '5%',render:function(data,type,row){
			return `<span class="Polaris-Thumbnail Polaris-Thumbnail--sizeSmall Image-Preview"><img src="${row.image_url}" class="Polaris-Thumbnail__Image" image_type="${row.optimize_status}" file_type="${row.type}" original-image="${row.backup_url}"></span>`;
		}},
		{data: 'file_name',width: '35%',render:function(data){
			return `<span class="image-url">${data}</span>`
		}},
		
		{data: 'optimize_status',className:'text-center',width: '15%',render:function(data, type,row){
			return getCrushedStatusHtml(data, row.optimize_save);
		}},
		{data : 'action',className:'text-center',width: '15%',render:function(data,type,row){
			var dataObj = {};
			dataObj.id = row.ID;
			dataObj.size = row.image_size;
			dataStringify = JSON.stringify(dataObj);
			var html = '';
			if(row.optimize_status == '0' ||  row.optimize_status == '5'){
				html += `<button class="Polaris-Button Polaris-Button--sizeSlim optimize" type="button" data-token='${dataStringify}'><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">${Optimize_lang}</span></span></button>`;
			}else if(row.optimize_status == '3'){
				html += `<button class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeSlim download" data-token='${dataStringify}' type="button" href="${row.ID}"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">${Download_lang}</span></span></button>`;
			}
			return html;
		}}
		],
		ajax: {
			url: PicsAjax,
			type: 'post',
			data: function(data) {
				data.filter = filterImageList();
				data.action = "PicsManualList";
			},
		},
		preDrawCallback: function() {
			if(dataTableLoader)
				jQuery('#listing-loader').addClass('Spinner_Show');
		},
		drawCallback: function(settings) {
			
			if(dataTableLoader)
				jQuery('#listing-loader').removeClass('Spinner_Show');
			dataTableLoader = true;
			jQuery('.paginate_button').not('.previous, .next, .first, .last').each(function(i, a) {
			   jQuery(a).text(jQuery(a).text());
			});
		}
	});
	return table;
}
/* GET MANUAL IMAGE WITH DATATABLE LOAD FUNCTION END*/
function filterImageList() {
	filterEle = {};
	var searchImage = jQuery('#search-image').val();
	if (searchImage != undefined && searchImage != null && searchImage != '')
		filterEle.search_image = searchImage;
	
	var imageContent = jQuery('#image-content').val();
	if (imageContent != undefined && imageContent != null && imageContent != '')
		filterEle.image_content = imageContent;
	
	return filterEle;
}
function getCrushedStatusHtml(status, saved = 0){
	if(status == 1)
		return `<span class="Polaris-Badge Polaris-Badge--statusInfo"><span class="Polaris-Badge__Pip Polaris-Badge__Pip--Loader"></span>${Queued_lang}</span>`;
	else if(status == 2)
		return `<span class="Polaris-Badge Polaris-Badge--statusAttention"><span class="Polaris-Badge__Pip Polaris-Badge__Pip--Loader"></span>${Optimizing_lang}</span>`;
	else if(status == 3)
		return `<span class="Polaris-Badge Polaris-Badge--statusSuccess"><span class="Polaris-Badge__Pip Polaris-Badge__Pip--Loader"></span><span class="optimize_save">${saved}%</span> ${Optimized_lang}</span>`;
	else if(status == 4)
		return `<span class="Polaris-Badge Polaris-Badge--statusWarning"><span class="Polaris-Badge__Pip Polaris-Badge__Pip--Loader"></span>${Already_Optimized}</span>`;
	else if(status == 5)
		return `<span class="Polaris-Badge Polaris-Badge--statusCritical"><span class="Polaris-Badge__Pip Polaris-Badge__Pip--Loader"></span>${Failed_lang}</span>`;
	else if(status == 6)
		return `<span class="Polaris-Badge Polaris-Badge--statusWarning"><span class="Polaris-Badge__Pip Polaris-Badge__Pip--Loader"></span>${Restored_lang}</span>`;
	else if(status == 7)
		return `<span class="Polaris-Badge Polaris-Badge--statusWarning"><span class="Polaris-Badge__Pip Polaris-Badge__Pip--Loader"></span>${Restoring_lang}</span>`;
	else if(status == 10)
		return `<span class="Polaris-Badge Polaris-Badge--statusWarning"><span class="Polaris-Badge__Pip Polaris-Badge__Pip--Loader"></span>${Restoring_lang}</span>`;
	return `<span class="Polaris-Badge"><span class="Polaris-Badge__Pip Polaris-Badge__Pip--Loader"></span>${Not_Optimized_lang}</span>`;
}
function actionAjax(action,_this){
	var token = _this.data('token');
	if(token == '' || typeof token == 'undefined'){
		ToastShowHide('Something went wrong!', 'error');
		
		return false;
	}
	var actionStatus = 10;
	if(action == 'optimize'){
		actionStatus = 1;
		_this.parents('tr').find('td:eq(2)').html(getCrushedStatusHtml(actionStatus));
	}
	var dataObj = {action:'PicsImgActions',Id:token.id,'imgAction': action};
	jQuery.ajax({
		url: PicsAjax,
		method: 'post',
		dataType: 'json',
		data: dataObj,
		beforeSend : function(){
			_this.btnLoading(true);
			if(action == 'optimize'){
				actionStatus = 2;
				_this.parents('tr').find('td:eq(2)').html(getCrushedStatusHtml(actionStatus));
				_this.parents('tr').find('td:eq(2)').find('.Polaris-Badge__Pip--Loader').addClass('show-badge-loader');
			}
		},
		success: function(response){
			if(!response.status){
				ToastShowHide(response.message, 'error');
			}
			if(response.status){
				ToastShowHide(response.message, 'success');
				_this.replaceWith(`<button class="Polaris-Button Polaris-Button--primary Polaris-Button--sizeSlim" type="button"><span class="Polaris-Button__Content"><span class="Polaris-Button__Text">${Download_lang}</span></span></button>`);
				
			}
		},
		complete:function(){
			_this.btnLoading();
			dataTableLoader = false;
			imageList.draw(false);
		}
	});
}