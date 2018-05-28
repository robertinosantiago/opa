<?php

/**
 * @author Robertino Mendes Santiago Junior
 */

namespace App\Model\Table;

use Cake\ORM\Table;

/**
 * Disciplines Table
 */
class DisciplinesTable extends Table {

    public function initialize(array $config) {
        $this->addBehavior('Timestamp');

        $this->hasMany('Teams');
    }

}