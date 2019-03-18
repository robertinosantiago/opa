<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Peers Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\AssessmentsTable|\Cake\ORM\Association\BelongsTo $Assessments
 * @property \App\Model\Table\AssessmentUsersTable|\Cake\ORM\Association\BelongsTo $AssessmentUsers
 *
 * @method \App\Model\Entity\Peer get($primaryKey, $options = [])
 * @method \App\Model\Entity\Peer newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Peer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Peer|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Peer|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Peer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Peer[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Peer findOrCreate($search, callable $callback = null, $options = [])
 */
class PeersTable extends Table
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

        $this->setTable('peers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'appraiser_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Assessments', [
            'foreignKey' => 'assessment_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('AssessmentUsers', [
            'foreignKey' => 'assessment_user_id'
        ]);
        $this->hasMany('AssessmentPeers', [
            'foreignKey' => 'peer_id'
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
            ->allowEmpty('id', 'create')
            ->allowEmpty('assessment_user_id', 'create');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['appraiser_id'], 'Users'));
        $rules->add($rules->existsIn(['assessment_id'], 'Assessments'));
        $rules->add($rules->existsIn(['assessment_user_id'], 'AssessmentUsers'));

        return $rules;
    }

    public function findPeers(Query $query, array $options) {
      $user_id = (array_key_exists('user_id', $options)) ? $options['user_id'] : NULL;
      $appraiser_id = (array_key_exists('appraiser_id', $options)) ? $options['appraiser_id'] : NULL;
      $assessment_id = (array_key_exists('assessment_id', $options)) ? $options['assessment_id'] : NULL;

      // $query->select(['COUNT(Peers.id)']);

      if ($user_id) $query->where(['Peers.user_id' => $user_id]);

      if ($appraiser_id) $query->where(['Peers.appraiser_id' => $appraiser_id]);

      if ($assessment_id) $query->where(['Peers.assessment_id' => $assessment_id]);

      // $query->group(['Peers.user_id']);

      return $query;
    }
}
