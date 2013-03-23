<?php

namespace InfinityBootstrap;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

class Module implements AutoloaderProviderInterface, BootstrapListenerInterface, ConfigProviderInterface
{

    public function onBootstrap(EventInterface $event)
    {
        // Load variables
        $application = $event->getApplication();

        // Attach view rendering strategy
        $listener = new Mvc\View\Http\ViewRenderingStrategy();
        $application->getEventManager()->attachAggregate($listener);
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

}