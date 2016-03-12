<?php
use Pagekit\Application;

return [

    'name' => 'groups',
	'type' => 'extension',
	
	'config' => [
		// Sample groups
		'groups' => [
			[ 'id' => 1, 'name' => 'Sample Group 1', 'size' => 2 ],
			[ 'id' => 2, 'name' => 'Sample Group 2', 'size' => 3 ],
			[ 'id' => 3, 'name' => 'Sample Group 3', 'size' => 4 ],
		]
	],
	
	'settings' => '@groups/settings',
	
	'permissions' => [
		'groups: create groups' => [
            'title' => 'Create groups',
            'description' => 'Allowed to create on the site'
		],
		'groups: manage own groups' => [
			'title' => 'Manage own groups',
			'description' => 'Allowed to manage groups owned by the currently logged in user'
		],
		'groups: manage groups' => [
			'title' => 'Manage groups',
			'description' => 'Allowed to manage groups on the site'
		]
	],
	
	'autoload' => [
		'brandonjames\\groups\\' => 'src'
	],
	
	'resources' => [
		'groups:' => ''
	],

    'nodes' => [

        'groups' => [
            'name' => '@groups',
            'label' => 'Groups',
            'controller' => 'brandonjames\\groups\\Controller\\SiteController',
            'protected' => true,
            'frontpage' => true
        ]

    ],
	
	'events' => [
        'view.scripts' => function ($event, $scripts) {
            $scripts->register('groupslink', 'groups:app/bundle/link-groups.js', '~panel-link');
        }
    ],

    'routes' => [

        '/groups' => [
            'name' => '@groups',
            'controller' => 'brandonjames\\groups\\Controller\\GroupsController'
        ],
        '/api/groups' => [
            'name' => '@groups/api',
            'controller' => [
                'brandonjames\\groups\\Controller\\GroupsApiController',
            ]
        ]

    ],
	
	'menu' => [
		'groups' => [
            'label' => 'Groups',
            'url' => '@groups/manage',
            'active' => '@groups/manage*',
			'icon' => 'app/system/assets/images/placeholder-icon.svg',
			'access' => 'groups: manage all groups'
		],
		'groups: manage' => [
			'label' => 'Manage',
			'parent' => 'groups',
			'url' => '@groups/manage',
			'access' => 'groups: manage all groups'
		],
		'groups: settings' => [
			'parent' => 'groups',
			'label' => 'Settings',
			'url' => '@groups/settings',
			'access' => 'groups: manage all groups'
		]
	],

    'settings' => '@groups/settings',
];