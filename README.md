<h1 align="center">Weather</h1>

<p align="center">:rainbow: 基于高德开放平台的 PHP 天气信息组件。</p>

[![Build Status](https://travis-ci.org/izongchao/gweather.svg?branch=master)](https://travis-ci.org/izongchao/gweather)
[![Latest Stable Version](https://poser.pugx.org/izongchao/gweather/v/stable)](https://packagist.org/packages/izongchao/gweather)
[![Total Downloads](https://poser.pugx.org/izongchao/gweather/downloads)](https://packagist.org/packages/izongchao/gweather)
![StyleCI build status](https://github.styleci.io/repos/186780490/shield) 
[![License](https://poser.pugx.org/izongchao/gweather/license)](https://packagist.org/packages/izongchao/gweather)

## 安装

```sh
$ composer require izongchao/gweather -vvv
```

## 配置

在使用本扩展之前，你需要去 [高德开放平台](https://lbs.amap.com/dev/id/newuser) 注册账号，然后创建应用，获取应用的 API Key。


## 使用

```php
use Izongchao\Gweather\Weather;

$key = 'xxxxxxxxxxxxxxxxxxxxxxxxxxx';

$weather = new Weather($key);
```

###  获取实时天气

```php
$response = $weather->getLiveWeather('合肥');
```
示例：

```json
{
    "status": "1",
    "count": "1",
    "info": "OK",
    "infocode": "10000",
    "lives": [
        {
            "province": "安徽",
            "city": "合肥市",
            "adcode": "340100",
            "weather": "多云",
            "temperature": "23",
            "winddirection": "北",
            "windpower": "4",
            "humidity": "20",
            "reporttime": "2019-05-20 09:21:20"
        }
    ]
}
```

### 获取近期天气预报

```
$response = $weather->getForecastsWeather('合肥');
```
示例：

```json
{
    "status": "1",
    "count": "1",
    "info": "OK",
    "infocode": "10000",
    "forecasts": [
        {
            "city": "合肥市",
            "adcode": "340100",
            "province": "安徽",
            "reporttime": "2019-05-20 09:21:20",
            "casts": [
                {
                    "date": "2019-05-20",
                    "week": "1",
                    "dayweather": "多云",
                    "nightweather": "阴",
                    "daytemp": "25",
                    "nighttemp": "13",
                    "daywind": "西北",
                    "nightwind": "西北",
                    "daypower": "4",
                    "nightpower": "4"
                },
                {
                    "date": "2019-05-21",
                    "week": "2",
                    "dayweather": "多云",
                    "nightweather": "多云",
                    "daytemp": "27",
                    "nighttemp": "15",
                    "daywind": "西",
                    "nightwind": "西",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                },
                {
                    "date": "2019-05-22",
                    "week": "3",
                    "dayweather": "晴",
                    "nightweather": "多云",
                    "daytemp": "32",
                    "nighttemp": "15",
                    "daywind": "西南",
                    "nightwind": "西南",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                },
                {
                    "date": "2019-05-23",
                    "week": "4",
                    "dayweather": "多云",
                    "nightweather": "多云",
                    "daytemp": "29",
                    "nighttemp": "18",
                    "daywind": "南",
                    "nightwind": "南",
                    "daypower": "≤3",
                    "nightpower": "≤3"
                }
            ]
        }
    ]
}

```

### 获取 XML 格式返回值

以上两个方法第二个参数为返回值类型，可选 `json` 与 `xml`，默认 `json`：

```php
$response = $weather->getLiveWeather('合肥', 'xml');
```

示例：

```xml
<response>
    <status>1</status>
    <count>1</count>
    <info>OK</info>
    <infocode>10000</infocode>
    <lives type="list">
        <live>
            <province>安徽</province>
            <city>合肥市</city>
            <adcode>340100</adcode>
            <weather>多云</weather>
            <temperature>23</temperature>
            <winddirection>北</winddirection>
            <windpower>4</windpower>
            <humidity>20</humidity>
            <reporttime>2019-05-20 09:21:20</reporttime>
        </live>
    </lives>
</response>
```

### 参数说明

```
array | string   getLiveWeather(string $city, string $format = 'json')
array | string   getForecastsWeather(string $city, string $format = 'json')
```

> - `$city` - 城市名/[高德地址位置 adcode](https://lbs.amap.com/api/webservice/guide/api/district)，比如：“合肥” 或者（adcode：340100）；
> - `$format`  - 输出的数据格式，默认为 json 格式，当 output 设置为 “`xml`” 时，输出的为 XML 格式的数据。


### 在 Laravel 中使用

在 Laravel 中使用也是同样的安装方式，配置写在 `config/services.php` 中：

```php
    .
    .
    .
     'weather' => [
        'key' => env('WEATHER_API_KEY'),
    ],
```

然后在 `.env` 中配置 `WEATHER_API_KEY` ：

```env
WEATHER_API_KEY=xxxxxxxxxxxxxxxxxxxxx
```

可以用两种方式来获取 `Izongchao\Gweather\Weather` 实例：

#### 方法参数注入

```php
    .
    .
    .
    public function edit(Weather $weather) 
    {
        $response = $weather->getLiveWeather('合肥');
    }
    .
    .
    .
```

#### 服务名访问

```php
    .
    .
    .
    public function edit() 
    {
        $response = app('weather')->getLiveWeather('合肥');
    }
    .
    .
    .

```

## 参考

- [高德开放平台天气接口](https://lbs.amap.com/api/webservice/guide/api/weatherinfo/)

## License

MIT
