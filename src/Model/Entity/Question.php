<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Question Entity
 *
 * @property int $id
 * @property int $exam_id
 * @property string $op1
 * @property string $op2
 * @property string $op3
 * @property string $op4
 * @property string $op5
 * @property string $justification
 * @property string $question
 * @property string $correct
 * @property string $theme_id
 * @property int $course_id
 *
 * @property \App\Model\Entity\Exam $exam
 * @property \App\Model\Entity\Theme $theme
 */
class Question extends Entity
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
        'exam_id' => true,
        'op1' => true,
        'op2' => true,
        'op3' => true,
        'op4' => true,
        'op5' => true,
        'a1' => true,
        'a2' => true,
        'a3' => true,
        'a4' => true,
        'a5' => true,
        'justification' => true,
        'question' => true,
        'correct' => true,
        'theme_id' => true,
        'course_id' => true,
        'exam' => true,
        'theme' => true
    ];
}
