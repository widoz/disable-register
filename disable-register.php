<?php
/*
 * Plugin Name: Disable Register
 * Plugin URI: https://github.com/widoz/disable-register
 * Description: Disable Register
 * Version: 0.0.2
 * Author: Guido Scialfa
 * Author URI: http://www.guidoscialfa.com
 * License: GPL2
 *
 * Copyright (C) 2015  Guido Scialfa
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

// Disable the user register option
update_option( 'users_can_register', true ); // @todo Need a check

// Disable site register option
add_filter( 'wpmu_active_signup', function( $active_signup ) {
	$active_signup = 'none';
	return $active_signup;
} );

// Clean resetpass action
if ( isset( $_GET['key'] ) ) {
	$action = 'login';
}

// @todo Check why the style is not enqueue in head tag
add_action( 'login_enqueue_scripts', function () {
	wp_enqueue_style( 'gs-disable-register', plugin_dir_url( __FILE__ ) . 'assets/css/login.css', false );
} );

// Don't shake for errors
add_filter( 'shake_error_codes', function () {
	return array();
} );

// Disable error messages
add_filter( 'login_errors', function ( $errors ) {
	$errors = '';
	return $errors;
} );

// Disable password reset
add_action( 'allow_password_reset', function ( $allow ) {
	$allow = false;
	return $allow;
} );

function gs_login_redirect() {
	// Redirect non login actions to 404
	if ( isset( $_REQUEST['action'] ) &&
	     'login' !== $_REQUEST['action'] &&
	     'logout' !== $_REQUEST['action'] ) {
		wp_redirect( site_url( 'wp-login.php' ) );
	}
}
add_action( 'login_init', 'gs_login_redirect' );
add_filter( 'wp_signup_location', 'gs_login_redirect' );

// Redirect non login actions to 404
function gs_404_redirect( $redirect = '' ) {
	global $wp_query;

	$wp_query->set_404();
	status_header( 404 );

	get_template_part( '404' );

	exit();
}

// Just in case
add_action( 'lostpassword_post', 'gs_404_redirect' );
// Redirect for signup form in multisite
add_action( 'before_signup_form', 'gs_404_redirect' );