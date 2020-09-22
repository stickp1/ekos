<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\Behavior\TreeBehavior;

/**
 * ThemeMessage Entity
 *
 * @property int $id
 * @property int $video_id
 * @property int $theme_id
 * @property int $course_id
 *
 */
class VideoThemes extends Entity
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
        'video_id' => true,
        'theme_id' => true,
        'course_id' => true
    ];

    //protected function _getChildren() 
    //{
    //    return TreeBehavior::childCount($this);
    //}
}