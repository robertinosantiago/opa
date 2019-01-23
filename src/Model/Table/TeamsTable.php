<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Log\Log;

/**
 * Teams Model
 *
 * @property \App\Model\Table\DisciplinesTable|\Cake\ORM\Association\BelongsTo $Disciplines
 *
 * @method \App\Model\Entity\Team get($primaryKey, $options = [])
 * @method \App\Model\Entity\Team newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Team[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Team|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Team patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Team[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Team findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TeamsTable extends Table
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

        $this->setTable('teams');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Disciplines', [
            'foreignKey' => 'discipline_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('TeamUsers');
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
            ->uuid('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        $validator
            ->scalar('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

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
        $rules->add($rules->existsIn(['discipline_id'], 'Disciplines'));

        return $rules;
    }

    public function findByUserAuth(Query $query, array $options) {
      $user_id = $options['user_id'];
      return $query
             ->select(['Teams.id', 'Teams.name', 'Disciplines.id', 'Disciplines.name'])
             ->contain(['Disciplines'])
             ->where(['Disciplines.user_id' => $user_id])
             ->order(['Disciplines.name' => 'ASC', 'Teams.name' => 'ASC']);
    }

    /**
    * Return data from teams for dataTable in add form to Assessment
    */
    public function findTable(Query $query, array $options) {
      $user_id = (array_key_exists('user_id', $options)) ? $options['user_id'] : NULL;
      $search = (array_key_exists('search', $options)) ? $options['search'] : '';
      $start = (array_key_exists('start', $options)) ? $options['start'] : 1;
      $length = (array_key_exists('length', $options)) ? $options['length'] : 20;

      $query
        ->select(['Teams.id', 'Teams.name', 'Disciplines.id', 'Disciplines.name'])
        ->contain(['Disciplines']);

      if ($user_id)
        $query->where(['Disciplines.user_id' => $user_id]);

      if ($search)
        $query->where(['OR' => [
          'Teams.name LIKE' => '%' . $search .'%',
          'Disciplines.name LIKE' => '%' . $search .'%'
          ]]);

      $query->order(['Disciplines.name' => 'ASC', 'Teams.name' => 'ASC']);

      $query->limit($length);
      $query->page($start);

      return $query;
    }
}
