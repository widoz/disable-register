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

namespace Widoz\DisableRegisterTests\Unit;

use Brain\Monkey\Functions;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use ProjectTestsHelper\Phpunit\TestCase;
use Widoz\DisableRegister\RegisterDisabler;
use Widoz\DisableRegister\RedirectToLoginPage as Testee;

/**
 * Class RedirectToLoginPageTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class RedirectToLoginPageTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * Test Invalid Action is Passed to Redirect Login Page if Input Get Key Passed
     */
    public function testInvalidActionGetPassed()
    {
        global $pagenow;

        $pagenow = 'pageNow';
        $_REQUEST = [
            'action' => 'valid_action',
        ];

        $disableRegistration = $this->createMock(RegisterDisabler::class);
        $testee = new Testee($disableRegistration);

        $disableRegistration
            ->expects($this->once())
            ->method('maybeRedirectToLoginPage')
            ->with($pagenow, 'invalid_action');

        Functions\expect('filter_var')
            ->once()
            ->with($_REQUEST['action'], FILTER_SANITIZE_STRING)
            ->andReturn($_REQUEST['action']);

        Functions\expect('filter_input')
            ->once()
            ->with(INPUT_GET, 'key', FILTER_SANITIZE_STRING)
            ->andReturn('has key');

        $testee->redirectToLoginPage();
    }
}
