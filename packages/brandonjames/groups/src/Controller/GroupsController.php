<?php
namespace brandonjames\groups\Controller;

use \Pagekit\Application as App;
use \Pagekit\User\Model\User;
use brandonjames\groups\Model\Group as Group;

/**
 * @Access(admin=true)
 * 
 */
class GroupsController {
	
	/**
	 * @Access("groups: manage all groups")
	 * @Route("/")
	 */
	public function manageAction() {
		$groups = App::db()->executeQuery('select * from @group')->fetchAll();
		
		return [
			'$view' => [
				'title' => 'Administrate Groups',
				'name' => 'groups:views/admin/index.php'
			],
			'$data' => [
				'groups' => $groups
			]
		];
	}
	
    /**
     * @Access("system: manage settings")
     */
	public function settingsAction() {
		$groups = App::db()->executeQuery('select * from @group')->fetchAll();
		
		return [
			'$view' => [
				'title' => 'Administrate Groups',
				'name' => 'groups:views/admin/settings.php'
			],
			'$data' => [
				'config' => App::module('groups')->config()
			]
		];
	}
}