<?php
namespace Front;

use Zend\Mvc\MvcEvent;


use Front\Controller\IndexController;
use Front\Controller\VoyageController;
use Front\Controller\ParcoursController;

use Front\Model\VoyageTable;
use Front\Model\Voyage;
use Front\Model\TypeVoyage;
use Front\Model\TypeVoyageTable;
use Front\Model\Parcours;
use Front\Model\ParcoursTable;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\Controller\ControllerManager;

class Module
{
	public function onBootstrap(MvcEvent $e)
	{
		$e->getApplication()->getServiceManager()->get('translator');
		$eventManager = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);
	}
	
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

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Front\Model\VoyageTable' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new VoyageTable($dbAdapter);
                    return $table;
                },
                'Front\Model\TypeVoyageTable' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new TypeVoyageTable($dbAdapter);
                    return $table;
                },
                'Front\Model\ParcoursTable' =>  function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new ParcoursTable($dbAdapter);
                    return $table;
                },
            ),
        );
    }

    public function getControllerConfig() {
        return array(
            'factories' => array(
                'Front\Controller\Voyage' => function(ControllerManager $cm) {
                    $sm = $cm->getServiceLocator();
                    $voyage = $sm->get('Front\Model\VoyageTable');
                    $typevoy = $sm->get('Front\Model\TypeVoyageTable');
                    $controller = new VoyageController($voyage,$typevoy);
                    return $controller;
                },
                'Front\Controller\Parcours' => function(ControllerManager $cm) {
                    $sm = $cm->getServiceLocator();
                    $parcours = $sm->get('Front\Model\ParcoursTable');
                    $voyage = $sm->get('Front\Model\VoyageTable');
                    $controller = new ParcoursController($parcours,$voyage);
                    return $controller;
                },
                'Front\Controller\Index' => function(ControllerManager $cm) {
                    $controller = new IndexController();
                    return $controller;
                },
            ),
        );
    }
}