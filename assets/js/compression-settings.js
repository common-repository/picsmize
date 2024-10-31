jQuery(document).ready(function(){
    jQuery(document).on('click','#settings-save',function(){
        var _this = jQuery(this);
        var dataObj = {};
        var compression_mode = 0;
        if(jQuery('[name=compression_mode]').is(':checked')) compression_mode = 1;
        dataObj.type = jQuery('[name=compression_type]:checked').val();
        dataObj.mode = compression_mode;
        dataObj.action = 'PicsSaveCompressSettings';
        
        jQuery.ajax({
            url: PicsAjax,
            method: 'post',
            dataType: 'json',
            data: dataObj,
            beforeSend : function(){
                _this.btnLoading(true);
            },
            success: function(response){
                ToastShowHide(response.message, 'success');
            },
            complete:function(){
                _this.btnLoading(false);
            }
        });
    });
});