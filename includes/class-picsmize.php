<?php

if (!defined('ABSPATH'))
    exit;

if ( !class_exists( 'PicsmizeCommon' ) ) {
	class PicsmizeCommon {
		/*protected static $crush_all_process;*/

	    public function __construct() {
	        
	    }

	    public static function getSinglePost($offset = 0){
			global $wpdb;
			
			$enabled_sizes = array( 'full' );
	        $post_qry = ("SELECT post.ID as post_id, post.post_title, post.post_date, post.post_author, post.post_name as slug,thumb.ID as image_id,
	                thumb.guid as image_name FROM $wpdb->posts as post JOIN $wpdb->posts AS thumb ON thumb.post_parent = post.ID WHERE thumb.post_status = 'inherit' AND thumb.post_type='attachment' ORDER BY post.post_date DESC LIMIT {$offset},1");
			
			$images = $wpdb->get_results($post_qry,ARRAY_A);
			$imageDetails = array();
			if(!empty($images)){
				$imageDetails = $images[0];
				$imageDetails['image_name'] = basename($imageDetails['image_name']);
				$imageDetails['image_alt'] = update_post_meta($imageDetails['image_id'], '_wp_attachment_image_alt', true);
				$imageDetails['author'] = get_the_author_meta('display_name', $imageDetails['post_author']);
				$category_detail = get_the_category( $imageDetails['post_id'] );//$post->ID
				$imageDetails['category'] = $category_detail[0]->cat_name;
				
			}

			return $imageDetails;
		}

		public static function getSinglePostBythumbId($thumb_id){
			global $wpdb;
			$post_id = $wpdb->get_results("SELECT post_parent FROM $wpdb->posts WHERE ID='{$thumb_id}' ");

			$post_id = $post_id[0]->post_parent;

			$enabled_sizes = array( 'full' );
			$post_qry = (" SELECT  p.ID  as post_id,   
	                      p.post_title, 
	                      p.post_date,
	                      p.post_name as slug,
	                      p.post_author,
	                      p.post_content
	                FROM $wpdb->posts as p
	                WHERE p.ID='{$post_id}'
	            ");
			
			$images = $wpdb->get_results($post_qry,ARRAY_A);
			
			$imageDetails = array();
			if(!empty($images)){
				$imageDetails = $images[0];
				$imageDetails['author'] = get_the_author_meta('display_name', $imageDetails['post_author']);
				$category_detail = get_the_category( $imageDetails['post_id'] );
				$imageDetails['category'] = $category_detail[0]->cat_name;
				
			}
			$imageDetails['image_alt'] = PicsImageFuntion::picsGetPostMeta($thumb_id, '_wp_attachment_image_alt');

			return $imageDetails;
		}
	}
}