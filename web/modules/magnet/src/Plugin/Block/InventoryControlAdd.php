<?php

namespace Drupal\magnet\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;

/**
 * Provides a states block.
 *
 * @Block(
 *   id = "magnet_inventory_add",
 *   admin_label = @Translation("Magnet inventory add block"),
 *   category = @Translation("Magnet Inventory Add Blokk"),
 * )
 */

class InventoryControlAdd extends BlockBase {

	/**
   * {@inheritdoc}
   */

  public function build() {

    if (is_null(magnet_get_current_inventory())) {
      return [];
    }

    $node = \Drupal::routeMatch()->getParameter('node');
    if ($node instanceof \Drupal\node\NodeInterface) {
      $nid = $node->id();
      if (!magnet_product_inventory_done($nid)) {
        $content = '<div id="inventory-add" class="active" data-nid="' . $nid . '">Add to inventory</div>';
      } else {
        $content = '<div id="inventory-done">Inventory done.</div>';
      }
    }
    
    
    return [
      '#theme' => 'magnet_inventory_add',
      '#attached' => [
        'library' => [
          'magnet/inventory',
        ],
      ],
      '#content' => $content,
    ];

   
    

  }


  public function getCacheMaxAge() {
    return 0;
}

}
