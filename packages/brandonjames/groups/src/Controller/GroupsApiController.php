<?php

namespace brandonjames\groups\Controller;

use \Pagekit\Application as App;
use \Pagekit\User\Model\User;
use brandonjames\groups\Model\Group as Group;
use brandonjames\groups\Model\GroupMember as GroupMember;

/**
 * @Access("groups: manage own groups || groups: manage all groups")
 * @Route("/")
 */
class GroupsApiController
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
     * @Route("/", methods="GET")
     */
	public function getAction()
	{
		$groupData = Group::findAll();
		$groups = [];

		foreach ($groupData as $group)
		{
			$groups[] = $group;
		}

		return [
			'message' => 'Found ' . sizeof($groups) . ' groups',
			'groups' => $groups
		];
	}

    /**
     * @Route("/{id}", methods="DELETE")
     * @Request({"id": "int"}, csrf=true)
     */
	public function deleteAction($id)
	{
		$group = Group::find($id);
		$groupName = $group->name;

		if (isset($groupName))
		{
			// Delete the group because it exists

			if (App::user()->hasAccess('groups: manage own groups'))
			{
				// An administrator should have access to both managing their
				// own groups and all groups.

				// User with access to their own groups is only allowed to delete
				// the group if it's their own group.

				if (App::user()->hasAccess('groups: manage all groups')
					|| $group->user_id = App::user()->id)
				{
					// Remember to override this method to include deleting the members
					$group->delete();

					return [
						'message' => $groupName . ' was deleted.'
					];
				}

			}

		}

		App::abort(403, __($groupName . ' does not belong to you. You may not delete it.'));
	}

    /**
     * @Route("/", methods="POST")
     * @Request({"new_group":"array"}, csrf=true)
     * @Access("groups: create groups")
     */
	public function createAction($new_group)
	{
		$group = new Group();
		if (isset($new_group['name'])
			&& isset($new_group['group_category_id']))
		{
			// Create the group
			$group = new Group();
			$new_group['user_id'] = App::user()->id;
			$new_group['created'] = date("Y-m-d H:i:s");
			$group->save($new_group);

			$groupMember = new GroupMember();
			$groupMember->user_id = App::user()->id;
			$groupMember->group_id = $group->id;
			$groupMember->save();

			return [
				'message' => $group->name . ' was created.',
				'group' => $group
			];
		}

		return [ 'error' => true, 'message' => 'The group was not input correctly. Vague, eh?' ];

	}

	/**
	 * @Route("/{id}")
	 * @Method({"GET", "PUT"})
	 * @Request({"group":"array", "id":"int"}, csrf=true)
 	 * @Access("groups: manage own groups")
	 */
	public function saveAction($group, $id)
	{
		$groupData = Group::find($id);

		$groupData->save($group);

		return [
			'message' => $group['name'] . ' was updated.'
		];

	}

	/**
	 * @Route("/{id}/join")
	 * @Method({"GET"})
	 * @Request({"id":"int"}, csrf=true)
	 * @Access("groups: join groups")
	 */
	public function joinGroupAction($id)
	{
		$groupData = Group::find($id);

		if ($groupData)
		{
			if (App::user()->hasPermission('groups: join groups'))
			{
				$groupMember = new GroupMember();
				$groupMember->user_id = App::user()->id;
				$groupMember->group_id = $id;
				$groupMember->save();

				return [
					'message' => 'You have joined ' . $groupData->name,
					'user' => App::user()
				];
			}
			return [
				'message' => 'You do not have permission to join groups'
			];

		}
		return [
			'message' => 'That group does not exist'
		];
	}

	/**
	 * @Route("/{id}/leave")
	 * @Method({"GET"})
	 * @Request({"id":"int"}, csrf=true)
	 * @Access("groups: join groups")
	 */
	public function leaveGroupAction($id)
	{
		$groupData = Group::find($id);

		if ($groupData)
		{
			if (App::user()->hasPermission('groups: join groups'))
			{
				$groupMember = GroupMember::where('user_id = ? AND group_id = ?', [App::user()->id, $id])->first();
				$groupMember->delete();

				return [
					'message' => 'You have left ' . $groupData->name,
					'user' => App::user()
				];
			}
			return [
				'message' => 'You do not have permission to join groups'
			];

		}
		return [
			'message' => 'That group does not exist'
		];
	}

	/**
	 * @Route("/update_settings")
	 * @Method({"GET", "PUT"})
	 * @Request({"config":"array"}, csrf=true)
 	 * @Access("groups: manage all groups")
	 */
	public function updateSettingsAction($config)
	{
		// Before production I need to make sure that no array values are
		// inserted that aren't in the base config.

		foreach ($config as $key => $value)
		{
			App::config('groups')->set($key, $value);
		}

		return [
			'message' => 'The Group application\'s configuration was updated.'
		];
	}

}
