<?php

namespace Drupal\avatars_gravatar;

use Drupal\avatars\Event\AvatarKitEvents;
use Drupal\avatars\Event\AvatarKitServiceDefinitionAlterEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\avatars_gravatar\Plugin\Avatars\Service\Gravatar;

/**
 * Used to alter avatar service plugin definitions.
 *
 * @package Drupal\avatars_gravatarAl
 */
class AvatarsGravatarAvatarServicePluginInfoAlter implements EventSubscriberInterface {

  /**
   * Alter  avatar service plugin definitions.
   *
   * @param \Drupal\avatars\Event\AvatarKitServiceDefinitionAlterEvent $event
   *   The event.
   */
  public function alterServiceInfo(AvatarKitServiceDefinitionAlterEvent $event) {
    $definitions = $event->getDefinitions();

    $ids = [
      'gravatar_identicon',
      'gravatar_monster',
      'gravatar_mystery_man',
      'gravatar_retro',
      'gravatar_universal',
      'gravatar_wavatar',
    ];

    foreach ($ids as $id) {
      $id = 'avatars_ak_common:' . $id;
      // Avatar Kit service plugin manager will pick up common services simply by
      // making these services use a real class instead of an abstract.
      $definitions[$id]['class'] = Gravatar::class;

      // Need to add a dependency to this module, since once this module is
      // uninstalled, the common deriver will revert to the abstract class, which
      // the plugin manager ignores.
      $definitions[$id]['config_dependencies']['module'][] = 'avatars_gravatar';
    }

    $event->setDefinitions($definitions);
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[AvatarKitEvents::PLUGIN_SERVICE_ALTER][] = ['alterServiceInfo'];
    return $events;
  }

}
