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

namespace Widoz\DisableRegisterTest\Functional;

use InvalidArgumentException;
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
}
