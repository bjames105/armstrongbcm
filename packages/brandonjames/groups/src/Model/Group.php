<?php

namespace brandonjames\groups\Model;

use \Pagekit\Application as App;
use \Pagekit\Database\ORM\ModelTrait;
use \Pagekit\System\Model\DataModelTrait;
use \Pagekit\User\Model\AccessModelTrait;
use \Pagekit\User\Model\User;

/**
 * @Entity(tableClass="@group")
 */
class Group implements \JsonSerializable
{
    use AccessModelTrait, DataModelTrait, ModelTrait;
	
	public function __construct()
    {
        $this->group_category = new GroupCategory();
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
	
    /**
     * @BelongsTo(targetEntity="Pagekit\User\Model\User", keyFrom="user_id")
     */
    public $user;
	
	/**
     * @OneToOne(targetEntity="brandonjames\groups\Model\GroupCategory")
     * @JoinColumn(name="group_category_id", referencedColumnName="id")
     */
    public $group_category;
	
	/** @var array */
    protected static $properties = [
        'author' => 'getAuthor',
        'group_category' => 'getGroupCategory'
    ];

    public function getAuthor()
    {
        return $this->user ? $this->user->username : null;
    }
	
	public function getGroupCategory() {
		return $this->group_category ? $this->group_category : null;
	}
}
