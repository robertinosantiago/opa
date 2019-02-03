<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AssessmentPeerRubrics Model
 *
 * @property \App\Model\Table\RubricsTable|\Cake\ORM\Association\BelongsTo $Rubrics
 * @property \App\Model\Table\AssessmentPeersTable|\Cake\ORM\Association\BelongsTo $AssessmentPeers
 *
 * @method \App\Model\Entity\AssessmentPeerRubric get($primaryKey, $options = [])
 * @method \App\Model\Entity\AssessmentPeerRubric newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AssessmentPeerRubric[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AssessmentPeerRubric|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AssessmentPeerRubric|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AssessmentPeerRubric patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AssessmentPeerRubric[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AssessmentPeerRubric findOrCreate($search, callable $callback = null, $options = [])
 */
class AssessmentPeerRubricsTable extends Table
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

        $this->setTable('assessment_peer_rubrics');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Rubrics', [
            'foreignKey' => 'rubric_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('AssessmentPeers', [
            'foreignKey' => 'assessment_peer_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->numeric('weight')
            ->requirePresence('weight', 'create')
            ->notEmpty('weight');

        $validator
            ->numeric('score')
            ->requirePresence('score', 'create')
            ->notEmpty('score');

        $validator
            ->scalar('comments')
            ->allowEmpty('comments');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['rubric_id'], 'Rubrics'));
        $rules->add($rules->existsIn(['assessment_peer_id'], 'AssessmentPeers'));

        return $rules;
    }
}
