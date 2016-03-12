<?php

namespace brandonjames\groups\Model;

use \Pagekit\Application as App;
use \Pagekit\Database\ORM\ModelTrait;
use \Pagekit\System\Model\DataModelTrait;
use \Pagekit\User\Model\AccessModelTrait;
use \Pagekit\User\Model\User;

/**
 * @Entity(tableClass="@group_category")
 */
class GroupCategory implements \JsonSerializable
{
    use AccessModelTrait, DataModelTrait, ModelTrait;
	
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
	
    /**
     * @BelongsTo(targetEntity="Pagekit\User\Model\User", keyFrom="user_id")
     */
    protected $user;
	
    protected $groups;

    public function getAuthor()
    {
        return $this->user ? $this->user->username : null;
    }
	
    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        $data = [];

        return $this->toArray($data);
    }
}
