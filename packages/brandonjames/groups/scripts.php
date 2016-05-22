<?php

return [

    /*
     * Installation hook.
     */
    'install' => function ($app) {

		$util = $app['db']->getUtility();

		if ($util->tableExists('@group') === false) {
			$util->createTable('@group', function ($table) {
				// ID is randomly generated to prevent bots from spamming requests
                $table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true, 'notnull' => false]);
                $table->addColumn('group_category_id', 'integer', ['unsigned' => true, 'length' => 10]);
				$table->addColumn('user_id', 'integer', ['unsigned' => true, 'length' => 10]);
				$table->addColumn('name', 'string', ['length' => 255, 'default' => '']);
                $table->addColumn('slug', 'string', ['length' => 255, 'default' => '']);
				$table->addColumn('max_members', 'integer', ['unsigned' => true, 'length' => 10, 'default' => 0, 'notnull' => false]);
				$table->addColumn('active_day', 'string', ['length' => 1, 'default' => 'M']);
				$table->addColumn('active_time', 'time', ['default' => '12:00']);
                $table->addColumn('description', 'string', ['length' => 255, 'default' => '', 'notnull' => false]);
                $table->addColumn('gender', 'string', ['length' => 1, 'default' => 'c']);
				$table->addColumn('location', 'string', ['length' => 255, 'default' => '', 'notnull' => false]);
				$table->addColumn('photo', 'string', ['length' => 255, 'default' => '', 'notnull' => false]);
				$table->addColumn('created', 'datetime', [ 'notnull' => false ]);
				$table->addColumn('modified', 'datetime', [ 'notnull' => false ]);
				$table->setPrimaryKey(['id']);
			});
		}
		if ($util->tableExists('@group_category') === false) {
			$util->createTable('@group_category', function ($table) {
                $table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
                $table->addColumn('user_id', 'integer', ['unsigned' => true, 'length' => 10, 'default' => 0]);
				$table->addColumn('name', 'string', ['length' => 255, 'default' => '']);
				$table->addColumn('description', 'string', ['length' => 255, 'default' => '', 'notnull' => false]);
				$table->addColumn('can_make_events', 'integer', ['length' => 1, 'default' => 0, 'notnull' => false]);
				$table->addColumn('times_are_on_calendar', 'integer', ['length' => 1, 'default' => 1, 'notnull' => false]);
				$table->addColumn('created', 'datetime', [ 'notnull' => false ]);
				$table->addColumn('modified', 'datetime', [ 'notnull' => false ]);
				$table->setPrimaryKey(['id']);
			});
		}
		if ($util->tableExists('@group_members') === false) {
			$util->createTable('@group_members', function ($table) {
                $table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
                $table->addColumn('user_id', 'integer', ['unsigned' => true, 'length' => 10]);
                $table->addColumn('group_id', 'integer', ['unsigned' => true, 'length' => 10]);
				$table->addColumn('created', 'datetime', [ 'notnull' => false ]);
				$table->setPrimaryKey(['id']);
			});
		}
		if ($util->tableExists('@group_discussions') === false) {
			$util->createTable('@group_discussions', function ($table) {
                $table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
                $table->addColumn('user_id', 'integer', ['unsigned' => true, 'length' => 10]);
                $table->addColumn('group_id', 'integer', ['unsigned' => true, 'length' => 10]);
				$table->addColumn('parent', 'integer', ['unsigned' => true, 'length' => 10, 'notnull' => false]);
                $table->addColumn('content', 'string', [ 'notnull' => false ]);
				$table->addColumn('created', 'datetime', [ 'notnull' => false ]);
				$table->addColumn('modified', 'datetime', [ 'notnull' => false ]);
				$table->setPrimaryKey(['id']);
			});
		}
    },

    /*
     * Enable hook
     *
     */
    'enable' => function ($app) {
    },

    /*
     * Uninstall hook
     *
     */
    'uninstall' => function ($app) {

        // remove the config
        $app['config']->remove('groups');

        $util = $app['db']->getUtility();

        if ($util->tableExists('@groups')) {
            $util->dropTable('@groups');
        }

        if ($util->tableExists('@group_categories')) {
            $util->dropTable('@group_categories');
        }

    },

    /*
     * Runs all updates that are newer than the current version.
     *
     */
    'updates' => [

        '0.1.1' => function ($app) {

        },

        '0.9.0' => function ($app) {

        },

    ],

];
