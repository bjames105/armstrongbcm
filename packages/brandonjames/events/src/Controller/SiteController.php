<?php

namespace brandonjames\events\Controller;

use \Pagekit\Application as App;
use \Pagekit\User\Model\User;

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
		$this->config = App::module('events')->config();
	}

	/**
     * @Route("/")
     * @Route("/{id}", name="id", requirements={"id" = "\d+"})
     */
	public function indexAction($id = null)
	{
		$title = 'Events';

		return [
			'$view' => [
				'title' => $title,
				'name' => 'events:views/index.php'
			],
			'$data' => [

			]
		];
	}
}
