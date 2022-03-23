<?php

declare(strict_types = 1);

namespace Drupal\social_eu_login\EventSubscriber;

use Drupal\cas\Event\CasPostLoginEvent;
use Drupal\cas\Service\CasHelper;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Url;
use Drupal\social_eu_login\EuLoginAttributesHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\social_eu_login\Form\EULoginSettingsForm;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Copies the EU Login attributes to user fields.
 */
class EuLoginAttributesToAccountFieldsSubscriber implements EventSubscriberInterface {

  /**
   * Entity Type Manager service.
   */
  protected EntityTypeManagerInterface $entityTypeManager;

  /**
   * The config factory.
   */
  protected ConfigFactoryInterface $configFactory;

  /**
   * Construct EuLoginAttributesToAccountFieldsSubscriber class.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   Entity Type Manager service.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The config factory service.
   */
  public function __construct(
    EntityTypeManagerInterface $entity_type_manager,
    ConfigFactoryInterface $configFactory
  ) {
    $this->entityTypeManager = $entity_type_manager;
    $this->configFactory = $configFactory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container): self {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      CasHelper::EVENT_POST_LOGIN => 'updateUserData',
    ];
  }

  /**
   * Updates the user data based on the information taken from EU Login.
   *
   * @param \Drupal\cas\Event\CasPostLoginEvent $event
   *   The triggered event.
   */
  public function updateUserData(CasPostLoginEvent $event): void {
    $attributes = EuLoginAttributesHelper::convertEuLoginAttributesToFieldValues($event->getCasPropertyBag()->getAttributes());

    // The list of ignored fields.
    $ignored_fields = (array) $this->configFactory->get(EULoginSettingsForm::CONFIG_NAME)->get('disabled_fields_sync');

    $account = $event->getAccount();

    /** @var \Drupal\profile\ProfileStorageInterface $profile_storage */
    $profile_storage = $this->entityTypeManager->getStorage('profile');
    /** @var \Drupal\profile\Entity\ProfileInterface $profile */
    $profile = $profile_storage->loadByUser($account, 'profile');

    // Loop through the different attributes.
    foreach ($attributes as $entity_type => $properties) {
      // For the user entity type we will be updating the account object.
      if ($entity_type === 'user') {
        foreach ($properties as $name => $value) {
          if (in_array($name, $ignored_fields)) {
            continue;
          }
          $account->set($name, $value);
        }
      }

      // For the profile entity type we will be updating the profile object.
      if ($entity_type === 'profile') {
        foreach ($properties as $name => $value) {
          if (in_array($name, $ignored_fields)) {
            continue;
          }
          $profile->set($name, $value);
        }
      }
    }

    // Save both the user account and profile.
    $account->save();
    $profile->save();

    // Redirect user to the front page instead of user stream.
    $front_url = Url::fromRoute('<front>')->toString();
    $response = new RedirectResponse($front_url);
    $response->send();
  }

}
