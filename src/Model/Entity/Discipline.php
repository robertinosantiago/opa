<?php

/**
 * @author Robertino Mendes Santiago Junior
 */

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Discipline Entity
 */
class Discipline extends Entity {
    
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
