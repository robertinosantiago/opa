<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use Cake\Datasource\EntityInterface;
use ArrayObject;
use Cake\Log\Log;


/**
 * Assessments Model
 *
 * @property \App\Model\Table\TeamsTable|\Cake\ORM\Association\BelongsTo $Teams
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\AssessmentRubricsTable|\Cake\ORM\Association\HasMany $AssessmentRubrics
 *
 * @method \App\Model\Entity\Assessment get($primaryKey, $options = [])
 * @method \App\Model\Entity\Assessment newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Assessment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Assessment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Assessment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Assessment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Assessment findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AssessmentsTable extends Table
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

        $this->setTable('assessments');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Uploadable');

        $this->belongsTo('Teams', [
            'foreignKey' => 'team_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('AssessmentRubrics', [
            'foreignKey' => 'assessment_id'
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
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        $validator
            ->integer('scale')
            ->requirePresence('scale', 'create')
            ->notEmpty('scale');

        $validator
            ->allowEmpty('labels');

        $validator
            // ->scalar('file')
            // ->maxLength('file', 255)
            ->allowEmpty('file');

        $validator
            ->numeric('maximum_score')
            ->requirePresence('maximum_score', 'create')
            ->notEmpty('maximum_score');

        $validator
            ->scalar('status')
            ->maxLength('status', 255)
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->dateTime('startAt')
            ->requirePresence('startAt', 'create')
            ->notEmpty('startAt');

        $validator
            ->dateTime('endAt')
            ->requirePresence('endAt', 'create')
            ->notEmpty('endAt');

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
        $rules->add($rules->existsIn(['team_id'], 'Teams'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options) {
      if (isset($entity->file['name']) && !empty($entity->file['name'])) {
        $entity->file = $this->upload($entity->file);
      }
    }
}
