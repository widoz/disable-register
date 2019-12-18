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
 * Class ScriptEnqueuer
 *
 * @author Guido Scialfa <dev@guidoscialfa.com>
 */
class ScriptEnqueuer
{
    /**
     * @var string
     */
    private $pluginDirUrl;

    /**
     * ScriptEnqueuer constructor
     * @param string $pluginDirUrl
     * @throws InvalidArgumentException
     */
    public function __construct(string $pluginDirUrl)
    {
        $pluginDirUrl = filter_var($pluginDirUrl, FILTER_VALIDATE_URL);
        if (!$pluginDirUrl) {
            throw new InvalidArgumentException('Require a valid url.');
        }

        $this->pluginDirUrl = $pluginDirUrl;
    }

    /**
     * Enqueue Scripts
     *
     * @return void
     */
    public function enqueue()
    {
        $pluginDirUrl = rtrim($this->pluginDirUrl, '/');
        wp_enqueue_style(
            'gs-disable-register',
            "{$pluginDirUrl}/assets/css/login.css",
            false
        );
    }
}
