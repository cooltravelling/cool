<?php
use Zend\HTTP;
use Front\Service\WeatherResult;

class YahooWeather
{
    const URL = 'http://weather.yahooapis.com/forecastrss?w=%s&u=%s';

    const TEMPERATURE_UNIT_CELSIUS    = 1;
    const TEMPERATURE_UNIT_FAHRENHEIT = 2;
    
    protected $_temperatureUnit = self::TEMPERATURE_UNIT_CELSIUS; 
    
    public function getCurrentWeather($code)
    {
        if (self::TEMPERATURE_UNIT_CELSIUS == $this->_temperatureUnit) {
            $temperatureUnit = 'c';
        } else {
            $temperatureUnit = 'f';
        }
    
        $url = sprintf(self::URL, $code, $temperatureUnit);    
        $httpClient = new Client($url);
        $response = $httpClient->request();

        return new WeatherResult($response->getBody());
    }
    
    public function setTemperatureUnit($unit)
    {
        $this->_temperatureUnit = $unit;
    }
}