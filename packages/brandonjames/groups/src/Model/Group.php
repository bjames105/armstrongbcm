<?php

namespace brandonjames\groups\Model;

use \Pagekit\Application as App;
use \Pagekit\Database\ORM\ModelTrait;
use \Pagekit\User\Model\User;

/**
 * @Entity(tableClass="@group")
 */
class Group implements \JsonSerializable
{
    use ModelTrait;

    public function __construct()
    {
        $this->group_members = new \Doctrine\Common\Collections\ArrayCollection();
    }

	/** @Column(type="integer") @Id */
	public $id;

    /** @Column(type="string") */
    public $group_category_id;

    /** @Column(type="integer") */
    public $user_id;

    /** @Column(type="text") */
    public $name;

    /** @Column(type="text") */
    public $description;

    /** @Column(type="integer") */
    public $max_members;

    /** @Column(type="string") */
    public $gender;

    /** @Column(type="string") */
    public $active_day;

    /** @Column(type="time") */
    public $active_time;

    /** @Column(type="string") */
    public $location;

    /** @Column(type="text") */
    public $photo;

    /** @Column(type="datetime") */
    public $created;

    /** @Column(type="datetime") */
    public $modified;

    /** @BelongsTo(targetEntity="\Pagekit\User\Model\User", keyFrom="user_id", keyTo="id") */
    public $user;

	/** @BelongsTo(targetEntity="\brandonjames\groups\Model\GroupCategory", keyFrom="group_category_id", keyTo="id") */
    public $group_category;

    /**
     * @HasMany(targetEntity="\brandonjames\groups\Model\GroupMember", keyFrom="id", keyTo="group_id")
     */
    public $group_members;

    public function jsonSerialize()
    {
        $data = [];
        $data['user'] = $this->user;
        $data['group_category'] = $this->group_category;

        $groupMembers = [];

        if (sizeof($this->group_members) > 0)
        {
            foreach ($this->group_members as $member)
            {
                $groupMembers[] = $member->user;
            }
        }

        $data['group_members'] = $groupMembers;

        return $this->toArray($data);
    }
}
