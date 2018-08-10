<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Question Entity
 *
 * @property int $id
 * @property string $type
 * @property string $description
 * @property array $values
 * @property int $parent_id
 * @property int $lft
 * @property int $rght
 * @property int $rubric_id
 *
 * @property \App\Model\Entity\ParentQuestion $parent_question
 * @property \App\Model\Entity\Rubric $rubric
 * @property \App\Model\Entity\ChildQuestion[] $child_questions
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
        'type' => true,
        'description' => true,
        'options' => true,
        'parent_id' => true,
        'lft' => true,
        'rght' => true,
        'rubric_id' => true,
        'parent_question' => true,
        'rubric' => true,
        'child_questions' => true
    ];
}
