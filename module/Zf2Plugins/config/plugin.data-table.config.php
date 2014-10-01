<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
	'controllers' => array (
			'invokables' => array (
					'DataTable\Controller\Index' => 'DataTable\Controller\IndexController',
			)
	),
    'router' => array(
        'routes' => array(
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /plugins/:plugin/:controller/:action
            'plugins-datatable' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/plugins/table[/:controller][/:action][/:id]',
                	'constraints' => array( 
                		'id'        	=> '[0-9]+' 
                	),
                    'defaults' => array(
                        '__NAMESPACE__' => 'DataTable\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index' 
                    ),
                ) 
            ),   
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
        		__DIR__ . '/../view',
        ),
    ), 
);
