<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Rubrics Model
 */
class RubricsTable extends Table
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

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);

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
        ->select(['Rubrics.id', 'Rubrics.title', 'Rubrics.description']);

      if ($user_id)
        $query->where(['Rubrics.user_id' => $user_id]);

      if ($search)
        $query->where(['OR' => [
          'Rubrics.title LIKE' => '%' . $search .'%',
          'Rubrics.description LIKE' => '%' . $search .'%'
          ]]);

      $query->order(['Rubrics.title' => 'ASC']);

      $query->limit($length);
      $query->page($start);

      return $query;
    }


}
