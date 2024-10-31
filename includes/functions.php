<?php
add_filter( 'big_image_size_threshold', '__return_false' );
add_action( 'save_post', 'pics_auto_compress_images'  );

add_action( 'wp_ajax_pics_authSettings', 'pics_authSettings' );
add_action( 'wp_ajax_nopriv_pics_authSettings', 'pics_authSettings' );

add_action( 'wp_ajax_pics_history_images', 'pics_history_images' );
add_action( 'wp_ajax_nopriv_pics_history_images', 'pics_history_images' );

add_action( 'wp_ajax_PicsImgActions', 'PicsImgActions' );
add_action( 'wp_ajax_nopriv_PicsImgActions', 'PicsImgActions' );

add_action( 'wp_ajax_PicsImgRename', 'PicsImgRename' );
add_action( 'wp_ajax_nopriv_PicsImgRename', 'PicsImgRename' );

add_action( 'wp_ajax_PicsSaveRenameRules', 'PicsSaveRenameRules' );
add_action( 'wp_ajax_nopriv_PicsSaveRenameRules', 'PicsSaveRenameRules' );

add_action( 'wp_ajax_PicsSaveALTRules', 'PicsSaveALTRules' );
add_action( 'wp_ajax_nopriv_PicsSaveALTRules', 'PicsSaveALTRules' );

add_action( 'wp_ajax_PicsSaveCompressSettings', 'PicsSaveCompressSettings' );
add_action( 'wp_ajax_nopriv_PicsSaveCompressSettings', 'PicsSaveCompressSettings' );

add_action( 'wp_ajax_PicsImageLogs', 'PicsImageLogs' );
add_action( 'wp_ajax_nopriv_PicsImageLogs', 'PicsImageLogs' );

add_action( 'wp_ajax_PicsManualList', 'PicsManualList' );
add_action( 'wp_ajax_nopriv_PicsManualList', 'PicsManualList' );

add_action( 'wp_ajax_PicsUploadManualFile', 'PicsUploadManualFile' );
add_action( 'wp_ajax_nopriv_PicsUploadManualFile', 'PicsUploadManualFile' );

add_action( 'wp_ajax_PicsDownloadFile', 'PicsDownloadFile' );
add_action( 'wp_ajax_nopriv_PicsDownloadFile', 'PicsDownloadFile' );

require_once( ABSPATH . 'wp-admin/includes/image.php' );

if(!function_exists('pics_authSettings')){
	function pics_authSettings(){
		$response = [];
		if(isset($_POST['api_key']) && $_POST['api_key'] != ''){
			$url = 'https://api.picsmize.com/user/api/check';
			$apikey = sanitize_text_field($_POST['api_key']);
			$post = ['apikey' => $apikey];
			$is_valid = PICS_remote_call($post, $url);
			$is_valid = json_decode($is_valid,true);
			if($is_valid['status']){
				update_option('pics_api_key',$apikey);
				$response['status'] = 200;
				$response['message'] = "API key saved successfully!";
			}else{
				$response['status'] = 203;
				$response['message'] = $is_valid['message'];
			}
		}else{
			$response['status'] = 203;
			$response['message'] = 'Invalid API Key';
		}
		echo json_encode($response);
		exit;
	}
}

function PICS_remote_call($params,$url){   
	$postBody = array(
		    'method'      => 'POST',
	        'timeout'     => 60,
	        'sslverify'  => false,
	        'httpversion' => CURL_HTTP_VERSION_1_1,
		    'data_format' => 'body',
	        'redirection' => 10,
	        'httpversion' => '1.0',
	        'blocking'    => true,
	        'headers'     => ['Content-Type' => 'application/json'],
		    'body'        => isset($params) ? json_encode($params) : []
		);
    $response = wp_remote_post($url, $postBody );
    
    if ( is_wp_error( $response ) ) {
        $result = $response->get_error_message();
    } else {
        $result = $response['body'];
    }
    return $result;
}

if(!function_exists('recursive_sanitize_text_field')){
	function recursive_sanitize_text_field($array) {
	    foreach ( $array as $key => &$value ) {
	        if ( is_array( $value ) ) {
	            $value = recursive_sanitize_text_field($value);
	        }
	        else {
	            $value = sanitize_text_field( $value );
	        }
	    }

	    return $array;
	}
}

if(!function_exists('pics_history_images')){
	function pics_history_images(){
		$request = recursive_sanitize_text_field($_REQUEST);
		global $wpdb;
		
		$enabled_sizes = array( 'full' );
		$pics_image_table = $wpdb->prefix . PICS_IMAGE_TABLE;
		
		$offset = isset($_POST['start']) ? absint($_POST['start']) : 0;
		$limit = isset($_POST['length']) ? absint($_POST['length']) : 10;
	    $filter = (isset($_POST['filter']) ? $_POST['filter'] : []);
	    $filter = recursive_sanitize_text_field($filter);

	    $total_images = PicsImageFuntion::all_images_list($filter);
	    $total = count($total_images);
	    $num_of_pages = ceil($total / $limit);
	    
	    $images = PicsImageFuntion::all_images_list($filter, $offset, $limit);

		$json_data = array(
			"draw" => intval($request['draw']),
			"recordsTotal" => intval($total),
			"recordsFiltered" => intval($total),
			"data" => $images
		);

		echo json_encode($json_data);
		exit;
	}
}

if(!function_exists('picsmizeLang')){
	function picsmizeLang($str){
		return str_replace('_', ' ', $str);
	}
}

if(!function_exists('PicsImgActions')){
	function PicsImgActions($imgId = '',$imgAction = '',$is_auto = ''){
		global $wpdb;
		$pics_image_table = $wpdb->prefix . PICS_IMAGE_TABLE;

		if($imgId == '')
			$imgId = sanitize_text_field($_POST['Id']);
		if($imgAction == '')
			$imgAction = sanitize_text_field($_POST['imgAction']);
		/* image data from post table */
		$image_url = PicsImageFuntion::PicsImgHttpUrl($imgId);
		
		/* Old status for this image */
		$json_response = array();
		$logAction = '';
		
		if($image_url){
			$updated_date = date('Y-m-d H:i:s');
			$image_dir = PicsImageFuntion::PicsFullsizepath($imgId);
			$upload_dir = wp_upload_dir();
	        if(strpos($image_dir, $upload_dir['basedir']) === false) $image_dir = $upload_dir['basedir'].$image_dir;
	        
			$imgSize= filesize($image_dir);
			$published = 0;
			$post_status = get_post_status( $imgId, ARRAY_A );
			if($post_status == 'publish') $published = 1;

			$geImgtQry = $wpdb->prepare("SELECT optimize_status,backup_url FROM `$pics_image_table` WHERE image_id = %d",$imgId);
			$PicImages = $wpdb->get_results($geImgtQry,ARRAY_A);
			if(empty($PicImages)){
				$wpdb->insert($pics_image_table, array(
				    'image_id' => $imgId,
				    'image_url' => $image_url,
				    'old_image_size' => $imgSize,
				    'published' => $published,
				    'created_date' => $updated_date
				));
			}

			if($imgAction == 'compress'){
				$pics_api_key  = get_option( 'pics_api_key' );
				$picsmize = new Picsmize($pics_api_key);
				
				$response = $picsmize->fetch($image_url)
					->compress(PicsImageFuntion::picsCompressionOptions())
					->toJSON();
				
				$updated_date = date('Y-m-d H:i:s');
				
				if ($response['status'] == true) {
					$response = $response['response'];
					$imageSize = $response['output']['size'];
					$inputFile = pathinfo($response['input']['src']);
					$saveBytes = $response['input']['size'] - $response['output']['size'];

					if($saveBytes < 0)
						$saveBytes = 0;

					if($saveBytes > 0)
						$saveBytes = ($saveBytes * 100) / $response['input']['size'];

					$compressUrl = $response['output']['src'];
					$compressSave = number_format($saveBytes, 2);
					$backupUrl = '';
					if($saveBytes > 0)
						$backupUrl = PicsImageFuntion::picsRegenerateMeta($imgId,$compressUrl,$image_url);
					$updateAry = ['optimize_status' => '3',
									'backup_url' => $backupUrl,
									'optimize_save' => $compressSave,
									'updated_date' => $updated_date,
									'image_size' => $imageSize
								]; 
					$wpdb->update($pics_image_table, $updateAry , ['image_id' => $imgId]);
					
					$json_response['status']  = true;
					$json_response['message'] = 'Image Compressed Successfully!';
					$logAction = 'Compressed';
				} else {
					$wpdb->query($wpdb->prepare("UPDATE `$pics_image_table` SET optimize_status=%s,optimize_error=%s,updated_date=%s WHERE image_id=%d ",'5',$response['message'],$updated_date,$imgId));
					$json_response['status']  = false;
					$json_response['message'] = $response['message'];
				}
				
			}elseif($imgAction == 'alt-rename'){

			    $rules = PicsALTRules();

			    if(!empty( $rules )){

			    	$wpdb->query($wpdb->prepare("UPDATE `$pics_image_table` SET alt_tag_status=%s,updated_date=%s WHERE image_id=%d ",'1',$updated_date,$imgId));

			    	$postDetail = PicsmizeCommon::getSinglePostBythumbId($imgId);
			    	$altTag = '';
					foreach($rules as $value) {
						if(isset($postDetail[$value['value']]) && $value['type'] != 'custom'){
							if($postDetail[$value['value']] != '' && $postDetail[$value['value']] != null)
								$altTag .= $postDetail[$value['value']] . ' ';
						}else{
							if($value['type'] == 'custom')
								$altTag .= $value['value'] . ' ';
						}
					}
				
			    	if($altTag != ''){
						$altTag = htmlentities(trim($altTag, ' '));
						
					    $old_alt = PicsImageFuntion::picsGetPostMeta($imgId, '_wp_attachment_image_alt');
					    
					    $pics_original_alt = PicsImageFuntion::picsGetPostMeta( $postDetail['post_id'], '_pics_original_alt' );

						if ( empty( $pics_original_alt ) )
							add_post_meta( $postDetail['post_id'], '_pics_original_alt', $old_alt, true );

					    $res = false;
					    update_post_meta($imgId, '_wp_attachment_image_alt', $altTag);
					    	
				    	$wpdb->query($wpdb->prepare("UPDATE `$pics_image_table` SET alt_tag_status='%s',image_alt='%s',old_alt='%s',updated_date='%s' WHERE image_id='%d' ",'2',$altTag,$old_alt,$updated_date,$imgId));
				    	
						$json_response['status']  = true;
						$json_response['message'] = 'Image ALT change Successfully';
						$logAction = 'ALT changed';
					}else{
						$json_response['status']  = false;
						$json_response['message'] = 'Post details not found!';
						$logAction = 'ALT changed';
					}
				    
				}else{
					$json_response['status']  = false;
					$json_response['message'] = 'Settings not added for ALT Image.';
				}

			}elseif($imgAction == 'file-rename'){

			    $rules = picsRenameRules();
			    if(!empty( $rules )){

				    $res = false;
			    	$json_response = PicsImageFuntion::PicsRename($imgId,$rules);
			    	if($json_response['status'] == true) $logAction = 'File Renamed';
				}else{
					$json_response['status']  = false;
					$json_response['message'] = 'Settings not added for rename image.';
				}
			
			}elseif($imgAction == 'restore'){
				
				$wpDir = wp_upload_dir();
				$restoreUrl =  $wpDir['basedir'].$PicImages[0]['backup_url'];
				
				if($restoreUrl != '' && $PicImages[0]['backup_url'] != ''){
					$image_dir = PicsImageFuntion::PicsFullsizepath($imgId);
					$copy_path = $image_dir;
					if(strpos($copy_path, $wpDir['basedir']) === false) $copy_path = $upload_dir['basedir'].$copy_path;
					if(copy($restoreUrl, $copy_path)){
						
						PicsImageFuntion::picsUnsetMeta($imgId);
						$new_metadata = wp_generate_attachment_metadata( $imgId, $copy_path );
						
						wp_update_attachment_metadata( $imgId, $new_metadata );

						$replaceAttach = str_replace($wpDir['basedir'], '', $image_dir);
						update_attached_file( $imgId, $replaceAttach );
						
						$wpdb->query($wpdb->prepare("UPDATE $pics_image_table SET optimize_status=%s,backup_url=%s,updated_date=%s WHERE image_id=%d ",'6','',$updated_date,$imgId));
						$json_response['status']  = true;
						$json_response['message'] = 'Image Restored Successfully!';
						$logAction = 'Optimized Restore';
					}else{
						$json_response['status']  = false;
						$json_response['message'] = 'Restore image missing!';
					}
				}else{
					$json_response['status']  = false;
					$json_response['message'] = 'Image can not restore!';
				}
			}
		}else{
			$json_response['status']  = false;
			$json_response['message'] = 'Something went wrong!';
		}
		clean_post_cache( $imgId );
		if($logAction != '') PicsImageFuntion::picsLogsLock($imgId,$logAction);

		if($is_auto == ''){
			echo json_encode($json_response);
			exit;
		}
	}
}

if(!function_exists('pics_auto_compress_images')){
	function pics_auto_compress_images($post_id) {
		global $wpdb;
		$pics_image_table = $wpdb->prefix . PICS_IMAGE_TABLE;
		$attachments = get_attached_media( 'image', $post_id );
		$isAutoCompress = get_option('Pics_autoCompress');
		$isAutoAltChange = get_option('Pics_autoALT');
		$isAutoRename = get_option('Pics_autoRename');
		if(!empty($attachments)){
			foreach ($attachments as $key => $attachment) {
				$attachment_id = $attachment->ID;
				
				$geImgtQry = $wpdb->prepare("SELECT optimize_status,alt_tag_status,filename_status FROM `$pics_image_table` WHERE image_id = %d ",$attachment_id);
				$PicImages = $wpdb->get_results($geImgtQry,ARRAY_A);
				if(empty($PicImages)){
					if ($isAutoCompress == '1') PicsImgActions($attachment_id, 'compress', true);
					if ($isAutoAltChange == '1')  PicsImgActions($attachment_id, 'alt-rename' , true);
					if ($isAutoRename == '1')  PicsImgActions($attachment_id, 'file-rename' , true);
					
				}else{
					
					if($PicImages[0]['optimize_status'] == '0' && $isAutoCompress == '1')
						PicsImgActions($attachment_id, 'compress' , true);
					if($PicImages[0]['alt_tag_status'] == '0' && $isAutoAltChange == '1')
						PicsImgActions($attachment_id, 'alt-rename' , true);
					if($PicImages[0]['filename_status'] == '0' && $isAutoRename == '1')
						PicsImgActions($attachment_id, 'file-rename' , true);
				}
			}
		}
	}
}

if(!function_exists('PicsImgRename')){
	function PicsImgRename(){
		if(isset($_POST['offset'])){
			$offset = (int)$_POST['offset'];
			echo json_encode(PicsmizeCommon::getSinglePost($offset));
		}
		exit;
	}
}

if(!function_exists('PicsSaveRenameRules')){
	function PicsSaveRenameRules(){
		$rules = isset($_POST['rules']) ? $_POST['rules'] : '';
		$rules = recursive_sanitize_text_field($rules);
		$rules = json_decode(stripslashes($rules),true);
		$auto_mode = isset($_POST['auto_mode']) ? sanitize_text_field($_POST['auto_mode']) : '0';

		update_option('Pics_autoRename',$auto_mode);
		if(update_option('Pics_renameRules', json_encode($rules))){
			$response['status'] = true;
			$response['message'] = 'Settings saved Successfully!';
		}else{
			$response['status'] = false;
			$response['message'] = 'Something went wrong!';
		}
		echo json_encode($response);
		exit;
	}
}

if(!function_exists('PicsSaveALTRules')){
	function PicsSaveALTRules(){
		$rules = isset($_POST['rules']) ? $_POST['rules'] : '';
		$rules = recursive_sanitize_text_field($rules);
		$alt_auto = isset($_POST['alt_auto']) ? sanitize_text_field($_POST['alt_auto']) : 0;

		$rules = json_decode(stripslashes($rules),true);
		update_option('Pics_autoALT',$alt_auto);
		if(update_option('Pics_ALTRules', json_encode($rules))){
			$response['status'] = true;
			$response['message'] = 'Settings saved Successfully!';
		}else{
			$response['status'] = false;
			$response['message'] = 'Something went wrong!';
		}
		echo json_encode($response);
		exit;
	}
}

if(!function_exists('PicsSaveCompressSettings')){
	function PicsSaveCompressSettings(){
		$type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : 0;
		$mode = isset($_POST['mode']) ? sanitize_text_field($_POST['mode']) : 0;

		update_option('Pics_autoCompress',$mode);
		update_option('Pics_compressStyle', $type);
		$response['status'] = true;
		$response['message'] = 'Settings saved Successfully!';
		
		echo json_encode($response);
		exit;
	}
}

if(!function_exists('picsRenameRules')){
	function picsRenameRules(){
		$addedRules = get_option('Pics_renameRules');
		$rules = [];
		if($addedRules){
			$rules = json_decode($addedRules, true);
		}
		return $rules;
	}
}

if(!function_exists('PicsALTRules')){
	function PicsALTRules(){
		$addedRules = get_option('Pics_ALTRules');
		$rules = [];
		if($addedRules){
			$rules = json_decode($addedRules, true);
		}
		return $rules;
	}
}

if(!function_exists('picsCompressStyle')){
	function picsCompressStyle(){
		$compressionType = get_option('Pics_compressStyle');
		if(!$compressionType) $compressionType = 1;
		return $compressionType;
	}
}

if(!function_exists('PicsImageLogs')){
	function PicsImageLogs(){
		global $wpdb;
		$pics_image_table = $wpdb->prefix . PICS_IMAGE_TABLE;
		$pics_log_table = $wpdb->prefix . PICS_LOG_TABLE;

		$imgId = sanitize_text_field($_POST['id']);
		$query = $wpdb->prepare("SELECT p.ID,p.guid as image_url,pr.post_type as type,p.post_date,pc.filename_status,pc.alt_tag_status,pc.optimize_status,pc.optimize_save,pc.backup_url,pc.updated_date,pc.image_size,pc.old_image_size,pc.expire_date,pc.image_url as newURL,pc.old_filename,pc.old_alt FROM `$wpdb->posts` p LEFT JOIN `$wpdb->posts` pr ON p.post_parent = pr.ID LEFT JOIN `$pics_image_table` pc ON p.ID = pc.image_id
	        WHERE p.ID = '%d'",$imgId);

	    $images = $wpdb->get_results($query,ARRAY_A);
	    $data = array('log' => '');
	    if(!empty($images)){
	    	$image = $images[0];
	    	$data = $image;
		    if($image['newURL'] != ''){
		    	$data['new_filename'] = parse_url(basename($image['newURL']),PHP_URL_PATH);
		    }

		    if($image['old_filename'] == '') $data['old_filename'] = parse_url(basename($data['image_url']),PHP_URL_PATH);
		    if($image['old_filename'] != ''){
		    	$old_filename = explode('/', $image['old_filename']);
		    	$data['old_filename'] = end($old_filename);
		    	
		    }
		    
			$data['ext'] = pathinfo($image['image_url'], PATHINFO_EXTENSION); 

			if ( empty( $image['image_size'] )) {
				    	
			    $results = $wpdb->get_results($wpdb->prepare(
				    "SELECT meta_value,meta_key FROM $wpdb->postmeta
	        			WHERE meta_key = '_wp_attachment_metadata' AND post_id =%d ",$imgId), OBJECT
			    );
			    
			    if ( ! empty( $results ) ) {
			    	$data['ori_file_size'] = PicsImageFuntion::pics_image_size( $results[0]->meta_value, 'full' );
			    }
			    
		    }else{
		    	$data['newSize'] = $image['image_size'];
		    	$data['ori_file_size'] = $image['old_image_size'];
		    }
		    if ( $image['alt_tag_status'] == '2') {
		    	$data['old_alt'] = $image['old_alt'];
		    	$data['image_alt'] = get_post_meta($imgId, '_wp_attachment_image_alt');
		    }else{
		    	$data['old_alt'] = get_post_meta($imgId, '_wp_attachment_image_alt');
		    	$data['image_alt'] = '';
		    }
			if($data['newSize'] > 0) $data['newSize'] = number_format($data['newSize']/1000,2);
			if($data['ori_file_size'] > 0) $data['ori_file_size'] = number_format($data['ori_file_size']/1000,2);
			
			$data['log'] = $wpdb->get_results($wpdb->prepare("SELECT action,created_date FROM `$pics_log_table` WHERE image_id=%d ORDER BY id ASC",$imgId),ARRAY_A);
			
		}
		echo json_encode($data);exit;
	}
}

if(!function_exists('PicsUploadManualFile')){
	function PicsUploadManualFile(){
		global $wpdb;
		$pics_image_table = $wpdb->prefix . PICS_IMAGE_TABLE;

		$totalImage = count($_FILES['images']['name']);
		for($i = 0; $i < $totalImage; $i++){

			$tmpFilePath = $_FILES['images']['tmp_name'][$i];
			if($tmpFilePath != ""){
				$currentDateTime = date('Y-m-d H:i:s');
				$uniqid = uniqid() . time();
				
				$name = explode('.', $_FILES['images']['name'][$i]);
				$ext = pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);
				$filename = str_replace(' ', '-', $name[0]) . '-' . $uniqid . '.' . $ext;

				$image_url = 'adress img';

				$upload_dir = wp_upload_dir();

				if ( wp_mkdir_p( $upload_dir['path'] ) ) {
				  $newFilePath = $upload_dir['path'] . '/' . $filename;
				}
				else {
				  $newFilePath = $upload_dir['basedir'] . '/' . $filename;
				}

				if(move_uploaded_file($tmpFilePath, $newFilePath)){

					$wp_filetype = wp_check_filetype( $filename, null );

					$attachment = array(
					  'post_mime_type' => $wp_filetype['type'],
					  'post_title' => sanitize_file_name( $filename ),
					  'post_content' => '',
					  'post_status' => 'inherit'
					);

					$attach_id = wp_insert_attachment( $attachment, $newFilePath );
					
					
					$attach_data = wp_generate_attachment_metadata( $attach_id, $newFilePath );
					wp_update_attachment_metadata( $attach_id, $attach_data );

					$image_url = PicsImageFuntion::PicsImgHttpUrl($attach_id);
					$imgSize= get_headers($image_url , 1)['Content-Length'];
					$updated_date = date('Y-m-d H:i:s');
					$wpdb->insert($pics_image_table, array(
					    'image_id' => $attach_id,
					    'type' => 'manual',
					    'image_url' => $image_url,
					    'old_image_size' => $imgSize,
					    'published' => '0',
					    'created_date' => $updated_date
					));
				}
			}
		}
		exit(json_encode(['status' => true]));
	}
}

if(!function_exists('PicsDownloadFile')){
	function PicsDownloadFile(){
		$ID = $_GET['download'];
		
		$file = PicsImageFuntion::PicsFullsizepath($ID);
		
		header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename="'.basename($file).'"');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($file));
	    flush(); // Flush system output buffer
	    readfile($file);
	}
}

if(!function_exists('PicsManualList')){
	function PicsManualList(){
		$request = recursive_sanitize_text_field($_REQUEST);
		global $wpdb;
		$wpDir = wp_upload_dir();
		
		$enabled_sizes = array( 'full' );
		$pics_image_table = $wpdb->prefix . PICS_IMAGE_TABLE;
		
		$offset = isset($_POST['start']) ? absint($_POST['start']) : 0;
		$limit = isset($_POST['length']) ? absint($_POST['length']) : 10;
	    $filter = (isset($_POST['filter']) ? recursive_sanitize_text_field($_POST['filter']) : []);

	    $where = '';
	    if(isset($filter['image_content'])){
	    	$where .= " AND pc.optimize_status='".$filter['image_content']."' ";
	    }
	    if(isset($filter['search_image'])){
	        $term_slash = str_replace("\'", " ", $filter['search_image']);
	        $where .= " AND (p.guid LIKE '%" . $wpdb->esc_like($term_slash) . "%' OR p.post_title LIKE '%" . $wpdb->esc_like($term_slash) . "%' OR pc.image_url LIKE '%" . $wpdb->esc_like($term_slash) . "%')";
	    }

		$query = "SELECT p.ID,p.guid as image_url,p.post_date,pc.type,pc.filename_status,pc.alt_tag_status,pc.optimize_status,pc.optimize_save,pc.backup_url,pc.updated_date,pc.image_size,pc.expire_date,pc.image_url as newURL
		FROM $wpdb->posts p JOIN `$pics_image_table` pc ON p.ID = pc.image_id
	    WHERE p.post_type = 'attachment' AND (p.post_mime_type = 'image/jpeg' OR p.post_mime_type = 'image/gif' OR p.post_mime_type = 'image/png') AND pc.type='manual' {$where} ";
	    
	    $query .= "ORDER BY p.post_date DESC ";

	    $total_images = $wpdb->get_results($query,ARRAY_A);
	    
		$pages = '';
		$images = [];
	    if(!empty($total_images)){
		    if (!empty($limit) && $offset >= 0) {
	    	
		        $query .= " LIMIT $offset, $limit";
		    }
		   
		    $images = $wpdb->get_results($query,ARRAY_A);
		    
		    foreach ( $images as $key => $image ) {
		    	$post_id = $image['ID'];
		    	$images[$key]['image_url'] = PicsImageFuntion::PicsImgHttpUrl($post_id);
		    	$images[$key]['download_url'] = download_url($images[$key]['image_url']);
		    	if($image['backup_url'] != '' ) $images[$key]['backup_url'] = $wpDir['baseurl'].$image['backup_url'];
		    	$images[$key]['file_name'] = parse_url(basename($images[$key]['image_url']),PHP_URL_PATH);
			    if ( empty( $images[$key]['image_size'] ) ) {
			    	
				    $results = $wpdb->get_results($wpdb->prepare(
					    "SELECT meta_value,meta_key FROM `$wpdb->postmeta`
	            			WHERE (meta_key = '_wp_attachment_metadata' OR meta_key = '_wp_attached_file') AND post_id =%d ", $post_id), OBJECT
				    );
				    
				    if ( ! empty( $results ) ) {
				    	foreach ($results as $k => $value) {

				    		if($value->meta_key == '_wp_attachment_metadata')
				    			$images[$key]['image_size'] = PicsImageFuntion::pics_image_size( $value->meta_value, 'full' );

				    		if($value->meta_key == '_wp_attached_file')
				    			$images[$key]['attached_file'] = $value->meta_value;
				    	}
				    }
			    }
		    }
		}
	    
	    $total = count($total_images);
	    $num_of_pages = ceil($total / $limit);

		$json_data = array(
			"draw" => intval($request['draw']),
			"recordsTotal" => intval($total),
			"recordsFiltered" => intval($total),
			"data" => $images
		);
		echo json_encode($json_data);
		exit;
	}
}
?>