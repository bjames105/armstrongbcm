<?php
namespace brandonjames\groups\Controller;

use \Pagekit\Application as App;
use \Pagekit\User\Model\User;
use brandonjames\groups\Model\Group as Group;
use brandonjames\groups\Model\GroupCategory as GroupCategory;

/**
 * @Access(admin=true)
 *
 */
class GroupsController {
	/**
     * @var Module config
     */
	protected $config;

	/**
     * Constructor.
     */
	public function __construct()
	{
		$this->config = App::module('groups')->config();
	}

	/**
	 * @Access("groups: manage all groups")
	 * @Route("/")
	 */
	public function manageAction()
	{
		$groupsData = Group::query()->related('user')->related('group_category')->related('group_members')->get();
		$groups = [];

		foreach ($groupsData as $group)
		{
			$groups[] = $group;
		}

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
	public function settingsAction()
	{
		$config = $this->config;

		return [
			'$view' => [
				'title' => 'Administrate Groups',
				'name' => 'groups:views/admin/settings.php'
			],
			'$data' => [
				'config' => $config
			]
		];
	}

	/**
	 * @Access("groups: manage all groups")
	 */
	public function categoriesAction()
	{
		$config = $this->config;

		$categoriesData = GroupCategory::findAll();
		$categories = [];

		foreach ($categoriesData as $category)
		{
			$categories[] = $category;
		}

		return [
			'$view' => [
				'title' => 'Administrate Group Categories',
				'name' => 'groups:views/admin/categories.php'
			],
			'$data' => [
				'categories' => $categories,
				'config' => $config
			]
		];
	}

	/**
	 * @Access("groups: manage all groups")
	 * @Route("/categories/create")
	 */
	public function categoriesCreateAction()
	{
		$config = $this->config;

		$categoriesData = GroupCategory::findAll();
		$categories = [];

		foreach ($categoriesData as $category)
		{
			$categories[] = $category;
		}

		return [
			'$view' => [
				'title' => 'Create Group Categories',
				'name' => 'groups:views/admin/categories/create.php'
			],
			'$data' => [
				'categories' => $categories,
				'config' => $config
			]
		];
	}
}
