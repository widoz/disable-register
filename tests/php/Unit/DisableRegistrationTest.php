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
use ReflectionClass;
use ReflectionMethod;
use \Widoz\DisableRegister\RegisterDisabler as Testee;

/**
 * Class DisableRegistrationTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class DisableRegistrationTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * Test Redirect to Login Page if Current Page is SignUp
     */
    public function testRedirectToLoginPageIfCurrentPageIsSignUp()
    {
        $loginPageUrl = 'http://loginpageurl.com';
        $currentPage = 'wp-signup.php';

        $testee = $this
            ->getMockBuilder(Testee::class)
            ->setConstructorArgs([$loginPageUrl])
            ->setMethods(['doExit'])
            ->getMock();

        Functions\expect('wp_redirect')
            ->once()
            ->with($loginPageUrl);

        $testee
            ->expects($this->once())
            ->method('doExit')
            ->willReturn(null);

        $testee->maybeRedirectToLoginPage($currentPage, 'invalid_action');
    }

    /**
     * Test No Redirect Happens If Current Page is empty
     */
    public function testNoRedirectHappensIfCurrentPageIsEmpty()
    {
        $loginPageUrl = 'http://loginpageurl.com';
        $testee = new Testee($loginPageUrl);

        Functions\expect('wp_redirect')
            ->never();

        $testee->maybeRedirectToLoginPage('', '');
    }

    /**
     * Test Redirect Does Not Happen If Request is Valid
     */
    public function testRedirectNotHappenIfRequestActionIsValid()
    {
        $loginPageUrl = 'http://loginpageurl.com';

        $testee = new Testee($loginPageUrl);

        Functions\expect('wp_redirect')
            ->never();

        $testee->maybeRedirectToLoginPage('', 'login');
        $testee->maybeRedirectToLoginPage('', 'logout');
        $testee->maybeRedirectToLoginPage('', 'postpass');
    }

    /**
     * Test Disable Registration
     */
    public function testDisableRegistrationForSite()
    {
        $loginPageUrl = 'http://loginpageurl.com';

        $testee = new Testee($loginPageUrl);

        Functions\expect('get_site_option')
            ->once()
            ->with('users_can_register', 0)
            ->andReturn(1);

        Functions\expect('update_site_option')
            ->once()
            ->with('users_can_register', 0);

        $testee->disableRegistration();
    }
}
