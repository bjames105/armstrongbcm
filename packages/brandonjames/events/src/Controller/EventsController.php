<?php
namespace brandonjames\events\Controller;

use \Pagekit\Application as App;
use \Pagekit\User\Model\User;

/**
 * @Access(admin=true)
 *
 */
class EventsController {
	/**
     * @var Module config
     */
	protected $config;

	/**
     * Constructor.
     */
	public function __construct()
	{
		$this->config = App::module('events')->config();
	}

	/**
	 * @Access("events: manage all events")
	 * @Route("/")
	 */
	public function manageAction()
	{

		return [
			'$view' => [
				'title' => 'Administrate Events',
				// 'name' => 'events:views/admin/index.php'
			],
			'$data' => [

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
				'title' => 'Administrate Events',
				// 'name' => 'events:views/admin/settings.php'
			],
			'$data' => [
				'config' => $config
			]
		];
	}

	/**
	 * @Access("events: manage all events")
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
				'name' => 'events:views/admin/categories.php'
			],
			'$data' => [
				'categories' => $categories,
				'config' => $config
			]
		];
	}

	/**
	 * @Access("events: manage all events")
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
				'name' => 'events:views/admin/categories/create.php'
			],
			'$data' => [
				'categories' => $categories,
				'config' => $config
			]
		];
	}
}
