<?php # -*- coding: utf-8 -*-

/*
 * This file is part of the disable-register package.
 *
 * (c) Guido Scialfa <dev@guidoscialfa.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Widoz\DisableRegister;

use InvalidArgumentException;

/**
 * Class Bootstrap
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class Bootstrapper
{
    /**
     * @var string
     */
    private $pluginFilePath;

    /**
     * Bootstrap constructor
     *
     * @param string $pluginFilePath
     */
    public function __construct(string $pluginFilePath)
    {
        // TODO Must be a real path.

        $this->pluginFilePath = $pluginFilePath;
    }

    /**
     * Run Bootstrap
     *
     * @return void
     * @throws InvalidArgumentException
     */
    final public function run()
    {
        $loginPageUrl = site_url('wp-login.php');
        $pluginDirUrl = plugin_dir_url($this->pluginFilePath);

        $disableRegistration = new RegisterDisabler($loginPageUrl);
        $redirectToLoginPage = new RedirectToLoginPage($disableRegistration);
        $scriptEnqueuer = new ScriptEnqueuer($pluginDirUrl);

        add_filter('wpmu_active_signup', [$disableRegistration, 'validRegistrationStatus']);
        add_filter('site_option_registration', [$disableRegistration, 'validRegistrationStatus']);
        add_filter('shake_error_codes', [$disableRegistration, 'disableShakeErrorCodes']);
        add_filter('login_errors', [$disableRegistration, 'hideLoginErrorMessages']);
        add_filter('wp_signup_location', [$disableRegistration, 'loginPageUrl']);

        add_action('wp_loaded', [$disableRegistration, 'disableRegistration']);
        add_action('wp_enqueue_scripts', [$scriptEnqueuer, 'enqueue']);
        add_action('login_init', [$redirectToLoginPage, 'redirectToLoginPage']);
    }
}
