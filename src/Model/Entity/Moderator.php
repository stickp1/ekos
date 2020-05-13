<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Moderator Entity
 *
 * @property int $users_id
 * @property int $courses_id
 * @property int $id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Course $course
 */
class Moderator extends Entity
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
        'users_id' => true,
        'courses_id' => true,
        'user' => true,
        'course' => true
    ];
}
