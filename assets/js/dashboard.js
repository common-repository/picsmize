var dataTableLoader = true;
var isFileNameAllowed = 1;
var isAltNameAllowed,isAutoCompressAllowed,autoCompressStatus,autoFileStatus,autoAltStatus,availableQuota;
var imageList;
var autoAltStatus = overwriteALT = 0;
console.log(jQuery,'jQuery');
jQuery(document).ready(function(){

	imageList = loadImageList();
	jQuery('#search-image').donetyping(function(callback) {
		imageList.draw();
	});

	jQuery(document).on('click', 'body', function(e){
		
		if(!jQuery(e.target).parent().hasClass('action')){
			jQuery(document).find('.action').removeClass('Polaris-Popover__PopoverOverlay--open');
			jQuery('.action-tooltip').addClass('Polaris-Tooltip--measuring');
		}
	});
	
	jQuery(document).on('click', '.action', function(e){
		
		_thisAction = jQuery(this);
		var dataJSON = _thisAction.data('token');
		
		if(dataJSON != false){
			var id = dataJSON.id;
			var optimize_status = dataJSON.optimize_status;
			var type = dataJSON.type;
			var size = dataJSON.size;
			var expire = dataJSON.expire;
			var action  = optimize_status == '3' ?  `${(dataJSON.backup_url != '') ? 'restore' : ''}` : 'optimize';
			
			var label  = optimize_status == '3' ? (dataJSON.backup_url != '') ? 'Restore' : '' : 'Compress';
			console.log(dataJSON.backup_url,label);
			var button = '';
			if(label != '')
				var button = `<li><button expire=${expire} data-size=${action == 'optimize' ? size : false} data-token='${id}' action='${action}' type="button" class="Polaris-ActionList__Item ${(expire) ? 'button-muted' : ''}"><div class="Polaris-ActionList__Content"><div class="Polaris-ActionList__Text">${label}</div></div></button></li>`;
			
			if(optimize_status == '3' || optimize_status == '4' || optimize_status == '6')
				button += `<li><button data-token='${id}' action='file_rename' type="button" class="Polaris-ActionList__Item"><div class="Polaris-ActionList__Content"><div class="Polaris-ActionList__Text">File Rename</div></div></button></li>`;
			
			if(optimize_status == '3' || optimize_status == '4' || optimize_status == '6')
				button += `<li><button data-token='${id}' action='alt_rename' type="button" class="Polaris-ActionList__Item"><div class="Polaris-ActionList__Content"><div class="Polaris-ActionList__Text">ALT Change</div></div></button></li>`;
			
			var html = `<ul class="Polaris-ActionList__Actions">${button}</ul>`;
		}else{
			var html = `<ul class="Polaris-ActionList__Actions"><li><button type="button" class="Polaris-ActionList__Item button-muted"><div class="Polaris-ActionList__Content"><div class="Polaris-ActionList__Text">No Action Available</div></div></button></li></ul>`;
		}

		jQuery('.action-tooltip .Polaris-ActionList__Section--withoutTitle').html(html);

		if(jQuery(this).hasClass('Polaris-Popover__PopoverOverlay--open')){

			jQuery(document).find('.action').removeClass('Polaris-Popover__PopoverOverlay--open');
			jQuery('.action-tooltip').addClass('Polaris-Tooltip--measuring');
		}else{

			jQuery(document).find('.action').removeClass('Polaris-Popover__PopoverOverlay--open');
			jQuery(this).addClass('Polaris-Popover__PopoverOverlay--open');
			
			jQuery('.action-tooltip').removeClass('Polaris-Tooltip--measuring').css({
				left: e.pageX - (jQuery('.action-tooltip').width() + 100),
				top: e.pageY
			});
		}
	});

	jQuery(document).on('click','[action=optimize]',function(){
		var _this = jQuery(this);
		actionAjax("compress",_this);
	});

	jQuery(document).on('click','[action=alt_rename]',function(){
		var _this = jQuery(this);
		
		if(autoAltStatus == '0'){
			if(_this.attr('avail-alt') == 'true' && overwriteALT == '0'){
				var data = {};
				data.okButton = "Change Forcefully";
				data.cancelButton = "Cancel";
				data.title = "Are you sure to change ALT text?";
				data.message = "This action will overwrite your existing ALT text.";
				if(confirm(data.title)){
					actionAjax("alt-rename",_this);
				}
				/*confirm(data,function(isConfirm){
					if(isConfirm){
						actionAjax("alt-rename",_this);
					}
				});*/
			}else{
				actionAjax("alt-rename",_this);
			}
		}
	});

	jQuery(document).on('click','[action=file_rename]',function(){
		var _this = jQuery(this);
		actionAjax("file-rename",_this);
	});

	jQuery(document).on('click','[action=restore]',function(){
		var _this = jQuery(this);
		actionAjax("restore",_this);
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

	jQuery(document).on('click','.image-details',function(){
		jQuery('.Polaris-Image-Modal').modalShow();
		var modalBodyHtml = jQuery('.modal-body-structure').html();
		var dataObj ={};
		dataObj.id = jQuery(this).data('token');
		dataObj.action = 'PicsImageLogs';

		jQuery.ajax({
			url: PicsAjax,
			method: 'post',
			dataType: 'json',
			data: dataObj,
			beforeSend : function(){
				jQuery('#model-loader').addClass('Spinner_Show');
			},
			success: function(response){
				console.log(response.ext);
				var hitory_html = '';

				if(response.log.length >= 1){
					jQuery.each(response.log, function( index, value ) {
						hitory_html += `<li><div class="history-badge history-badge-dot"></div><div class="history-panel"><div class="history-heading"><div class="history-action">${value.action}</div><div class="history-timestamp">${dateTimeFormat(value.created_date)} UTC</div></div></div></li>`;
					});
				}
				
				var optimize_save = (response.optimize_status == '3') ? `${(response.optimize_save)}%` : '-';
				var newSize = (response.optimize_status == '3') ? (response.newSize)+' KB' : '-';
				modalBodyHtml =	modalBodyHtml.replace("{{IMAGE_TYPE}}", (response.type != null ? response.type.toUpperCase() : ''))
				.replace("{{FILE_TYPE}}", (response.ext != null ? response.ext.toUpperCase() : ''))
				.replace("{{ORIGINAL_SIZE}}", (response.ori_file_size != null ? response.ori_file_size+' KB' : 0))
				.replace("{{CRUSHED_SIZE}}", newSize)
				.replace("{{SAVED}}",optimize_save)
				.replace("{{ORIGINAL_FILE_NAME}}", response.type != 'manual' ? (response.old_filename != null ? response.old_filename : '-')  : (response.new_filename != null ? response.new_filename : '-'))
				.replace("{{OPTIMISED_FILE_NAME}}", response.type != 'manual' ? (response.new_filename != '' && response.new_filename != null && (response.filename_status == '2' || response.filename_status == '5') ? response.new_filename : '-') : manual_not_available)
				.replace("{{ORIGINAL_ALT_TAG}}", response.type != 'manual' && response.old_alt != null ? response.old_alt : '-')
				.replace("{{OPTIMISED_ALT_TAG}}",response.type != 'manual' ? (response.image_alt != '' && (response.alt_tag_status == '2' || response.alt_tag_status == '5') ? response.image_alt : '-') : manual_not_available)
				.replace("{{HISTORY}}", hitory_html);
				jQuery('.Polaris-Image-Modal').find('.Polaris-Modal__BodyWrapper').html(modalBodyHtml);
			},
			complete:function(){
				jQuery('#model-loader').removeClass('Spinner_Show');
			}
		});
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
})

function actionAjax(imgAction,_this){
	var token = _this.data('token');
	
	_thisAction.trigger('click');
	var actionStatus = 10;
	if(imgAction == 'compress'){
		actionStatus = 1;
		_thisAction.parents('tr').find('td:eq(4)').html(getCrushedStatusHtml(actionStatus));
	}

	if(imgAction == 'restore'){
		actionStatus = 7;
		_thisAction.parents('tr').find('td:eq(4)').html(getCrushedStatusHtml(actionStatus)).find('.Polaris-Badge__Pip--Loader').addClass('show-badge-loader');	
	}

	if(imgAction == 'file-rename'){
		actionStatus = 1;
		_thisAction.parents('tr').find('td:eq(2)').html(getRenamedStatusHtml(actionStatus));
	}

	if(imgAction == 'alt-rename'){
		actionStatus = 1;
		_thisAction.parents('tr').find('td:eq(3)').html(getRenamedStatusHtml(actionStatus));
	}
	var dataObj = {action:'PicsImgActions',Id:token,'imgAction': imgAction};
	jQuery.ajax({
		url: PicsAjax,
		method: 'post',
		dataType: 'json',
		data: dataObj,
		beforeSend : function(){
			var actionStatus = 10;
			if(imgAction == 'compress'){
				actionStatus = 2;
				_thisAction.parents('tr').find('td:eq(4)').html(getCrushedStatusHtml(actionStatus));
				_thisAction.parents('tr').find('td:eq(4)').find('.Polaris-Badge__Pip--Loader').addClass('show-badge-loader');
			}

			if(imgAction == 'file-rename'){
				actionStatus = 4;
				_thisAction.parents('tr').find('td:eq(2)').html(getRenamedStatusHtml(actionStatus));
				_thisAction.parents('tr').find('td:eq(2)').find('.Polaris-Badge__Pip--Loader').addClass('show-badge-loader');
			}

			if(imgAction == 'alt-rename'){
				actionStatus = 4;
				_thisAction.parents('tr').find('td:eq(3)').html(getRenamedStatusHtml(actionStatus));
				_thisAction.parents('tr').find('td:eq(3)').find('.Polaris-Badge__Pip--Loader').addClass('show-badge-loader');
			}

		},
		success: function(response){
			if(!response.status)
				ToastShowHide(response.message, 'error');

			if(response.status){
				ToastShowHide(response.message, 'success');
			}
		},
		complete:function(){
			dataTableLoader = false;
			imageList.draw(false);
		}
	});
}
/* GET ALL IMAGE WITH DATATABLE LOAD FUNCTION START*/
function loadImageList(){
	var table = jQuery('#image-listing').DataTable({
		serverSide: true,
		processing: false,
		autoWidth: false,
		responsive: false,
		lengthChange: false,
		bInfo : false,
		searching: false,
		order: [[ 0, "asc" ]],
		columnDefs: [
			{
				"targets": [ 0 ],
				"visible": false,
			},{
				"targets": [ 1,2,3,4,5,6 ],
				"orderable" : false
			}
		],
		pagingType: "full_numbers",
		columns: [
		{"data" : "ID"},
		{"data": "image_url",width: '5%',render:function(data,type,row){
			var expire = false;
			var expireTime = (new Date(row.expire_date).getTime());
			var rightNowTime = (new Date().getTime() + new Date().getTimezoneOffset()*60*1000);
			if(rightNowTime > expireTime)
				expire = true;

			if(row.type == 'manual')
				return `<span class="Polaris-Thumbnail Polaris-Thumbnail--sizeSmall Image-Preview"><img src="${row.image_url}" class="Polaris-Thumbnail__Image" image_type="${row.optimize_status}" file_type="${row.type}" expire="${expire}" original-image="${row.backup_url}"></span>`;
			return `<span class="Polaris-Thumbnail Polaris-Thumbnail--sizeSmall Image-Preview"><img src="${row.image_url}" class="Polaris-Thumbnail__Image" image_type="${row.optimize_status}" file_type="${row.type}" expire="${expire}" original-image="${row.backup_url}"></span>`;
		}},
		{data: 'file_name',width: '35%',render:function(data){
			return `<span class="image-url">${data}</span>`
		}},
		{data: 'filename_status',className:'text-center',width: '15%',render:function(data,type,row){
			if(row.type == 'assets' || row.type == 'manual')
				return '<span class="Polaris-Badge badge-muted">N/A</span>';
			return getRenamedStatusHtml(data,'0','file');
		}},
		{data: 'alt_tag_status',className:'text-center',width: '15%',render:function(data,type,row){
			if(row.type == 'assets' || row.type == 'manual')
				return '<span class="Polaris-Badge badge-muted">N/A</span>';
			return getRenamedStatusHtml(data,'0','alt');
		}},
		{data: 'optimize_status',className:'text-center',width: '15%',render:function(data, type,row){
			return getCrushedStatusHtml(data, row.optimize_save);
		}},
		{data : 'id',className:'text-center',width: '15%',render:function(data,type,row){
			var dataObj = {};

			dataObj.expire = false;
			if(row.expire_date != null){
				var expireTime = (new Date(row.expire_date).getTime());
				var rightNowTime = (new Date().getTime() + new Date().getTimezoneOffset()*60*1000);
				
				if(rightNowTime > expireTime)
					dataObj.expire = true;
			}

			dataObj.id = row.ID;
			dataObj.optimize_status = row.optimize_status;
			dataObj.type = row.type;
			dataObj.size = row.image_size;
			dataObj.backup_url = row.backup_url;
			
			if(row.optimize_status == '3' && row.type == 'manual')
				dataObj.backup_url = row.backup_url;

			dataStringify = JSON.stringify(dataObj);
			var html = '';
			html += '<div style="display:inline-flex;vertical-align:middle">';
			html += `<span class="Polaris-Icon image-details" data-token='${row.ID}'><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill="#000" fill-rule="evenodd" d="M19.928 9.629C17.791 4.286 13.681 1.85 9.573 2.064c-4.06.21-7.892 3.002-9.516 7.603L-.061 10l.118.333c1.624 4.601 5.455 7.393 9.516 7.603 4.108.213 8.218-2.222 10.355-7.565l.149-.371-.149-.371zM10 15a5 5 0 100-10 5 5 0 000 10z"/><circle fill="#000" cx="10" cy="10" r="3"/></svg></span>`;
			if(row.optimize_status == null || row.optimize_status == 0 || row.optimize_status == 3 || row.optimize_status == 6 || row.optimize_status == 5){
				html += `<span class="Polaris-Icon action" data-token='${dataStringify}'><svg viewBox="0 0 20 20"><path d="M10 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2zm0 2c1.103 0 2 .897 2 2s-.897 2-2 2-2-.897-2-2 .897-2 2-2zm0 6c1.103 0 2 .897 2 2s-.897 2-2 2-2-.897-2-2 .897-2 2-2z" fill="#000"/></svg></span></div>`;
			}else{
				html += `<span class="Polaris-Icon action" data-token='false'><svg viewBox="0 0 20 20"><path d="M10 6c-1.103 0-2-.897-2-2s.897-2 2-2 2 .897 2 2-.897 2-2 2zm0 2c1.103 0 2 .897 2 2s-.897 2-2 2-2-.897-2-2 .897-2 2-2zm0 6c1.103 0 2 .897 2 2s-.897 2-2 2-2-.897-2-2 .897-2 2-2z" fill="#000"/></svg></span></div>`;
			}
			return html;
		}}
		],
		ajax: {
			url: PicsAjax,
			type: 'post',
			data: function(data) {
				data.filter = filterImageList();
				data.action = "pics_history_images";
			}
		},
		preDrawCallback: function() {
			
			if(dataTableLoader)
				jQuery('#listing-loader').addClass('Spinner_Show');
		},
		drawCallback: function(settings) {
			
			if(dataTableLoader){
				jQuery('#listing-loader').removeClass('Spinner_Show');
			}
			dataTableLoader = true;
			/*jQuery('.paginate_button').not('.previous, .next, .first, .last').each(function(i, a) {
			   jQuery(a).text(numberLanguage(jQuery(a).text()));
			});*/
		}
	});
	return table;
}
/* GET ALL IMAGE WITH DATATABLE LOAD FUNCTION END*/

function filterImageList() {
	filterEle = {};
	var searchImage = jQuery('#search-image').val();
	if (searchImage != undefined && searchImage != null && searchImage != '')
		filterEle.search_image = searchImage;
	
	var imageContent = jQuery('#image-content').val();
	if (imageContent != undefined && imageContent != null && imageContent != '')
		filterEle.image_content = imageContent;

	var imageStatus = jQuery('#image-status').val();
	if (imageStatus != undefined && imageStatus != null && imageStatus != '')
		filterEle.image_status = imageStatus;
	
	return filterEle;
}

function PicsImgResize(src, size){
	return src.replace(/_(pico|icon|thumb|100x100|150x150|300x199|324x324|416x277)+\./g, '.').replace(/\.jpg|\.png|\.gif|\.jpeg/g, function(match) {
		if(size == '')
			return match;	
		return '-'+size+match;
	});
}
function getRenamedStatusHtml(status, saved = 0, type = ''){
	if(status == 1)
		return `<span class="Polaris-Badge Polaris-Badge--statusInfo"><span class="Polaris-Badge__Pip Polaris-Badge__Pip--Loader"></span>In Progress</span>`;
	else if(status == 2 || status == 5)
		return `<span class="Polaris-Badge Polaris-Badge--statusSuccess"><span class="Polaris-Badge__Pip Polaris-Badge__Pip--Loader"></span>${type == 'alt' ? 'Changed' : 'Renamed'}</span>`;
	else if(status == 3)
		return `<span class="Polaris-Badge Polaris-Badge--statusCritical"><span class="Polaris-Badge__Pip Polaris-Badge__Pip--Loader"></span>Failed</span>`;
	else if(status == 4)
		return `<span class="Polaris-Badge Polaris-Badge--statusWarning"><span class="Polaris-Badge__Pip Polaris-Badge__Pip--Loader"></span>Renaming</span>`;
	return `<span class="Polaris-Badge"><span class="Polaris-Badge__Pip Polaris-Badge__Pip--Loader"></span>${type == 'alt' ? 'Not Change' : 'Not Rename'}</span>`;
}
function getCrushedStatusHtml(status, saved = 0){
	if(status == 1)
		return `<span class="Polaris-Badge Polaris-Badge--statusInfo"><span class="Polaris-Badge__Pip Polaris-Badge__Pip--Loader"></span>Queued</span>`;
	else if(status == 2)
		return `<span class="Polaris-Badge Polaris-Badge--statusAttention"><span class="Polaris-Badge__Pip Polaris-Badge__Pip--Loader"></span>Optimizing</span>`;
	else if(status == 3)
		return `<span class="Polaris-Badge Polaris-Badge--statusSuccess"><span class="Polaris-Badge__Pip Polaris-Badge__Pip--Loader"></span><span class="optimize_save">${saved}%</span></span>`;
	else if(status == 4)
		return `<span class="Polaris-Badge Polaris-Badge--statusWarning"><span class="Polaris-Badge__Pip Polaris-Badge__Pip--Loader"></span>Already Optimized</span>`;
	else if(status == 5)
		return `<span class="Polaris-Badge Polaris-Badge--statusCritical"><span class="Polaris-Badge__Pip Polaris-Badge__Pip--Loader"></span>Failed</span>`;
	else if(status == 6)
		return `<span class="Polaris-Badge Polaris-Badge--statusWarning"><span class="Polaris-Badge__Pip Polaris-Badge__Pip--Loader"></span>Restored</span>`;
	else if(status == 7)
		return `<span class="Polaris-Badge Polaris-Badge--statusWarning"><span class="Polaris-Badge__Pip Polaris-Badge__Pip--Loader"></span>Restoring</span>`;
	else if(status == 10)
		return `<span class="Polaris-Badge Polaris-Badge--statusWarning"><span class="Polaris-Badge__Pip Polaris-Badge__Pip--Loader"></span>Restoring Images</span>`;
	return `<span class="Polaris-Badge"><span class="Polaris-Badge__Pip Polaris-Badge__Pip--Loader"></span>Not Optimized</span>`;
}
function dateTimeFormat(DateTime){
	var d = new Date(DateTime);
	var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"];
	var year = d.getFullYear();
	var month = months[d.getMonth()];
	var days = d.getDate();
	var hours  = d.getHours();
	var minutes  = `${d.getMinutes() < 10 ? '0' : ''}${d.getMinutes()}`;

	return `${days} ${month}, ${year} ${hours}:${minutes}`;
}