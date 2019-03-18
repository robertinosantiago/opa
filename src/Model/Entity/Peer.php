<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Peer Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $appraiser_id
 * @property int $assessment_id
 * @property int $assessment_user_id
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Assessment $assessment
 * @property \App\Model\Entity\AssessmentUser $assessment_user
 */
class Peer extends Entity
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
        'user_id' => true,
        'appraiser_id' => true,
        'assessment_id' => true,
        'assessment_user_id' => true,
        'user' => true,
        'assessment' => true,
        'assessment_user' => true
    ];
}
