<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Questions Model
 * @mixin \Cake\ORM\Behavior\TreeBehavior
 */
class QuestionsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->addBehavior('Tree');

        $this->belongsTo('ParentQuestions', [
            'className' => 'Questions',
            'foreignKey' => 'parent_id'
        ]);
        $this->belongsTo('Rubrics', [
            'foreignKey' => 'rubric_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('ChildQuestions', [
            'className' => 'Questions',
            'foreignKey' => 'parent_id'
        ]);
    }


}
