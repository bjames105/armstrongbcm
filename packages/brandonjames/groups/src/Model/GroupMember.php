<?php

namespace brandonjames\groups\Model;

use \Pagekit\Application as App;
use \Pagekit\Database\ORM\ModelTrait;
use \Pagekit\User\Model\User;

/**
 * @Entity(tableClass="@group_members")
 */
class GroupMember implements \JsonSerializable
{
    use ModelTrait;

	/** @Column(type="integer") @Id */
	public $id;

    /** @Column(type="integer") */
    public $user_id;

    /** @Column(type="integer") */
    public $group_id;

    /** @BelongsTo(targetEntity="\Pagekit\User\Model\User", keyFrom="user_id", keyTo="id") */
    public $user;

	/** @BelongsTo(targetEntity="\brandonjames\groups\Model\Group", keyFrom="group_id", keyTo="id") */
    public $group;

    /** @Column(type="datetime") */
    public $created;

    public function jsonSerialize()
    {
        $data = [];
        $data['user'] = $this->user;

        return $this->toArray($data);
    }
}
