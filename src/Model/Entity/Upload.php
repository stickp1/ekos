<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Upload Entity
 *
 * @property int $id
 * @property int $theme_id
 * @property string $url
 * @property string $type
 * @property bool $active
 * @property int $owner
 * @property \Cake\I18n\FrozenTime $timestamp
 * @property string $name
 *
 * @property \App\Model\Entity\Theme $theme
 */
class Upload extends Entity
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
        'theme_id' => true,
        'url' => true,
        'type' => true,
        'active' => true,
        'owner' => true,
        'timestamp' => true,
        'name' => true,
        'theme' => true,
        'city_id' => true
    ];
}
