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

namespace Widoz\DisableRegisterTest\Unit;

use Brain\Monkey\Functions;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use ProjectTestsHelper\Phpunit\TestCase;
use Widoz\DisableRegister\ScriptEnqueuer as Testee;

/**
 * Class ScriptEnqueuerTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class ScriptEnqueuerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * Test Logic Css is Enqueued
     */
    public function testLoginCssEnqueued()
    {
        $testee = new Testee('http://url.com');

        Functions\expect('wp_enqueue_style')
            ->once()
            ->with('gs-disable-register', 'http://url.com/assets/css/login.css', false);

        $testee->enqueue();
    }
}
