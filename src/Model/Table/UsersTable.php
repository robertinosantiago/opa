<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Query;

class UsersTable extends Table
{

    /**
     * @param array $config
     */
    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->hasMany('ADmad/SocialAuth.SocialProfiles');
        $this->hasMany('TeamUsers');
    }

    /**
     * @param \Cake\Datasource\EntityInterface $profile
     * @return mixed
     */
    public function getUser(\Cake\Datasource\EntityInterface $profile)
    {

        if (empty($profile->email)) {
            throw new \RuntimeException(__('Não foi possível encontrar um email para este perfil.'));
        }

        $user = $this->find()
            ->where(['email' => $profile->email])
            ->first();

        if ($user) {
            return $user;
        }

        $user = $this->newEntity(['email' => $profile->email]);
        $user->first_name = (!empty($profile->first_name) ? $profile->first_name : '');
        $user->last_name = (!empty($profile->last_name) ? $profile->last_name : '');
        $user->avatar = (!empty($profile->pictureURL) ? $profile->pictureURL : '');
        $user->locale = (!empty($profile->locale) ? $profile->locale : '');
        $user = $this->save($user);

        if (!$user) {
            throw new \RuntimeException(__('Não foi possível salvar este novo usuário'));
        }

        return $user;
    }

    /**
    * Método utilizado para recuperar a listagem de usuários cadastrados
    */
    public function findTable(Query $query, array $options) {
      $team = (array_key_exists('team', $options)) ? $options['team'] : '';
      $search = (array_key_exists('search', $options)) ? $options['search'] : '';
      $start = (array_key_exists('start', $options)) ? $options['start'] : 1;
      $length = (array_key_exists('length', $options)) ? $options['length'] : 20;

      $query
        ->select(['Users.id', 'Users.first_name', 'Users.last_name', 'Users.email', 'Users.avatar']);

      if ($team) {
        // $query->contain('TeamUsers');
        $query->notMatching('TeamUsers', function($q) use ($team){
          return $q->where(['team_id' => $team]);
        });
      }

      if ($search)
        $query->where(['OR' => [
          'Users.first_name LIKE' => '%' . $search .'%',
          'Users.last_name LIKE' => '%' . $search .'%',
          'Users.email LIKE' => '%' . $search .'%',
          ]]);

      $query->order(['Users.first_name' => 'ASC', 'Users.last_name' => 'ASC']);

      $query->limit($length);
      $query->page($start);

      return $query;
    }
}
