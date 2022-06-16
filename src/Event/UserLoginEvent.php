<?php

namespace Drupal\user_link\Event;

use Drupal\user\UserInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Description of UserLoginEvent
 *
 * @author Rohan
 */
class UserLoginEvent extends Event {

  const REGISTRATION_DONE = 'user_link.custom_events_user_register';
  const USER_LOGIN = 'user_link.custom_events_user_login';

  /**
   * The user account.
   *
   * @var UserInterface
   */
  public $account;
  
  public $passed_id;

  /**
   * 
   * @param UserInterface $account
   * @param type $id
   */
  public function __construct(UserInterface $account, $id) {
    $this->account = $account;
    $this->passed_id = $id;
  }
  
  public function getPassedId(){
      return $this->passed_id;
  }
}