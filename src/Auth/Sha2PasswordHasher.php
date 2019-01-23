<?php
namespace App\Auth;

use Cake\Auth\AbstractPasswordHasher;

class Sha2PasswordHasher extends AbstractPasswordHasher
{

    public function hash($password)
    {
        return sha1($password);
    }

    public function check($password, $hashedPassword)
    {
        return sha1($password) === $hashedPassword;
    }
}
