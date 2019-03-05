<?php # -*- coding: utf-8 -*-
declare(strict_types=1);

namespace TZimpel\PluginBootstrap;

use TZimpel\PluginBootstrap\Hook\HookInterface;

/**
 * Class Bootstrap
 * @package TZimpel\PluginBootstrap
 */
class Bootstrap
{
    private $core;

    private $front;

    private $admin;

    public function __construct(
        HookInterface $core = null,
        HookInterface $front = null,
        HookInterface $admin = null
    ) {

        $this->core = $core;
        $this->front = $front;
        $this->admin = $admin;
    }

    public static function createAndBootstrap(
        HookInterface $core = null,
        HookInterface $front = null,
        HookInterface $admin = null
    ) {

        return (new static($core, $front, $admin))->bootstrap();
    }

    public function bootstrap()
    {
        $is_admin = is_admin();

        $this->core and $this->core->setup();
        ($is_admin && $this->admin) and $ok = $this->admin->setup();
        (! $is_admin && $this->front) and $ok = $this->front->setup();
    }
}
