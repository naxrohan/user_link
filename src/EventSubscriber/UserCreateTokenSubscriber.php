<?php

namespace Drupal\user_link\EventSubscriber;

use Drupal;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ImmutableConfig;
use Drupal\user\Entity\User;
use Drupal\user_link\AuthToken;
use Drupal\user_link\Event\UserLoginEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Description of UserCreateToken
 *
 * @author Rohan
 */
class UserCreateTokenSubscriber implements EventSubscriberInterface {

    /**
     * User settings config instance.
     *
     * @var ImmutableConfig
     */
    private $userSettings;

    /**
     * UserRegistrationSubscriber constructor.
     *
     * @param ConfigFactoryInterface $config_factory
     *   The configuration factory.
     */
    public function __construct(ConfigFactoryInterface $config_factory) {
        $this->userSettings = $config_factory->get('user.settings');
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents() {
        return [
            UserLoginEvent::REGISTRATION_DONE => 'setNewAuthToken',
            UserLoginEvent::USER_LOGIN => 'userLoginEvent'
        ];
    }

    public function setNewAuthToken(UserLoginEvent $event) {
        $passid = $event->getPassedId();
        
        Drupal::messenger()->addMessage("New AuthToken has been assigned--{$passid}");
       
        $tokenGen = new AuthToken();
        $tokenGen->setTokeForUser($passid);
    }

    public function userLoginEvent(UserLoginEvent $event) {
        $passid = $event->getPassedId();
        //Drupal::messenger()->addMessage("LoginEvent called--{$passid}");
    }

}
