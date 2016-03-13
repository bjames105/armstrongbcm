<?php

namespace brandonjames\groups\Model;

use \Pagekit\Application as App;
use \Pagekit\Database\ORM\ModelTrait;
use \Pagekit\User\Model\User;

/**
 * @Entity(tableClass="@group_category")
 */
class GroupCategory implements \JsonSerializable
{
    use ModelTrait;

	/** @Column(type="integer") @Id */
	public $id;

    /** @Column(type="integer") */
    public $user_id;

    /** @Column(type="text") */
    public $name;

    /** @Column(type="text") */
    public $description;

    /** @Column(type="integer") */
    public $can_make_events;

    /** @Column(type="integer") */
    public $times_are_on_calendar;

    /** @Column(type="datetime") */
    public $created;

    /** @Column(type="datetime") */
    public $modified;
}
