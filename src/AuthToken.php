<?php
namespace Drupal\user_link;

use Drupal;
use Drupal\user\Entity\User;

error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * AuthToken class to handle tokens 
 */
class AuthToken {

    private $token = null;
    private $token_length;
    
    /**
     * define the field name
     * @var type
     */
    private $field_name = "field_auth_token";
    
    function __construct(int $length = 32) {
        $this->token = null;
        $this->token_length = $length;
    }

    public function createToken() {
        mt_srand(rand(111111, 999999));
        $count = 0;
        $full_number = '';
        while($count < $this->token_length) {
            $full_number .= sprintf('%02d',mt_rand(01, 99));
            $count++;
        }

        $this->token = $full_number;
    }

    public function getNewToken() {
        self::createToken();
        
        return $this->token;
    }

    public function assignToken() {
        $ids = Drupal::entityQuery('user')
            ->condition('status', 1) // include all active users only
        //    ->condition('roles', 'administrator','=') //exclude/include accounts by role..
            ->execute();

        $users = User::loadMultiple($ids);
        Drupal::messenger()->addMessage("Token updated for --> Total Users::".count($users));

        foreach ($users as $user){
            $uid = $user->id();

            if (!in_array($uid, array(0, 1))) {
                //todo: check if the token already exists
                // var_dump($account->getAuthToken());
                
                $this->setTokeForUser($uid);
            }
        }
    }
    
    public function setTokeForUser(int $user_id) {
        $account = User::load($user_id);

        // updated the auth token fields for the user
        $randToken = $this->getNewToken();
        $account->set($this->field_name, $randToken);
        $account->save();
    }

    /**
     * Lookup toke in db
     * @param type $_token
     * @return type
     */
    public function lookUpToken($_token){
        
        $ids = Drupal::entityQuery('user')
            ->condition('status', 1) // include all active users only
            ->condition('field_auth_token', $_token)
            ->range(0, 1)
            ->execute();
    
        if(count($ids) > 0){
            $uid = array_pop($ids);
            $account = User::load($uid);
            return $account;
        }
        return null;
    }
    
    public function lookUpToken2($_token) {
        $userStorage = \Drupal::service('entity_type.manager')->getStorage('user');
        $users = $userStorage->loadByProperties([
            'field_auth_token' => $_token,
            'status' => 1,
        ]);
        if(!empty($users)){
            return reset($users);
        }
        return null;
    }

}

// $tokenHandler = new AuthToken();
// $tokenHandler->assignToken();
