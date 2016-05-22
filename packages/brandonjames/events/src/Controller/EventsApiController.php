<?php

namespace brandonjames\events\Controller;

use \Pagekit\Application as App;
use \Pagekit\User\Model\User;

/**
 * @Access("events: manage own events || events: manage all events")
 * @Route("/")
 */
class EventsApiController
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

}
