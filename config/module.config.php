<?php

// Cache vendor path
$vendorPath = realpath('vendor');
return array(
    'twitter_bootstrap' => array(
        'use_lessphp' => true,
    ),
    'asset_manager' => array(
        'resolver_configs' => array(
            'collections' => array(
                'css/master.css' => array(
                    'css/bootstrap.css',
                ),
                'js/master.js'   => array(
                    'js/jquery.js',
                    'js/bootstrap.js',
                ),
                'css/bootstrap.css' => array(
                    'less/bootstrap.less',
                    'less/bootstrap-responsive.less',
                )
            ),
            'map'         => array(
                'js/html5.js'                        => $vendorPath . '/afarkas/html5shiv/html5shiv-printshiv.js',
                'js/jquery.js'                       => $vendorPath . '/jquery/jquery/jquery-1.9.1.js',
                'less/bootstrap.less'                => $vendorPath . '/twitter/bootstrap/less/bootstrap.less',
                'less/bootstrap-responsive.less'     => $vendorPath . '/twitter/bootstrap/less/responsive.less',
            ),
        ),
    ),
    'view_manager'  => array(
        'template_map'        => array(
            'layout/bootstrap' => __DIR__ . '/../view/layout/bootstrap.phtml',
        ),
        'template_path_stack' => array(
            'InfinityBootstrap' => __DIR__ . '/../view',
        ),
        'layout'              => 'layout/bootstrap',
    ),
    'view_helpers' => array(
        'aliases' => array(
            'messages' => 'sxbFlashMessenger',
        ),
        'invokables' => array(
            'form' => 'InfinityBootstrap\Form\View\Helper\Form',
            'formRow' => 'InfinityBootstrap\Form\View\Helper\FormRow',
        ),
    ),
);