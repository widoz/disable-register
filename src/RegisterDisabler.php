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
 * Class DisableRegistration
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class RegisterDisabler
{
    const REGISTRATION_STATUS = 'none';
    const VALID_LOGIN_ACTION = 'login';
    const VALID_ACTIONS = [
        'login',
        'logout',
        'postpass',
    ];

    /**
     * @var string
     */
    private $loginPageUrl;

    /**
     * DisableRegistration constructor
     * @param string $loginPageUrl
     * @throws InvalidArgumentException
     */
    final public function __construct(string $loginPageUrl)
    {
        $loginPageUrl = filter_var($loginPageUrl, FILTER_VALIDATE_URL);
        if (!$loginPageUrl) {
            throw new InvalidArgumentException('Require a valid url.');
        }

        $this->loginPageUrl = $loginPageUrl;
    }

    /**
     * Retrieve Valid Registration Status
     *
     * @return string Always 'none'
     */
    final public function validRegistrationStatus(): string
    {
        return self::REGISTRATION_STATUS;
    }

    /**
     * Retrieve Valid Action
     *
     * @return string
     */
    final public function validAction(): string
    {
        return self::VALID_LOGIN_ACTION;
    }

    /**
     * Disable Shake Error Codes
     *
     * @return array
     */
    final public function disableShakeErrorCodes(): array
    {
        return [];
    }

    /**
     * Hide Login Error Messages
     *
     * @return string
     */
    final public function hideLoginErrorMessages(): string
    {
        return '';
    }

    /**
     * Login Page Url
     *
     * @return string
     */
    final public function loginPageUrl(): string
    {
        return $this->loginPageUrl;
    }

    /**
     * Maybe Redirect to Login Page if Invalid Request
     *
     * @param string $currentPage
     * @param string $action
     *
     * @return void
     */
    final public function maybeRedirectToLoginPage(string $currentPage, string $action)
    {
        if (!$currentPage || !$action) {
            return;
        }

        if ('wp-signup.php' === $currentPage || !in_array($action, self::VALID_ACTIONS, true)) {
            wp_redirect($this->loginPageUrl);
            $this->doExit();
        }
    }

    /**
     * Disable Registration
     *
     * @return void
     */
    final public function disableRegistration()
    {
        $option = get_site_option('users_can_register', 0);
        $option and update_site_option('users_can_register', 0);
    }

    /**
     * Do Exit
     *
     * @return void
     */
    protected function doExit()
    {
        exit;
    }
}
