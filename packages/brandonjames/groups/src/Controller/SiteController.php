<?php

namespace brandonjames\groups\Controller;

use \Pagekit\Application as App;
use \Pagekit\User\Model\User;
use brandonjames\groups\Model\Group as Group;

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

		if (!is_null($id)) {
			$group = Group::find($id);

			return [
				'$view' => [
					'title' => 'Groups',
					'name' => 'groups:views/group.php'
				],
				'$data' => [
					'group' => $group
				]
			];
		}


		$groups = Group::findAll();

		return [
			'$view' => [
				'title' => 'Groups',
				'name' => 'groups:views/index.php'
			],
			'$data' => [
				'groups' => $groups,
				'displayMessage' => $displayMessage
			]
		];
	}

	/**
	 * @Access("groups: create groups")
	 */
	public function createAction()
	{
		return [
			'$view' => [
				'title' => 'Create a New Group',
				'name' => 'groups:views/create.php'
			]
		];
	}
}
