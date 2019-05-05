<?php
/**
 * Plugin Name: Disable Register
 * Plugin URI: https://wordpress.org/plugins/disable-register
 * Description: Disable Register
 * Version: 2.0.1
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

// phpcs:disable

namespace Widoz\DisableRegister;

use function class_exists;

$bootstrap = \Closure::bind(function () {
    /**
     * @param string $message
     * @param string $noticeType
     * @param array $allowedMarkup
     */
    function adminNotice($message, $noticeType, array $allowedMarkup = [])
    {
        \assert(\is_string($message) && \is_string($noticeType));
        add_action(
            'admin_notices',
            function () use ($message, $noticeType, $allowedMarkup) {
                ?>
                <div class="notice notice-<?= esc_attr($noticeType) ?>">
                    <p><?= wp_kses($message, $allowedMarkup) ?></p>
                </div>
                <?php
            }
        );
    }

    /**
     * @return bool
     */
    function autoload()
    {
        if (class_exists(Bootstrapper::class)) {
            return true;
        }
        $autoloader = plugin_dir_path(__FILE__) . '/vendor/autoload.php';
        if (!file_exists($autoloader)) {
            return false;
        }
        /** @noinspection PhpIncludeInspection */
        require_once $autoloader;
        return true;
    }

    /**
     * Compare PHP Version with our minimum.
     *
     * @return bool
     */
    function isPhpVersionCompatible()
    {
        return PHP_VERSION_ID >= 70100;
    }

    if (!isPhpVersionCompatible()) {
        adminNotice(
            sprintf(
            // Translators: %s is the PHP version of the current installation, where is the plugin is active.
                __(
                    'Disable Register require php version 7.1 at least. Your\'s is %s',
                    'disable-register'
                ),
                PHP_VERSION
            ),
            'error'
        );
        return;
    }
    if (!autoload()) {
        adminNotice(
            __(
                'No suitable autoloader found. Disable Register cannot be loaded correctly.',
                'disable-register'
            ),
            'error'
        );
        return;
    }

    $bootstrap = new Bootstrapper(__FILE__);
    $bootstrap->run();
}, null);

$bootstrap();
