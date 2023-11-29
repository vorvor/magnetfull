<?php

namespace Drupal\magnet\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;

/**
 * Provides a states block.
 *
 * @Block(
 *   id = "magnet_inventory_status",
 *   admin_label = @Translation("Magnet inventory status block"),
 *   category = @Translation("Magnet Inventory Status Blokk"),
 * )
 */

class InventoryControlStatus extends BlockBase {

	/**
   * {@inheritdoc}
   */

  public function build() {

    if (is_null($inventory = magnet_get_current_inventory())) {
      return [];
    }

    $product_all = \Drupal::entityQuery('node')
      ->condition('type', 'product')
      ->sort('nid')
      ->accessCheck(TRUE)
      ->execute();

    $product_inventory_done = magnet_inventory_products_done();
    $product_inventory_todo = array_diff($product_all, $product_inventory_done);

    $count_todo = count($product_inventory_todo);
    $count_done = count($product_inventory_done);
    $percent = floor(($count_done / count($product_all)) * 100);

    $width_left = $percent;

    $status = 'Inventory control "<span class="inventory-status-name">' . $inventory->getTitle() . '</span>" in progress. ' . count($product_inventory_todo) . '/' . count($product_inventory_done) . '   ' . $percent . '% done.';


    return [
      '#theme' => 'magnet_inventory_status',
      '#attached' => [
        'library' => [
          'magnet/inventory',
        ],
      ],
      '#status' => $status,
      '#width_left' => $width_left,
    ];




  }


  public function getCacheMaxAge() {
    return 0;
}

}
