<?php
namespace Drupal\user_link;

use Drupal;
use Drupal\user\Entity\User;

/**
 * AuthToken class to handle tokens 
 */
class AuthToken {

    private $token = null;
    private $token_length;

    function __construct(int $length = 32) {
        $this->token = null;
        $this->token_length = $length;
    }

    public function createToken() {
        $length = $this->token_length;
        $this->token = rand(intval(pow(10, $length-1)), intval(pow(10, $length))-1);
    }

    public function getNewToken() {
        self::createToken();
        
        return $this->token;
    }

    public function assignToken() {
        $ids = Drupal::entityQuery('user')
            ->condition('status', 1)
//            ->condition('roles', 'administrator', '!=')
            ->execute();
        
        $users = User::loadMultiple($ids);
        print("\n Total Users::". count($users));
        
        foreach ($users as $user){
            //todo: check if the topken already exists
            
            // updated the auth token fields for the user
            $randToken = $this->getNewToken();
            $user->set('field_auth_token2', $randToken);
            print("\n Token Updated..");
        }
        
    }
}