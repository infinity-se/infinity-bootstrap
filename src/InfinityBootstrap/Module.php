<?php

namespace InfinityBootstrap;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;

class Module implements AutoloaderProviderInterface, BootstrapListenerInterface, ConfigProviderInterface, DependencyIndicatorInterface
{

    public function onBootstrap(EventInterface $event)
    {
        // Load variables
        $application = $event->getApplication();

        // Attach view rendering strategy
        $listener = new Mvc\View\Http\ViewRenderingStrategy();
        $application->getEventManager()->attachAggregate($listener);

        // Attach new navigation helper
        $pluginManager = $application->getServiceManager()
                ->get('ViewHelperManager')->get('Navigation')
                ->getPluginManager();
        $pluginManager->setInvokableClass('bar', '\InfinityBootstrap\View\Helper\Navigation\Bar');
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    public function getModuleDependencies()
    {
        return array('InfinityBase', 'SxBootstrap');
    }

}

