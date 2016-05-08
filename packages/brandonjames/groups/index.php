<?php
use Pagekit\Application;

return [

    'name' => 'groups',
	'type' => 'extension',

	'config' => [
        'displayMessage' => 'Find a place to belong in the Armstrong BCM community'
	],

	'settings' => '@groups/settings',

	'permissions' => [
		'groups: create groups' => [
            'title' => 'Create groups',
            'description' => 'Allowed to create groups'
		],
        'groups: join groups' => [
            'title' => 'Join groups',
            'description' => 'Allowed to join groups'
        ],
		'groups: manage own groups' => [
			'title' => 'Manage own groups',
			'description' => 'Allowed to manage groups owned by the currently logged in user'
		],
		'groups: manage all groups' => [
			'title' => 'Manage groups',
			'description' => 'Allowed to manage all groups'
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
        ],
        '/api/group_categories' => [
            'name' => '@group_categories/api',
            'controller' => [
                'brandonjames\\groups\\Controller\\GroupCategoriesApiController',
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
        'groups: categories' => [
            'label' => 'Categories',
            'parent' => 'groups',
            'url' => '@groups/categories',
            'active' => '@groups/categories',
            'access' => 'groups: manage all groups'
        ],
		'groups: settings' => [
			'parent' => 'groups',
			'label' => 'Settings',
			'url' => '@groups/settings',
            'active' => '@groups/settings',
			'access' => 'groups: manage all groups'
		]
	],

    'settings' => '@groups/settings',
];
