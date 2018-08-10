<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AssessmentRubric Entity
 *
 * @property int $id
 * @property float $weight
 * @property int $assessment_id
 * @property int $rubric_id
 *
 * @property \App\Model\Entity\Assessment $assessment
 * @property \App\Model\Entity\Rubric $rubric
 */
class AssessmentRubric extends Entity
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
        'weight' => true,
        'assessment_id' => true,
        'rubric_id' => true,
        'assessment' => true,
        'rubric' => true
    ];
}
