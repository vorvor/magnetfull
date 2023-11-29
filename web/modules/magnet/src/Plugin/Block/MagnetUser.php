<?php

namespace Drupal\magnet\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides an example block.
 *
 * @Block(
 *   id = "magnet_user",
 *   admin_label = @Translation("Magnet User"),
 *   category = @Translation("Magnet User")
 * )
 */
class MagnetUser extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $current_user = \Drupal::currentUser();
    $user_account_name = $current_user->getAccountName();

    $build['content'] = [
      '#markup' => '<h3>Hello ' . $user_account_name . '!</h3><a href="/user">My works</a>',
      '#cache' => ['contexts' => ['user']],
    ];

    return $build;
  }

}
