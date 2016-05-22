<?php
use Pagekit\Application;

return [

    'name' => 'events',
	'type' => 'extension',

	'config' => [

	],

	'settings' => '@events/settings',

	'permissions' => [
		'events: create events' => [
            'title' => 'Create events',
            'description' => 'Allowed to create events'
		],
        'events: join events' => [
            'title' => 'Join events',
            'description' => 'Allowed to join events'
        ],
		'events: manage own events' => [
			'title' => 'Manage own events',
			'description' => 'Allowed to manage events owned by the currently logged in user'
		],
		'events: manage all events' => [
			'title' => 'Manage events',
			'description' => 'Allowed to manage all events'
		]
	],

	'autoload' => [
		'brandonjames\\events\\' => 'src'
	],

	'resources' => [
		'events:' => ''
	],

    'nodes' => [

        'events' => [
            'name' => '@events',
            'label' => 'Events',
            'controller' => 'brandonjames\\events\\Controller\\SiteController',
            'protected' => true,
            'frontpage' => true
        ]

    ],

	// 'events' => [
    //     'view.scripts' => function ($event, $scripts) {
    //         $scripts->register('eventslink', 'events:app/bundle/link-events.js', '~panel-link');
    //     }
    // ],

    'routes' => [

        '/events' => [
            'name' => '@events',
            'controller' => 'brandonjames\\events\\Controller\\EventsController'
        ],
        '/api/events' => [
            'name' => '@events/api',
            'controller' => [
                'brandonjames\\events\\Controller\\EventsApiController',
            ]
        ]

    ],

	'menu' => [
		'events' => [
            'label' => 'Events',
            'url' => '@events/manage',
            'active' => '@events/manage*',
			'icon' => 'app/system/assets/images/placeholder-icon.svg',
			'access' => 'events: manage all events'
		],
		'events: manage' => [
			'label' => 'Manage',
			'parent' => 'events',
			'url' => '@events/manage',
			'access' => 'events: manage all events'
		],
		'events: settings' => [
			'parent' => 'events',
			'label' => 'Settings',
			'url' => '@events/settings',
            'active' => '@events/settings',
			'access' => 'events: manage all events'
		]
	],

    'settings' => '@events/settings',
];
