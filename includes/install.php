<?php

/**
 * Plugin Setup (On Activation)
 * 
 * Does the initial setup,
 * stest default values for the plugin options.
 * 
 * @package Picsmize
 * @since 1.0.0
 */
function PICS_install() {
    /* Intialization */
    global $wpdb;
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    $charset_collate = $wpdb->get_charset_collate();
    
    $table_image_actions = $wpdb->prefix . PICS_IMAGE_TABLE;
    $pics_log_table = $wpdb->prefix . PICS_LOG_TABLE;

    if ($wpdb->get_var("SHOW TABLES LIKE '$table_image_actions'") != $table_image_actions) {
        $sql = "CREATE TABLE `".$table_image_actions."` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `type` varchar(100) NOT NULL,
                `product_id` varchar(255) NOT NULL,
                `status` varchar(155) NOT NULL DEFAULT '' COMMENT 'Product active status',
                `variant_id` varchar(255) NOT NULL,
                `image_id` varchar(255) NOT NULL,
                `image_alt` varchar(255) NOT NULL DEFAULT '',
                `image_url` mediumtext NOT NULL,
                `image_size` int(11) NOT NULL DEFAULT 0,
                `old_image_size` int(11) NOT NULL,
                `backup_url` longtext DEFAULT NULL,
                `optimize_status` int(11) NOT NULL DEFAULT 0 COMMENT '0: Pending, 1: Queued, 2: Optimizing, 3: Optimized, 4: Already Optimized, 5:Failed, 6: Restored',
                `optimize_save` float(10,2) NOT NULL DEFAULT 0.00,
                `optimize_error` longtext DEFAULT NULL,
                `old_filename` mediumtext DEFAULT NULL,
                `old_alt` longtext DEFAULT NULL,
                `filename_status` int(11) NOT NULL DEFAULT 0 COMMENT '0: Pending, 1: In Progress, 2 : Success, 3: Fail, 4: Renaming, 5: Rule Change',
                `filerename_error` longtext DEFAULT NULL,
                `alt_tag_status` int(11) NOT NULL DEFAULT 0 COMMENT '0: Pending, 1: In Progress, 2 : Success, 3: Fail, 4: Renaming, 5: Rule Change',
                `alt_tag_error` longtext DEFAULT NULL,
                `is_delete` int(11) NOT NULL DEFAULT 0 COMMENT '0: No, 1: Yes',
                `published` int(11) NOT NULL DEFAULT 0 COMMENT '0 : Not Published, 1 : Published',
                `expire_date` varchar(255) NOT NULL DEFAULT '',
                `created_date` datetime NOT NULL,
                `updated_date` varchar(255) NOT NULL DEFAULT '',
                PRIMARY KEY (`id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
        dbDelta($sql);
    }

    if ($wpdb->get_var("SHOW TABLES LIKE '$pics_log_table'") != $pics_log_table) {
        $sql = "CREATE TABLE `{$pics_log_table}` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `image_id` int(11) NOT NULL,
                `action` varchar(255) NOT NULL,
                `created_date` datetime NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET={$charset_collate};";
        $wpdb->query($sql);
    }
}

function PICS_uninstall(){
   
}
?>