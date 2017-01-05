<?php
/**
 * Plugin Name: Disable Register
 * Plugin URI: https://wordpress.org/plugins/disable-register
 * Description: Disable Register
 * Version: 1.0.0
 * Author: Guido Scialfa
 * Author URI: http://www.guidoscialfa.com
 * Text Domain: disable-register
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

add_filter('wpmu_active_signup', 'gs_disable_registration');
add_filter('site_option_registration', 'gs_disable_registration');

add_action('login_init', 'gs_login_redirect');

// Disable the user register option.
// @todo Save the current theme option and restore it on plugin remove.
update_option('users_can_register', 0);

// Clean resetpass action.
if (isset($_GET['key'])) {
    $action = 'login';
}

/**
 * Disable register option
 *
 * @since 1.0.0
 */
function gs_disable_registration($status)
{
    $status = 'none';

    return $status;
}

// @todo Check why the style is not enqueue in head tag
add_action('login_enqueue_scripts', function () {
    wp_enqueue_style('gs-disable-register', plugin_dir_url(__FILE__) . 'assets/css/login.css', false);
});

/**
 * Don't shake for errors
 *
 * @since 1.0.0
 */
add_filter('shake_error_codes', function () {
    return [];
});

/**
 * Disable error messages
 *
 * @since 1.0.0
 */
add_filter('login_errors', function ($errors) {
    $errors = '';

    return $errors;
});

/**
 * Set the sign up location to wp-login.php
 *
 * @since 1.0.0
 */
add_filter('wp_signup_location', function ($url) {
    $url = site_url('wp-login.php');

    return $url;
});

/**
 * Redirect to the login page if the request action is different than login or logout
 * or in case the current page is wp-signup.php
 *
 * @since 1.0.0
 */
function gs_login_redirect()
{
    global $pagenow;

    $_url = site_url('wp-login.php');

    if ('wp-signup.php' === $pagenow) {
        wp_redirect($_url);
        exit;
    } elseif (isset($_REQUEST['action']) && 'login' !== $_REQUEST['action'] && 'logout' !== $_REQUEST['action']) {
        wp_redirect(site_url('wp-login.php'));
        exit;
    }
}
