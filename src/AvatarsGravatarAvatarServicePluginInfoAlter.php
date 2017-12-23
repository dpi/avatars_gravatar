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
    // Avatar Kit service plugin manager will pick up common services simply by
    // making these services use a real class instead of an abstract.
    $definitions = $event->getDefinitions();
    $definitions['avatars_ak_common:gravatar_identicon']['class'] = Gravatar::class;
    $definitions['avatars_ak_common:gravatar_monster']['class'] = Gravatar::class;
    $definitions['avatars_ak_common:gravatar_mystery_man']['class'] = Gravatar::class;
    $definitions['avatars_ak_common:gravatar_retro']['class'] = Gravatar::class;
    $definitions['avatars_ak_common:gravatar_universal']['class'] = Gravatar::class;
    $definitions['avatars_ak_common:gravatar_wavatar']['class'] = Gravatar::class;
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
