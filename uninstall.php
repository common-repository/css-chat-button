<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * @link       https://atakanau.blogspot.com
 * @since      1.0.0
 *
 * @package    CSS_Chat_Button
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
$upload_dir   = wp_upload_dir();
$read_dirname = 'css-chat-btn';
$filenames = array('generated.html','s.css');
$full_dirname = $upload_dir['basedir'].'/'.$read_dirname;
if( ! empty( $full_dirname ) ) {
	foreach( $filenames as $filename ){
		$full_path = $full_dirname.'/'.$filename;
		if( file_exists( $full_path ) ) {
			unlink($full_path);
		}
	}
	rmdir($full_dirname);
}

