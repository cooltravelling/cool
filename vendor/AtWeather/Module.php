<?php

namespace AtWeather;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'AtWeather' => 'AtWeather\Service\ManagerFactory',
            )
        ); 
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /*public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'getWeather' => function ($sm) {
                    $locator = $sm->getServiceLocator();
                    $config = $locator->get('Configuration');
                    $params = $config['at-weather'];
                    $viewHelper = new View\Helper\AtWeather();
                    $viewHelper->setService($locator->get('AtWeather'));
                    $viewHelper->setParams($params);
                    
                    return $viewHelper;
                },
            ),
        );
    }*/
}