<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Theme Entity
 *
 * @property int $id
 * @property string $name
 * @property int $courses_id
 * @property bool $active
 * @property string $bibliography
 * @property bool $MD
 * @property bool $D
 * @property bool $P
 * @property bool $T
 * @property bool $GD
 *
 * @property \App\Model\Entity\Course $course
 */
class Theme extends Entity
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
        'name' => true,
        'active' => true,
        'bibliography_1' => true,
        'bibliography_2' => true,
        'prefered' => true,
        'MD' => true,
        'D' => true,
        'P' => true,
        'T' => true,
        'GD' => true,
        'courses_id' => true,
        'area' => true,
        'relevance' => true,
        'domain' => true
    ];
}
