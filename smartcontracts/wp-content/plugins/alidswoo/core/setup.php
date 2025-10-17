<?php

/**
 * Setup the plugin
 */
function adsw_install() {

	require( ADSW_PATH . 'core/sql.php' );

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	foreach( adsw_sql_list() as $key ) {

		dbDelta($key);
	}

    adsw_maybe_add_columns();

    adsw_alter_ali_meta();

    adsw_alter_transact();
    adsw_delete_product_is_empty_post();

    new \adsw\adsUpgrade();
    
	update_option( 'adsw-version', ADSW_VERSION, false );

    add_rewrite_rule( '^oauth1/extension/?$','index.php?rest_oauth1=extension','top' );

    flush_rewrite_rules();

    adsw_install_options();

	if( !ADSW_ERROR )
        adsw_check_currency();
}

function adsw_alter_ali_meta() {

    global $wpdb;

    $qoo = [
        'skuOriginal' => "ALTER TABLE `{$wpdb->prefix}adsw_ali_meta` ADD `skuOriginal` LONGTEXT DEFAULT NULL;"
    ];

    $foo = [ 'skuOriginal' ];

    $result = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * 
			 FROM `information_schema`.`COLUMNS` 
			 WHERE `TABLE_SCHEMA` = '%s' AND `TABLE_NAME` = '{$wpdb->prefix}adsw_ali_meta'",
            DB_NAME
        )
    );

    $col = [];

    if( count($result) > 0 ) foreach( $result as $column ) {

        $col[] = $column->COLUMN_NAME;
    }

    $res = array_diff( $foo, $col );

    if( count($res) > 0 ) {

        foreach( $res as $column ) {

            $wpdb->query( $qoo[ $column ] );
        }
    }
}


function adsw_maybe_add_columns(){
    global $wpdb;

    $args = [
        'adsw_activities' => [
            'trouble' => "ALTER TABLE `{$wpdb->prefix}adsw_activities` ADD trouble VARCHAR(40) DEFAULT NULL"
        ]
    ];

    foreach( $args as $key => $val ) {

        $result = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT *
			 	 FROM `information_schema`.`COLUMNS`
			 	 WHERE `TABLE_SCHEMA` = '%s' AND `TABLE_NAME` = '{$wpdb->prefix}{$key}'",
                DB_NAME
            )
        );

        $col = [];
        if( count($result) > 0 ) foreach( $result as $column ) {
            $col[] = $column->COLUMN_NAME;
        }

        if( count($col) > 0 ) foreach( $val as $k => $v ) {
            if( ! in_array( $k, $col ) )
                $wpdb->query( $v );
        }
    }
}


function adsw_alter_transact() {

    global $wpdb;

    $row = $wpdb->get_var(
        $wpdb->prepare(
            "SELECT DATA_TYPE
             FROM `information_schema`.`COLUMNS`
             WHERE `TABLE_SCHEMA` = '%s' AND COLUMN_NAME = 'feedbackUrl'
             AND `TABLE_NAME` = '{$wpdb->prefix}adsw_ali_meta'",
            DB_NAME
        )
    );

    if( ! empty( $row ) && $row == 'varchar' ) {

        $charset_collate = $wpdb->get_charset_collate();
        $charset_collate = str_replace('DEFAULT', '', $charset_collate);

        $wpdb->query("ALTER TABLE `{$wpdb->prefix}adsw_ali_meta` CHANGE `feedbackUrl` `feedbackUrl` TEXT {$charset_collate} DEFAULT NULL");
        $wpdb->query("ALTER TABLE `{$wpdb->prefix}adsw_ali_meta` CHANGE `productUrl` `productUrl` TEXT {$charset_collate} DEFAULT NULL");
        $wpdb->query("ALTER TABLE `{$wpdb->prefix}adsw_ali_meta` CHANGE `storeUrl` `storeUrl` TEXT {$charset_collate} DEFAULT NULL");
    }

    $result = $wpdb->prepare(
        "SELECT * 
		 FROM `information_schema`.`COLUMNS`
	     WHERE `TABLE_SCHEMA` = '%s' AND 
            `TABLE_NAME` = '{$wpdb->prefix}adsw_ali_meta' AND 
            `COLUMN_NAME` = 'product_id'",
        DB_NAME
    );

    $row = $wpdb->get_row( $result );

    if( $row && $row->IS_NULLABLE == 'NO' ) {

        $wpdb->query(
            "ALTER TABLE `{$wpdb->prefix}adsw_ali_meta` 
			 CHANGE `product_id` `product_id` VARCHAR(20) 
			 CHARACTER SET $wpdb->charset COLLATE $wpdb->collate NULL DEFAULT NULL;"
        );
    }
}

function adsw_delete_product_is_empty_post(){

    global $wpdb;

    $wpdb->query("DELETE FROM `{$wpdb->prefix}adsw_ali_meta` WHERE post_id NOT IN ( SELECT DISTINCT ID FROM `{$wpdb->prefix}posts` WHERE ID IS NOT NULL )");
}

/**
 * Set new options default
 */
function adsw_install_options(){

	add_option( 'ads_product_tools_settings', [
		'product_panel' => 1
	] );

	add_option( 'ads_front_view_settings', [
		'baguetteBox' => 1
	] );

    add_option( 'ads_size_guide_settings', [
        'size_guide' => 1
    ] );

    $ads_setting_import = get_option( 'ads_setting_import', [] );

    if( empty( $ads_setting_import ) ) {
        add_option( 'ads_setting_import', [
            'feature_images'   => 0,
            'gallery_images'   => 0,
            'variation_images' => 0,
            'delete_images'    => 1,
        ] );
    } else {
        if( !isset( $ads_setting_import[ 'delete_images' ] ) ) {
            $ads_setting_import['delete_images'] = 1;
            update_option( 'ads_setting_import', $ads_setting_import, false );
        }
    }

	update_option( 'comments_notify', '', false );
	update_option( 'moderation_notify', '', false );
}

/**
 * Check installed plugin
 */
function adsw_installed(){

	if ( !current_user_can( 'install_plugins' ) ) return;

	if ( get_option( 'adsw-version' ) < ADSW_VERSION )
		adsw_install( );
}
add_action( 'admin_menu', 'adsw_installed' );

/**
 * When activate plugin
 */
function adsw_activate(){

	adsw_installed();

	do_action( 'adsw_activate' );
}

/**
 * When deactivate plugin
 */
function adsw_deactivate(){

	do_action( 'adsw_deactivate' );
}

/**
 * Change images type to LONGTEXT
 */
function adsw_alter_task_upload_images(){

    global $wpdb;

    $sql =  "ALTER TABLE `{$wpdb->prefix}adsw_task_upload_images` MODIFY `images` LONGTEXT";

    $wpdb->query( $sql );
}
add_action('adsw_activate', 'adsw_alter_task_upload_images');