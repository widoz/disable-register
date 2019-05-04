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

use Brain\Monkey\Filters;
use Brain\Monkey\Actions;
use Brain\Monkey\Functions;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use ProjectTestsHelper\Phpunit\TestCase;
use Widoz\DisableRegister\Bootstrapper as Testee;

/**
 * Class BootstrapTest
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class BootstrapTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    /**
     * Test Filters Applied
     */
    public function testFiltersApplied()
    {
        $testee = new Testee(__FILE__);

        Functions\when('site_url')->justReturn('http://loginpageurl.com');
        Functions\when('plugin_dir_url')->justReturn('http://plugindirurl.com');

        Filters\expectAdded('wpmu_active_signup')->once();
        Filters\expectAdded('site_option_registration')->once();
        Filters\expectAdded('shake_error_codes')->once();
        Filters\expectAdded('login_errors')->once();
        Filters\expectAdded('wp_signup_location')->once();

        Actions\expectAdded('login_init')->once();
        Actions\expectAdded('wp_enqueue_scripts')->once();
        Actions\expectAdded('wp_loaded')->once();

        $testee->run();
    }
}
