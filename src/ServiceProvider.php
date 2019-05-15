<?php
/**
 * Created by PhpStorm.
 * User: xuzongchao
 * Date: 2019/5/15
 * Time: 下午3:57
 */

namespace Izongchao\Gweather;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(Weather::class, function(){
            return new Weather(config('services.weather.key'));
        });

        $this->app->alias(Weather::class, 'weather');
    }

    public function provides()
    {
        return [Weather::class, 'weather'];
    }
}