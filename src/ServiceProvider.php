<?php

/*
 * This file is part of the izongchao/gweather.
 *
 * (c) xuzongchao <zchao0723@126.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Izongchao\Gweather;

/**
 * Class ServiceProvider.
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * register.
     */
    public function register()
    {
        $this->app->singleton(Weather::class, function () {
            return new Weather(config('services.weather.key'));
        });

        $this->app->alias(Weather::class, 'weather');
    }

    /**
     * provides.
     *
     * @return array
     */
    public function provides()
    {
        return [Weather::class, 'weather'];
    }
}
