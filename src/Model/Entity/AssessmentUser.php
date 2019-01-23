<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AssessmentUser Entity
 *
 * @property int $id
 * @property string $file
 * @property string $document_text
 * @property bool $draft
 * @property int $user_id
 * @property int $assessment_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Assessment $assessment
 * @property \App\Model\Entity\Peer[] $peers
 */
class AssessmentUser extends Entity
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
        'file' => true,
        'document_text' => true,
        'draft' => true,
        'user_id' => true,
        'assessment_id' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'assessment' => true,
        'peers' => true
    ];
}
