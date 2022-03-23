<?php

declare(strict_types=1);

namespace Drupal\social_oe_webtools\EventSubscriber;

use Drupal\Core\Session\AccountInterface;
use Drupal\oe_webtools_analytics\AnalyticsEventInterface;
use Drupal\oe_webtools_analytics\Event\AnalyticsEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event subscriber for the Webtools Analytics event.
 */
class SocialWebtoolsAnalyticsSubscriber implements EventSubscriberInterface {

  /**
   * The current user.
   */
  protected AccountInterface $currentUser;

  /**
   * Constructs an SocialWebtoolsAnalyticsSubscriber.
   *
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   The current user.
   */
  public function __construct(AccountInterface $current_user) {
    $this->currentUser = $current_user;
  }

  /**
   * Event listener that track in analytics if a user is authenticated or not.
   *
   * @param \Drupal\oe_webtools_analytics\AnalyticsEventInterface $event
   *   The analytics event.
   */
  public function onAnalyticsEvent(AnalyticsEventInterface $event): void {
    // The result cache should vary based on the user role (authenticated).
    $event->addCacheContexts(['user.roles:authenticated']);

    // When a user is authenticated pass it in the SiteSection parameters.
    // When a user is anonymous, don't pass anything.
    if ($this->currentUser->isAuthenticated()) {
      $event->setSiteSection('authenticated');
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    $events[AnalyticsEvent::NAME][] = ['onAnalyticsEvent'];

    return $events;
  }

}
