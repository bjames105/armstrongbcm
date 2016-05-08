<?php

namespace brandonjames\groups\Controller;

use \Pagekit\Application as App;
use \Pagekit\User\Model\User;
use brandonjames\groups\Model\Group as Group;
use brandonjames\groups\Model\GroupCategory as GroupCategory;

class SiteController
{
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
     * @Route("/")
     * @Route("/{id}", name="id", requirements={"id" = "\d+"})
     */
	public function indexAction($id = null)
	{
		$displayMessage = $this->config['displayMessage'];
		$title = 'Groups';
		$user_can_create_group = App::user()->hasAccess('groups: create groups');
		$groupCategoriesData = GroupCategory::findAll();
		$group_categories = [];
		$current_user = (App::user()->isAuthenticated()) ? App::user() : null;

		foreach ($groupCategoriesData as $groupCategory)
		{
			$group_categories[] = $groupCategory;
		}

		if (!is_null($id)) {
			$group = Group::query()->where('id = ?', [$id])->related('user')->related('group_category')->related('group_members')->first();

			$user_can_edit_group = (App::user()->hasAccess('groups: manage all groups')
				|| (App::user()->hasAccess('groups: manage own groups') && $group->user_id == App::user()->id)) ? true : false;
			$user_is_not_in_group = true;

			foreach ($group->group_members as $member)
			{
				if ($member->user_id == App::user()->id
					&& $user_is_not_in_group)
				{
					$user_is_not_in_group = false;
				}
			}

			$user_can_join_group = (App::user()->isAuthenticated() && $user_is_not_in_group);
			$title = $group->name . ' | ' . $title;

			return [
				'$view' => [
					'title' => $title,
					'name' => 'groups:views/group.php'
				],
				'user_can_edit_group' => $user_can_edit_group,
				'user_can_create_group' => $user_can_create_group,
				'user_can_join_group' => $user_can_join_group,
				'$data' => [
					'group_categories' => $group_categories,
					'current_user' => $current_user,
					'group' => $group
				]
			];
		}

		$groupsData = Group::query()->related('user')->related('group_category')->related('group_members')->get();
		$groups = [];

		foreach ($groupsData as $group)
		{
			$groups[] = $group;
		}

		return [
			'$view' => [
				'title' => 'Groups',
				'name' => 'groups:views/index.php'
			],
			'user_can_create_group' => $user_can_create_group,
			'$data' => [
				'groups' => $groups,
				'group_categories' => $group_categories,
				'currentUser' => $current_user,
				'displayMessage' => $displayMessage
			]
		];
	}

	/**
	 * @Access("groups: create groups")
	 */
	public function createAction()
	{
		$user_can_create_group = App::user()->hasAccess('groups: create groups');
		$groupCategoriesData = GroupCategory::findAll();
		$group_categories = [];
		$current_user = (App::user()->isAuthenticated()) ? App::user() : null;

		foreach ($groupCategoriesData as $groupCategory)
		{
			$group_categories[] = $groupCategory;
		}

		$group = [
			'active_day' => 'M',
			'active_time' => '12:00',
			'gender' => 'c',
			'max_members' => 0,
			'user' => $current_user,
			'group_members' => []
		];

		return [
			'$view' => [
				'title' => 'Create a New Group',
				'name' => 'groups:views/create.php'
			],
			'user_can_create_group' => $user_can_create_group,
			'$data' => [
				'group' => $group,
				'group_categories' => $group_categories,
				'currentUser' => $current_user
			]
		];
	}
}
