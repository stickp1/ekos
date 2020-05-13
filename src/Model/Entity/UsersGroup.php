<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UsersGroup Entity
 *
 * @property int $id
 * @property int $groups_id
 * @property int $groups_courses_id
 * @property int $users_id
 *
 * @property \App\Model\Entity\Group $group
 * @property \App\Model\Entity\User $user
 */
class UsersGroup extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'groups_id' => true,
        'groups_courses_id' => true,
        'users_id' => true,
        'group' => true,
        'user' => true
    ];
}
