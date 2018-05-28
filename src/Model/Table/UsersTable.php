<?php

namespace App\Model\Table;

use Cake\Log\Log;
use Cake\ORM\Table;

class UsersTable extends Table
{

 public function initialize(array $config)
 {
  $this->addBehavior('Timestamp');
  $this->hasMany('ADmad/SocialAuth.SocialProfiles');
  $this->hasMany('Students');
 }

 public function getUser(\Cake\Datasource\EntityInterface $profile)
 {

  if (empty($profile->email)) {
   throw new \RuntimeException(__('Could not find email in social profile.'));
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
   throw new \RuntimeException(__('Unable to save new user'));
  }

  return $user;
 }
}
