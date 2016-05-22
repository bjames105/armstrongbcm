<?php

namespace brandonjames\groups\Model;

use \Pagekit\Application as App;
use \Pagekit\Database\ORM\ModelTrait;
use \Pagekit\User\Model\User as User;

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

    /** @Column(type="string") */
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

    /**
     * @HasMany(targetEntity="\brandonjames\groups\Model\GroupDiscussion", keyFrom="id", keyTo="group_id")
     */
    public $group_discussion;

    public function userIsInGroup($user)
    {
        foreach ($this->group_members as $member)
        {
            if ($member->user_id == $user->id)
            {
                return true;
            }
        }
        return false;
    }

    public function postDiscussion($discussion_content = [])
    {
        $discussion_content['group_id'] = $this->id;
        $discussion_post = GroupDiscussion::create($discussion_content);
        $discussion_post->save();
        return $discussion_post;
    }

    public function jsonSerialize()
    {
        $data = [];
        $data['user'] = $this->user;
        $data['group_category'] = $this->group_category;

        $group_members = [];
        $group_discussion = [];

        // These group members are basically the User class
        if (sizeof($this->group_members) > 0)
        {
            foreach ($this->group_members as $member)
            {
                $group_members[] = User::find($member->user_id);
            }
        }

        if (sizeof($this->group_discussion) > 0)
        {
            foreach ($this->group_discussion as $post)
            {
                $group_discussion[] = GroupDiscussion::query()->where('id = ?', [$post->id])->related('user')->first();
            }
        }

        $data['group_members'] = $group_members;
        $data['group_discussion'] = $group_discussion;

        return $this->toArray($data);
    }

}
