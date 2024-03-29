<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AssessmentPeer Entity
 *
 * @property int $id
 * @property string $comments
 * @property int $peer_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Peer $peer
 * @property \App\Model\Entity\AssessmentPeerRubric[] $assessment_peer_rubrics
 */
class AssessmentPeer extends Entity
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
        'comments' => true,
        'peer_id' => true,
        'created' => true,
        'modified' => true,
        'peer' => true,
        'score' => true,
        'assessment_peer_rubrics' => true
    ];
}
