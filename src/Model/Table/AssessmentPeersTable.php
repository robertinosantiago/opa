<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AssessmentPeers Model
 *
 * @property \App\Model\Table\PeersTable|\Cake\ORM\Association\BelongsTo $Peers
 * @property \App\Model\Table\AssessmentPeerRubricsTable|\Cake\ORM\Association\HasMany $AssessmentPeerRubrics
 *
 * @method \App\Model\Entity\AssessmentPeer get($primaryKey, $options = [])
 * @method \App\Model\Entity\AssessmentPeer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AssessmentPeer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AssessmentPeer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AssessmentPeer|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AssessmentPeer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AssessmentPeer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AssessmentPeer findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AssessmentPeersTable extends Table
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

        $this->setTable('assessment_peers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Peers', [
            'foreignKey' => 'peer_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('AssessmentPeerRubrics', [
            'foreignKey' => 'assessment_peer_id'
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
        $rules->add($rules->existsIn(['peer_id'], 'Peers'));

        return $rules;
    }
}
