<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property int $group_id
 * @property int $group_courses_id
 * @property int $sale_id
 * @property int $sales_users_id
 * @property string $value
 *
 * @property \App\Model\Entity\Group $group
 * @property \App\Model\Entity\Sale $sale
 */
class Product extends Entity
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
        'group_id' => true,
        'group_courses_id' => true,
        'sale_id' => true,
        'sales_users_id' => true,
        'value' => true,
        'group' => true,
        'sale' => true
    ];
}
