<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\Behavior\TreeBehavior;

/**
 * ThemeMessage Entity
 *
 * @property int $id
 * @property int $parent
 * @property int $left
 * @property int $right
 * @property int $theme_id
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime $date
 * @property int $upvotes
 * @property string $title
 * @property string $message
 *
 * @property \App\Model\Entity\Theme $theme
 * @property \App\Model\Entity\User $user
 */
class ThemeMessage extends Entity
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

    //protected $_virtual = [
    //    'children'
    //];

    protected $_accessible = [
        'theme_id' => true,
        'user_id' => true,
        'date_created' => true,
        'date_last' => true,
        'upvotes' => true,
        'title' => true,
        'message' => true
    ];

    //protected function _getChildren() 
    //{
    //    return TreeBehavior::childCount($this);
    //}
}
