<?php
return array(
    'modules' => array(
        'ZendDeveloperTools',
        'ZfcBase',
        'ZfcUser',
        'ZfcAdmin',
        'CdliUserProfile',
        'GoalioRememberMe',
        //'BjyAuthorize',
        'BjyProfiler',
        'Front',
        
    ),
    'module_listener_options' => array(
        'config_glob_paths'    => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
);
