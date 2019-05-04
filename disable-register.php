<?php
/**
 * Plugin Name: Disable Register
 * Plugin URI: https://wordpress.org/plugins/disable-register
 * Description: Disable Register
 * Version: 1.0.1
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

(function () {
    $autoloaderFile = __DIR__ . '/vendor/autoload.php';

    // Add other stuffs about php version etc...

    if (!file_exists($autoloaderFile)) {
        // TODO Show Message in admin.
    }

    require_once $autoloaderFile;

    $bootstrap = new \Widoz\DisableRegister\Bootstrapper(__FILE__);
    $bootstrap->run();
})();
