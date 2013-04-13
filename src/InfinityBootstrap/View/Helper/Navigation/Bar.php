<?php

namespace InfinityBootstrap\View\Helper\Navigation;

use Zend\View\Helper\Navigation\AbstractHelper;
use Zend\View\Model\ViewModel;

class Bar extends AbstractHelper
{

    /**
     * @var array
     */
    private $config;

    /**
     * View helper entry point
     *
     * @param  AbstractContainer $container
     * @return Bar
     */
    public function __invoke($container = null)
    {
        // Set container if passed
        if (null !== $container) {
            $this->setContainer($container);
        }

        return $this;
    }

    /**
     * Renders navigation bar
     * 
     * return string
     */
    public function render($container = null)
    {
        // Get container
        if (null !== $container) {
            $this->setContainer($container);
        }
        
        // Load brand
        $container = $this->getContainer();
        $brand     = $container->findOneBy('class', 'brand');
        if ($brand) {
            $container->removePage($brand);
        }

        // Render navigation bar
        $viewModel            = new ViewModel();
        $viewModel->brand     = $brand;
        $viewModel->container = $container;

        $viewModel->setTemplate('helper/navigation/bar');
        return $this->getView()->render($viewModel);
    }

    public function getConfig()
    {
        if (null === $this->config) {
            // Set config
            $config       = $this->getServiceLocator()->getServiceLocator()
                            ->get('application')->getConfig();
            $this->config = $config['infinity']['bootstrap'];
        }
        return $this->config;
    }

}