<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UsersQuestion Entity
 *
 * @property int $id
 * @property int $question_id
 * @property int $user_id
 * @property int $correct
 * @property \Cake\I18n\FrozenTime $last_time
 * @property int $favorite
 *
 * @property \App\Model\Entity\Question $question
 * @property \App\Model\Entity\User $user
 */
class UsersQuestion extends Entity
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
        'question_id' => true,
        'user_id' => true,
        'correct' => true,
        'last_time' => true,
        'favorite' => true
    ];
}
