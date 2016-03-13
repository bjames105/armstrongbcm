<?php

namespace brandonjames\groups\Controller;

use \Pagekit\Application as App;
use \Pagekit\User\Model\User;
use brandonjames\groups\Model\Group as Group;

/**
 * @Access("groups: manage own groups || groups: manage groups")
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
			'message' => 'Found ' . sizeof($groups) . ' groups.',
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

			// user without universal access can only edit their own groups
			if (!App::user()->hasAccess('groups: manage all groups') &&
				$group->user_id !== App::user()->id)
			{
                App::abort(403, __('Access denied.'));
			}
			else if (App::user()->hasAccess('groups: manage own groups'))
			{
				$group->delete();

				return [
					'message' => $groupName . ' was deleted.'
				];
			}

			// user without universal access is not allowed to assign groups to other users
			if (App::user()->hasAccess('groups: manage all groups'))
			{
				$group->delete();
			}
		}

		return [
			'message' => $groupName . ' was deleted.'
		];
	}

    /**
     * @Route("/", methods="POST")
     * @Request({"new_group":"array"}, csrf=true)
     * @Access("groups: create groups")
     */
	public function addAction($new_group)
	{
		if (isset($new_group['name']))
		{
			// Create the group
			$group = new Group();
			$new_group['user_id'] = App::user()->id;
			$new_group['created'] = date("Y-m-d H:i:s");
			$group->save($new_group);

			return [
				'message' => $group->name . ' was created.', 'group' => $group
			];
		}

		return [
			'message' => 'The group does not contain the proper fields.'
		];

	}

	/**
     * @Route("/", methods="PUT")
     * @Request({"group":"array"}, csrf=true)
     */
	public function saveAction($group)
	{
		if (isset($group['id']))
		{
			$id = $group['id'];
			$group = Group::find($id);

			// validate the fields
			if (isset($group->name))
			{
				// Update the group
				$group->save($group);

				return [
					'message' => $group->name . ' was updated.'
				];
			}
		}

		return [
			'message' => 'The group does not contain the proper fields.'
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
