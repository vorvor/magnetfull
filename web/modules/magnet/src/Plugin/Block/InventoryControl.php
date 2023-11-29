<?php

namespace Drupal\magnet\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;

/**
 * Provides a states block.
 *
 * @Block(
 *   id = "magnet_inventory",
 *   admin_label = @Translation("Magnet inventory block"),
 *   category = @Translation("Magnet Inventory Blokk"),
 * )
 */

class InventoryControl extends BlockBase {

	/**
   * {@inheritdoc}
   */

  public function build() {


    if (is_null(magnet_get_current_inventory())) {
      return [];
    }

    // Load products inventory done.
    $product_inventory_done = magnet_inventory_products_done();

    $views = views_embed_view('inventory_control', 'page_1', implode('+', $product_inventory_done));
    $inventory_done = \Drupal::service('renderer')->render($views);

    // Load inventory todo.
    $product_all = \Drupal::entityQuery('node')
      ->condition('type', 'product')
      ->sort('nid')
      ->accessCheck(TRUE)
      ->execute();

    $product_inventory_todo = array_diff($product_all, $product_inventory_done);
    $views = views_embed_view('inventory_control', 'page_1', implode('+', $product_inventory_todo));
    $inventory_todo = \Drupal::service('renderer')->render($views);

    return [
      '#theme' => 'magnet_inventory',
      '#attached' => [
        'library' => [
          'magnet/inventory',
        ],
      ],
      '#inventory_done' => $inventory_done,
      '#inventory_todo' => $inventory_todo,
    ];




  }


  public function getCacheMaxAge() {
    return 0;
}

}
