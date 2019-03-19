<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Invite Entity
 *
 * @property int $id
 * @property string $email
 * @property string $hash
 * @property bool $confirm
 * @property int $team_id
 *
 * @property \App\Model\Entity\Team $team
 */
class Invite extends Entity
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
        'email' => true,
        'hash' => true,
        'confirm' => true,
        'team_id' => true,
        'team' => true
    ];
}
