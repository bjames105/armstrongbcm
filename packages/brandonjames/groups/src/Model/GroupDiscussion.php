<?php

namespace brandonjames\groups\Model;

use \Pagekit\Application as App;
use \Pagekit\Database\ORM\ModelTrait;
use \Pagekit\User\Model\User as User;

/**
 * @Entity(tableClass="@group_discussions")
 */
class GroupDiscussion implements \JsonSerializable
{
    use ModelTrait;
    
	/** @Column(type="integer") @Id */
	public $id;

    /** @Column(type="integer") */
    public $user_id;

    /** @Column(type="integer") */
    public $group_id;

    /** @Column(type="integer") */
    public $parent;
    
    /** @Column(type="string") */
    public $content;

    /** @Column(type="datetime") */
    public $created;

    /** @Column(type="datetime") */
    public $modified;

    /** @BelongsTo(targetEntity="\brandonjames\groups\Model\GroupDiscussion", keyFrom="parent", keyTo="id") */
    public $parent_post;

    /** @BelongsTo(targetEntity="\Pagekit\User\Model\User", keyFrom="user_id", keyTo="id") */
    public $user;

	/** @BelongsTo(targetEntity="\brandonjames\groups\Model\Group", keyFrom="group_id", keyTo="id") */
    public $group;

    public function jsonSerialize()
    {
        $data = [];
        $data['user'] = $this->user;

        return $this->toArray($data);
    }
}