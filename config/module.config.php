<?php

// Cache vendor path
$vendorPath = realpath('vendor');
return array(
    'infinity'          => array(
        'bootstrap' => array(
        ),
    ),
    'twitter_bootstrap' => array(
        'use_lessphp' => true,
    ),
    'asset_manager'     => array(
        'resolver_configs' => array(
            'collections' => array(
                'css/master.css' => array(
                    'less/bootstrap.less',
                    'css/bootstrap-responsive-pre.css',
                    'less/bootstrap-responsive.less',
                ),
                'js/master.js'   => array(
                    'js/jquery.js',
                    'js/bootstrap.js',
                ),
            ),
            'map'         => array(
                'js/html5.js'                      => 'https://raw.github.com/aFarkas/html5shiv/3.6.2/src/html5shiv-printshiv.js',
                'js/jquery.js'                     => 'https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js',
                'less/bootstrap.less'              => $vendorPath . '/twitter/bootstrap/less/bootstrap.less',
                'less/bootstrap-responsive.less'   => $vendorPath . '/twitter/bootstrap/less/responsive.less',
                'css/bootstrap-responsive-pre.css' => __DIR__ . '/../assets/css/bootstrap-responsive-pre.css',
            ),
        ),
        'filters'          => array(
            'css/master.css' => array(
                array(
                    'service' => 'SxBootstrap\Service\BootstrapFilter',
                ),
            ),
        ),
    ),
    'view_manager'      => array(
        'template_map'        => array(
            'layout/bootstrap' => __DIR__ . '/../view/layout/bootstrap.phtml',
        ),
        'template_path_stack' => array(
            'InfinityBootstrap' => __DIR__ . '/../view',
        ),
        'layout'              => 'layout/bootstrap',
    ),
    'view_helpers'      => array(
        'aliases'    => array(
            'messages' => 'sxbFlashMessenger',
        ),
        'invokables' => array(
            'formRow' => 'InfinityBootstrap\Form\View\Helper\FormRow',
        ),
    ),
    'navigation'        => array(
        'default' => array(
            'brand' => array(
                'label' => 'Infinity Software & Engineering',
                'class' => 'brand',
                'route' => 'home',
                'icon'  => 'home',
            ),
        ),
    ),
    'service_manager'   => array(
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
    ),
);