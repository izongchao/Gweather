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

use GuzzleHttp\Client;
use Izongchao\Gweather\Exceptions\HttpException;
use Izongchao\Gweather\Exceptions\InvalidArgumentException;

/**
 * Class Weather.
 */
class Weather
{
    const WEATHER_URL = 'https://restapi.amap.com/v3/weather/weatherInfo';

    /**
     * @var array
     */
    protected static $types = [
        'base',
        'all',
    ];

    /**
     * @var array
     */
    protected static $formats = [
        'json',
        'xml',
    ];

    /**
     * @var string
     */
    protected $key;

    /**
     * @var array
     */
    protected $guzzleOptions = [];

    /**
     * Weather constructor.
     *
     * @param $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * Get weather.
     *
     * @param $city
     * @param string $type
     * @param string $format
     *
     * @return mixed
     *
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function getWeather($city, $type = 'base', $format = 'json')
    {
        if (!in_array(\strtolower($format), self::$formats)) {
            throw new InvalidArgumentException('Invalid response format: '.$format);
        }

        if (!in_array(\strtolower($type), self::$types)) {
            throw new InvalidArgumentException('Invalid type value(base/all): ' . $type);
        }

        $query = array_filter([
            'key' => $this->key,
            'city' => $city,
            'output' => \strtolower($format),
            'extensions' => \strtolower($type),
        ]);

        try {
            $response = $this->getHttpClient()->get(self::WEATHER_URL, [
                'query' => $query,
            ])->getBody()->getContents();

            return 'json' === $format ? \json_decode($response, true) : $response;
        } catch (\Exception $e) {
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Get live weather.
     *
     * @param $city
     * @param string $format
     *
     * @return mixed
     *
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function getLiveWeather($city, $format = 'json')
    {
        return $this->getWeather($city, 'base', $format);
    }

    /**
     * Get forecasts weather.
     *
     * @param $city
     * @param string $format
     *
     * @return mixed
     *
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function getForecastsWeather($city, $format = 'json')
    {
        return $this->getWeather($city, 'all', $format);
    }

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    /**
     * Set GuzzleOptions.
     *
     * @param array $options
     */
    public function setGuzzleOptions(array $options)
    {
        $this->guzzleOptions = $options;
    }
}
