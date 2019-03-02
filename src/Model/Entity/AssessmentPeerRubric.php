<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AssessmentPeerRubric Entity
 *
 * @property int $id
 * @property float $weight
 * @property float $score
 * @property string $comments
 * @property int $rubric_id
 * @property int $assessment_peer_id
 *
 * @property \App\Model\Entity\Rubric $rubric
 * @property \App\Model\Entity\AssessmentPeer $assessment_peer
 */
class AssessmentPeerRubric extends Entity
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
        'score' => true,
        'comments' => true,
        'rubric_id' => true,
        'assessment_peer_id' => true,
        'rubric' => true,
        'assessment_peer' => true,
        'label' => true
    ];
}
