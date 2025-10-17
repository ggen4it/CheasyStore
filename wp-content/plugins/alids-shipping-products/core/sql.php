<?php

if( ! function_exists( 'sship_sql_list' ) ) {

	function sship_sql_list() {

        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        return [

/*            "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}sship_shipping (
                `id` BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
                `product_id` VARCHAR(20) NOT NULL,
                `enabled` INT(1) DEFAULT 1,
                `shipping` LONGTEXT DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY (`product_id`)
	        ) {$charset_collate};",*/

            "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}sship_shipping_list (
                `id` BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
                `enabled` INT(1) DEFAULT 1,
                `company` VARCHAR(190) NOT NULL,
                `name` VARCHAR(255) NOT NULL,
                PRIMARY KEY (`id`),
                KEY (`company`)
	        ) {$charset_collate};",
            
            "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}sship_shippings_order (
                `id` BIGINT(20) unsigned NOT NULL AUTO_INCREMENT,
                `order_id` INT(11) DEFAULT NULL,
                `shipping` LONGTEXT DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY (`order_id`)
	        ) {$charset_collate};",
    
            "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}sship_task_upload_shipping` (
	            `post_id` 	 	   BIGINT(20) UNSIGNED NOT NULL,
	            `product_id` 	   VARCHAR(20) NOT NULL,
	            `country` 	       VARCHAR(3) NOT NULL,
                `sku_id`           VARCHAR(100) NULL,
	            `data` 	 	       TEXT DEFAULT NULL,
	            `count` 	 	   SMALLINT(5) UNSIGNED DEFAULT NULL,
                `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	            KEY (`product_id`)
		    ) {$charset_collate};",
    
            "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}sship_shipping_country (
                `post_id` BIGINT(20) UNSIGNED NOT NULL,
                `product_id` VARCHAR(20) NOT NULL,
                `enabled` INT(1) DEFAULT 1,
                `apply_all_sku` INT(1) DEFAULT 0,
                `sku_id` VARCHAR(100) NULL,
                `skuAttrKey` VARCHAR(100) NULL,
                `country` VARCHAR(3) NOT NULL,
                `shipping` LONGTEXT DEFAULT NULL,
                `date_update` TIMESTAMP NOT NULL
                    DEFAULT CURRENT_TIMESTAMP
                    ON UPDATE CURRENT_TIMESTAMP,
                KEY (`product_id`)
	        ) {$charset_collate};",
        ];
	}
}

