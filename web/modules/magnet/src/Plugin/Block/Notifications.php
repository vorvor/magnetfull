<?php

namespace Drupal\magnet\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Link;
use Drupal\Core\Render\Markup;
use Drupal\Core\Url;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "notifications",
 *   admin_label = @Translation("Notification"),
 *   category = @Translation("Notification")
 * )
 */
class Notifications extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    // TODO: cron run email send.
    $config = \Drupal::service('config.factory')->getEditable('magnet.mail');
    $config->set('mail.sent.login', 2);
    $config->save();

    $content = magnet_upcoming_deadlines();

    return [
      '#theme' => 'magnet_notification_block',
      '#attached' => [
        'library' => [
          'magnet/notification',
        ],
      ],
      '#content' => $content,
    ];
  }

}
