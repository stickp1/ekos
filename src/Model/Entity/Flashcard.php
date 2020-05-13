<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Flashcard Entity
 *
 * @property int $id
 * @property string $front
 * @property string $verse
 * @property int $theme_id
 *
 * @property \App\Model\Entity\Theme $theme
 * @property \App\Model\Entity\FlashcardsUser7[] $flashcards_user7
 */
class Flashcard extends Entity
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
        'front' => true,
        'verse' => true,
        'theme_id' => true,
        'course_id' => true
    ];
}
