<?php

namespace brandonjames\groups\Controller;

use \Pagekit\Application as App;
use \Pagekit\User\Model\User;
use brandonjames\groups\Model\GroupCategory as GroupCategory;
use brandonjames\groups\Model\GroupMember as GroupMember;

/**
 * @Access("groups: manage own groups || groups: manage all groups")
 * @Route("/")
 */
class GroupCategoriesApiController
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

    // Category stuff

    /**
     * @Route("/", methods="POST")
     * @Request({"new_category":"array"}, csrf=true)
     * @Access("groups: create groups")
     */
    public function createCategoriesAction($new_category)
    {
		if (App::user()->hasAccess('groups: manage all groups'))
		{
	        if (isset($new_category['name']))
	        {
	            $groupCategory = new GroupCategory();
	            $groupCategory->user_id = App::user()->id;

				$new_category['can_make_events'] = 0;
				$new_category['times_are_on_calendar'] = 0;
				$new_category['created'] = date("Y-m-d H:i:s");
				$new_category['modified'] = date("Y-m-d H:i:s");

	            $groupCategory->save($new_category);

	            return [
	                'message' => $groupCategory->name . ' was created.',
	                'category' => $groupCategory
	            ];
	        }

        	return [ 'error' => true, 'message' => 'The category does not have a name' ];
		}

		App::abort(403, __('You do not have permission to delete a group category'));
    }

    /**
     * @Route("/{id}", methods="DELETE")
     * @Request({"id": "int"}, csrf=true)
	 * @Access("groups: manage all groups")
     */
	public function deleteAction($id)
	{
		if (App::user()->hasAccess('groups: manage all groups'))
		{
			$groupCategory = GroupCategory::find($id);
			$groupCategoryName = $groupCategory->name;

			if (isset($groupCategoryName))
			{
				// Delete the group category because it exists

				$groupCategory->delete();

				return [
					'message' => $groupCategoryName . ' was deleted.'
				];

			}
		}

		App::abort(403, __('You do not have permission to delete a group category'));
	}

	/**
	 * @Route("/{id}")
	 * @Method({"GET", "PUT"})
	 * @Request({"group_category":"array", "id":"int"}, csrf=true)
	 * @Access("groups: manage all groups")
	 */
	public function saveAction($group_category, $id)
	{
		if (App::user()->hasAccess('groups: manage all groups'))
		{
			$groupCategory = GroupCategory::find($id);

			$groupCategoryName = $groupCategory->name;

			if (isset($groupCategoryName))
			{
				$groupCategory->save($group_category);

				return [
					'message' => $groupCategory->name . ' was updated.'
				];
			}

			App::abort(403, __('You do not have permission to update group categories.'));

		}

		App::abort(404, __('This group category does not exist.'));
	}
}
