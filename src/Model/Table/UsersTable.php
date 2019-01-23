<?php

namespace App\Model\Table;

use Cake\ORM\Table;

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
}
