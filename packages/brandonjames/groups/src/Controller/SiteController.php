<?php

namespace brandonjames\groups\Controller;

use \Pagekit\Application as App;
use \Pagekit\User\Model\User;
use brandonjames\groups\Model\Group as Group;

class SiteController
{
	/**
     * @var Module
     */
	protected $groups;

	/**
     * Constructor.
     */
	public function __construct()
	{
		$this->groups = App::module('groups');
	}

	/**
     * @Route("/")
     * @Route("/group/{id}", name="id", requirements={"id" = "\d+"})
     */
	public function indexAction($id = null)
	{
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
				'groups' => $groups
			]
		];
	}
}
