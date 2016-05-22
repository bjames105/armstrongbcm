<?php

namespace brandonjames\groups\Controller;

use \Pagekit\Application as App;
use \Pagekit\User\Model\User;
use brandonjames\groups\Model\Group as Group;
use brandonjames\groups\Model\GroupDiscussion as GroupDiscussion;
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
		$group_data = Group::findAll();
		$groups = [];

		foreach ($group_data as $group)
		{
			$groups[] = $group;
		}

		return [
			'message' => 'Found ' . sizeof($groups) . ' groups',
			'groups' => $groups
		];
	}

	// Settings stuff

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

    /**
     * @Route("/{id}", methods="DELETE")
     * @Request({"id": "int"}, csrf=true)
     */
	public function deleteAction($id)
	{
		$group = Group::query()->related('group_members')->where('id = ?', [$id])->first();

		$groupName = $group->name;

		if (isset($groupName))
		{
			if (App::user()->hasAccess('groups: manage own groups'))
			{
				// An administrator should have access to both managing their
				// own groups and all groups.

				// User with access to their own groups is only allowed to delete
				// the group if it's their own group.

				if (App::user()->hasAccess('groups: manage all groups')
					|| $group->user_id = App::user()->id)
				{
					if (sizeof($group->group_members) > 0)
					{
				        foreach ($group->group_members as $member)
				        {
				            $member->delete();
				        }
					}

					$group->delete();

					return [
						'message' => $groupName . ' was deleted.'
					];
				}

				App::abort(403, __($groupName . ' does not belong to you. You may not delete it.'));

			}

			App::abort(403, __('You do not have permission to delete groups.'));

		}

		App::abort(404, __('This group does not exist.'));
	}

    /**
     * @Route("/", methods="POST")
     * @Request({"new_group":"array"}, csrf=true)
     * @Access("groups: create groups")
     */
	public function createAction($new_group)
	{
		if (App::user()->hasAccess('groups: create groups'))
		{
			if (isset($new_group['name'])
				&& isset($new_group['group_category_id']))
			{
				if (!isset($new_group['gender']))
				{
					if ($new_group['gender'] != 'c'
						|| $new_group['gender'] != 'm'
						|| $new_group['gender'] != 'f')
					{
						$new_group['gender'] = 'c';
					}
				}

				// Create the group
				$group = new Group();
				$new_group['max_members'] = (!isset($new_group['max_members'])) ? 0 : $new_group['max_members'];
				$new_group['gender'] = (!isset($new_group['gender'])) ? 'c' : $new_group['gender'];
				$new_group['slug'] = urlencode($new_group['name']);
				$new_group['user_id'] = App::user()->id;
				$new_group['created'] = new \DateTime();
				$new_group['modified'] = new \DateTime();
				$group->save($new_group);

				$group_member = new GroupMember();
				$group_member->user_id = App::user()->id;
				$group_member->group_id = $group->id;
				$group_member->created = new \DateTime();
				$group_member->save();

				return [
					'message' => $group->name . ' was created.',
					'group' => $group
				];
			}

			App::abort(405, __('The group doesn\'t have a name.'));
		}

		App::abort(403, __('You do not have permission to create groups.'));
	}

	/**
	 * @Route("/{id}")
	 * @Method({"GET", "PUT"})
	 * @Request({"group":"array", "id":"int"}, csrf=true)
 	 * @Access("groups: manage own groups")
	 */
	public function saveAction($group, $id)
	{
		$group_data = $group;
		$group = Group::find($id);

		if (isset($group->name))
		{
			if (App::user()->hasAccess('groups: manage own groups'))
			{
				// An administrator should have access to both managing their
				// own groups and all groups.

				// User with access to their own groups is only allowed to delete
				// the group if it's their own group.

				if (App::user()->hasAccess('groups: manage all groups')
					|| $group->user_id = App::user()->id)
				{

					$group->save($group_data);

					return [
						'message' => $group->name . ' was updated.'
					];
				}

				App::abort(403, __($group->name . ' does not belong to you. You may not update it.'));

			}

			App::abort(403, __('You do not have permission to update groups.'));

		}

		App::abort(404, __('This group does not exist.'));
	}

	/**
	 * @Route("/{id}/join")
	 * @Method({"GET"})
	 * @Request({"id":"int"}, csrf=true)
	 * @Access("groups: join groups")
	 */
	public function joinGroupAction($id)
	{
		$group = Group::query()->related('group_members')->where('id = ?', [$id])->first();

		if ($group)
		{
			if (App::user()->hasPermission('groups: join groups'))
			{
				if ($group->max_members <= sizeof($group->group_members)
					|| $group->max_members == 0
					|| App::user()->hasPermission('groups: manage all groups'))
				{
					$group_member = new GroupMember();
					$group_member->user_id = App::user()->id;
					$group_member->group_id = $id;
					$group_member->created = date("Y-m-d H:i:s");
					$group_member->save();

					return [
						'message' => 'You have joined ' . $group->name,
						'user' => App::user()
					];
				}

				App::abort(400, __('The group has reached a member maximum. You may not join this group.'));
			}

			App::abort(403, __('You do not have permission to join groups.'));
		}

		App::abort(403, __($groupName . ' does not belong to you. You may not delete it.'));
	}

	/**
	 * @Route("/{id}/leave")
	 * @Method({"GET"})
	 * @Request({"id":"int"}, csrf=true)
	 * @Access("groups: join groups")
	 */
	public function leaveGroupAction($id)
	{
		$group_data = Group::find($id);

		if ($group_data)
		{
			if (App::user()->hasPermission('groups: join groups'))
			{
				$group_member = GroupMember::where('user_id = ? AND group_id = ?', [App::user()->id, $id])->first();
				$group_member->delete();

				return [
					'message' => 'You have left ' . $group_data->name,
					'user' => App::user()
				];
			}

			App::abort(403, __('You do not have permission to join groups.'));

		}
		App::abort(404, __('This group does not exist.'));
	}

	/**
	 * @Route("/{id}/discussion")
	 * @Method({"POST"})
	 * @Request({"id":"int", "content":"array"}, csrf=true)
	 */
	public function postDiscussionAction($id, $content)
	{
		$group = Group::query()->where('id = ?', [$id])->related('group_members')->first();

		if ($group)
		{
			if (App::user()->hasPermission('groups: post discussions'))
			{
				if ($group->userIsInGroup(App::user()) || App::user()->hasPermission('groups: manage all groups'))
				{
					$content['user_id'] = App::user()->id;
					$discussion_post = $group->postDiscussion($content);
					$post = GroupDiscussion::query()->where('id = ?', [$discussion_post->id])->related('user')->first();

					return [
						'message' => 'You have posted to the discussion',
						'group_discussion_post' => $post
					];
				}

				App::abort(403, __('You do not have permission to post a group discussion in a group you haven\'t joined.'));
			}

			App::abort(403, __('You do not have permission to post a group discussion.'));

		}
		App::abort(404, __('This group does not exist.'));
	}

	/**
	 * @Route("/kick/{id}")
	 * @Method({"POST"})
	 * @Request({"id":"int"}, csrf=true)
	 */
	public function kickMemberAction($id)
	{
		$member = GroupMember::find($id);

		if ($member)
		{
			$member->delete();
		}
	}

	/**
	 * @Route("/discussion/{id}", methods="DELETE")
	 * @Request({"id":"int"}, csrf=true)
	 */
	public function deleteDiscussionPostAction($id)
	{
		$discussion = GroupDiscussion::find($id);

		if ($discussion)
		{
			if (App::user()->hasPermission('groups: post discussions'))
			{
				if ($discussion->user_id == App::user()->id
					|| App::user()->hasPermission('groups: manage all groups'))
				{
					$discussion->delete();

					return [
						'message' => 'The discussion post was deleted successfully.'
					];
				}
			}

			App::abort(403, __('You do not have permission to delete a group discussion.'));

		}
		App::abort(404, __('This discussion post does not exist.'));
	}

}
