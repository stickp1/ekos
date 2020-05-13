<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Sale Entity
 *
 * @property int $id
 * @property int $users_id
 * @property string $value
 * @property string $status
 * @property string $receipt
 * @property string $invoice
 *
 * @property \App\Model\Entity\User $user
 */
class Sale extends Entity
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
        'value' => true,
        'status' => true,
        'receipt' => true,
        'invoice' => true,
        'moloni_id' => true,
        'user' => true
    ];
}
