<?php

namespace InfinityBootstrap\Mvc\View\Http;

use InfinityBootstrap\View\Helper\Navigation\PluginManager;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\EventInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Renderer\PhpRenderer;

class ViewRenderingStrategy implements ListenerAggregateInterface
{
    /**
     * @var array
     */
    protected $_listeners = array();

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $eventManager)
    {
        $this->_listeners[] = $eventManager->attach(
                'render', array($this, 'load'), 1000
                );
    }

    /**
     * {@inheritDoc}
     */
    public function detach(EventManagerInterface $eventManager)
    {
        foreach ($this->_listeners as $index => $listener) {
            if ($eventManager->detach($listener)) {
                unset($this->_listeners[$index]);
            }
        }
    }

    /**
     * Load view parameters
     *
     * @param EventInterface $event
     */
    public function load(EventInterface $event)
    {
        // Load variables
        $application    = $event->getTarget();
        $serviceManager = $application->getServiceManager();

        // Check for renderer
        if (!$serviceManager->has('ViewRenderer')) {
            return;
        }

        // Check renderer
        $renderer = $serviceManager->get('ViewRenderer');
        if (!$renderer instanceof PhpRenderer) {
            return;
        }

        // Load globals
        $this->_loadGlobals($renderer);

        // Register navigation helpers
        $this->_loadNavigation($serviceManager);
    }

    /**
     * Load global variables
     *
     * @param PhpRenderer $renderer
     */
    protected function _loadGlobals($renderer)
    {
        // Set base path
        $basePath = $renderer->basePath();

        // Set title
        $renderer->headTitle()
                ->setSeparator(' :: ')
                ->setAutoEscape(false);

        // Add head links
        $renderer->headLink(
                array(
                    'rel'  => 'shortcut icon',
                    'type' => 'image/vnd.microsoft.icon',
                    'href' => $basePath . '/favicon.ico'
                    )
                )
                ->appendStylesheet($basePath . '/css/master.css');

        // Add head scripts
        $renderer->headScript()
                ->appendFile(
                        $basePath . '/js/html5.js',
                        'text/javascript',
                        array('conditional' => 'lt IE 9')
                        );

        // Add inline script
        $renderer->inlineScript()
                ->appendFile($basePath . '/js/master.js');
    }

    /**
     * Load navigation
     *
     * @param ServiceLocatorInterface $serviceManager
     */
    protected function _loadNavigation(ServiceLocatorInterface $serviceManager)
    {
        return;
        // Load view helper manager
        $helperManager = $serviceManager->get('view_helper_manager');
        if (!$helperManager) {
            return;
        }

        // Register navigation plugin manager
        $navigationManager = $helperManager->get('navigation');
        $pluginManager     = new PluginManager();
        $navigationManager->setPluginManager($pluginManager);
    }
}