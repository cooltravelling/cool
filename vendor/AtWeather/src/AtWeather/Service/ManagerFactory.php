<?php

namespace AtWeather\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use AtWeather\Manager;

/**
 * AtWeather service manager factory
 */

class ManagerFactory implements FactoryInterface
{
    /**
     * Factory method for AtWeather Manager service
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return \AtWeather\Manager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $params = $config['at-weather'];

        $manager = new Manager($params);
        return $manager;
    }
}