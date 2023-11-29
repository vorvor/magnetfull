<?php

namespace Drupal\magnet\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;

/**
 * Provides a states block.
 *
 * @Block(
 *   id = "magnet_finished_exclude_button",
 *   admin_label = @Translation("Magnet finished exclude button"),
 *   category = @Translation("Magnet finished exclude button"),
 * )
 */

class FinishedExcludeButton extends BlockBase {

	/**
   * {@inheritdoc}
   */

  public function build() {

    return [
      '#type' => 'markup',
      '#markup' => '<div id="show-finished-products"><div id="finished-inside">Show finished products</div></div>',
    ];
  }


  public function getCacheMaxAge() {
    return 0;
}

}
