<?php

namespace Drupal\magnet\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;

/**
 * Provides a states block.
 *
 * @Block(
 *   id = "magnet_coming_sooon",
 *   admin_label = @Translation("Coming Soon"),
 *   category = @Translation("Magnet Inventory Block"),
 * )
 */

class ComingSoon extends BlockBase {

	/**
   * {@inheritdoc}
   */

  public function build() {

    return [
      '#theme' => 'magnet_coming_soon',
      '#attached' => [
        'library' => [
          'magnet/coming_soon',
        ],
      ],
      '#content' => magnet_coming_soon(),
    ];
  }


  public function getCacheMaxAge() {
    return 0;
}

}
