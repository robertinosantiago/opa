<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Assessment Entity
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $scale
 * @property array $labels
 * @property string $file
 * @property float $maximum_score
 * @property string $status
 * @property \Cake\I18n\FrozenTime $startAt
 * @property \Cake\I18n\FrozenTime $endAt
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $team_id
 * @property int $user_id
 *
 * @property \App\Model\Entity\Team $team
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\AssessmentRubric[] $assessment_rubrics
 */
class Assessment extends Entity
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
        'title' => true,
        'description' => true,
        'scale' => true,
        'labels' => true,
        'file' => true,
        'maximum_score' => true,
        'status' => true,
        'startAt' => true,
        'endAt' => true,
        'created' => true,
        'modified' => true,
        'team_id' => true,
        'user_id' => true,
        'team' => true,
        'user' => true,
        'assessment_rubrics' => true
    ];
}
