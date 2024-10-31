<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package Picsmize
 * @since 1.0
 */
if (!defined('ABSPATH'))
    exit;

class PicsImageFuntion {
	
    public function __construct() {
        
    }

    public static function all_images_count( $enabled_sizes, $sql ) {
		global $wpdb;
		$images_count = 0;

		$images = $wpdb->get_results( $sql );
		if ( ! empty( $images ) ) {
			foreach ( $images as $image ) {
				$attachment_id = $image->post_id;
				if ( ! empty( $image->meta_value ) ) {
					$data = unserialize( $image->meta_value );
					if ( ! empty( $attachment_id ) && ! empty( $data ) ) {
						$images_count++;
						if ( $enabled_sizes && ! empty( $data['sizes'] ) ) {
							foreach ( $data['sizes'] as $key => $size ) {
								if ( in_array( $key, $enabled_sizes ) ) {
									$images_count++;
								}
							}
						}
					}
				}
			}
		}
		return $images_count;
	}

	public static function all_images_list($search_term = array(), $offest = 0, $limit = 0) {
        global $wpdb;
        $wpDir = wp_upload_dir();
        $pics_image_table = $wpdb->prefix . PICS_IMAGE_TABLE;
        $extraJoin = '';
        if(!empty($search_term) && (isset($search_term['image_content']) || isset($search_term['image_status']))){
        	$extraJoin = " JOIN `$wpdb->posts` pr ON p.post_parent = pr.ID ";
        }
    	$query = "SELECT p.ID,p.guid as image_url,p.post_date,pc.type,pc.filename_status,pc.alt_tag_status,pc.optimize_status,pc.optimize_save,pc.backup_url,pc.updated_date,pc.image_size,pc.expire_date,pc.image_url as newURL,pc.backup_url
    	FROM $wpdb->posts p {$extraJoin} LEFT JOIN `$pics_image_table` pc ON p.ID = pc.image_id
        WHERE p.post_type = 'attachment' AND
            p.post_status = 'inherit' AND (p.post_mime_type = 'image/jpeg' OR p.post_mime_type = 'image/png' or p.post_mime_type = 'image/webp') AND (pc.type != 'manual' OR pc.type IS NULL ) ";
        
        if (!empty($search_term)) {
        	if(isset($search_term['search_image'])){
	            $term_slash = str_replace("\'", " ", $search_term['search_image']);
	            $query .= " and (p.guid LIKE '%" . $wpdb->esc_like($term_slash) . "%' OR p.post_title LIKE '%" . $wpdb->esc_like($term_slash) . "%')";
	        }
	        if(isset($search_term['image_content'])){
	        	$query .= " AND pr.post_type='".$search_term['image_content']."' ";
	        }
	        if(isset($search_term['image_status'])){
	        	$query .= " AND pr.post_status='".$search_term['image_status']."' ";
	        }
        }
        $order = "ORDER BY p.post_date DESC ";

        $pages = '';
        if (!empty($limit) && $offest >= 0) {
            $pages = "LIMIT $offest, $limit";
        }
        $sql = $query . $order . $pages;
       	
	    $images = $wpdb->get_results($sql,ARRAY_A);

	    if($limit > 0){
		    foreach ( $images as $key => $image ) {
		    	$post_id = $image['ID'];
		    	
		    	if($image['backup_url'] != '' ) $images[$key]['backup_url'] = $wpDir['baseurl'].$image['backup_url'];
		    	$images[$key]['image_url'] = self::PicsImgHttpUrl($post_id);
		    	
		    	$images[$key]['file_name'] = parse_url(basename($images[$key]['image_url']),PHP_URL_PATH);
			    if ( empty( $images[$key]['image_size'] ) ) {
			    	
				    $results = $wpdb->get_results(
					    "SELECT meta_value,meta_key FROM $wpdb->postmeta
	            			WHERE (meta_key = '_wp_attachment_metadata' OR meta_key = '_wp_attached_file') AND post_id ={$post_id} ", OBJECT
				    );

				    
				    if ( ! empty( $results ) ) {
				    	foreach ($results as $k => $value) {

				    		if($value->meta_key == '_wp_attachment_metadata')
				    			$images[$key]['image_size'] = self::pics_image_size( $value->meta_value, 'full' );

				    		if($value->meta_key == '_wp_attached_file')
				    			$images[$key]['attached_file'] = $value->meta_value;
				    	}
				    }
			    }
		    }
		}

        return $images;
    }

    public static function picsAnalytics() {
        global $wpdb;
        $wpDir = wp_upload_dir();
        $pics_image_table = $wpdb->prefix . PICS_IMAGE_TABLE;

    	$sql = "SELECT p.ID,pc.filename_status,pc.alt_tag_status,pc.optimize_status,pr.post_type
    	FROM $wpdb->posts p JOIN `{$wpdb->posts}` pr ON p.post_parent = pr.ID LEFT JOIN `$pics_image_table` pc ON p.ID = pc.image_id
        WHERE p.post_type = 'attachment' AND
            p.post_status = 'inherit' AND (p.post_mime_type = 'image/jpeg' OR p.post_mime_type = 'image/webp' OR p.post_mime_type = 'image/png')";
	    $images = $wpdb->get_results($sql,ARRAY_A);
	    
	    $total_products = $total_assets = $productCompressed = $assetsCompressed = $productRestored = $assetsRestored = $renamed = $altChanged = 0;
	    if(!empty($images)){

		    foreach ( $images as $key => $image ) {
		    	if($image['post_type'] == 'product'){
		    		$total_products++;
		    		if($image['optimize_status'] == '3') $productCompressed++;
		    		if($image['optimize_status'] == '6') $productRestored++;
		    	}else{
		    		$total_assets++;
		    		if($image['optimize_status'] == '3') $assetsCompressed++;
		    		if($image['optimize_status'] == '6') $assetsRestored++;
		    	}
		    	if($image['filename_status'] == '2') $renamed++;
		    	if($image['alt_tag_status'] == '2') $altChanged++;
		    }
		}
		$json['total'] = count($images);
		$json['products'] = $total_products;
		$json['assets'] = $total_assets;
		$json['productCompressed'] = $productCompressed;
		$json['assetsCompressed'] = $assetsCompressed;
		$json['productRestored'] = $productRestored;
		$json['assetsRestored'] = $assetsRestored;
		$json['renamed'] = $renamed;
		$json['altChanged'] = $altChanged;
        return $json;
    }

    /**
    	Get image size 
	 * @param $results
	 * @param $size
	 *
	 * @return false|int
	 */
	public static function pics_image_size( $results, $size ) {
		$image_details['size'] = '';
		$image_with_size       = $results;
		if ( ! empty( $image_with_size->meta_value ) ) {
			$data = unserialize( $image_with_size->meta_value );
			if ( ! empty( $data ) ) {
				$upload_dir = wp_upload_dir();

				/*full image path*/
				$full_image_path = $upload_dir['basedir'] . '/' . $data['file'];

				if ( $size == 'full' ) {
					$image_details['size'] = filesize( $full_image_path );
				} else {
					if ( ! empty( $data['sizes'] ) ) {

						$full_image_name = basename( $full_image_path );
						/*general dir*/
						$base_dir_path = str_replace( $full_image_name, '', $full_image_path );

						$sized_file_path       = $data['sizes'][$size]['file'] ? $base_dir_path . $data['sizes'][$size]['file'] : '';
						$image_details['size'] = filesize( $sized_file_path );
					}
				}
				return $image_details['size'];
			}
		}
	}

	public static function PicsRename($imgId,$rules){
		global $wpdb;
		$pics_image_table = $wpdb->prefix . PICS_IMAGE_TABLE;
		$json_response = array();
		$postDetail = PicsmizeCommon::getSinglePostBythumbId($imgId);
    	$renameTag = '';
    	$post_content = '';
    	if(!empty($postDetail)){
			$post_content = $postDetail['post_content'];
		}
		foreach($rules as $value) {
			if(isset($postDetail[$value['value']]) && $value['type'] != 'custom'){
				if($postDetail[$value['value']] != '' && $postDetail[$value['value']] != null)
					$renameTag .= $postDetail[$value['value']] . '-';
			}else{
				if($value['type'] == 'custom')
					$renameTag .= $value['value'] . '-';
			}
		}
		if($renameTag != ''){
			$renameTag .= $imgId;

			$renameTag = self::PicsCleanUrl(strtolower($renameTag));
		    $file = self::picsStripSlash(self::PicsFullsizepath($imgId));

		    $oldpath = pathinfo($file);
		   	$oldDir = isset( $oldpath['dirname'] ) ? $oldpath['dirname'] : null;
		   	$old_ext = isset( $oldpath['extension'] ) ? $oldpath['extension'] : null;
		    $old_filename = $oldpath['filename'].'.'.$old_ext;
		    /*create new file name */
		    $newfile = self::picsStripSlash($oldDir."/".$renameTag.".".$old_ext);
		    $newfile_name = basename($newfile);
		    $noext_old_filename = str_replace( '.' . $old_ext, '', $old_filename ); // Old filename without extension
			$noext_new_filename = str_replace( '.' . $old_ext, '', $newfile_name ); 
		    /*keep original file name */
		    $original_filename = get_post_meta( $postDetail['post_id'], '_pics_original_filename', true );
			if ( empty( $original_filename ) )
				add_post_meta( $postDetail['post_id'], '_pics_original_filename', $old_filename, true );
			/*get meta for all media size */
		    $meta = wp_get_attachment_metadata( $imgId );
		    
			$meta_old_filename = $meta['original_image'];
			$meta_old_filepath = trailingslashit( $oldDir ) . $old_filename;
			$meta['original_image'] = $newfile_name;
			$post = get_post( $imgId, ARRAY_A );
		   
		    $wpDir = wp_upload_dir();

		    if(strpos($meta_old_filepath, $wpDir['basedir']) === false) $meta_old_filepath = $wpDir['basedir'].$meta_old_filepath;
		    if(strpos($newfile, $wpDir['basedir']) === false) $newfile = $wpDir['basedir'].$newfile;

			if(rename($meta_old_filepath, $newfile)){
				/*update content if have image name */
				
				if(strpos($post_content, $old_filename) !== false){
					$post_content = str_replace($old_filename, $newfile_name, $post_content);
					
					$postData = array(
			            'ID' => $postDetail['post_id'],
			            'post_content' => $post_content
			        );
			        wp_update_post($postData, true);
				}
				if ( $meta ) {
					if ( isset( $meta['file'] ) && !empty( $meta['file'] ) )
						$meta['file'] = str_replace( $noext_old_filename, $noext_new_filename, $meta['file'] );
					
					if ( isset( $meta['url'] ) && !empty( $meta['url'] ) && strlen( $meta['url'] ) > 4 )
						$meta['url'] = str_replace( $noext_old_filename, $noext_new_filename, $meta['url'] );
					else
						$meta['url'] = '';//$noext_new_filename . '.' . $old_ext;

					if(isset($meta['sizes'])){
						$is_scaled_image = isset( $meta['original_image'] ) && !empty( $meta['original_image'] );
						if($is_scaled_image){
							$noext_new_filename = preg_replace( '/\-scaled$/', '', $noext_new_filename );
							$noext_old_filename = preg_replace( '/\-scaled$/', '', $noext_old_filename );
						}

						$already_exist = array();
						$orig_image_urls = array();
						$orig_image_data = wp_get_attachment_image_src( $imgId, 'full' );
						$orig_image_urls['full'] = $orig_image_data[0];

						foreach ( $meta['sizes'] as $size => $meta_size ) {
							if ( !isset($meta_size['file'] ) || in_array( $size, $already_exist ) ) {
								continue;
							}
							$meta_old_filename = $meta_size['file'];
							$meta_old_filepath = trailingslashit( $oldDir ) . $meta_old_filename;
							$meta_new_filename = str_replace( $noext_old_filename, $noext_new_filename, $meta_old_filename );
							$meta_new_filepath = trailingslashit( $oldDir ) .$meta_new_filename;
							
							$orig_image_data = wp_get_attachment_image_src( $imgId, $size );
							$orig_image_urls[$size] = $orig_image_data[0];

							if(strpos($meta_old_filepath, $wpDir['basedir']) === false) $meta_old_filepath = $wpDir['basedir'].$meta_old_filepath;
		    				if(strpos($meta_new_filepath, $wpDir['basedir']) === false) $meta_new_filepath = $wpDir['basedir'].$meta_new_filepath;
							
							if(!is_writable( $meta_old_filepath )) chmod( $meta_old_filepath ,0755);
							if ( file_exists( $meta_old_filepath ) && !file_exists( $meta_new_filepath )) {
								
								if(rename($meta_old_filepath,$meta_new_filepath)){
									$meta['sizes'][$size]['file'] =  $meta_new_filename;
								}
							}
							array_push( $already_exist, $size );
						}
						
						if ( $meta ){
							wp_update_attachment_metadata( $imgId, $meta );
							$new_url = str_replace(basename($orig_image_urls['full']), $newfile_name, $orig_image_urls['full']);
							do_action( 'mfrh_url_renamed', $post, $orig_image_urls['full'], $new_url );
							
							if ( !empty( $meta['sizes'] ) ) {
								foreach ( $meta['sizes'] as $size => $meta_size ) {
									$orig_image_url = $orig_image_urls[$size];
									$new_image_data = wp_get_attachment_image_src( $id, $size );
									$new_image_url = $new_image_data[0];
									$new_url = str_replace(basename($orig_image_url), $newfile_name, $orig_image_url);
									
									do_action( 'mfrh_url_renamed', $post, $orig_image_url, $new_url );
								}
							}
						}
					}
				}
				
				update_attached_file( $imgId, $meta['file'] );
				
				clean_post_cache( $imgId );
				$oldFile = $getResponse['old_path'];
	    		$newFile = $getResponse['new_file'];
	    		$updated_date = date('Y-m-d H:i:s');
	    		
	    		$wpdb->query($wpdb->prepare("UPDATE $pics_image_table SET filename_status='2',image_url='{$newfile}',old_filename='{$meta_old_filepath}',updated_date='{$updated_date}' WHERE image_id={$imgId} "));
				$json_response['status']  = true;
				$json_response['message'] = 'Image Rename Successfully';
			}else{
				
				$json_response['status']  = false;
				$json_response['message'] = 'Something went wrong!';
			}
		}else{
			$json_response['status']  = false;
			$json_response['message'] = 'Meta not found for this image!';
		}
		return $json_response;
	}

	public function PicsCleanUrl($url){
		
		$url = str_replace( ".jpg", "", $url );
		$url = str_replace( ".jpeg", "", $url );
		$url = str_replace( ".png", "", $url );
		
		// Related to English
		$url = str_replace( "'s", "", $url );
		$url = str_replace( "n\'t", "nt", $url );
		$url = preg_replace( "/\'m/i", "-am", $url );

		// We probably do not want those neither
		$url = str_replace( "'", "-", $url );
		$url = preg_replace( "/\//s", "-", $url );
		$url = str_replace( ['.','…'], "", $url );
		$url = preg_replace( "/&amp;/s", "-", $url );
		/*$url = str_replace("\\", '/', $url);*/
		return sanitize_file_name(htmlentities(trim($url, '-')));
	}

	public function PicsFullsizepath($imgId){
		if ( function_exists( 'wp_get_original_image_path' ) ) {
			$fullsizepath = wp_get_original_image_path( $imgId );
		} else {
			$fullsizepath = get_attached_file( $imgId );
		}
		return $fullsizepath;
	}

	public function PicsImgHttpUrl($post_id){
		return wp_get_attachment_url( $post_id );
	}

	public function picsUnsetMeta($imgId){
		$meta = wp_get_attachment_metadata( $imgId );
		
		foreach ( $meta['sizes'] as $size => $meta_size ) {
			$meta_old_filepath = trailingslashit( $oldDir ) . $meta_size['file'];
			if(file_exists($meta_old_filepath))
				unlink($meta_old_filepath);
		}
	}

	public static function picsImageBackup($compressed_image_url = '', $imgId = '', $backup = false) {
        $backup_imaged_path = '';
        $path = self::PicsFullsizepath($imgId);
       	
        if (!empty($compressed_image_url) && !empty($path)) {
            $upload_dir = wp_upload_dir();
            if(strpos($path, $upload_dir['basedir']) === false) $path = $upload_dir['basedir'].$path;
            
            $compressed_image_data = '';
            $response = wp_remote_get($compressed_image_url);
      
            if (is_array($response) && !is_wp_error($response)) {
                $compressed_image_data = wp_remote_retrieve_body($response);
            }  
            
            if ($backup) {
            	
                $filename = basename($path);
                if (mkdir($upload_dir['basedir'] . '/pics-restore/',0755)) {
                    $file = $upload_dir['basedir'] . '/pics-restore/' . $filename;
                } else {
                    $file = $upload_dir['basedir'] . '/pics-restore/' . $filename;
                }
                if(!is_writable( $file )) chmod( $file ,0755);
                if(!is_writable( $path )) chmod( $path ,0755);
                
                if(copy($path, $file)){
                	$backup_imaged_path = '/pics-restore/' . $filename;
                }
                file_put_contents($path, $compressed_image_data);
            } else {
                unlink($path);
                file_put_contents($path, $compressed_image_data);
            }
        }
        
        return $backup_imaged_path;
    } 

	public function picsRegenerateMeta($imgId, $newUrl, $old_img_url){
		$image_dir = self::PicsFullsizepath($imgId);
		$backupUrl = self::picsImageBackup($newUrl,$imgId,true);
		
		self::picsUnsetMeta($imgId);
		$upload_dir = wp_upload_dir();
        if(strpos($image_dir, $upload_dir['basedir']) === false) $image_dir = $upload_dir['basedir'].$image_dir;
		$newMeta = wp_generate_attachment_metadata( $imgId, $image_dir );
		wp_update_attachment_metadata( $imgId, $newMeta);
		
		$replaceAttach = str_replace($wpDir['basedir'], '', $image_dir);
		update_attached_file( $imgId, $replaceAttach );
		return $backupUrl;
	}

	public function picsStripSlash( $url ){
		return str_replace("\\", '/', $url);
	}

	public function picsCompressionOptions(){
		$options = [];
		$compressionType = picsCompressStyle();
		if($compressionType == '1' || $compressionType == ''){
			$options['compress']['level'] = 'low';
		}elseif($compressionType == '2'){
			$options['compress']['level'] = 'medium';
		}elseif($compressionType == '3'){
			$options['compress']['level'] = 'high';
		}
		return $options;
	}

	public function picsLogsLock($postId, $action){
		global $wpdb;
		$pics_log_table = $wpdb->prefix . PICS_LOG_TABLE;
		$created_date = date('Y-m-d H:i:s');
		$wpdb->query($wpdb->prepare("INSERT INTO $pics_log_table (image_id,action,created_date) VALUES ('{$postId}','{$action}','{$created_date}')"));
	}

	public function picsGetPostMeta($post_id,$key){
		global $wpdb;
		
		$results = $wpdb->get_results(
			    "SELECT meta_value FROM $wpdb->postmeta WHERE meta_key = '{$key}' AND post_id ={$post_id} ", ARRAY_A
		    );
		return (!empty($results) ? $results[0]['meta_value'] : '');
	}

}