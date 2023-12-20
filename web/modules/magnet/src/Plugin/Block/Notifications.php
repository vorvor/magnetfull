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

    $actual_deadlines = magnet_upcoming_deadlines();

    $build['content'] = [
      '#markup' => '<div><h2>Upcoming deadlines (' . $now . ')</h2></div>' . implode('<br />', $actual_deadlines),
      '#cache' => ['contexts' => ['user']],
    ];

    return $build;
  }

}
