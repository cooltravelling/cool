<?php

return array(
    'at-weather' => array(
        'providers' => array(
            'gismeteo' => array(
                'name' => 'AtWeather\Provider\Gismeteo',
                'params' => array(
                    'apiUrl' => 'http://informer.gismeteo.ru/xml/'
                )
            ),
            'yahoo' => array(
                'name' => 'AtWeather\Provider\Yahoo',
                'params' => array(
                    'apiUrl' => 'http://weather.yahooapis.com/forecastrss',
                    'units'  => ''
                )
            ),
            'worldweatheronline' => array(
                'name' => 'AtWeather\Provider\WorldWeatherOnline',
                'params' => array(
                    'apiUrl'      => 'http://free.worldweatheronline.com/feed/weather.ashx',
                    'apiKey'      => '',
                    'format'      => 'json',
                    'num_of_days' => 5
                )
            )
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            //'AtWeatherManager' => 'AtWeather\Service\ManagerFactory',
            //'AtWeatherProvider' => 'AtWeather\Service\ProviderFactory',
            'AtWeatherManager' => function($sm) {
                $manager = new \AtWeather\Service\ManagerFactory;
                $manager = $manager->createService($sm);
                return $manager;
            },
            'AtWeatherProvider' => function($sm) {
                $provider = new \AtWeather\Service\ProviderFactory;
                $provider = $provider->createService($sm);
                return $provider;
            }

        ),
    )
);