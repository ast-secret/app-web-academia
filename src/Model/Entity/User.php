<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity.
 */
class User extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'gym_id' => true,
        'role_id' => true,
        'name' => true,
        'username' => true,
        'password' => true,
        'is_active' => true,
        'mail_temp' => true,
        'token_mail' => true,
        'token_time_exp' => true,
        'gym' => true,
        'role' => true,
        'cards' => true,
        'releases' => true,
    ];

    protected function _setPassword($password){

        return (new DefaultPasswordHasher)->hash($password);
    }
}
