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

namespace Widoz\DisableRegisterTests\Functional;

use InvalidArgumentException;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use ProjectTestsHelper\Phpunit\TestCase;
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
     * Test Object Require Valid Url at Construct Time
     */
    public function testObjectRequireValidUrl()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Require a valid url.');
        $testee = new Testee('');

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Require a valid url.');
        $testee = new Testee('Non Valid Url');
    }

    /**
     * Test Registration Status
     */
    public function testRegistrationStatus()
    {
        $testee = new Testee('http://url.com');

        $response = $testee->validRegistrationStatus();

        self::assertSame('none', $response);
    }

    /**
     * Test Action
     */
    public function testAction()
    {
        $testee = new Testee('http://url.com');

        $response = $testee->validAction();

        self::assertSame('login', $response);
    }

    /**
     * Test Disable Shake Error Codes
     */
    public function testDisableShakeErrorCodes()
    {
        $testee = new Testee('http://url.com');

        $response = $testee->disableShakeErrorCodes();

        self::assertSame([], $response);
    }

    /**
     * Test Hide Login Error Messages
     */
    public function testHideLoginErrorMessages()
    {
        $testee = new Testee('http://url.com');

        $response = $testee->hideLoginErrorMessages();

        self::assertSame('', $response);
    }

    /**
     * Test SignUp Location
     */
    public function testSignUpLocation()
    {
        $loginPageUrl = 'http://url.com';
        $testee = new Testee($loginPageUrl);

        $response = $testee->loginPageUrl();

        self::assertSame($loginPageUrl, $response);
    }
}
