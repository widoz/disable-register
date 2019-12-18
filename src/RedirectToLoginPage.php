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

/**
 * Class RedirectToLoginPage
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class RedirectToLoginPage
{
    /**
     * @var RegisterDisabler
     */
    private $disableRegistration;

    /**
     * RedirectToLoginPage constructor
     * @param RegisterDisabler $disableRegistration
     */
    public function __construct(RegisterDisabler $disableRegistration)
    {
        $this->disableRegistration = $disableRegistration;
    }

    /**
     * Redirect to Login Page Based on Request
     *
     * @return void
     */
    public function redirectToLoginPage()
    {
        global $pagenow;

        // phpcs:disable
        $action = (string)filter_var($_REQUEST['action'] ?? '', FILTER_SANITIZE_STRING);
        // phpcs:enable
        $key = (string)filter_input(INPUT_GET, 'key', FILTER_SANITIZE_STRING);
        // Because WordPress set the action to `resetpass` when `key` is provided.
        $action = !$key ? $action : 'invalid_action';

        $this->disableRegistration->maybeRedirectToLoginPage($pagenow, $action);
    }
}
